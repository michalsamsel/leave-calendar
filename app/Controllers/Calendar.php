<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\CalendarUserModel;
use App\Models\CompanyModel;
use App\Models\UserModel;

class Calendar extends Controller
{
    /*
    *
    */
    public function index($invite_code)
    {
        $session = session();
        if (session()->get('account_type_id') == 1) {
            $userModel = new UserModel();
            $userList['users'] = $userModel->getUserList($invite_code);
            echo view('Views/templates/header');
            echo view('Views/calendar/calendarOwner', $userList);
            echo view('Views/templates/footer');
        } else if (session()->get('account_type_id') == 2) {
            echo view('Views/templates/header');
            echo view('Views/calendar/calendarWorker');
            echo view('Views/templates/footer');
        }
    }

    /*
    * This method creates new calendar on user demand.
    * User passes information about name of new calendar and for which company he creates it.
    * List of companies are downloaded from database for specific user.
    */
    public function create()
    {
        $session = session();
        //Messages for failed validation.
        $ruleMessages = [
            'company_id' => [
                'greater_than' => 'Wybierz z listy jedną z dostępnych firm. Jeśli nie stworzyłeś jeszcze firmy to najpierw ją założ a następnie stwórz kalendarz.'
            ],
        ];

        //Check if validation was successful.
        if ($this->request->getMethod() === 'post' && $this->validate([
            'company_id' => 'greater_than[0]',
        ], $ruleMessages)) {
            $calendarModel = new CalendarModel();
            //Add new calendar to database.
            $calendarModel->createCalendar($session->get('id'), $this->request->getPost('company_id'), $this->request->getPost('name'));
            //After successful creating of calendar redirect user to his main page.
            return redirect('user');
        } else {
            $companyModel = new CompanyModel();
            //Get users list of companies which he added to database.
            $companyArray['companies'] = $companyModel->getCompanyArray($session->get('id'));

            //Displaying form of creating calendar for specific company.
            echo view('Views/templates/header');
            echo view('Views/calendar/create', $companyArray);
            echo view('Views/templates/footer');
        }
    }

    /*
    * This method let's users join calendars created by company owners.
    * User join callendar by inserting invite code provided by his supervisor.
    */
    public function join()
    {
        //Messages for failed validation.
        $ruleMessages = [
            'invite_code' => [
                'alpha_numeric' => 'W polu mogą znajdować się tylko znaki od A do Z oraz cyfry od 0 do 9.',
                'min_length' => 'W polu musi być 6 znaków',
                'max_length' => 'W polu musi być 6 znaków',
            ],
        ];
        //Check if validation was successful.
        if ($this->request->getMethod() === 'post' && $this->validate([
            'invite_code' => 'alpha_numeric|min_length[6]|max_length[6]',
        ], $ruleMessages)) {
            $session = session();
            $calendarUserModel = new CalendarUserModel();

            //Create connection between user and calendar he joins.
            $joinResult = $calendarUserModel->joinCalendar($session->get('id'), $this->request->getPost('invite_code'));
            if ($joinResult) {
                //If user joined calendar redirect him to his main page.
                return redirect('user');
            } else {
                //Display form and information if user inserted wrong code or is already member of calendar.
                echo view('Views/templates/header');
                echo view('Views/calendar/join');
                echo '<b>Podany kod nie istnieje lub użytkownik już należy do podanego kalendarza.</b>';
                echo view('Views/templates/footer');
            }
        } else {
            //Form for users to join specific calendar.
            echo view('Views/templates/header');
            echo view('Views/calendar/join');
            echo view('Views/templates/footer');
        }
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\CompanyModel;

class Calendar extends Controller
{
    /*
    * This method creates new calendar on user demand.
    * User passes information about name of new calendar and for which company he creates it.
    * List of companies are downloaded from database for specific user.
    */
    public function create()
    {
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
            $calendarModel->createCalendar($this->request->getPost('company_id'), $this->request->getPost('name'));
            //After successful creating of calendar redirect user to his main page.
            return redirect('user');
        } else {
            $session = session();
            $companyModel = new CompanyModel();
            //Get users list of companies which he added to database.
            $companyArray['companies'] = $companyModel->getCompanyArray($session->get('id'));

            //Displaying form of creating calendar for specific company.
            echo view('Views/templates/header');
            echo view('Views/calendar/create', $companyArray);
            echo view('Views/templates/footer');
        }
    }
}

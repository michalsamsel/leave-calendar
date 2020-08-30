<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\CalendarUserModel;
use App\Models\CompanyModel;
use App\Models\DaysOfLeaveModel;
use App\Models\LeaveModel;
use App\Models\UserModel;

class CalendarController extends Controller
{
    /* This method shows calendar for user.
    * It also calculates date based on given,
    when country holiday days will happend.
    */
    public function index(string $invite_code, int $month = null, int $year = null)
    {
        $session = session();
        $userId = $session->get('id');
        $accountTypeId = $session->get('account_type_id');
        $firstName = $session->get('first_name');
        $lastName = $session->get('last_name');

        $calendarModel = new CalendarModel();
        $calendarId = $calendarModel->getId($invite_code);
        $calendarOwnerId = $calendarModel->getOwnerId($invite_code);

        $calendarUserModel = new CalendarUserModel();
        $daysOfLeaveModel = new DaysOfLeaveModel();
        $leaveModel = new LeaveModel();
        $userModel = new UserModel();

        //If someone didnt joined calenadr by code, redirect him to his main view.
        if (
            $calendarOwnerId['owner_id'] != $userId &&
            !$calendarUserModel->isUserMemberOfCalendar(
                $userId,
                $calendarId['id']
            )
        ) {
            return redirect('user');
        }

        $data['invite_code'] = $invite_code;
        if ($month !== null && $year !== null) {
            $data['month'] = intval($month);
            $data['year'] = intval($year);
        } else {
            $data['month'] = date('n');
            $data['year'] = date('Y');
        }


        //These are dates of all static date polish public holidays
        $publicHolidays = [
            0 => date(mktime(0, 0, 0, 1, 1, $year)),
            1 => date(mktime(0, 0, 0, 1, 6, $year)),
            2 => date(mktime(0, 0, 0, 5, 1, $year)),
            3 => date(mktime(0, 0, 0, 5, 3, $year)),
            4 => date(mktime(0, 0, 0, 8, 15, $year)),
            5 => date(mktime(0, 0, 0, 11, 1, $year)),
            6 => date(mktime(0, 0, 0, 11, 11, $year)),
            7 => date(mktime(0, 0, 0, 12, 25, $year)),
            8 => date(mktime(0, 0, 0, 12, 26, $year)),
        ];

        //This is calculation for checking when easter will happen in choosen year.
        $yearMod19 = $year % 19;
        $yearMod4 = $year % 4;
        $yearMod7 = $year % 7;
        $easterHelpA = (19 * $yearMod19 + 24) % 30;
        $easterHelpB = ((2 * $yearMod4) + (4 * $yearMod7) + (6 * $easterHelpA) + 5) % 7;
        $easterDay = 22 + $easterHelpA + $easterHelpB;

        //Checking if easter happens in march or april.
        if ($easterDay <= 31) {
            $publicHolidays[9] = date(mktime(0, 0, 0, 3, $easterDay, $year));
        } else {
            $easterDay = $easterHelpA + $easterHelpB - 9;
            $publicHolidays[9] = date(mktime(0, 0, 0, 4, $easterDay, $year));
        }

        //These are holidays which dates are based on easter.
        $publicHolidays[10] = strtotime("1 day", $publicHolidays[9]); //Adding 1 day to easter date.
        $publicHolidays[11] = strtotime("60 days", $publicHolidays[9]); //Adding 60 days to easter date.

        $data['publicHolidays'] = $publicHolidays;


        switch ($accountTypeId) {
            case 1: //Supervisor view.            
                $data['userList'] = $userModel->getUserList($invite_code);
                $data['numberOfDaysToLeave'] = $daysOfLeaveModel->getAllUsersNumberOfDays($data['invite_code'], $data['year']);

                $allDaysOfLeaveUsed = $leaveModel->countAllWorkingDaysUsed(
                    $calendarId['id'],
                    $data['year']
                );

                //Get days in month when users have leave and mark it on calendar.
                $datesOfLeave = $leaveModel->getAllDaysFromTo(
                    $calendarId['id'],
                    $data['month'],
                    $data['year']
                );
                $data['leaveDates'] = $datesOfLeave;

                $data['workingDaysUsed'] = $allDaysOfLeaveUsed;

                echo view('Views/templates/header');
                echo view('Views/calendar/calendarView', $data);
                echo view('Views/calendar/calendarLegend');
                echo view('Views/templates/footer');
                break;

            case 2: //Worker view

                //Get number of days user have at all and display them in 'pula' field.
                $userDaysOfLeave = $daysOfLeaveModel->getNumberOfDays(
                    $userId,
                    $data['invite_code'],
                    $data['year']
                );

                //If number of days wasnt updated yet, set them as 0 days.
                if (empty($userDaysOfLeave['number_of_days'])) {
                    $data['numberOfDaysToLeave'][0] = [
                        'user_id' => $userId,
                        'number_of_days' => 0,
                    ];
                } else {
                    $data['numberOfDaysToLeave'][0] = $userDaysOfLeave;
                }

                //Get number of days which user used for leaves and display them in 'wykorzystane' field. 
                $userWorkingDaysUsed = $leaveModel->countUserWorkingDaysUsed(
                    $userId,
                    $calendarId['id'],
                    $data['year']
                );

                if (empty($userWorkingDaysUsed['working_days_used'])) {
                    $data['workingDaysUsed'][0] = [
                        'user_id' => $userId,
                        'working_days_used' => 0,
                    ];
                } else {
                    $data['workingDaysUsed'][0] = [
                        'user_id' => $userId,
                        'working_days_used' => $userWorkingDaysUsed['working_days_used'],
                    ];
                }

                //Get days in month when user had leave and mark it on calendar.
                $datesOfLeave = $leaveModel->getUserDaysFromTo(
                    $userId,
                    $calendarId['id'],
                    $data['month'],
                    $data['year']
                );
                $data['leaveDates'] = $datesOfLeave;

                //Set data about current loged user.
                $user = [
                    'id' => $userId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ];

                $data['userList'][0] = $user;

                echo view('Views/templates/header');
                echo view('Views/calendar/calendarView', $data);
                echo view('Views/templates/footer');

                break;
        }
    }

    /*
    * This method creates new calendar.
    * User passes information about name(not required) of new calendar and for which company he creates it.
    * List of companies are downloaded from database for specific user.
    */
    public function create()
    {
        $session = session();
        $userId = $session->get('id');
        $accountTypeId = $session->get('account_type_id');

        $calendarModel = new CalendarModel();
        $companyModel = new CompanyModel();

        //If someone with diffrent account types gets here, redirect him to his main view.
        if ($accountTypeId != 1) {
            return redirect('user');
        }

        $validationErrorMessage = [
            'company_id' => [
                'greater_than' => 'Wybierz z listy jedną z dostępnych firm. Jeśli nie stworzyłeś jeszcze firmy to najpierw ją stwórz a następnie przejdź do tworzenia kalendarz.',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'company_id' => 'greater_than[0]',
        ], $validationErrorMessage)) {

            $calendarModel->createCalendar(
                $userId,
                $this->request->getPost('company_id'),
                $this->request->getPost('name')
            );

            //After successful login redirect user to his main view.
            return redirect('user');
        } else {
            //Get users list of companies which he added to database.
            $companyList['companyList'] = $companyModel->getCompanyList($userId);

            //Displaying form of creating calendar for supervisor.
            echo view('Views/templates/header');
            echo view('Views/calendar/create', $companyList);
            echo view('Views/templates/footer');
        }
    }

    /*
    * This method let's users join calendars.
    * User join callendar by writing invite code provided by his supervisor.
    */
    public function join()
    {
        $session = session();
        $userId = $session->get('id');
        $accountTypeId = $session->get('account_type_id');

        $calendarUserModel = new CalendarUserModel();

        //If someone with diffrent account types gets here, redirect him to his main view.
        if ($accountTypeId != 2) {
            return redirect('user');
        }

        $inviteCodeErrorMessage['errorMessage'] = '';

        $validationErrorMessage = [
            'invite_code' => [
                'alpha_numeric' => 'W polu mogą znajdować się tylko litery od A do Z oraz cyfry od 0 do 9.',
                'min_length' => 'W polu musi być 6 znaków, podano ich za mało.',
                'max_length' => 'W polu musi być 6 znaków, podano ich za dużo.',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'invite_code' => 'alpha_numeric|min_length[6]|max_length[6]',
        ], $validationErrorMessage)) {

            if ($calendarUserModel->joinCalendar($userId, $this->request->getPost('invite_code'))) {
                //If user joined calendar redirect him to his main page.
                return redirect('user');
            } else {
                //Display form and information if user inserted wrong code or is already member of calendar.
                $inviteCodeErrorMessage['errorMessage'] = 'Podany kod nie istnieje lub użytkownik już należy do podanego kalendarza.';
                echo view('Views/templates/header');
                echo view('Views/calendar/join', $inviteCodeErrorMessage);
                echo view('Views/templates/footer');
            }
        } else {
            //Form for users to join specific calendar.
            echo view('Views/templates/header');
            echo view('Views/calendar/join', $inviteCodeErrorMessage);
            echo view('Views/templates/footer');
        }
    }
}

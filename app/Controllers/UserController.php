<?php

namespace app\Controllers;

use CodeIgniter\Controller;
use App\Models\AccountTypeModel;
use App\Models\UserModel;
use App\Models\CalendarModel;
use App\Models\CalendarUserModel;

class UserController extends Controller
{
    /*
    * This controller loads pages based on type of account.
        Supervisor and worker have diffrent functions so they have diffrent views.
    */
    public function index()
    {
        $session = session();
        $userId = $session->get('id');
        $accountTypeId = $session->get('account_type_id');

        //If user was not logged in or his session ended redirect him to login website.
        if ($userId == null) {
            return redirect('user/login');
        }

        //Load calendar list for supervisor.
        if ($accountTypeId == 1) {

            $calendarModel = new CalendarModel();
            $calendarList['calendarList'] = $calendarModel->getCalendarList($userId);
        }
        //Load calendar list for worker.
        else if ($accountTypeId == 2) {
            $calendarUserModel = new CalendarUserModel();
            $calendarList['calendarList'] = $calendarUserModel->getCalendarList($userId);
        }

        echo view('Views/templates/header');
        echo view('Views/user/calendarList', $calendarList);
        echo view('Views/templates/footer');
    }
    /*
    * This controller lets users create a new accounts.
    * To work on website users need to have an account.
    */
    public function register()
    {
        $validationErrorMessage = [
            'account_type_id' => [
                'in_list' => 'Wybierz jeden z dwóch typów konta.',
            ],
            'first_name' => [
                'alpha' => 'Pole Imie przyjmuje tylko litery bez polskich znaków.',
                'min_length' => 'Pole Imie musi zawierać minimalnie 3 liter.',
                'max_length' => 'Pole Imie może zawierać maksymalnie 100 liter.',
            ],
            'last_name' => [
                'alpha_dash' => 'Pole Nazwisko przyjmuje tylko litery bez polskich znaków oraz znak -.',
                'min_length' => 'Pole Nazwisko musi zawierać minimalnie 3 litery.',
                'max_length' => 'Pole Nazwisko może zawierać maksymalnie 100 liter.',
            ],
            'email' => [
                'valid_email' => 'To nie jest poprawny adres email.',
                'max_length' => 'Pole Email może zawierać maksymalnie 100 znaków.',
                'isEmailFreeToUse' => 'Na podany adres Email jest już stworzone konto.',
            ],
            'password' => [
                'min_length' => 'Pole Hasło musi zawierać minimalnie 6 znaków.',
                'max_length' => 'Pole Hasło może zawierać maksymalnie 16 znaków.',
            ],
            'password_validate' => [
                'matches' => 'Podane Hasła nie są identyczne.',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'account_type_id' => 'in_list[1,2]',
            'first_name' => 'alpha|min_length[3]|max_length[100]',
            'last_name' => 'alpha_dash|min_length[3]|max_length[100]',
            'email' => 'valid_email|max_length[100]|isEmailFreeToUse',
            'password' => 'min_length[6]|max_length[16]',
            'password_validate' => 'matches[password]',
        ], $validationErrorMessage)) {

            $userModel = new UserModel();

            $userModel->createUser(
                $this->request->getPost('email'),
                $this->request->getPost('password'),
                $this->request->getPost('first_name'),
                $this->request->getPost('last_name'),
                $this->request->getPost('account_type_id')
            );

            //After successful registration redirect user to main page.
            return redirect('/');
        } else {
            $accountTypeModel = new AccountTypeModel();
            $accountTypes['accountTypes'] = $accountTypeModel->getAccountTypes();

            //Displaying form of creating account.
            echo view('Views/templates/header');
            echo view('Views/user/register', $accountTypes);
            echo view('Views/templates/footer');
        }
    }

    /*
    * This controller creates session after successful login to website.
    */
    public function login()
    {
        $session = session();
        $userId = $session->get('id');

        if ($userId != null) {
            //If user is logged in, redirect him to his main page.
            return redirect('user');
        }

        $validationLoginError['errorMessage'] = '';

        $validationErrorMessage = [
            'email' => [
                'valid_email' => 'To nie jest poprawny adres email.',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'email' => 'valid_email',
        ], $validationErrorMessage)) {

            $userModel = new UserModel();

            //Get hashed password basen on provided email.
            $hashedPassword = $userModel->getPassword($this->request->getPost('email'));

            //If passwords are the same create session for this user.
            if (password_verify($this->request->getPost('password'), $hashedPassword['password'])) {

                $session = session();
                $session->set($userModel->getUser($this->request->getPost('email')));

                //After successful login redirect user to his main view.
                return redirect('user');
            } else {
                //If something went wrong display information about wrong email or password.
                $validationLoginError['errorMessage'] = 'Podano zły email lub hasło.';
                echo view('Views/templates/header');
                echo view('Views/user/login', $validationLoginError);
                echo view('Views/templates/footer');
            }
        } else {
            //Display form of log in to website.
            echo view('Views/templates/header');
            echo view('Views/user/login', $validationLoginError);
            echo view('Views/templates/footer');
        }
    }

    /*
    * This controller should destroy session.
    * After that redirect user to main page.
    */
    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect('/');
    }
}

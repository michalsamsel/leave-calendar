<?php

namespace app\Controllers;

use CodeIgniter\Controller;
use App\Models\AccountTypeModel;
use App\Models\UserModel;

class User extends Controller
{
    /*
    * This method shows pages for logged users based on their account type.
    */
    public function index()
    {
        $session = session();
        if ($session->get('id') !== null) {
            //Load page for user with account type of 'company owner'.
            if ($session->get('account_type_id') == 1) {
                echo view('Views/templates/header');
                echo view('Views/user/companyOwner');
                echo view('Views/templates/footer');
            }
            //Load page for user with account type of 'company worker'.
            else if ($session->get('account_type_id') == 2) {
                echo view('Views/templates/header');
                echo view('Views/user/companyWorker');
                echo view('Views/templates/footer');
            } else {
                //Other account types shouldnt exist so redirect them to main website.
                return redirect('/');
            }
        } else {
            //If user isnt loged in redirect him to main website.
            return redirect('/');
        }
    }

    /*
    * This method lets users create account to leave-calendar app.    
    */
    public function register()
    {
        //Messages for failed validation.
        $ruleMessages = [
            'account_type_id' => [
                'in_list' => 'Wybierz jeden z dwóch typów konta.',
            ],
            'first_name' => [
                'alpha' => 'Podaj swoje imię bez polskich znaków.',
                'min_length' => 'W polu Imie jest zbyt mało znaków (minimum 3 znaki).',
                'max_length' => 'W polu Imie jest zbyt dużo znaków (maksymalnie 100 znaków).',
            ],
            'last_name' => [
                'alpha_dash' => 'Podaj swoje nazwisko bez polskich znaków',
                'min_length' => 'W polu Nazwisko jest zbyt mało znaków (minimum 3 znaki).',
                'max_length' => 'W polu Nazwisko jest zbyt dużo znaków (maksymalnie 100 znaków).',
            ],
            'email' => [
                'valid_email' => 'To nie jest poprawny adres email.',
                'max_length' => 'W polu Email jest zbyt dużo znaków (maksymalnie 100 znaków).',
                'isEmailUsed' => 'Podany email jest już wykorzystany.',
            ],
            'password' => [
                'min_length' => 'Podane hasło jest zbyt krótkie (minimum 6 znaków).',
                'max_length' => 'Podane haslo jest zbyt długie (maksymalnie 16 znaków).',
            ],
            'password_validate' => [
                'matches' => 'Podane hasła nie są identyczne.',
            ],
        ];

        //Check if validation was successful.
        if ($this->request->getMethod() === 'post' && $this->validate([
            'account_type_id' => 'in_list[1,2]',
            'first_name' => 'alpha|min_length[3]|max_length[100]',
            'last_name' => 'alpha_dash|min_length[3]|max_length[100]',
            'email' => 'valid_email|max_length[100]|isEmailUsed',
            'password' => 'min_length[6]|max_length[16]',
            'password_validate' => 'matches[password]',
        ], $ruleMessages)) {
            $userModel = new UserModel();
            //Create user account
            $userModel->createUser(
                $this->request->getPost('account_type_id'),
                $this->request->getPost('first_name'),
                $this->request->getPost('last_name'),
                $this->request->getPost('email'),
                $this->request->getPost('password')
            );
            //After successful signing in redirect user to main page of app.
            return redirect()->to('/');
        } else {
            $accountTypeModel = new AccountTypeModel();
            $accountType['accounts'] = $accountTypeModel->getAccountTypes();

            //Displaying form of creating account.
            echo view('Views/templates/header');
            echo view('Views/user/register', $accountType);
            echo view('Views/templates/footer');
        }
    }

    /*
    * User log in to app using his email and password.
    */
    public function login()
    {
        $userModel = new UserModel();
        //Messages for failed validation.
        $ruleMessages = [
            'email' => [
                'valid_email' => 'To nie jest poprawny adres email.',
                'max_length' => 'W polu Email jest zbyt dużo znaków (maksymalnie 100 znaków).',
            ],
            'password' => [
                'min_length' => 'Podane hasło jest zbyt krótkie (minimum 6 znaków).',
                'max_length' => 'Podane haslo jest zbyt długie (maksymalnie 16 znaków).',
            ],
        ];
        //Check if validation was successful.
        if ($this->request->getMethod() === 'get' && $this->validate([
            'email' => 'valid_email|max_length[100]',
            'password' => 'min_length[6]|max_length[16]',
        ], $ruleMessages)) {
            //Get password for given email.
            $databasePassword = $userModel->passwordVerify($this->request->getGet('email'));

            echo view('Views/templates/header');
            //If passwords are the same create session for this user.
            if (password_verify($this->request->getGet('password'), $databasePassword['password'])) {
                $session = session();
                $session->set($userModel->getUserData($this->request->getGet('email')));
                return redirect('user');
            } else {
                //If something went wrong display information about wrong email or password.
                echo view('Views/templates/header');
                echo '<b>Błędny email lub hasło</b>';
                echo view('Views/user/login');
                echo view('Views/templates/footer');
            }
        } else {
            //Display form of log in to app.
            echo view('Views/templates/header');
            echo view('Views/user/login');
            echo view('Views/templates/footer');
        }
    }
}

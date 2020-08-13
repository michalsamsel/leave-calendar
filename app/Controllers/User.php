<?php

namespace app\Controllers;

use CodeIgniter\Controller;
use App\Models\AccountTypeModel;
use App\Models\UserModel;

class User extends Controller
{
    public function index()
    {
    }

    public function register()
    {
        $ruleMessages = [
            'account_type_id' => [
                'in_list' => 'Wybierz jeden z dwóch typów konta.',
            ],
            'first_name' => [
                'min_length' => 'W polu Imie jest zbyt mało znaków (minimum 3 znaki).',
                'max_length' => 'W polu Imie jest zbyt dużo znaków (maksymalnie 100 znaków).',
            ],
            'last_name' => [
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

        if ($this->request->getMethod() === 'post' && $this->validate([
            'account_type_id' => 'in_list[1,2]',
            'first_name' => 'min_length[3]|max_length[100]',
            'last_name' => 'min_length[3]|max_length[100]',
            'email' => 'valid_email|max_length[100]|isEmailUsed',
            'password' => 'min_length[6]|max_length[16]',
            'password_validate' => 'matches[password]',
        ], $ruleMessages)) {
            $userModel = new UserModel();
            $userModel->createUser(
                $this->request->getPost('account_type_id'),
                $this->request->getPost('first_name'),
                $this->request->getPost('last_name'),
                $this->request->getPost('email'),
                $this->request->getPost('password')
            );

            echo view('Views/templates/header');
            echo 'Rejestracja przebiegła pomyślnie.';
            echo view('Views/templates/footer');
        } else {
            $accountTypeModel = new AccountTypeModel();
            $accountType['accounts'] = $accountTypeModel->getAccountTypes();

            echo view('Views/templates/header');
            echo view('Views/user/register', $accountType);
            echo view('Views/templates/footer');
        }
    }

    public function login()
    {
        $userModel = new UserModel();

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

        if ($this->request->getMethod() === 'get' && $this->validate([
            'email' => 'valid_email|max_length[100]',
            'password' => 'min_length[6]|max_length[16]',
        ], $ruleMessages)) {
            $databasePassword = $userModel->passwordVerify($this->request->getGet('email'));

            echo view('Views/templates/header');
            if (password_verify($this->request->getGet('password'), $databasePassword['password'])) {
                echo 'Sukces';
            } else {
                echo view('Views/templates/header');
                echo view('Views/user/login');
                echo '<b>Błędny email lub hasło</b>';
                echo view('Views/templates/footer');
            }
            echo view('Views/templates/footer');
        } else {
            echo view('Views/templates/header');
            echo view('Views/user/login');
            echo view('Views/templates/footer');
        }
    }
}

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
        if ($this->request->getMethod() === 'post' && $this->validate([
            'first_name' => 'alpha|min_length[3]|max_length[100]',
            'last_name' => 'alpha_dash|min_length[3]|max_length[100]',
            'email' => 'valid_email|max_length[100]|isEmailUsed',
            'password' => 'min_length[6]|max_length[16]',
            'password_validate' => 'matches[password]',
            'account_type_id' => 'in_list[1,2]',
        ])) {
            $userModel = new UserModel();
            $userModel->createUser(
                $this->request->getPost('account_type_id'),
                $this->request->getPost('first_name'),
                $this->request->getPost('last_name'),
                $this->request->getPost('email'),
                $this->request->getPost('password')
            );

            echo view('Views/templates/header');
            echo 'Success';
            echo view('Views/templates/footer');
        } else {
            $accountTypeModel = new AccountTypeModel();
            $accountType['accounts'] = $accountTypeModel->getAccountTypes();

            echo view('Views/templates/header');
            echo view('Views/user/register', $accountType);
            echo view('Views/templates/footer');
        }
    }
}

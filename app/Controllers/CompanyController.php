<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CompanyModel;

class CompanyController extends Controller
{
    /*
    * This controller creates a new company on user demand.
    * User passes information about companies in given html form.
    */
    public function create()
    {
        $session = session();
        $userId = $session->get('id');
        $accountTypeId = $session->get('account_type_id');

        //If someone with other then supervisor account tries to open form, redirect him to main page.
        if($accountTypeId != 1)
        {
            return redirect('/');
        }

        $companyModel = new CompanyModel();

        $validationErrorMessage = [
            'name' => [
                'required' => 'Pole Nazwa firmy nie może być puste.',
                'min_length' => 'Pole Nazwa firmy musi zawierać minimalnie 1 litere.',
                'max_length' => 'Pole Nazwa firmy może zawierać maksymalnie 255 liter.',
            ],
            'nip' => [
                'required' => 'Pole NIP nie może być puste',
                'min_length' => 'Pole NIP jest zbyt krótkie, musi składać się z 10 znaków.',
                'max_length' => 'Pole NIP jest zbyt długue, musi składać się z 10 znaków.',
                'numeric' => 'W polu NIP mogą znajdywać się jedynie cyfry',
            ],
            'city' => [
                'required' => 'Pole Miasto nie może być puste',
                'min_length' => 'Pole Miasto musi zawierać minimalnie 1 litere.',
                'max_length' => 'Pole Miasto może zawierać maksymalnie 255 liter.',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required|min_length[1]|max_length[255]',
            'nip' => 'required|min_length[10]|max_length[10]|numeric',
            'city' => 'required|min_length[1]|max_length[255]',
        ], $validationErrorMessage)) {

            //Add new company to database.
            $companyModel->createCompany(
                $userId,
                $this->request->getPost('name'),
                $this->request->getPost('nip'),
                $this->request->getPost('city')
            );

            //After successful creating of calendar redirect user to his main page.
            return redirect('user');
        } else {
            //Displaying form of creating company.
            echo view('Views/templates/header');
            echo view('Views/company/create');
            echo view('Views/templates/footer');
        }
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CompanyModel;

class Company extends Controller
{
    /*
    * This method creates new company on user demand.
    * User passes information about companies in given html form.
    */
    public function create()
    {
        //Messages for failed validation.
        $ruleMessages = [
            'name' => [
                'min_length' => 'W polu Nazwa firmy jest zbyt mało znaków (minimum 1 znak).',
                'max_length' => 'W polu Nazwa firmy jest zbyt dużo znaków (maksymalnie 255 znaków).',
            ],
            'nip' => [
                'min_length' => 'Zbyt mało cyfr w polu NIP. (Wymagane 10 cyfr).',
                'max_length' => 'Zbyt dużo cyfr w polu NIP. (Wymagane 10 cyfr).',
                'numeric' => 'Usuń z pola NIP znaki które nie są cyframi.'
            ],
            'city' => [
                'min_length' => 'W polu Miasto jest zbyt mało znaków (minimum 1 znak).',
                'max_length' => 'W polu Miasto jest zbyt dużo znaków (maksymalnie 255 znaków).',
            ],
        ];

        //Check if validation was successful.
        if ($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'min_length[1]|max_length[255]',
            'nip' => 'min_length[10]|max_length[10]|numeric',
            'city' => 'min_length[1]|max_length[255]',
        ], $ruleMessages)) {
            $session = session();
            $companyModel = new CompanyModel();
            //Add new company to database.
            $companyModel->createCompany(
                $session->get('id'),
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

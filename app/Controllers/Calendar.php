<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\CompanyModel;

class Calendar extends Controller
{

    public function create()
    {
        $ruleMessages = [
            'company_id' =>[
                'greater_than' => 'Wybierz z listy jedną z dostępnych firm. Jeśli nie stworzyłeś jeszcze firmy to najpierw ją założ a następnie stwórz kalendarz.'
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'company_id' => 'greater_than[0]',
        ], $ruleMessages)) {
            $calendarModel = new CalendarModel();
            $calendarModel->createCalendar($this->request->getPost('company_id'), $this->request->getPost('name'));
            return redirect('user');
        } else {
            $session = session();
            $companyModel = new CompanyModel();
            $companyArray['companies'] = $companyModel->getCompanyArray($session->get('id'));

            echo view('Views/templates/header');
            echo view('Views/calendar/create', $companyArray);
            echo $this->request->getPost('company_id');
            echo view('Views/templates/footer');
        }
    }
}

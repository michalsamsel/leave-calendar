<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DaysOfLeaveModel;

class DaysOfLeaveController extends Controller
{

    /*
    * This method validates form when user wants to change number of days to leave in calendar.
    */
    public function update(string $inviteCode)
    {
        $session = session();
        $userId = $session->get('id');

        $daysOfLeaveModel = new DaysOfLeaveModel();

        $validationErrorMessage = [
            'number_of_days' => [
                'max_length' => 'Nie można podać wyższej wartości niż 99',
                'greater_than_equal_to' => 'Nie można podać ujemnej ilości dni.',
                'required' => 'Pole nie może być puste',
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'number_of_days' => 'max_length[2]|greater_than_equal_to[0]|required',
        ], $validationErrorMessage)) {
            $daysOfLeaveModel->updateNumberOfDays(
                $userId,
                $inviteCode,
                $this->request->getPost('year'),
                $this->request->getPost('number_of_days')
            );

            echo view('Views/templates/header');
            echo view('Views/daysOfLeave/success');
            echo view('Views/templates/footer');
        } else {
            echo view('Views/templates/header');
            echo view('Views/daysOfLeave/fail');
            echo view('Views/templates/footer');
        }
    }
}

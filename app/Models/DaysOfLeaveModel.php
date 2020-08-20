<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarModel;

class DaysOfLeaveModel extends Model
{
    protected $table = 'day_of_leave';
    protected $allowedFields = ['calendar_id', 'user_id', 'number_of_days', 'year'];

    public function saveDays($invite_code, $user_id, $year, $number_of_days=0)
    {
        if(is_int($number_of_days) && $number_of_days > 0){
            $calendarModel = new CalendarModel();
            $data = [
                'calendar_id' => $calendarModel->getCalendarId($invite_code),
                'user_id' => $user_id,
                'number_of_days' => $number_of_days,
                'year' => $year,
            ];

            return $this->save($data);
        }
    }
}
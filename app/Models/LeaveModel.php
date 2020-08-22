<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{

    protected $table = 'leave';
    protected $allowedFields = ['user_id', 'calendar_id', 'leave_type_id', 'from', 'to', 'working_days_used'];

    /*
    * This method is for getting all leave types in app.
    * Usage for this data is not implemented yet.
    */
    public function getLeaveTypes(): array
    {
        return $this->findAll();
    }

    /*
    * This method is for adding new department type in app.
    * Usage for this method is not implemented yet.
    */
    public function createLeave(array $data)
    {
        return $this->insertBatch($data);
    }

    /*
    * This method gets for single user number of days which he used in single year
    */
    public function countUserDays(int $userId, int $calendarId, int $year)
    {
        return $this->asArray()
        ->where(['user_id' => $userId, 'calendar_id' => $calendarId])
        ->like('from', $year, 'after')
        ->like('to', $year, 'after')
        ->select('user_id')
        ->selectSum('working_days_used')
        ->first();
    }
}

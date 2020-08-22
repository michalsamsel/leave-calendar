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
    public function createLeave($data)
    {
        return $this->insertBatch($data);
    }
}

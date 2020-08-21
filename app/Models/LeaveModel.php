<?php
namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model{

    protected $table = 'leave';
    protected $allowedFields = ['user_id', 'calendar_id', 'leave_type_id', 'from', 'to', 'working_days_used'];

    public function addLeave($data){
        return $this->insert($data);
    }
}
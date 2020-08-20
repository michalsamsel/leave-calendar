<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentTypeModel extends Model
{
    protected $table = 'department_type';

    public function getDepartmentTypes()
    {
        return $this->findAll();
    }
}
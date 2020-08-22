<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentTypeModel extends Model
{
    protected $table = 'department_type';

    /*
    * This method is for getting all department types in app.
    * Usage for this data is not implemented yet.
    */
    public function getDepartmentTypes(): array
    {
        return $this->findAll();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountTypeModel extends Model
{
    protected $table = 'account_type';

    public function getAccountTypes()
    {
        return $this->findAll();
    }
}

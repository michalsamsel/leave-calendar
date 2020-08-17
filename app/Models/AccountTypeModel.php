<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountTypeModel extends Model
{
    protected $table = 'account_type';

    /*
    * This method is for downloading all datatypes in app.
    * This values gonna be used during registration of new user account.
    */
    public function getAccountTypes()
    {
        return $this->findAll();
    }
}

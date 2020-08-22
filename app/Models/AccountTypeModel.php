<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountTypeModel extends Model
{
    protected $table = 'account_type';

    /*
    * This method is for getting all account types in app.
    * This values gonna be used during registration of new user account.
    */
    public function getAccountTypes(): array
    {
        return $this->asArray()->findAll();
    }
}

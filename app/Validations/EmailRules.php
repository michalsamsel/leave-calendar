<?php

namespace App\Validations;

use App\Models\UserModel;

class EmailRules
{
    /*
    * This method checks if given email during registration is already used.
    * If email is already in database return false.
    */
    public function isEmailUsed(string $email): bool
    {
        $userModel = new UserModel();
        
        if ($userModel->emailVerify($email)) {
            return false;
        }
        return true;
    }
}

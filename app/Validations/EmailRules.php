<?php

namespace App\Validations;

use App\Models\UserModel;

class EmailRules
{
    /*
    * This validation checks if given email during registration is already used.
    */
    public function isEmailFreeToUse(string $email): bool
    {
        $userModel = new UserModel();

        //If email is not avaible to use return false.
        if ($userModel->emailVerify($email)) {
            return false;
        }
        //If email is avaible to use return true.
        return true;
    }
}

<?php

namespace App\Validations;

use App\Models\UserModel;

class EmailRules
{
    public function isEmailUsed(string $email, &$error = null): bool
    {
        $userModel = new UserModel();
        $user = $userModel->findEmail($email);

        if(count($user) !== 0)
        {
            $error = lang('myerror.emailAlreadyUsed');
            return false;
        }
        return true;
    }
}
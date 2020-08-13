<?php

namespace App\Validations;

use App\Models\UserModel;

class EmailRules
{
    public function isEmailUsed(string $email): bool
    {
        $userModel = new UserModel();

        if (!$userModel->emailVerify($email)) {
            return true;
        }
        return false;
    }
}

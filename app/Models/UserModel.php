<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['account_type_id', 'first_name', 'last_name', 'email', 'password'];

    public function createUser($accountType = null, $firstName = null, $lastName = null, $email = null, $password = null)
    {
        $data = [
            'account_type_id' => $accountType,
            'first_name' => ucfirst(strtolower($firstName)),
            'last_name' => ucfirst(strtolower($lastName)),
            'email' => $email,
            'password' => $password,
        ];

        if (!in_array(null, $data)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            $this->save($data);
        }
    }

    public function findEmail($email = null)
    {
        if (is_string($email)) {
            return $this->asArray()
                ->where(['email' => $email])
                ->first();
        }
    }
}

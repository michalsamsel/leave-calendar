<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarUserModel;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['account_type_id', 'first_name', 'last_name', 'email', 'password'];

    /*    
    * This method creates account for user.
    * Users log in to website using given email and password during registration.
    */
    public function createUser(string $email, string $password, string $firstName, string $lastName, int $accountType)
    {
        $data = [
            'account_type_id' => $accountType,
            'first_name' => ucfirst(strtolower($firstName)),
            'last_name' => ucfirst(strtolower($lastName)),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        $this->save($data);
    }

    /*
    * This method is used for validation.
    * Each email in database should be unique.
    */
    public function getEmail(string $email): array
    {
        return $this->asArray()
            ->select('email')
            ->where(['email' => $email])
            ->first();
    }

    /*
    * This method gets hashed password to account.
        Later this password can be compared with not hashed given during login.
    */
    public function getPassword(string $email): array
    {
        return $this->asArray()
            ->select('password')
            ->where(['email' => $email])
            ->first();
    }

    /*    
    * This method gets all necessery user data after they login.
    * Data will be saved as session.
    */
    public function getUser(string $email): array
    {
        return $this->asArray()
            ->select(['id', 'account_type_id', 'first_name', 'last_name'])
            ->where(['email' => $email])
            ->first();
    }

    /*
    * This method gets list of all users which joined specific calendar.
    * Data will be used laser in supervisor view.
    */
    public function getUserList(string $inviteCode): array
    {
        $calendarModel = new CalendarModel();
        $calendarId = $calendarModel->getId($inviteCode);

        return $this->query('SELECT u.id, u.first_name, u.last_name 
        FROM user AS u, calendar_user AS cu 
        WHERE cu.calendar_id=' . $calendarId['id'] . ' AND cu.user_id=u.id 
        ORDER BY u.last_name, u.first_name;')->getResultArray();
    }
}

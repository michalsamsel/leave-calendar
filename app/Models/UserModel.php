<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Calendar;
use App\Models\CalendarUserModel;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['account_type_id', 'first_name', 'last_name', 'email', 'password'];

    /*
    * This method is used to create a new user account.
    */

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

    /*
    * This method is used to validate if given email in form during registration is not already used.
    */

    public function emailVerify($email = null)
    {
        if (is_string($email)) {
            return $this->asArray()
                ->select('email')
                ->where(['email' => $email])
                ->first();
        }
    }

    /*
    * This method is used to download password connected to email and
      compare it with not hashed password given in form.
    */
    public function passwordVerify($email = null)
    {
        if (is_string($email)) {
            return $this->asArray()
                ->select('password')
                ->where(['email' => $email])
                ->first();
        }
    }
    /*
    * This method gets user data which gonna be saved in session.
    */

    public function getUserData($email)
    {
        if (is_string($email)) {
            return $this->asArray()
                ->select(['id', 'account_type_id', 'first_name', 'last_name'])
                ->where(['email' => $email])
                ->first();
        }
    }

    /*
    * This method gets list of users who joined calendar.
    */
    public function getUserList($invite_code)
    {
        $calendarModel = new CalendarModel();
        $calendarUserModel = new CalendarUserModel();

        $calendarId = $calendarModel->getCalendarId($invite_code);

        return $this->query('SELECT u.id, u.first_name, u.last_name FROM user AS u, calendar_user AS cu WHERE cu.calendar_id=' . $calendarId['id'] . ' AND cu.user_id=u.id ORDER BY u.last_name, u.first_name;')->getResultArray();
    }
}

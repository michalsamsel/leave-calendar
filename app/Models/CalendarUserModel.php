<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarModel;

class CalendarUserModel extends Model
{

    protected $table = 'calendar_user';
    protected $allowedFields = ['calendar_id', 'user_id', 'user_department_id'];

    /*
    * This method create connection betweend user and calendar.
    * Function checks if user didnt already joined calendar.
    */
    public function joinCalendar(int $userId, string $invite_code)
    {
        $calendarModel = new CalendarModel();
        $calendarId = $calendarModel->getId($invite_code);

        $data = [
            'user_id' => $userId,
            'calendar_id' => $calendarId['id'],
        ];

        if (!$this->isUserMemberOfCalendar($data['user_id'], $data['calendar_id'])) {
            return $this->save($data);
        }
    }

    /*
    * This method checks and returns information if user joined specific calendar.
    */
    public function isUserMemberOfCalendar(int $userId, int $calendarId): bool
    {
        if ($this->asArray()
            ->where(['user_id' => $userId, 'calendar_id' => $calendarId])
            ->first()
        ) {
            return true;
        }
        return false;
    }

    /*
    * This method returns name and invite code of all calendars which worker joined.
    */
    public function getCalendarList(int $userId): array
    {
        return $this->query('SELECT c.name, c.invite_code 
            FROM calendar_user AS cu, calendar AS c 
            WHERE ' . $this->escape($userId) . '=cu.user_id AND c.id=cu.calendar_id')
            ->getResultArray();
    }
}

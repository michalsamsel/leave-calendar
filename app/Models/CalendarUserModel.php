<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarModel;

class CalendarUserModel extends Model
{

    protected $table = 'calendar_user';
    protected $allowedFields = ['calendar_id', 'user_id', 'user_department_id'];

    /*
    * This method is used for displaying all callendars which user joined by invite code
    */

    public function joinCalendar($user_id = null, $invite_code = null)
    {
        $calendarModel = new CalendarModel();

        $calendar_id = $calendarModel->getCalendarId($invite_code);

        if($invite_code!==null && $calendar_id){
            $data = [
                'user_id' => $user_id,
                'calendar_id' => $calendar_id['id'],
            ];
    
            if (!in_array(null, $data) && ! $this->userAlreadyJoined($user_id, $calendar_id)) {
                return $this->save($data);
            }
        }  
        else{
            return false;
        }  

    }

    public function getWorkerCalendars($user_id = null)
    {
        if ($user_id !== null) {
            return $this->query('SELECT c.name, c.invite_code FROM calendar_user AS cu, calendar AS c WHERE '.$this->escape($user_id).'=cu.user_id AND c.id=cu.calendar_id')->getResultArray();
        }
    }

    protected function userAlreadyJoined($user_id, $calendar_id)
    {
        if($this->asArray()
            ->where(['user_id' => $user_id, 'calendar_id' => $calendar_id])
            ->first())
            {
                return true;
            }
            else{
                return false;
            }
    }
}

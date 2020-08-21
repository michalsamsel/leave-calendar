<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarModel;
use mysqli;

class DaysOfLeaveModel extends Model
{
    protected $table = 'days_of_leave';
    protected $allowedFields = ['calendar_id', 'user_id', 'number_of_days', 'year'];

    protected function checkIfExist($user_id, $calendar_id, $year)
    {
        $data = [
            'user_id' => $user_id,
            'calendar_id' => $calendar_id,
            'year' => $year,
        ];

        $numberOfRows = $this->asArray()->where($data)->first();
        if (is_array($numberOfRows)) {
            return true;
        }
        return false;
    }

    public function saveDays($invite_code, $user_id, $year, $number_of_days = 0)
    {
        if ($number_of_days >= 0) {
            $calendarModel = new CalendarModel();
            $calendar = $calendarModel->getCalendarId($invite_code);
            $data = [
                'calendar_id' => $calendar['id'],
                'user_id' => $user_id,
                'number_of_days' => $number_of_days,
                'year' => $year,
            ];

            $ifExist = $this->checkIfExist($data['user_id'], $data['calendar_id'], $data['year']);
            if ($ifExist) {
                $this->where(['calendar_id' => $data['calendar_id'], 'user_id' => $data['user_id'], 'year' => $data['year']]);
                $this->delete();
            }
            return $this->save($data);
        }
    }

    public function getUserDays($user_id, $invite_code, $year)
    {
        $calendarModel = new CalendarModel();
        $calendar_id = $calendarModel->getCalendarId($invite_code);

        $data = [
            'user_id' => $user_id,
            'calendar_id' => $calendar_id,
            'year' => $year,
        ];

        return $this->asArray()
        ->where($data)
        ->select('number_of_days')
        ->first();
    }

    public function getAllUsersDays($invite_code, $year)
    {
        $calendarModel = new CalendarModel();
        $calendar_id = $calendarModel->getCalendarId($invite_code);

        $data = [
            'calendar_id' => $calendar_id,
            'year' => $year,
        ];

        return $this->asArray()
        ->where($data)
        ->select(['user_id', 'number_of_days'])
        ->findAll();
    }
}

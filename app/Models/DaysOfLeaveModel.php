<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CalendarModel;

class DaysOfLeaveModel extends Model
{
    protected $table = 'days_of_leave';
    protected $allowedFields = ['calendar_id', 'user_id', 'number_of_days', 'year'];

    /*
    * This method lets users save in calendar and for each year diffrent number of days they can use to take a leave from work.
    * If user already updated his number of days method will delete old value and replace it with a new one.
    * If there is no value then method will just insert given arguments to database.
    */
    public function updateNumberOfDays(int $userId, string $inviteCode, int $year, int $numberOfDays = 0)
    {
        if ($numberOfDays >= 0) {
            $calendarModel = new CalendarModel();
            $calendarId = $calendarModel->getId($inviteCode);

            $data = [
                'calendar_id' => $calendarId['id'],
                'user_id' => $userId,
                'number_of_days' => $numberOfDays,
                'year' => $year,
            ];

            //If user already updated his days for choosen year, delete old value and replace it with a new.
            if ($this->ifNumberOfDaysExist($data['user_id'], $data['calendar_id'], $data['year'])) {
                $this->where(['calendar_id' => $data['calendar_id'], 'user_id' => $data['user_id'], 'year' => $data['year']])
                    ->delete();
            }
            return $this->save($data);
        }
    }

    /*
    * This method checks if user already updated his number of days of leave in calendar.
    * If he did return true.
    */
    protected function ifNumberOfDaysExist(int $userId, int $calendarId, int $year): bool
    {
        $data = [
            'user_id' => $userId,
            'calendar_id' => $calendarId,
            'year' => $year,
        ];

        if ($this->asArray()->where($data)->first()) {
            return true;
        }
        return false;
    }

    /*
    * This method gets number of days for one user for given calendar and year.
    * Later this information is displayed in calendar for worker view.
    */
    public function getNumberOfDays(int $userId, string $inviteCode, int $year)
    {
        $calendarModel = new CalendarModel();
        $calendarId = $calendarModel->getId($inviteCode);

        $data = [
            'user_id' => $userId,
            'calendar_id' => $calendarId['id'],
            'year' => $year,
        ];

        return $this->asArray()
            ->where($data)
            ->select(['user_id', 'number_of_days'])
            ->first();
    }

    /*
    * This method gets number of days for all users which joined specific calendar, and for specific year.
    * Later this information is displayed in calendar for supervisor view.
    */
    public function getAllUsersNumberOfDays(string $inviteCode, int $year): array
    {
        $calendarModel = new CalendarModel();
        $calendarId = $calendarModel->getId($inviteCode);

        $data = [
            'calendar_id' => $calendarId['id'],
            'year' => $year,
        ];

        return $this->asArray()
            ->where($data)
            ->select(['user_id', 'number_of_days'])
            ->findAll();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{

    protected $table = 'leave';
    protected $allowedFields = ['user_id', 'calendar_id', 'leave_type_id', 'from', 'to', 'working_days_used'];

    /*
    * This method is for getting all leave types in app.
    * Usage for this data is not implemented yet.
    */
    public function getLeaveTypes(): array
    {
        return $this->findAll();
    }

    /*
    * This method is for adding new department type in app.
    * Usage for this method is not implemented yet.
    */
    public function createLeave(array $data)
    {
        return $this->insertBatch($data);
    }

    /*
    * This method gets worker number of days which he used in single year
    */
    public function countUserWorkingDaysUsed(int $userId, int $calendarId, int $year)
    {
        return $this->asArray()
            ->where(['user_id' => $userId, 'calendar_id' => $calendarId])
            ->like('from', $year, 'after')
            ->like('to', $year, 'after')
            ->select('user_id')
            ->selectSum('working_days_used')
            ->first();
    }

    /*
    * This method gives supervisor list of all days workers already used in single year 
    */
    public function countAllWorkingDaysUsed(int $calendarId, int $year)
    {
        return $this->asArray()
            ->where(['calendar_id' => $calendarId])
            ->like('from', $year, 'after')
            ->like('to', $year, 'after')
            ->select('user_id')
            ->selectSum('working_days_used')
            ->groupBy('user_id')
            ->findAll();
    }

    /*
    * This method gets all days of leave user used in month.
    * Later that data will be used to mark on calendar when user had leave.
    */
    public function getUserDaysFromTo(int $userId, int $calendarId, int $month, int $year)
    {
        if ($month < 10) {
            $date = strval($year) . '-0' . strval($month);
        } else {
            $date = strval($year) . '-' . strval($month);
        }

        return $this->asArray()
            ->where(['user_id' => $userId, 'calendar_id' => $calendarId])
            ->like('from', $date, 'after')
            ->like('to', $date, 'after')
            ->select(['user_id', 'from', 'to'])
            ->findAll();
    }

    /*
    * This method gets all days of leave users used in month.
    * Later that dates will be used to mark on calendar for supervisor view.
    */
    public function getAllDaysFromTo(int $calendarId, int $month, int $year)
    {
        if ($month < 10) {
            $date = strval($year) . '-0' . strval($month);
        } else {
            $date = strval($year) . '-' . strval($month);
        }

        return $this->asArray()
            ->where(['calendar_id' => $calendarId])
            ->like('from', $date, 'after')
            ->like('to', $date, 'after')
            ->select(['user_id', 'from', 'to'])
            ->findAll();
    }
}

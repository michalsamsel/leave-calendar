<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\LeaveModel;

class LeaveController extends Controller
{

    /*
    * This controller should replace validation in calendar::index
    * But for now there is something wrong.
    */
    public function update(string $inviteCode, int $year)
    {
        $calendarModel = new CalendarModel();
        $leaveModel = new LeaveModel();

        $publicHolidays = [
            0 => date(mktime(0, 0, 0, 1, 1, $year)),
            1 => date(mktime(0, 0, 0, 1, 6, $year)),
            2 => date(mktime(0, 0, 0, 5, 1, $year)),
            3 => date(mktime(0, 0, 0, 5, 3, $year)),
            4 => date(mktime(0, 0, 0, 8, 15, $year)),
            5 => date(mktime(0, 0, 0, 11, 1, $year)),
            6 => date(mktime(0, 0, 0, 11, 11, $year)),
            7 => date(mktime(0, 0, 0, 12, 25, $year)),
            8 => date(mktime(0, 0, 0, 12, 26, $year)),
        ];

        //This is calculation for checking when easter will happen in choosen year.
        $yearMod19 = $year % 19;
        $yearMod4 = $year % 4;
        $yearMod7 = $year % 7;
        $easterHelpA = (19 * $yearMod19 + 24) % 30;
        $easterHelpB = ((2 * $yearMod4) + (4 * $yearMod7) + (6 * $easterHelpA) + 5) % 7;
        $easterDay = 22 + $easterHelpA + $easterHelpB;

        //Checking if easter happens in march or april.
        if ($easterDay <= 31) {
            $publicHolidays[9] = date(mktime(0, 0, 0, 3, $easterDay, $year));
        } else {
            $easterDay = $easterHelpA + $easterHelpB - 9;
            $publicHolidays[9] = date(mktime(0, 0, 0, 4, $easterDay, $year));
        }

        //These are holidays which dates are based on easter.
        $publicHolidays[10] = strtotime("1 day", $publicHolidays[9]); //Adding 1 day to easter date.
        $publicHolidays[11] = strtotime("60 days", $publicHolidays[9]); //Adding 60 days to easter date.


        if ($this->request->getMethod() === 'post') {
            $leaveList = $this->request->getPost('leaveList');

            foreach ($leaveList as $leave) {
                if (empty($leave['from']) && empty($leave['to'])) {
                    //If for some worker date of leave will not be choosen, skip him.
                    unset($leaveList[$leave['user_id']]);
                    continue;
                }

                //If only one date is choosen, save this as only 1 day of leave.
                if (empty($leave['from'])) {
                    $leave['from'] = $leave['to'];
                } else if (empty($leave['to'])) {
                    $leave['to'] = $leave['from'];
                }

                //If someone swaps first day and last day of leave, replace their values.
                if ($leave['from'] > $leave['to']) {
                    $temporaryDate = $leave['from'];
                    $leave['from'] = $leave['to'];
                    $leave['to'] = $temporaryDate;
                }

                //Count number of working days. Skip weekends and country holidays.
                $workingDays = 0;

                //Count days from first day of leave to last day of leave.
                for ($i = $leave['from']; $i <= $leave['to']; $i++) {
                    $splitedDate = explode("-", $i); //Year[0]-Month[1]-Day[2]

                    $dayOfWeek = date('w', mktime(0, 0, 0, $splitedDate[1], $splitedDate[2], $splitedDate[0]));
                    $selectedDate = date(mktime(0, 0, 0, $splitedDate[1], $splitedDate[2], $splitedDate[0]));
                    if (($dayOfWeek == 0 || $dayOfWeek == 6)  && !in_array($selectedDate, $publicHolidays)) {
                        //If not weekend and not public holiday, increase counter
                        $workingDays++;
                    }
                }

                //If the single day of leave was choosen at weekend or at public holiday, dont save it in database.
                if ($workingDays === 0) {
                    unset($leaveList[$leave['user_id']]);
                    continue;
                }

                $leave['calendar_id'] = $calendarModel->getId($inviteCode);
                $leave['working_days_used'] = $workingDays;
                $leave['leave_type_id'] = 1;

                //Update modified array for selected user.
                $leaveList[$leave['user_id']] = $leave;
            }
            $leaveModel->createLeave($leaveList);
            echo view('Views/templates/header');
            echo view('Views/leave/success');
            echo view('Views/templates/footer');
        } else {
            echo view('Views/templates/header');
            echo view('Views/leave/fail');
            echo view('Views/templates/footer');
        }
    }
}

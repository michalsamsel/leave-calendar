<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyModel;

class CalendarModel extends Model
{

    protected $table = 'calendar';
    protected $allowedFields = ['owner_id', 'company_id', 'name', 'invite_code'];

    /*
    * This method is used during creaton of new calendar.
    * If name variable will be empty the name of calendar should be identical to name of company.
    * Method generates on it's own unique invite code for calendar.
    */
    public function createCalendar(int $ownerId, int $companyId, string $name = null)
    {
        $data = [
            'owner_id' => $ownerId,
            'company_id' => $companyId,
            'name' => $name,
        ];

        if ($name === null || $name == '') {
            //If name of calendar is not provided then insert name of company.
            $companyModel = new CompanyModel();
            $data['name'] = $companyModel->getName($companyId);
        }

        do {
            //This loop should break when un used invite code is generated.
            $inviteCode = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 6);
        } while ($this->isInviteCodeUsed($inviteCode));

        $data['invite_code'] = $inviteCode;

        return $this->save($data);
    }

    /*
    * This method is used when new invite code is generating for a new callendar.
        It checks if generated code doesn't already exist.
    * Every invite code should be unique.
    */
    protected function isInviteCodeUsed(string $inviteCode): bool
    {
        if ($this->asArray()
            ->select('invite_code')
            ->where(['invite_code' => $inviteCode])
            ->first()
        ) {
            return true;
        }
        return false;
    }

    /*
    * This method is used to display all calendars which supervisor created.
    */
    public function getCalendarList(int $ownerId): array
    {
        return $this->asArray()
            ->select(['id', 'name', 'invite_code'])
            ->where(['owner_id' => $ownerId])
            ->findAll();
    }

    /*
    * This method is used to get id of calendar based on given invite code.
    */
    public function getId(string $invite_code): array
    {
        return $this->asArray()
            ->select('id')
            ->where(['invite_code' => $invite_code])
            ->first();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyModel;

class CalendarModel extends Model{

    protected $table = 'calendar';
    protected $allowedFields = ['company_id', 'name', 'invite_code'];

    /*
    * This method is used during creating new calendar by user.
    * If given code is already used it needs to create a new code.
    * Every invite code should be unique.
    */

    protected function isInviteCodeUsed($invite_code = null)
    {
        if (is_string($invite_code)) {
            return $this->asArray()
                ->select('invite_code')
                ->where(['invite_code' => $invite_code])
                ->first();
        }
    }

    /*
    * This method is used for add new calendar to database.
    * It gets values from user like name or company id but it generate invite code on its own.
    * If user does not pass name to function it takes default name of company which he had to choose in form.
    */

    public function createCalendar($company_id=null, $name=null)
    {
        $data = [
            'company_id' => $company_id,
        ];

        if($name === null || $name == '')
        {
            $companyModel = new CompanyModel();
            $data['name'] = $companyModel->getCompanyName($company_id);
        }
        else
        {
            $data['name'] = $name;
        }

        do{
            $invite_code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 6);
        }while($this->isInviteCodeUsed($invite_code));
        $data['invite_code'] = $invite_code;
        
        return $this->save($data);
    }
}
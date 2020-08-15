<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyModel;

class CalendarModel extends Model{

    protected $table = 'calendar';
    protected $allowedFields = ['company_id', 'name', 'invite_code'];

    protected function isInviteCodeUsed($invite_code = null)
    {
        if (is_string($invite_code)) {
            return $this->asArray()
                ->select('invite_code')
                ->where(['invite_code' => $invite_code])
                ->first();
        }
    }

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
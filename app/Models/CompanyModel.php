<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $allowedFields = ['owner_id', 'name', 'nip', 'city'];

    public function createCompany($owner_id = null, $name = null, $nip = null, $city = null)
    {
        $data = [
            'owner_id' => $owner_id,
            'name' => ucfirst(strtolower($name)),
            'nip' => $nip,
            'city' => ucfirst(strtolower($city)),
        ];

        if(!in_array(null, $data)){
            $this->save($data);
        }

    }

    public function getCompanyArray($owner_id = null){
        if($owner_id !== null)
        {
            $session = session();
            return $this->asArray()
                ->select(['id', 'name'])
                ->where(['owner_id' => $session->get('id')])
                ->findAll();
        }
    }

    public function getCompanyName($id = null){
        if($id !== null){
            return $this->asArray()
            ->select('name')
            ->where(['id' => $id])
            ->first();
        }
    }
}

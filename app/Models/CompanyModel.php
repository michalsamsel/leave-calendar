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
}

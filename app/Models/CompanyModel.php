<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $allowedFields = ['owner_id', 'name', 'nip', 'city'];

    /*
    * This method let's supervisors create a new company.
    * Company can be later connected with calendar.
    */
    public function createCompany(int $ownerId, string $name, string $nip, string $city)
    {
        $data = [
            'owner_id' => $ownerId,
            'name' => ucfirst(strtolower($name)),
            'nip' => $nip,
            'city' => ucfirst(strtolower($city)),
        ];

        return $this->save($data);
    }

    /*    
    * This method get list of all companies which supervisor created.
    * List will be used during creaton of new calendar.
    */
    public function getCompanyList(int $ownerId): array
    {
        return $this->asArray()
            ->select(['id', 'name'])
            ->where(['owner_id' => $ownerId])
            ->findAll();
    }

    /*
    * This method get name of company.
    * If user leave calendar name empty then this function will replace that empty string.
    */
    public function getName(int $id): array
    {
        return $this->asArray()
            ->select('name')
            ->where(['id' => $id])
            ->first();
    }
}

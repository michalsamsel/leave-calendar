<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $allowedFields = ['owner_id', 'name', 'nip', 'city'];

    /*
    * This method creates new company connected with userr.
    * Companies are needed to connect with calendar for downloading data to fill leave form in PDF.
    */

    public function createCompany($owner_id = null, $name = null, $nip = null, $city = null)
    {
        $data = [
            'owner_id' => $owner_id,
            'name' => ucfirst(strtolower($name)),
            'nip' => $nip,
            'city' => ucfirst(strtolower($city)),
        ];

        if (!in_array(null, $data)) {
            $this->save($data);
        }
    }

    /*
    * This method is used during creation of calendar.
    * Array which is returned is later maked as <select> in calendar create form.
    */

    public function getCompanyArray($owner_id = null)
    {
        if ($owner_id !== null) {
            $session = session();
            return $this->asArray()
                ->select(['id', 'name'])
                ->where(['owner_id' => $session->get('id')])
                ->findAll();
        }
    }

    /*
    * This method is used if during creation of calendar user didnt pass name as argument,
      this downloads name of company by id to fill missing values in form.
    */

    public function getCompanyName($id = null)
    {
        if ($id !== null) {
            return $this->asArray()
                ->select('name')
                ->where(['id' => $id])
                ->first();
        }
    }
}

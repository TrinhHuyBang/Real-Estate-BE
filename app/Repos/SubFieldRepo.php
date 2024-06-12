<?php
namespace App\Repos;

use App\Interfaces\SubFieldRepoInterface;
use App\Models\SubField;

class SubFieldRepo implements SubFieldRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        $subField = new SubField();
        $subField->fill($data)->save();
        return $subField;
    }
    public function edit($id, $data)
    {
    }
    public function delete($id)
    {
        return SubField::where('id', $id)->delete();
    }

    public function deleteEnterpriseId($enterprise_id) {
        return SubField::where('enterprise_id', $enterprise_id)->delete();
    }

}
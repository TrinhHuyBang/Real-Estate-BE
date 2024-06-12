<?php
namespace App\Repos;

use App\Interfaces\PermissionRepoInterface;
use App\Models\Permission;

class PermissionRepo implements PermissionRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return Permission::where('id', $id)->first();
    }
    public function create($data)
    {
        $permission = new Permission();
        $permission->fill($data)->save();
        return $permission;
    }
    public function edit($id, $data)
    {
        return Permission::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return Permission::where('id', $id)->delete();
    }

    public function list()
    {
        $permissions = Permission::get();
        return $permissions;
    }
}
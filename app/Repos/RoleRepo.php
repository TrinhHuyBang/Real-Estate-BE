<?php
namespace App\Repos;

use App\Interfaces\RoleRepoInterface;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RoleRepo implements RoleRepoInterface
{
    public function getInstance($fields = ['*'])
    {
        $roles = Role::select($fields)->get();
        return $roles;
    }
    public function get($name)
    {
        return Role::where('name', $name)->first();
    }
    public function create($data)
    {
        $role = new Role();
        $role->fill($data)->save();
        return $role;
    }
    public function edit($id, $data)
    {
        return Role::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return Role::where('id', $id)->delete();
    }

    public function list($search)
    {
        $roles = Role::where('name', 'like', '%' . $search . '%')->paginate(10);
        foreach ($roles as $role) {
            $permissions = Permission::select(['permissions.name'])
            ->leftJoin('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->where('role_permissions.role_id', $role->id)
            ->get();
            $listPermissions = [];
            foreach($permissions as $permission) {
                $listPermissions[] = $permission->name;
            }
            $role->permissions = $listPermissions;
        }
        return $roles;
    }

    public function createRole($data, $permissions)
    {
        $role = new Role();
        $role->fill($data)->save();
        foreach($permissions as $permission) {
            RolePermission::create(['role_id' => $role->id, 'permission_id' => $permission]);
        }
        return $role;
    }

    public function updateRole($id, $data, $permissions)
    {
        $role = Role::where('id', $id)->first();
        $role->fill($data)->save();
        RolePermission::where('role_id', $role->id)->delete();
        foreach($permissions as $permission) {
            RolePermission::create(['role_id' => $role->id, 'permission_id' => $permission]);
        }
        return $role;
    }

    public function getByAdminId($id) {
        $roles = Role::select(['roles.id', 'roles.name'])
            ->leftJoin('admin_roles', 'admin_roles.role_id', '=', 'roles.id')
            ->where('admin_roles.admin_id', $id)->get();
        foreach ($roles as $role) {
            $permissions = Permission::select(['permissions.name'])
            ->leftJoin('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->where('role_permissions.role_id', $role->id)
            ->get();
            $listPermissions = [];
            foreach($permissions as $permission) {
                $listPermissions[] = $permission->name;
            }
            $role->permissions = $listPermissions;
        }
        return $roles;
    }
}
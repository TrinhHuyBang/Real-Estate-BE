<?php
namespace App\Repos;

use App\Interfaces\AdminRepoInterface;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Permission;

class AdminRepo implements AdminRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $admin = Admin::where('id', $id)->first();
        $permissions = Permission::select(['permissions.name'])
            ->leftJoin('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_permissions.role_id')
            ->leftJoin('admin_roles', 'roles.id', '=', 'admin_roles.role_id')
            ->where('admin_roles.admin_id', $admin->id)
            ->get();
        $admin->permissions = $permissions->pluck('name');
        return $admin;
    }
    public function create($data)
    {
        return Admin::create($data);
    }
    public function edit($id, $data)
    {
        return Admin::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }

    public function checkStatus($username) {
        return Admin::where('email', $username)->where('status', 1)->first();
    }

    public function findAccount($email) {
        return Admin::where('email', $email)->first();
    }

    public function list($search) {
        $admins = Admin::select(['id', 'name', 'email', 'role', 'status'])
        ->where('email', 'like', '%' . $search . '%')
        ->where('id', '!=', auth('admin')->user()->id)
        ->paginate(15);
        return $admins;
    }

    public function blockAccount($id) {
        $admin = Admin::where('id', $id)->first();
        if($admin->status == 1) {
            $admin->update(['status' => 0]);
            return 'Khoá tài khoản thành công';
        } else {
            $admin->update(['status' => 1]);
            return 'Mở khoá tài khoản thành công';
        }
    }

    public function updateRole($id, $roles) {
        AdminRole::where('admin_id', $id)->delete();
        foreach($roles as $role) {
            AdminRole::create(['admin_id' => $id, 'role_id' => $role]);
        }
    }
}
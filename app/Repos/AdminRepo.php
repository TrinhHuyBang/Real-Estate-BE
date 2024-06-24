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

    public function list($search)
    {
        $authAdminId = auth('admin')->id();
        return Admin::select(['id', 'name', 'email', 'role', 'status'])
            ->where('email', 'like', '%' . $search . '%')
            ->where('id', '!=', $authAdminId)
            ->paginate(15);
    }

    public function blockAccount($id)
    {
        $admin = Admin::findOrFail($id);
        $status = $admin->status == 1 ? 0 : 1;
        $admin->update(['status' => $status]);

        return $status == 1 ? 'Mở khoá tài khoản thành công' : 'Khoá tài khoản thành công';
    }

    public function updateRole($id, $roles)
    {
        AdminRole::where('admin_id', $id)->delete();

        $data = array_map(function ($role) use ($id) {
            return ['admin_id' => $id, 'role_id' => $role];
        }, $roles);

        AdminRole::insert($data);
    }
}

<?php

namespace App\Traits;

use App\Models\AdminRole;

trait HasPermission
{
    public function checkPermission($admin, $permission)
    {
        $permission = AdminRole::where('admin_roles.admin_id', $admin->id)
        ->leftJoin('role_permissions', 'role_permissions.role_id', '=', 'admin_roles.role_id')
        ->where('role_permissions.permission_id', $permission)
        ->first();
        if($permission) {
            return true;
        } else {
            return false;
        }
    }
}
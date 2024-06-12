<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Post;
use App\Models\Admin;
use App\Traits\HasPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
    use HasPermission;

    /**
     * Determine whether the Admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::VIEW_ANY_POST);
        return $has_permission;
    }

    /**
     * Determine whether the Admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::VIEW_POST);
        return $has_permission;
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the Admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::UPDATE_POST);
        return $has_permission;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::DELETE_POST);
        return $has_permission;
    }

    /**
     * Determine whether the admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, Post $post)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, Post $post)
    {
        //
    }
}

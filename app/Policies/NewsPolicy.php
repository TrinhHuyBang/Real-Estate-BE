<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\News;
use App\Models\Admin;
use App\Traits\HasPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;
    use HasPermission;

    /**
     * Determine whether the admin can view any models.
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
        $has_permission = $this->checkPermission($admin, Permission::VIEW_ANY_NEWS);
        return $has_permission;
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\News  $news
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, News $news)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::VIEW_NEWS);
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
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::CREATE_NEWS);
        return $has_permission;
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\News  $news
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, News $news)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::UPDATE_NEWS);
        if($has_permission) {
            $has_permission = $news->admin_id === $admin->id ? true : false;    
        }
        return $has_permission;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\News  $news
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, News $news)
    {
        $has_permission = false;
        if($admin->role === 0) {
            return true;
        }
        $has_permission = $this->checkPermission($admin, Permission::DELETE_NEWS);
        if($has_permission) {
            $has_permission = $news->admin_id === $admin->id ? true : false;    
        }
        return $has_permission;
    }

    /**
     * Determine whether the admin can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\News  $news
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, News $news)
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\News  $news
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, News $news)
    {
        //
    }
}

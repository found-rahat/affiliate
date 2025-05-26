<?php

namespace App\Policies;

use App\Models\AdminProduct;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Admin Product View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdminProduct $adminProduct): bool
    {
        if($user->hasPermissionTo('Admin Product View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Admin Product Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdminProduct $adminProduct): bool
    {   
        if($user->hasPermissionTo('Admin Product Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AdminProduct $adminProduct): bool
    {
        if($user->hasPermissionTo('Admin Product Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AdminProduct $adminProduct): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AdminProduct $adminProduct): bool
    {
        return true;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserPanal;
use Illuminate\Auth\Access\Response;

class UserPanalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $User): bool
    {
        if($User->hasPermissionTo('Affiliate User View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $User, UserPanal $userPanalPanal): bool
    {
        
        if($User->hasPermissionTo('Affiliate User View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $User): bool
    {
        if($User->hasPermissionTo('Affiliate User Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $User, UserPanal $userPanalPanal): bool
    {
         if($User->hasPermissionTo('Affiliate User Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $User, UserPanal $userPanalPanal): bool
    {
         if($User->hasPermissionTo('Affiliate User Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $User, UserPanal $userPanalPanal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $User, UserPanal $userPanalPanal): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\CuriorServiceProviderCost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CuriorServiceProviderCostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Curior Service Provider Cost View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CuriorServiceProviderCost $curiorServiceProviderCost): bool
    {
        if($user->hasPermissionTo('Curior Service Provider Cost View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Curior Service Provider Cost Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CuriorServiceProviderCost $curiorServiceProviderCost): bool
    {
        if($user->hasPermissionTo('Curior Service Provider Cost Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CuriorServiceProviderCost $curiorServiceProviderCost): bool
    {
        if($user->hasPermissionTo('Curior Service Provider Cost Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CuriorServiceProviderCost $curiorServiceProviderCost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CuriorServiceProviderCost $curiorServiceProviderCost): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\AddCart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddCartPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Add Cart View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AddCart $addCart): bool
    {
        if($user->hasPermissionTo('Add Cart View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Add Cart Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AddCart $addCart): bool
    {
        if($user->hasPermissionTo('Add Cart Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AddCart $addCart): bool
    {
        if($user->hasPermissionTo('Add Cart Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AddCart $addCart): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AddCart $addCart): bool
    {
        return false;
    }
}

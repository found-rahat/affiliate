<?php

namespace App\Policies;

use App\Models\CustomerInfo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerInfoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Order List View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerInfo $customerInfo): bool
    {
        if($user->hasPermissionTo('Order List View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Order List Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerInfo $customerInfo): bool
    {
        if($user->hasPermissionTo('Order List Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerInfo $customerInfo): bool
    {
        if($user->hasPermissionTo('Order List Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerInfo $customerInfo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerInfo $customerInfo): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\DeliveryCharge;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeliveryChargePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Delivery Charge View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeliveryCharge $deliveryCharge): bool
    {
        if($user->hasPermissionTo('Delivery Charge View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Delivery Charge Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeliveryCharge $deliveryCharge): bool
    {
        if($user->hasPermissionTo('Delivery Charge Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeliveryCharge $deliveryCharge): bool
    {
        if($user->hasPermissionTo('Delivery Charge Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeliveryCharge $deliveryCharge): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeliveryCharge $deliveryCharge): bool
    {
        return false;
    }
}

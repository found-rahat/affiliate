<?php

namespace App\Policies;

use App\Models\CollectProductStock;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CollectProductStockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Collect Product Stock View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CollectProductStock $collectProductStock): bool
    {
        if($user->hasPermissionTo('Collect Product Stock View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Collect Product Stock Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CollectProductStock $collectProductStock): bool
    {
        if($user->hasPermissionTo('Collect Product Stock Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CollectProductStock $collectProductStock): bool
    {
        if($user->hasPermissionTo('Collect Product Stock Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CollectProductStock $collectProductStock): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CollectProductStock $collectProductStock): bool
    {
        return false;
    }
}

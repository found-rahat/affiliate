<?php

namespace App\Policies;

use App\Models\CollectionUserInfo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CollectionUserInfoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Collection User Info View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CollectionUserInfo $collectionUserInfo): bool
    {
        if($user->hasPermissionTo('Collection User Info View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Collection User Info Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CollectionUserInfo $collectionUserInfo): bool
    {
        if($user->hasPermissionTo('Collection User Info Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CollectionUserInfo $collectionUserInfo): bool
    {
        if($user->hasPermissionTo('Collection User Info Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CollectionUserInfo $collectionUserInfo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CollectionUserInfo $collectionUserInfo): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\Reportus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasPermissionTo('Reports us View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reportus $reportus): bool
    {
         if($user->hasPermissionTo('Reports us View')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasPermissionTo('Reports us Create')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reportus $reportus): bool
    {
        if($user->hasPermissionTo('Reports us Update')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reportus $reportus): bool
    {
         if($user->hasPermissionTo('Reports us Delete')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reportus $reportus): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reportus $reportus): bool
    {
        return false;
    }
}

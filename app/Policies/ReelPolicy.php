<?php

namespace App\Policies;

use App\Models\Reel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasRole(['Developer']) || $user->hasPermissionTo('Akses Reel')){
            return true;
        }
            return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Reel $reel): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    // public function create(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, Reel $reel): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can delete the model.
     */
    // public function delete(User $user, Reel $reel): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Reel $reel): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Reel $reel): bool
    // {
    //     //
    // }
}

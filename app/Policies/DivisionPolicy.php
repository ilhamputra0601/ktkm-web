<?php

namespace App\Policies;

use App\Models\Division;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DivisionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->hasRole('Developer') || $user->hasPermissionTo('Akses Divisi')){
            return true;
        }
            return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Division $division): bool
    {
        if($user->hasRole('Developer') || $user->hasPermissionTo('Akses Divisi')){
            return true;
        }
            return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasRole('Developer') || $user->hasPermissionTo('Akses Divisi')){
            return true;
        }
            return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Division $division): bool
    {
        if($user->hasRole('Developer') || $user->hasPermissionTo('Akses Divisi')){
            return true;
        }
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Division $division): bool
    {
        return $user->hasRole('Developer');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Division $division): bool
    {
        return $user->hasRole('Developer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Division $division): bool
    {
        return $user->hasRole('Developer');
    }
}

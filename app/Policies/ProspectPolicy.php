<?php

namespace App\Policies;

use App\Models\Prospect;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProspectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('manage-prospects');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Prospect  $prospect
     * @return Response|bool
     */
    public function view(User $user, Prospect $prospect)
    {
        return $user->hasPermissionTo('manage-prospects');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(?User $user)
    {
        return optional($user)->hasPermissionTo('manage-prospects') || auth()->guest();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Prospect  $prospect
     * @return Response|bool
     */
    public function update(User $user, Prospect $prospect)
    {
        return $user->hasPermissionTo('manage-prospects');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Prospect  $prospect
     * @return Response|bool
     */
    public function delete(User $user, Prospect $prospect)
    {
        return $user->hasPermissionTo('manage-prospects');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Prospect  $prospect
     * @return Response|bool
     */
    public function restore(User $user, Prospect $prospect)
    {
        return $user->hasPermissionTo('manage-prospects');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Prospect  $prospect
     * @return Response|bool
     */
    public function forceDelete(User $user, Prospect $prospect)
    {
        return $user->hasRole('super-admin');
    }
}

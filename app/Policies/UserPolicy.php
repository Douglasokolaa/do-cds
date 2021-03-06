<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
        return $user->hasPermissionTo('manage-users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $userObject
     * @return Response|bool
     */
    public function view(User $user, User $userObject)
    {
        return $user->hasPermissionTo('manage-users') || $user->id === $userObject->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('manage-users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $userObject
     * @return Response|bool
     */
    public function update(User $user, User $userObject)
    {
        return $user->hasPermissionTo('manage-users') || $user->id === $userObject->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  User  $userObject
     * @return Response|bool
     */
    public function delete(User $user, User $userObject)
    {
        return $user->hasPermissionTo('manage-users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  User  $userObject
     * @return Response|bool
     */
    public function restore(User $user, User $userObject)
    {
        return $user->hasPermissionTo('manage-users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  User  $userObject
     * @return Response|bool
     */
    public function forceDelete(User $user, User $userObject)
    {
        return $user->hasRole('super-admin');
    }

    public function importUsers(User $user): bool
    {
        return $user->hasPermissionTo('manage-users');
    }
}

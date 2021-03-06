<?php

namespace App\Policies;

use App\Models\TrainingAttendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TrainingAttendancePolicy
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
        return $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  TrainingAttendance  $trainingAttendance
     * @return Response|bool
     */
    public function view(User $user, TrainingAttendance $trainingAttendance)
    {
        return $user->id === $trainingAttendance->user_id || $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('access=projects') || $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  TrainingAttendance  $trainingAttendance
     * @return Response|bool
     */
    public function update(User $user, TrainingAttendance $trainingAttendance)
    {
        return $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  TrainingAttendance  $trainingAttendance
     * @return Response|bool
     */
    public function delete(User $user, TrainingAttendance $trainingAttendance)
    {
        return $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  TrainingAttendance  $trainingAttendance
     * @return Response|bool
     */
    public function restore(User $user, TrainingAttendance $trainingAttendance)
    {
        return $user->hasPermissionTo('manage-attendance');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  TrainingAttendance  $trainingAttendance
     * @return Response|bool
     */
    public function forceDelete(User $user, TrainingAttendance $trainingAttendance)
    {
        return $user->hasRole('super-admin');
    }

    public function import(User $user): bool
    {
        return $user->hasPermissionTo('manage-attendance');
    }
}

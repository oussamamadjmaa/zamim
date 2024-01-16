<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\School;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param $user
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Teacher $teacher)
    {
        return $user instanceof School && $user->id == $teacher->school_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return $user instanceof School;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param $user
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Teacher $teacher)
    {
        return $user instanceof School && $user->id == $teacher->school_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param $user
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Teacher $teacher)
    {
        return $user instanceof School && $user->id == $teacher->school_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param $user
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Teacher $teacher)
    {
        return $user instanceof School && $user->id == $teacher->school_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param $user
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Teacher $teacher)
    {
        return $user instanceof School && $user->id == $teacher->school_id;
    }
}

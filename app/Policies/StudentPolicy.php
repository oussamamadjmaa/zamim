<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\School;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Student $student)
    {
        return $user instanceof School && $user->id == $student->school_id;
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
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Student $student)
    {
        return $user instanceof School && $user->id == $student->school_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Student $student)
    {
        return $user instanceof School && $user->id == $student->school_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Student $student)
    {
        return $user instanceof School && $user->id == $student->school_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param $user
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Student $student)
    {
        return $user instanceof School && $user->id == $student->school_id;
    }
}

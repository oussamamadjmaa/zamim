<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
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
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Activity $activity)
    {
        return $user instanceof School && $user->id == $activity->school_id;
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
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Activity $activity)
    {
        return $user instanceof School && $user->id == $activity->school_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param $user
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Activity $activity)
    {
        return $user instanceof School && $user->id == $activity->school_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param $user
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Activity $activity)
    {
        return $user instanceof School && $user->id == $activity->school_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param $user
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Activity $activity)
    {
        return $user instanceof School && $user->id == $activity->school_id;
    }
}

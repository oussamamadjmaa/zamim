<?php

namespace App\Policies;

use App\Models\Radio;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RadioPolicy
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
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Radio $radio)
    {
        return $user instanceof School && $user->id == $radio->school_id;
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
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Radio $radio)
    {
        return $user instanceof School && $user->id == $radio->school_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param $user
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Radio $radio)
    {
        return $user instanceof School && $user->id == $radio->school_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param $user
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Radio $radio)
    {
        return $user instanceof School && $user->id == $radio->school_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param $user
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Radio $radio)
    {
        return $user instanceof School && $user->id == $radio->school_id;
    }
}

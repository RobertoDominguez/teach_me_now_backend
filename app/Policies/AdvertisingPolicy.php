<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\Advertising;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Administrator $administrator)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Administrator $administrator, Advertising $advertising)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Administrator $administrator)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Administrator $administrator, Advertising $advertising)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Administrator $administrator, Advertising $advertising)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Administrator $administrator, Advertising $advertising)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Administrator $administrator, Advertising $advertising)
    {
        //
    }
}

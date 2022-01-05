<?php

namespace App\Policies;

use App\Models\Administrator;
use App\Models\University;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityPolicy
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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Administrator $administrator, University $university)
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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Administrator $administrator, University $university)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\University  $university
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Administrator $administrator, University $university)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\University  $university
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Administrator $administrator, University $university)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Administrator  $administrator
     * @param  \App\Models\University  $university
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Administrator $administrator, University $university)
    {
        //
    }
}

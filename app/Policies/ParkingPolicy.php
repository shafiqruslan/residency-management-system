<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Parking;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParkingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_parking');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Parking $parking): bool
    {
        return $user->can('view_parking');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_parking');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Parking $parking): bool
    {
        return $user->can('update_parking');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Parking $parking): bool
    {
        return $user->can('delete_parking');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_parking');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Parking $parking): bool
    {
        return $user->can('force_delete_parking');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_parking');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Parking $parking): bool
    {
        return $user->can('restore_parking');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_parking');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parking  $parking
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Parking $parking): bool
    {
        return $user->can('replicate_parking');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_parking');
    }

}

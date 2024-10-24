<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Keuangan;
use Illuminate\Auth\Access\HandlesAuthorization;

class KeuanganPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_keuangan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Keuangan $keuangan): bool
    {
        return $user->can('view_keuangan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_keuangan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Keuangan $keuangan): bool
    {
        return $user->can('update_keuangan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Keuangan $keuangan): bool
    {
        return $user->can('delete_keuangan');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_keuangan');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Keuangan $keuangan): bool
    {
        return $user->can('force_delete_keuangan');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_keuangan');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Keuangan $keuangan): bool
    {
        return $user->can('restore_keuangan');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_keuangan');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Keuangan $keuangan): bool
    {
        return $user->can('replicate_keuangan');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_keuangan');
    }
}

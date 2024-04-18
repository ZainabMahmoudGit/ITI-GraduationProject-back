<?php

namespace App\Policies;

use App\Models\ServiceCenter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceCenterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
    }

    
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceCenter $serviceCenter)
    {
                return $user->id === $serviceCenter->user_id ;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->role === 'agent';

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ServiceCenter $serviceCenter)
    {
        return $user->id === $serviceCenter->user_id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ServiceCenter $serviceCenter)
    {
        return $user->id === $serviceCenter->user_id ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ServiceCenter $serviceCenter)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ServiceCenter $serviceCenter)
    {
        //
    }
}

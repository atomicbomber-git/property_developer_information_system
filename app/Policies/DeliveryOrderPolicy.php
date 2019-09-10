<?php

namespace App\Policies;

use App\User;
use App\DeliveryOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any app delivery orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the app delivery order.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryOrder  $delivery_order
     * @return mixed
     */
    public function view(User $user, DeliveryOrder $delivery_order)
    {
        //
    }

    /**
     * Determine whether the user can create app delivery orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the app delivery order.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryOrder  $delivery_order
     * @return mixed
     */
    public function update(User $user, DeliveryOrder $delivery_order)
    {
        //
    }

    /**
     * Determine whether the user can delete the app delivery order.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryOrder  $delivery_order
     * @return mixed
     */
    public function delete(User $user, DeliveryOrder $delivery_order)
    {
        return !$delivery_order->hasRelatedModels();
    }

    /**
     * Determine whether the user can restore the app delivery order.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryOrder  $delivery_order
     * @return mixed
     */
    public function restore(User $user, DeliveryOrder $delivery_order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the app delivery order.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryOrder  $delivery_order
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryOrder $delivery_order)
    {
        //
    }
}

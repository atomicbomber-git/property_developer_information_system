<?php

namespace App\Policies;

use App\Item;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Item $item)
    {
        return !$item->hasRelatedModels();
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;

class AddressPolicy
{
    public function update(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }

    public function delete(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'privilege'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const privileges = [
        'EMPLOYEE',
        'ADMINISTRATOR'
    ];

    public function invoices_created()
    {
        return $this->hasMany(Invoice::class, 'creator_id');
    }

    public function invoices_received()
    {
        return $this->hasMany(Invoice::class, 'receiver_id');
    }
}

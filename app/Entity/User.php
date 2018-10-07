<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @proprerty int $id
 * @proprerty string $name
 * @proprerty string $email
 * @proprerty string $status
 */
class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_WAIT = 'wait';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}

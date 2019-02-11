<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * @proprerty int $id
 * @proprerty string $name
 * @proprerty string $email
 * @proprerty string $password
 * @proprerty string $status
 * @proprerty string $verify_code
 * @proprerty string $role
 */
class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ACTIVE = 'active';
    const STATUS_WAIT = 'wait';

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'verify_code',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function register(string $name, string $email, string  $password): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'verify_token' => Str::random(),
            'status' => User::STATUS_WAIT,
            'role' => self::ROLE_USER
        ]);
    }

    public static function new(string $name, string $email): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(Str::random()),
            'status' => User::STATUS_ACTIVE,
            'role' => self::ROLE_USER
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function verify(): void
    {
        if (!$this->isWait()){
            throw new \DomainException('User is already verified.');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_code' => null
        ]);
    }

    public function changeRole($role): void
    {
        if (!\in_array($role, [self::ROLE_USER, self::ROLE_ADMIN], true)){
            throw  new \InvalidArgumentException('Undefined role "' . $role . '"');
        }

        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }

        $this->update(['role' => $role]);
    }

    public function isAdmin():void
    {
        return $this->role === self::ROLE_ADMIN;
    }
}

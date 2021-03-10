<?php

namespace App\Laravue\Models;

use Illuminate\Auth\Authenticatable;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Maklad\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Role[] $roles
 *
 * @method static User create(array $user)
 * @package App
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set permissions guard to API by default
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * @inheritdoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritdoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        foreach ($this->roles  as $role) {
            if ($role->isAdmin()) {
                return true;
            }
        }

        return false;
    }
    public function isManage(): bool
    {
        foreach ($this->roles  as $role) {
            if ($role->isManage()) {
                return true;
            }
        }
        return false;
    }
}

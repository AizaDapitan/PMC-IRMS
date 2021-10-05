<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements AuditableContract, UserResolver
{
    use Notifiable;
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'location',
        'status',
        'isLocked',
        'lockedOn',
        'remember_token',
        'email',
        'role_id'
    ];
    protected $auditInclude = [
        'name',
        'username',
        'password',
        'role',
        'location',
        'status',
        'isLocked',
        'lockedOn',
        'remember_token',
        'email',
        'role_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
    public static function resolve()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
}

<?php

namespace Zeropingheroes\Lanager;

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
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the user's linked accounts.
     */
    public function OAuthAccounts()
    {
        return $this->hasMany('Zeropingheroes\Lanager\UserOAuthAccount');
    }

    /**
     * The roles that belong to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this
            ->belongsToMany('Zeropingheroes\Lanager\Role', 'role_assignments')
            ->withTimestamps();
    }

    /**
     * Check if the user has the specified role(s)
     * @param array $roles
     * @return bool
     * @internal param $role
     */
    public function hasRole(...$roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Get the user's avatar, in small, medium or large
     * @param str $size
     * @return string
     */
    public function avatar(string $size = 'large')
    {
        $avatar['medium'] = $this->OAuthAccounts()
            ->where('provider', 'steam')
            ->first()
            ->avatar;

        $avatar['small'] = str_replace('_medium.jpg', '.jpg', $avatar['medium']);

        $avatar['large'] = str_replace('_medium.jpg', '_full.jpg', $avatar['medium']);

        return $avatar[$size];
    }

}

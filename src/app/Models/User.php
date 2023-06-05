<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be appended.
     *
     * @var array<int, string>
     */
    protected $with = [
        'socials',
    ];
   
    /**
     * Get the user's social media accounts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(SocialMediaAccount::class);
    }

    protected $appends = [
        'github',
    ];

    /**
     * Get the user's github account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getGithubAttribute()
    {
        return $this->getSocial('github');
    }

    private function getSocial($socialName) 
    {
        foreach ($this->socials as $social) {
            if (strtolower($social->social_media) === $socialName) {
                return $social;
            }
        }

        return null;
    }
}

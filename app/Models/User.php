<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
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
        'state',
        'city',
        'district',
        'wp',
        'gender',
        'civil',
        'username',
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
    ];

    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::slug($value),
            set: fn ($value) => Str::slug($value),
        );
    }

    public function portfolios(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(portfolio::class);
    }

    public function portfolio(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(portfolio::class)->where('profile_photo', 1);
    }

    public function portfolioWithContestPhoto(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(portfolio::class)->where('contest_photo', 1);
    }

    public function portfolio_without_profile_photo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(portfolio::class);
    }

    public function links(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function interest(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Interest::class);
    }

    public function contestes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Contest::class, 'contest_participants');
    }

    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContestVotingResult::class, 'whom_vote');
    }

    public function configures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Configure::class);
    }
}

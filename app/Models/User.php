<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $state
 * @property string $city
 * @property string $district
 * @property string $wp
 * @property string $gender
 * @property string $civil
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $username
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read int|null $configures_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read int|null $contestes_count
 * @property-read \App\Models\Interest|null $interest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read int|null $model_infos_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\portfolio|null $portfolio
 * @property-read \App\Models\portfolio|null $portfolioWithContestPhoto
 * @property-read \App\Models\portfolio|null $portfolio_without_profile_photo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read int|null $portfolios_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read int|null $results_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCivil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWp($value)
 * @property int|null $status
 * @property int|null $subscribed
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \App\Models\ModelInfo|null $model_info_love
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscribed($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \App\Models\Payment|null $payment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property string|null $payment_card_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePaymentCardId($value)
 * @property array|null $preferences
 * @property-read \App\Models\City|null $city_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Configure> $configures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelInfo> $modelInfos
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\portfolio> $portfolios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $results
 * @property-read \App\Models\State|null $state_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePreferences($value)
 * @mixin \Eloquent
 */
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
        'age' ,
        'bust' ,
        'eyes' ,
        'hips' ,
        'skin' ,
        'dress' ,
        'other' ,
        'waist' ,
        'height' ,
        'hair' ,
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
        'preferences' => 'json',
    ];

    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::slug($value),
            set: fn ($value) => Str::slug($value),
        );
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('jS F Y'),
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

    public function modelInfos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ModelInfo::class)->where('key', '=', 'rate');
    }

    public function model_info_love(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ModelInfo::class)->where('key', 'love');
    }

    public function payment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function state_name(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function city_name(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contest
 *
 * @property int $id
 * @property string $title
 * @property string $start
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $category_id
 * @property string $end
 * @property float $prize_first
 * @property float $prize_second
 * @property float $prize_third
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read int|null $user_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @property-read int|null $voting_results_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest wherePrizeFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest wherePrizeSecond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest wherePrizeThird($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @property string|null $rules
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @method static \Illuminate\Database\Eloquent\Builder|Contest whereRules($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestOption> $options
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user_participants
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVotingResult> $voting_results
 * @mixin \Eloquent
 */
class Contest extends Model
{
    use HasFactory;

    public function start(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('jS F Y'),
        );
    }

    public function end(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('jS F Y'),
        );
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContestOption::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contest_participants')->inRandomOrder()->limit(2);
    }

    public function user_participants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contest_participants');
    }

    public function voting_results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContestVotingResult::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

//    public function scopeNotInVote($query)
//    {
//        return $query->whereNotIn('user_id', );
//    }
}

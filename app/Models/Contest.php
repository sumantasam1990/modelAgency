<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    public function start(): Attribute
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

//    public function scopeNotInVote($query)
//    {
//        return $query->whereNotIn('user_id', );
//    }
}

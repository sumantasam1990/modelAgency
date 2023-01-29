<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContestOption::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contest_participants')->inRandomOrder()->limit(2);
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

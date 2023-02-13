<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContestVotingResult
 *
 * @property int $id
 * @property int $contest_id
 * @property int $user_id
 * @property int $whom_vote
 * @property int $vote_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contest $contest
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereVoteCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestVotingResult whereWhomVote($value)
 * @mixin \Eloquent
 */
class ContestVotingResult extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'whom_vote', 'id');
    }

    public function contest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }


}

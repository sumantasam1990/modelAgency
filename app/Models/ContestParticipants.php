<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContestParticipants
 *
 * @property int $id
 * @property int $contest_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContestParticipants whereUserId($value)
 * @mixin \Eloquent
 */
class ContestParticipants extends Model
{
    use HasFactory;
}

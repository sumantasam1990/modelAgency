<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\portfolio
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $ext
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $profile_photo
 * @property int $contest_photo
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio query()
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereContestPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|portfolio whereUserId($value)
 * @mixin \Eloquent
 */
class portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'ext',
        'user_id'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

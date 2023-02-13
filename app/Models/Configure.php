<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Configure
 *
 * @property int $id
 * @property int $user_id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Configure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configure query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configure whereValue($value)
 * @mixin \Eloquent
 */
class Configure extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

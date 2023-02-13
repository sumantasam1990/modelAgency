<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModelInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelInfo whereValue($value)
 * @mixin \Eloquent
 */
class ModelInfo extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

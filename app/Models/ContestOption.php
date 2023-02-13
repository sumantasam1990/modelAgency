<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContestOption
 *
 * @property-read \App\Models\Contest|null $contest
 * @method static \Illuminate\Database\Eloquent\Builder|ContestOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContestOption query()
 * @mixin \Eloquent
 */
class ContestOption extends Model
{
    use HasFactory;

    public function contest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}

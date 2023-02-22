<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $title
 * @property string $age
 * @property string $height
 * @property string $gender
 * @property string $skin_color
 * @property string $hair_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read int|null $contests_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereHairColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSkinColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property string|null $dress_size
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDressSize($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    public function contests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contest::class);
    }
}

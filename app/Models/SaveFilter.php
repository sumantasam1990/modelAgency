<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SaveFilter
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveFilter whereUrl($value)
 * @mixin \Eloquent
 */
class SaveFilter extends Model
{
    use HasFactory;
}

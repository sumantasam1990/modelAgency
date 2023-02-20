<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminNote
 *
 * @property int $id
 * @property int $user_id
 * @property int $to_user_id
 * @property string $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNote whereUserId($value)
 * @mixin \Eloquent
 */
class AdminNote extends Model
{
    use HasFactory;
}

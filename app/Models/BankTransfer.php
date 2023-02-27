<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BankTransfer
 *
 * @property int $id
 * @property int $user_id
 * @property int $contest_id
 * @property string $acc_no
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereAccNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankTransfer whereUserId($value)
 * @mixin \Eloquent
 */
class BankTransfer extends Model
{
    use HasFactory;
}

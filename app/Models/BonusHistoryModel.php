<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusHistoryModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'bonus_history';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'free_bet_id',
        'constant_bonus_id',
        'event',
        'member_id',
        'is_use',
        'is_send',
        'is_delete',
        'jumlah',
        'credit',
        'hadiah',
        'type',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
    public function member()
    {
        return $this->belongsTo(MembersModel::class, 'created_by');
    }
    public function constantBonus()
    {
        return $this->belongsTo(ConstantBonusModel::class, 'constant_bonus_id');
    }

    public function referrals()
    {
        return $this->hasMany(BonusHistoryModel::class, 'referrer_id', 'created_by');
    }
}

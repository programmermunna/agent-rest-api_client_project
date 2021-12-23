<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;

class BetModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'bets';


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'bet_id',
        'seq_no',
        'bet_option',
        'group_bet_option',
        'guid',
        'shoe_id',
        'game_status',
        'round_id',
        'jackpot',
        'platform',
        'refptxid',
        'constant_provider_id',
        'game',
        'game_info',
        'type',
        'bonus_daily_referal',
        'game_id',
        'bet_name',
        'deskripsi',
        'credit',
        'bet',
        'win',
        'url_detail',
        'player_wl',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    //start referal
    /**
     * A member has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(MembersModel::class, 'referrer_id', 'id');
    }

    /**
     * A member has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(MembersModel::class, 'referrer_id', 'id');
    }

    public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'created_by');
    }

    public function game()
    {
        return $this->belongsTo(GamesModel::class, 'game_id');
    }
}

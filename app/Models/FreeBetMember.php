<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeBetMember extends Model
{
    protected $table = 'free_bet_members';

    public $timestamps = true;

    protected $fillable = [
        'member_id',
        'free_bet_id',
        'type',
        'amount',
        'is_use',
    ];

    public function member()
    {
        return $this->belongsTo(MembersModel::class, 'member_id');
    }

    public function freeBet()
    {
        return $this->belongsTo(FreeBetModel::class, 'free_bet_id');
    }
        //start referal
    /**
     * A member has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(MembersModel::class, 'referal', 'username');
    }

    /**
     * A member has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(MembersModel::class, 'referal', 'username');
    }
}
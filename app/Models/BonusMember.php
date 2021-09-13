<?php

namespace App\Models;

use App\Models\BonusModel;
use Illuminate\Database\Eloquent\Model;

class BonusMember extends Model
{
    protected $table = 'bonus_members';

    public $timestamps = true;

    protected $fillable = [
        'member_id',
        'bonus_id',
        'type',
        'amount',
    ];

    public function member()
    {
        return $this->belongsTo(MembersModel::class, 'member_id');
    }

    public function bonus()
    {
        return $this->belongsTo(BonusModel::class, 'bonus_id');
    }
}
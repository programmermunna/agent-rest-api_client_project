<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeBetModel extends Model
{

    protected $table = 'free_bets';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'event',
        'amount',
        'type',
        'maximum',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($freeBet) {
            $bytes = random_bytes(3);
            $freeBet->code = 'F-' . bin2hex($bytes);
        });
    }

    public function freeBetMembers()
    {
        return $this->hasMany(FreeBetMember::class, 'free_bet_id');
    }

    protected $appends = ['user_count', 'created_at_input'];

    public function getUserCountAttribute()
    {
        return BonusHistoryModel::where('free_bet_id', $this->id)->where('is_use', 1)->count();
    }

    public function getCreatedAtInputAttribute()
    {
        if ($this->created_at == null) {
            return null;
        }

        return $this->created_at->format('Y-m-d');
    }
}
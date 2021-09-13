<?php

namespace App\Models;

use App\Models\UploadBonusModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusModel extends Model
{
    use SoftDeletes;

    protected $table = 'bonus';

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'name',
        'event',
        'amount',
        'status',
        'event_type',
        'upload_bonus_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($bonus) {
            $bytes = random_bytes(3);
            if($bonus->event_type == 'bonus'){
                $bonus->code = 'B-' . bin2hex($bytes);
            }else{
                 $bonus->code = 'P-' . bin2hex($bytes);
            }
        });
    }

    public function bonusMembers()
    {
        return $this->hasMany(BonusMember::class, 'bonus_id');
    }

    public function uploadBonus()
    {
        return $this->belongsTo(UploadBonusModel::class);
    }
}
<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

class UploadBonusModel extends Model
{
    protected $table = 'upload_bonus';

    public $timestamps = true;

    protected $fillable = [
        'path',
        'description',
        'created_by',
        'deleted_by',
        'deleted_at',
    ];

    public function bonus()
    {
        return $this->hasMany(BonusModel::class, 'upload_bonus_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault([
            'name' => 'N/A',
        ]);
    }
}

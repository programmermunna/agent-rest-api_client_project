<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberToken extends Model
{
    protected $fillable = [
        'token',
        'member_id',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'member_id', 'id');
    }
}

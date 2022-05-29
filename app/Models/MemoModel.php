<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemoModel extends Model
{
    use SoftDeletes;
    protected $table = 'memo';

    protected $fillable = [
        'member_id',
        'subject',
        'content',
        'send_type',
        'is_sent',
        'is_reply',
        'is_read',
        'member_id',
        'memo_id',
        'is_bonus',
        'sender_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'member_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(MembersModel::class, 'sender_id');
    }

    public function parentMemo() : BelongsTo
    {
        return $this->belongsTo(MemoModel::class, 'memo_id', 'id');
    }

    public function subMemos() : HasMany
    {
        return $this->hasMany(MemoModel::class, 'memo_id')->orderByDesc('created_at');
    }

}

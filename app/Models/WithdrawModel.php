<?php

namespace App\Models;

// WEB SOCKET START
// use App\Events\CreateWithdrawalEvent;
// WEB SOCKET END
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawModel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';

    // WEB SOCKET START
    // protected $dispatchesEvents = [
    //     'created' => CreateWithdrawalEvent::class
    // ];
    // WEB SOCKET END

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'deleted_at',
    // ];

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'withdraw';

    protected $appends = ['type'];

    public $timestamps = true;

    protected function getTypeAttribute()
    {
        return "withdraw";
    }

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'members_id',
        'rekening_id',
        'jumlah',
        'credit',
        'note',
        'rek_member_id',
        'is_claim_bonus_freebet',
        'approval_status',
        'approval_status_by',
        'approval_status_at',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
}

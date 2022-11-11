<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use App\Domains\Auth\Models\Traits\Attribute\UserAttribute;
use App\Domains\Auth\Models\Traits\Method\UserMethod;
use App\Domains\Auth\Models\Traits\Relationship\UserRelationship;
use App\Domains\Auth\Models\Traits\Scope\UserScope;
use DarkGhostHunter\Laraguard\Contracts\TwoFactorAuthenticatable;
use DarkGhostHunter\Laraguard\TwoFactorAuthentication;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MembersModel extends Authenticatable implements MustVerifyEmail, TwoFactorAuthenticatable, JWTSubject
{
    use HasRoles,
    Impersonate,
    MustVerifyEmailTrait,
    Notifiable,
    SoftDeletes,
    TwoFactorAuthentication,
    UserAttribute,
    UserMethod,
    UserRelationship,
        UserScope;

    protected $connection = 'mysql';

    public const TYPE_ADMIN = 'admin';
    public const TYPE_USER = 'user';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'deleted_at',
    // ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';
    public $timestamps = true;
    protected $guard = 'api';

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
        // 'referrer_id',
        'bonus_referal',
        // 'type',
        'is_cash',
        // 'device',
        'username',
        'rek_member_id',
        'is_new_member',
        'is_next_deposit',
        'constant_rekening_id',
        'rekening_tujuan_depo_id',
        'nama_rekening',
        'email',
        'rekening_id_tujuan_depo',
        'credit',
        'email_verified_at',
        // 'password',
        // 'password_changed_at',
        // 'nomor_rekening',
        'phone',
        'active',
        'remember_token',
        'status',
        // 'referal',
        // 'info_dari',
        // 'info_dari_lainnya',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'last_login_at',
        'email_verified_at',
        'password_changed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'to_be_logged_out' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'avatar',
        // 'referral_link',
    ];
    /**
     * Get the member's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = url('https://cikaslot.com/register?ref=' . $this->username);
    }

    /**
     * @var string[]
     */
    protected $with = [
        // 'permissions',
        // 'roles',
    ];

    /**
     * Return true or false if the user can impersonate an other user.
     *
     * @param void
     * @return  bool
     */
    public function canImpersonate(): bool
    {
        return $this->can('admin.access.user.impersonate');
    }

    /**
     * Return true or false if the user can be impersonate.
     *
     * @param void
     * @return  bool
     */
    public function canBeImpersonated(): bool
    {
        return !$this->isMasterAdmin();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function freeBets()
    {
        return $this->hasMany(FreeBetMember::class);
    }
    public function bonusHistory()
    {
        return $this->hasMany(BonusHistoryModel::class);
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
        return $this->hasMany(MembersModel::class, 'referrer_id', 'id')->latest();
    }

    public function bets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BetModel::class, 'created_by');
    }

    public function withdrawals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WithdrawModel::class, 'members_id');
    }

    public function deposits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DepositModel::class, 'members_id');
    }

    public function rekeningMembers()
    {
        return $this->hasMany(RekMemberModel::class, 'created_by', 'id');
    }

    public function scopeIsNewMember($query, $userId)
    {
        return $query->where('is_new_member', 1)
            ->where('id', $userId);
    }

    public function scopeIsNextDeposit($query, $userId)
    {
        return $query->where('is_next_deposit', 1)
            ->where('id', $userId);
    }

    public function authTokens(): HasMany
    {
        return $this->hasMany(MemberToken::class, 'member_id', 'id');
    }
}

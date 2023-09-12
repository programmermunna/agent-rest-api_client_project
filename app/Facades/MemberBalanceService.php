<?php

namespace App\Facades;

use App\Models\MembersModel;
use Illuminate\Support\Facades\Facade;

/**
 * @method static float increment(MembersModel $member, float $amount)
 * @method static float decrement(MembersModel $member, float $amount)
 *
 * @see \App\Services\MemberBalanceService
 */
class MemberBalanceService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\MemberBalanceService::class;
    }
}

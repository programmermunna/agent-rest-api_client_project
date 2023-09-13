<?php

namespace App\Services;

use App\Models\MembersModel;

class MemberBalanceService
{

    public function increment(MembersModel $member, float $amount): float
    {
        try {
            $member->increment('credit',$amount);

            return ($member->refresh())->credit;
        } catch (\Throwable $exception) {
            logger('Member Balance Increment Error');
            logger($exception);

            return 0.0;
        }
    }

    public function decrement(MembersModel $member, float $amount): float
    {
        try{
            $member->decrement('credit', $amount);

            return ($member->refresh())->credit;
        } catch (\Throwable $exception) {
            logger('Member Balance Increment Error');
            logger($exception);

            return 0.0;
        }
    }
}

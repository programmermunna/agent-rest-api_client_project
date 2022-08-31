<?php

namespace App\Jobs;

use App\Models\BetModel;
use App\Models\MembersModel;
use App\Models\UserLogModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProccessPragmatic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bet = BetModel::create($this->data);
        $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
            ->leftJoin('members', 'members.id', '=', 'bets.created_by')
            ->where('bets.id', $bet->id)->first();
        $member = MembersModel::where('id', $bet->created_by)->first();
        UserLogModel::logMemberActivity(
            'create bet',
            $member,
            $bet,
            [
                'target' => $nameProvider->username,
                'activity' => 'Bet',
                'device' => $nameProvider->device,
                'ip_member' => $nameProvider->last_login_ip,
            ],
            $nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bet->game_info . ' idr '. $nameProvider->bet
        );

        return true;
    }
}

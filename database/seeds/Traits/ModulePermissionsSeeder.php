<?php

use App\Domains\Auth\Models\Permission;
use Illuminate\Database\Seeder;

class ModulePermissionsSeeder extends Seeder
{
    /**
     * Append Permissions for new module.
     * @array
     */
    private $permissions = [
        [
            'name' => 'user.access.members.win_lose_togel',
            'description' => 'Can See List of Win Lose Togel',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.bet.list-bets',
            'description' => 'Can See List Of Bets',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.bet.bet-buangan',
            'description' => 'Can See List Of Bet Buangan',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.bet.buangan-terpasang',
            'description' => 'Can See List Of Bet Buangan Terpasang',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.bet.bets-table',
            'description' => 'Can See Bets Table',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.keluaran.analisa',
            'description' => 'Can See Analisa',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.keluaran.scan',
            'description' => 'Can See Scan',
            'type' => 'user',
            'guard_name' => 'web',
        ],
        [
            'name' => 'user.access.keluaran.submit',
            'description' => 'Can See Submit',
            'type' => 'user',
            'guard_name' => 'web',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->permissions as $Permission) {
            Permission::firstOrCreate(['name' => $Permission['name']], $Permission);
        }
    }
}

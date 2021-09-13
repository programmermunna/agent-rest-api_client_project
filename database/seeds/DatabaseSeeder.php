<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'activity_log',
            'failed_jobs',
        ]);

        $this->call(AuthSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(ConstantProviderSeeder::class);
        $this->call(ConstantRekeningSeeder::class);
        $this->call(AppSettingSeeder::class);
        $this->call(RekeningAgentSeeder::class);

        Model::reguard();
    }
}

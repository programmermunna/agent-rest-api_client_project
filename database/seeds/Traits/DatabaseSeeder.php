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
        $this->call(AppSettingSeeder::class);
        $this->call(ConstantBonusSeeder::class);
        $this->call(ConstantProviderSeeder::class);
        $this->call(ConstantRekeningSeeder::class);
        $this->call(ImageContentsSeeder::class);
        $this->call(RekeningAgentSeeder::class);
        $this->call(RekeningSeeder::class);
        $this->call(UserLogSeeder::class);
        $this->call(WebsiteContentsSeeder::class);
        $this->call(BonusTurnoverSeeder::class);
        $this->call(BonusCashbackSeeder::class);
        $this->call(ModulePermissionsSeeder::class);

        $this->call(ConstantProviderTogelSeeder::class);
        $this->call(TogelCategoryGameSeeder::class);
        $this->call(TogelDiscountKeiSeeder::class);
        $this->call(TogelDreamsBookSeeder::class);
        $this->call(TogelGameSeeder::class);
        $this->call(TogelShioNameSeeder::class);
        $this->call(TogelShioNumberSeeder::class);
        $this->call(TogelSettingGameSeeder::class);
        $this->call(TogelResultsNumberSeeder::class);
        $this->call(ConstantProviderTogelWlSeeder::class);
        $this->call(BetsTogelSeeder::class);    
        $this->call(TogelPeraturanSeeder::class);    
        
        Model::reguard();
    }
}

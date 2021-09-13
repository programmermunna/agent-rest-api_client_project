<?php

use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Refferal Game
        \DB::table('app_settings')->insert([
            'name' => 'all_bet',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'pg_soft',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'playtech',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'joker_gaming',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'spade_gaming',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'pragmatic_play',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'pragmatic_play_live',
            'value' => 0,
            'type' => 'game',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'habanero',
            'value' => 0,
            'type' => 'game',
        ]);

        // Maintenance
        \DB::table('app_settings')->insert([
            'name' => 'main_maintenance_description',
            'value' => 'We are adding more nice features for you :)',
            'type' => 'maintenance',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'main_maintenance',
            'value' => 'Be right Back !!!!!!',
            'type' => 'maintenance',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'status',
            'value' => '200',
            'type' => 'maintenance',
        ]);

        // Social Media
        \DB::table('app_settings')->insert([
            'name' => 'telegram',
            'value' => 'telecika',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'email',
            'value' => 'test email',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'phone',
            'value' => 'test phone',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'facebook',
            'value' => 'facebookcika',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'wechat',
            'value' => 'test wechat',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'skype',
            'value' => 'test skype',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'line',
            'value' => 'cikaline',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'sms',
            'value' => 'test sms',
            'type' => 'social_media',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'whatsapp',
            'value' => '999999912312312312',
            'type' => 'social_media',
        ]);
        
        // Web
        \DB::table('app_settings')->insert([
            'name' => 'max_deposit',
            'value' => '100000000',
            'type' => 'web',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'min_deposit',
            'value' => '50000',
            'type' => 'web',
        ]);
        \DB::table('app_settings')->insert([
            'name' => 'min_withdraw',
            'value' => '50000',
            'type' => 'web',
        ]);

        // web page
        \DB::table('app_settings')->insert([
            'name' => 'multimedia',
            'value' => 'https://www.youtube.com/watch?v=IUxi0e2NkBU,https://www.youtube.com/watch?v=X4Qc7fajBCg,https://www.youtube.com/watch?v=hja1M_ktXT8,https://www.youtube.com/watch?v=fiwly53PM-g,https://www.youtube.com/watch?v=XRUeCECctcA,https://www.youtube.com/watch?v=-0_yU6Y_Jok',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'footer_text',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'footer_tag',
            'value' => '© 2018 - 2021 Copyright . All Rights Reserved. 123 asdsadsadas',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'apk_url',
            'value' => 'https://linkToAPKfile',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'whats_app_url',
            'value' => '08123456789',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'live_chat_url',
            'value' => 'tes.com',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'live_chat_tag',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'meta_tag',
            'type' => 'web_page',
        ]);

        \DB::table('app_settings')->insert([
            'name' => 'title',
            'value' => 'Cikaslots',
            'type' => 'web_page',
        ]);
    }
}

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
        \DB::table('app_settings')->insert(['id' => '1','name' => 'main_maintenance','value' => 'Be right Back !!!!!!','type' => 'maintenance','additional' => NULL,'created_by' => '40','updated_by' => '40','deleted_by' => NULL,'created_at' => '2021-09-12 05:05:32','updated_at' => '2021-09-12 05:05:32','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '2','name' => 'main_maintenance_description','value' => 'We are adding more nice features for you :)','type' => 'maintenance','additional' => NULL,'created_by' => '40','updated_by' => '40','deleted_by' => NULL,'created_at' => '2021-09-12 05:05:32','updated_at' => '2021-09-12 05:05:32','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '3','name' => 'status','value' => '200','type' => 'maintenance','additional' => NULL,'created_by' => '40','updated_by' => '40','deleted_by' => NULL,'created_at' => '2021-09-12 05:05:32','updated_at' => '2021-09-12 05:05:32','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '4','name' => 'min_withdraw','value' => '52000','type' => 'web','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-09-03 06:13:07','updated_at' => '2021-09-03 06:13:07','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '5','name' => 'min_deposit','value' => '51000','type' => 'web','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-09-03 06:13:07','updated_at' => '2021-09-03 06:13:07','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '6','name' => 'max_deposit','value' => '1000000','type' => 'web','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-09-03 06:13:07','updated_at' => '2021-09-03 06:13:07','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '7','name' => 'pragmatic_play','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '8','name' => 'pragmatic_play_live','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '9','name' => 'habanero','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '10','name' => 'spade_gaming','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '11','name' => 'joker_gaming','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '12','name' => 'playtech','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '13','name' => 'pg_soft','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '16','name' => 'all_bet','value' => '0.01','type' => 'game','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-26 02:56:53','updated_at' => '2021-08-26 02:56:53','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '19','name' => 'title','value' => 'Cikaslots','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);
        
        \DB::table('app_settings')->insert(['id' => '20','name' => 'meta_tag','value' => '<meta name=description
        content=" ialah situs agen judi slot online, togel online, dan judi kasino online terbesar di indonesia yang menerima transaksi deposit via pulsa , ovo, gopay, dana dan link aja" /><meta name=keywords
        content="slot online, slot pulsa, judi slot, togel pulsa, togel deposit pulsa, slot deposit pulsa, judi kasino, " /><link rel=canonical href="" /><meta name=google-site-verification content=A2Q8kILHh0sZukiwX8SuyJn3ljO-kfucQqmiX2AAiho /><meta name=google-site-verification content=Xi-j-7tWHJeOr284wAKu7DPa1dEmTnKjS0--7nurQAI />','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '21','name' => 'live_chat_tag','value' => 'window.__lc = window.__lc || {};
        window.__lc.license = 12104664;;
        (function(n, t, c){function i(n){return e._h ? e._h.apply(null, n) : e._q.push(n)
        }var e = {
        _q: [],
        _h: null,
        _v: "2.0",
        on: function(){i(["on", c.call(arguments)])
        },
        once: function(){i(["once", c.call(arguments)])
        },
        off: function(){i(["off", c.call(arguments)])
        },
        get: function(){if (!e._h) throw new Error("[LiveChatWidget] You can\'t use getters before load.");
        return i(["get", c.call(arguments)])
        },
        call: function(){i(["call", c.call(arguments)])
        },
        init: function(){var n = t.createElement("script");
        n.async = !0, n.type = "text/javascript", n.src =
        "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
        }};
        !n.__lc.asyncInit && e.init(),n.LiveChatWidget = n.LiveChatWidget || e
        }(window, document, [].slice))','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '22','name' => 'live_chat_url','value' => 'test.com','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '23','name' => 'whats_app_url','value' => '08123456789','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '24','name' => 'apk_url','value' => 'https://linkToAPKfile','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '25','name' => 'multimedia','value' => 'https://www.youtube.com/watch?v=IUxi0e2NkBU,https://www.youtube.com/watch?v=X4Qc7fajBCg,https://www.youtube.com/watch?v=hja1M_ktXT8,https://www.youtube.com/watch?v=fiwly53PM-g,https://www.youtube.com/watch?v=XRUeCECctcA,https://www.youtube.com/watch?v=-0_yU6Y_Jok','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '26','name' => 'footer_text','value' => NULL,'type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '27','name' => 'footer_tag','value' => '© 2018 - 2021 Copyright . All Rights Reserved. 123 asdsadsadas','type' => 'web_page','additional' => NULL,'created_by' => '1','updated_by' => '1','deleted_by' => NULL,'created_at' => '2021-08-25 07:10:48','updated_at' => '2021-08-25 07:10:48','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '28','name' => 'whatsapp','value' => '999999912312312312','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '29','name' => 'sms','value' => 'test sms','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '30','name' => 'line','value' => 'cikaline','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '31','name' => 'skype','value' => 'test skype','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '32','name' => 'wechat','value' => 'test wechat','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '33','name' => 'facebook','value' => 'facebookcika','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '34','name' => 'telegram','value' => 'telecika','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);

        \DB::table('app_settings')->insert(['id' => '35','name' => 'email','value' => 'test email','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);
        
        \DB::table('app_settings')->insert(['id' => '36','name' => 'phone','value' => 'test phone','type' => 'social_media','additional' => NULL,'created_by' => '41','updated_by' => '41','deleted_by' => NULL,'created_at' => '2021-08-14 03:41:28','updated_at' => '2021-08-14 03:41:28','deleted_at' => NULL]);
    }
}

<?php

use Illuminate\Database\Seeder;

class ConstantProviderTogelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('constant_provider_togel')->insert([
            'id' => '1',
            'name' => 'HK SIANG',
            'name_initial' => 'HKD',
            'website_url' => 'www.hkpools1.com',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '10:30 WIB',
            'jadwal' => '11:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '2',
            'name' => 'BULLSEYE',
            'name_initial' => 'NZB',
            'website_url' => 'mylotto.co.nz/results/bullseye',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '11:45 WIB',
            'jadwal' => '12:15 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '3',
            'name' => 'SYDNEY',
            'name_initial' => 'SY',
            'website_url' => 'www.sydneypoolstoday.com',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '13:30 WIB',
            'jadwal' => '13:50 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '4',
            'name' => 'HAIPHONG',
            'name_initial' => 'HAI',
            'website_url' => 'www.haiphongpools.com',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '14:30 WIB',
            'jadwal' => '15:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '5',
            'name' => 'SINGAPORE',
            'name_initial' => 'SG',
            'website_url' => 'www.singaporepools.com',
            'period' => '0',
            'hari_diundi' => 'Senin, Rabu, Kamis, Sabtu, Minggu',
            'libur' => 'Selasa, Jumat',
            'tutup' => '17:30 WIB',
            'jadwal' => '17:45 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '6',
            'name' => 'JINAN',
            'name_initial' => 'JINAN',
            'website_url' => 'www.jinanpools.net',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '19.30 WIB',
            'jadwal' => '20.00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '7',
            'name' => 'QATAR',
            'name_initial' => 'QTR',
            'website_url' => 'www.qatarlottery.com',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '20:30 WIB',
            'jadwal' => '21:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
          \DB::table('constant_provider_togel')->insert([
            'id' => '8',
            'name' => 'MALAYSIA',
            'name_initial' => 'BGP',
            'website_url' => 'http://www.malaysialottery.net/',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '21:30 WIB',
            'jadwal' => '22:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);

          \DB::table('constant_provider_togel')->insert([
            'id' => '9',
            'name' => 'HONGKONG',
            'name_initial' => 'HK',
            'website_url' => 'https://hongkongpools.com/',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '22:30 WIB',
            'jadwal' => '23:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);

          \DB::table('constant_provider_togel')->insert([
            'id' => '10',
            'name' => 'SINGAPORE 45',
            'name_initial' => 'SGP45',
            'website_url' => 'http://www.malaysialottery.net/',
            'period' => '0',
            'hari_diundi' => 'Setiap Hari',
            'libur' => NULL,
            'tutup' => '21:30 WIB',
            'jadwal' => '22:00 WIB',
            'status' => '0',
            'created_by' => '2',
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
            'updated_at' => NULL,
            'deleted_at' => NULL
          ]);
        
    }
}

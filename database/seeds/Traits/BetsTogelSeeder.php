<?php

use Illuminate\Database\Seeder;

class BetsTogelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // member seeder
        \DB::table('members')->insert(['id' => '1','referal' => NULL,'rek_member_id' => '8','type' => 'admin','is_cash' => '0','bonus_referal' => '0.00','credit' => '100025.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'pingpong','device' => 'Chrome','is_next_deposit' => '0','is_new_member' => '0','constant_rekening_id' => '4','nama_rekening' => NULL,'nomor_rekening' => '11111','phone' => '08123456789','email' => 'pingpong@email.com','rekening_id_tujuan_depo' => '40','email_verified_at' => '2020-10-02 18:07:23','password' => '$2y$10$O05H2DFMCCWz8IB4yNotR.kexgII04xUcrPaaMaXXQ1WkxgvW1una','password_changed_at' => '2021-04-25 06:13:01','active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-09-23 02:02:25','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => '4bqFvo32sAH8gMMIvCAKPdvVQeepR3kKoLt1LyPr0R9S8vIktsExqx8TuGDc','created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-01 18:07:23','updated_at' => '2021-09-23 09:05:57','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '2','referal' => NULL,'rek_member_id' => NULL,'type' => 'admin','is_cash' => '0','bonus_referal' => NULL,'credit' => '144445.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'admin','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '6','nama_rekening' => 'Admin Sukses','nomor_rekening' => '22222','phone' => NULL,'email' => 'admin@admin.com','rekening_id_tujuan_depo' => '17','email_verified_at' => '2021-02-28 01:05:48','password' => '$2y$10$9ObIKGR5vxJ6msT3PBe4vecj.04p.9qgMeih/tUVHvkr2AVXly2qa','password_changed_at' => NULL,'active' => '0','status' => '0','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-07-10 00:08:55','last_login_ip' => '92.223.85.245','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-02-28 01:05:48','updated_at' => '2021-08-08 02:33:30','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '3','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.41','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testdaftar','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Daftar','nomor_rekening' => '33333','phone' => NULL,'email' => 'testdaftar@testdaftar.com','rekening_id_tujuan_depo' => '10','email_verified_at' => '2021-03-18 03:18:41','password' => '$2y$10$4lOi5WgoJxPDZqFtMoxWVObKfqNu0khLc708nGI96aAGEnueh7XZa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-03-18 03:44:57','last_login_ip' => '103.115.175.244','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-03-18 03:18:41','updated_at' => '2021-08-16 01:03:15','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '4','referal' => 'Referalnya Kartika','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.10','credit' => '96300.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikacantik','device' => '','is_next_deposit' => '0','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => 'Kartika Cantik Luar Biasa','nomor_rekening' => '112233445566778899','phone' => '08121234345656','email' => 'kartikacantik@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => '2021-04-01 21:18:06','password' => '$2y$10$lbN0aE6rGC3fhDKejH0e1evapbTTqqjF8yNpwXQlDzdYYJNkiaKAy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-08-26 01:46:34','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-04-01 21:18:06','updated_at' => '2021-08-26 01:47:03','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '5','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '29000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'bejibun','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => 'Bejibun','nomor_rekening' => '121212121212','phone' => NULL,'email' => 'bejibun@email.com','rekening_id_tujuan_depo' => '6','email_verified_at' => '2021-04-08 08:07:06','password' => '$2y$10$uN0aKdrkS1r4k/k3eMuPduGRWjPyNbRgp5Di/Lnvb9restYHzR49a','password_changed_at' => NULL,'active' => '0','status' => '2','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-04-08 08:11:08','last_login_ip' => '103.115.175.241','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-04-08 08:07:06','updated_at' => '2021-05-29 23:59:57','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '6','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '60.00','credit' => '840545.18','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'macankeren','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'at','nomor_rekening' => '1163388986','phone' => '081260610999','email' => 'mngcikaloka@gmail.com','rekening_id_tujuan_depo' => '15','email_verified_at' => '2021-04-16 13:11:59','password' => '$2y$10$YfPsLbroE90XxKeCJngaee6aqttSjf4iBIPvL8ViEoKcCVPDVn5Oy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Lain-lain','info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-09-06 02:59:56','last_login_ip' => '5.62.34.23','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-04-16 13:11:59','updated_at' => '2021-09-09 16:08:44','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '7','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '25000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Ronald','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => '8745834789','nomor_rekening' => '753457','phone' => '081366020805','email' => 'jambispirit@gmail.com','rekening_id_tujuan_depo' => '10','email_verified_at' => '2021-05-09 14:14:26','password' => '$2y$10$4wwN7CuofTF7I4BUxkWnAOUdGw5pE3x8cOmzd7cs5nLkMEJXXFNj6','password_changed_at' => NULL,'active' => '0','status' => '2','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => 'Asia/Jakarta','last_login_at' => '2021-05-09 14:14:57','last_login_ip' => '103.148.44.67','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-05-09 14:14:26','updated_at' => '2021-07-18 15:02:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '8','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'htay','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => '1233','nomor_rekening' => '12313','phone' => '123456789','email' => 'cikatechgroup14@gmail.com','rekening_id_tujuan_depo' => '10','email_verified_at' => '2021-05-22 04:14:45','password' => '$2y$10$hcU6xlXz6O1dGo.fY.nEZ.1IopMicTwF3lh.p.a0SkBNDmeLrTCSq','password_changed_at' => NULL,'active' => '0','status' => '2','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => 'Asia/Singapore','last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-05-22 04:14:45','updated_at' => '2021-07-18 14:58:42','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '9','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '150.00','credit' => '-15000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'HelloYser','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '1234561111','phone' => '12374892','email' => 'test@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$.dTa1ti5346R/7OHKQTmNeoBeJDTi60nwlRAzuNbq1eW3wpXltiuG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-10 01:56:06','updated_at' => '2021-08-05 23:23:47','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '11','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testing','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'dshahdas','nomor_rekening' => '23813','phone' => '7321893891','email' => 'dsaodjsao@gmail.com','rekening_id_tujuan_depo' => '11','email_verified_at' => NULL,'password' => '$2y$10$aksrjYVtCd4xxNxUJiFsBO0/lBgkMJu7scn4dLeMgqFQENzJLfKq.','password_changed_at' => '2021-07-04 08:31:04','active' => '0','status' => '2','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-04 08:31:25','last_login_ip' => '103.115.175.241','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-10 04:58:10','updated_at' => '2021-07-18 14:59:15','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '12','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '100000.00','credit' => '-10000000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'djsaiojdaio','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '5','nama_rekening' => 'fdsafasd','nomor_rekening' => '21312412','phone' => '4271388217389','email' => 'dsakjds@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$vp3aP.GLjC3oe6NersCUZux9ti80RJP/kQsvUdOHJd2yZcC2aE46i','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-10 05:10:19','updated_at' => '2021-08-11 06:48:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '13','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'test','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'Test','nomor_rekening' => '1235678900','phone' => '+23123123213','email' => 'gg@gmail.com','rekening_id_tujuan_depo' => '22','email_verified_at' => NULL,'password' => '$2y$10$lo7auEqEXoW3XG/GDltpR.1C4Gx2zVV2ysO//p3Trm1R2eA33uTiG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-10 08:01:21','updated_at' => '2021-09-10 10:04:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '14','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'Budi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Budiwan Andi','nomor_rekening' => '2235789554','phone' => '0854466885455','email' => 'budiwan@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$vPM7vjYK9EarbhZuHKlQU.8VQ77d.I.1ynVSa9vE4fm1mNAdVXplC','password_changed_at' => NULL,'active' => '0','status' => '2','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-06-23 00:30:37','last_login_ip' => '118.137.176.179','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-21 03:39:08','updated_at' => '2021-07-18 15:02:07','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '15','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'dasdsa','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'dffsadfasdf','nomor_rekening' => '32143243242','phone' => '54352342','email' => 'dfasdsa@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$A0EFdLrf09SYVQz49WZWie6aA.SwkgaDTeFjeSUf5.lEb.aMIxg.i','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-25 00:42:50','updated_at' => '2021-06-25 00:42:50','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '16','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'robbyramasenju','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Budi','nomor_rekening' => '1122358862','phone' => '0856445114588','email' => 'robby@gmail.com','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$kOBE/AsNguEY9Bzgx8JLs.QskdhQ1o9tDGSF5PjGiA/yxVphooz/e','password_changed_at' => NULL,'active' => '0','status' => '2','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-04 06:00:15','last_login_ip' => '92.223.85.68','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-06-29 02:38:56','updated_at' => '2021-09-09 16:08:44','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '17','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'Halooo','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => 'jdasiojdoa','nomor_rekening' => '8239018','phone' => '37281973','email' => 'dhiuoashj@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$pljDMS8HcepOnfLxSmDQdu7F1WmS7V0nEENO1KQ.q7gzk1z0IlXT2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-16 04:09:29','last_login_ip' => '95.142.120.48','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-07 22:21:26','updated_at' => '2021-07-16 04:09:29','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '18','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'bbb','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'bb@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$.FGwUBvHEmD76LoCnwBZhuN3Iei1WZ8FtY3xSXCANps37juBNmsE6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-09 02:46:41','last_login_ip' => '92.223.85.252','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-09 02:45:50','updated_at' => '2021-07-09 02:46:41','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '19','referal' => 'pingpong','rek_member_id' => '1','type' => 'user','is_cash' => '0','bonus_referal' => '6.50','credit' => '103464179.40','rekening_tujuan_depo_id' => NULL,'referrer_id' => '3','username' => 'namasaya','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => '3','nama_rekening' => 'dhsaudasio','nomor_rekening' => '3271983','phone' => '849023180','email' => 'sjdioajo@gmail.com','rekening_id_tujuan_depo' => '43','email_verified_at' => NULL,'password' => '$2y$10$lDkcyh6feTwxBNBq9P3HVet6WtRLySKjadCE/XBnd1WApwJ/iFq2u','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 10:34:02','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:13:12','updated_at' => '2021-09-23 10:34:02','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '20','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizky sianturi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => '123123wqrsf1qw41','nomor_rekening' => '13414446431','phone' => '12342513524','email' => 'rizky123@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$3qhg0Wy3znPZ5/QK8OHjmOGVF.ZUrB8lm4aYB4pkHjHt0owMIb7uK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:17:06','updated_at' => '2021-07-10 08:17:06','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '21','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'aaa aaa','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'als@aa','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$/rT1xgaUlKI3gI0UNhYqruXm5M3BaDUcSjQmDKMD2POEb8sVdNKNi','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:18:51','updated_at' => '2021-07-10 08:18:51','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '22','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'username','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => '1123123','nomor_rekening' => '1231255345','phone' => '012381274','email' => 'username@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$tnbQMVReUKcD8u0M9YzUf.oXaq7NZnzmfGLdk8Lc8lMbNwq.14nr6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:24:42','updated_at' => '2021-07-10 08:24:42','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '23','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'usernamep','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => '1234414124','nomor_rekening' => '343535234','phone' => '12415513','email' => 'usernamep@gmail.com','rekening_id_tujuan_depo' => '25','email_verified_at' => NULL,'password' => '$2y$10$1VX.FvZFf56XcbFn0MRpmelXnC/E8XbKM6pUi6K7Ho2TDR7aZ6SSW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:29:07','updated_at' => '2021-08-13 02:17:26','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '24','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tes098','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'tes@tes','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$VtP0yPodujQ4ruHNgCnXDeL1ulNSqZWPaQoBCFw3v9fKDY4WWJMQG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:29:24','updated_at' => '2021-07-10 08:29:24','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '25','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tes0987','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'tes@tes123','rekening_id_tujuan_depo' => '7','email_verified_at' => NULL,'password' => '$2y$10$6iNTwNjX1UHXnbgJICBHHOV7DDBXQJA51dEt4GSeoZ6kmSNKyw6Da','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:31:39','updated_at' => '2021-08-27 21:53:49','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '26','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tes000000','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'yoga','nomor_rekening' => '34242342','phone' => '12374892','email' => 'tes@tes123aaaa','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$RTLCNrNtrN2R23gVAfvrGuiq.PAS4odLq8/8L1Z2ST7madBF61Qj.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-10 08:58:24','updated_at' => '2021-07-17 02:05:04','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '27','referal' => NULL,'rek_member_id' => '22','type' => 'user','is_cash' => '0','bonus_referal' => '929150.86','credit' => '1010000.18','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => '6','nama_rekening' => NULL,'nomor_rekening' => '12824764555','phone' => '0888888888','email' => 'rizkysaaa@email.us','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$mqBfwNDP0/.p7wVUR1kwqe8hphyH2bMiowpfKfT9/nOCvPb9I7o/.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 00:25:32','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => 'Teman','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-15 01:36:41','updated_at' => '2021-08-26 00:26:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '28','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testsekali','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'test sekali lagi','nomor_rekening' => '48484848','phone' => '09888888888','email' => 'testsekali@testsekali.co.my','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$EyAb5wHevM7/shm5ndMA2OBI81Zi2TPsJtWeda2n8G/kG7ZSReWGO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-15 07:01:44','last_login_ip' => '92.223.85.198','to_be_logged_out' => '0','provider' => 'Forum','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-15 07:01:37','updated_at' => '2021-07-15 07:01:44','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '29','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tes000000aaaa','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'tes@tes123aaaaaaa','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Px0iH91pgDrkxgrnmaZQouWNlrUL0ixswyBhuB6CrB2tVoHjPJgwW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-16 04:13:21','updated_at' => '2021-07-16 04:13:21','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '30','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testajah','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '5','nama_rekening' => '124351534613463456345435143543','nomor_rekening' => '1234113111123','phone' => '09999999','email' => 'rizkysianturi@gmail','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1F9cJbRm422QLhQALQeOGOusiY9D3RjieDRHK1NNMh9EAVB3zfqaO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Twitter','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-17 23:31:56','updated_at' => '2021-07-17 23:31:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '31','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => NULL,'credit' => '80000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'nama rizku','nomor_rekening' => '124555555','phone' => '07097808','email' => 'awseqwe@gmila','rekening_id_tujuan_depo' => '2','email_verified_at' => NULL,'password' => '$2y$10$b5IKotxEPVZr87I5dgCZSeRQtAObVizJsLmJJtNXojRFC5y.nZO3y','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-18 02:03:27','last_login_ip' => '185.54.231.21','to_be_logged_out' => '0','provider' => 'BBM','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-18 01:24:36','updated_at' => '2021-07-27 23:37:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '32','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refkartikacantik50','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'refkartikacantik50@com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$qQb6L/tnhCYJi3UcvREKCu6y/kehNj99hbWQ2Gi12z5P2P2pSXk3a','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-19 23:04:32','updated_at' => '2021-07-19 23:04:32','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '33','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refPingpong','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'refPingpong@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$h1wy6iCLu7NMha0y555gKuYuF8tOLAyaS5okx0LbQBE9b/.lZAfdq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-19 23:05:13','updated_at' => '2021-07-19 23:05:13','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '34','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refPingpong2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '123748924','email' => 'refPingpong2@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$V5SzDv8SzCdkce.QWG7CnOSBMynaKQpFVWfjQjdVc1b9NLpXHavPi','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-20 00:49:10','updated_at' => '2021-07-27 14:34:31','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '35','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi5','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => '5','nama_rekening' => 'sdasdsad wqe','nomor_rekening' => '1234124','phone' => '46436213123123','email' => 'asdasd@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$J05l0cuIjgWCJfbAnINSv.hjKGJ3m/UQms3TS4Q4S5xuOrjOpWRYK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 00:37:42','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => 'Teman','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-25 02:42:28','updated_at' => '2021-08-26 00:37:42','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '36','referal' => 'Referalnya Kartika','rek_member_id' => '12','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '21976253.13','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => '4','nama_rekening' => '"""saya mengubah Dana ke Bca"""','nomor_rekening' => '112233445566778899','phone' => '08121234345656','email' => 'kartikasari@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => '2021-04-01 21:18:06','password' => '$2y$10$A3wcbCZq4cIbQZC6uR9ecu9kD4/odHovv.cC8xLNagy6YN2ltUv9W','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => 'Asia/Phnom_Penh','last_login_at' => '2021-09-24 19:15:48','last_login_ip' => '103.115.175.242','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-04-01 21:18:06','updated_at' => '2021-09-24 19:15:48','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '37','referal' => '','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturu00','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'oke sekali kan','nomor_rekening' => '122312555','phone' => '222222222220222222222222222222222222222','email' => 'asda22sd@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$oK7dXs5dWaz7u4JWu06YT.5kLWmyuOBLE6Xo8JhWbJJ3FzDulcT6G','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Teman','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-25 22:35:32','updated_at' => '2021-07-27 22:46:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '38','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpong2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'Tarek Mahmoud','nomor_rekening' => '4738874585244521','phone' => '62000000000','email' => 'pingpong@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$RE2S6MclXd6.p5My46soZ.hCF36AU6Uxrn91Jmbt.obojvXcPXyvq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-26 13:33:55','last_login_ip' => '156.213.104.64','to_be_logged_out' => '0','provider' => 'Twitter','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-26 13:33:42','updated_at' => '2021-07-26 13:33:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '39','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '1.00','credit' => '206500.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'galihprawira','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => 'Moch Galih Prawira Adam','nomor_rekening' => '123456789','phone' => '082295211304','email' => 'galihprawira.cikatech@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$fYMQdZqGSMDT3.PfJJ0WiuUymr5lTBkII7oHnI04ZqBjMrqoUztgu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-29 21:54:23','last_login_ip' => '95.142.120.138','to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-27 11:32:08','updated_at' => '2021-07-29 21:54:23','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '41','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refkartikacantik','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'refkartikacantik','nomor_rekening' => '123456789','phone' => '6289123456','email' => 'refkartikacantik@gmail.com','rekening_id_tujuan_depo' => '8','email_verified_at' => NULL,'password' => '$2y$10$H8bQJek5T5O.ksz41yKXU.s2ORFBIMyOhPhXzYHW.BDVXbsH7zafm','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Refferal','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-30 23:54:55','updated_at' => '2021-08-23 10:02:02','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '42','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teskartika','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'teskartika','nomor_rekening' => '09876543','phone' => '62831231','email' => 'teskartika@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Y.6i6OEqVggOHxhe0H9Wz.W48IdcZJTdCo5R4OUiPonp0A79OZqKa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Refferal','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-30 23:59:25','updated_at' => '2021-07-30 23:59:25','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '53','referal' => 'pingpong','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '267.00','credit' => '46300.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'tesping7','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'Test Account','nomor_rekening' => '34242342','phone' => '12374892','email' => 'tesping7@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$5zWFxciD7w02ubAsLDcvTe6FtulHThzSt4Cx0ZtqoGNxqNtnaHKXa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-09 01:50:22','last_login_ip' => '185.54.231.41','to_be_logged_out' => '0','provider' => 'Facebook','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 05:45:59','updated_at' => '2021-08-09 06:44:30','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '54','referal' => 'pingpong','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpongoi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'pingpongoi','nomor_rekening' => '1231231231231','phone' => '6212342342','email' => 'pingpongoi@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$FfQKTRJR/NlEMaQmbeRbCOuqMV8XK7j/Q2HJEwmZ759iDaUcuJ/YW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Refferal','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 05:48:11','updated_at' => '2021-07-31 05:48:11','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '55','referal' => 'namasaya','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refnamasaya','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'refnamasaya','nomor_rekening' => '123112313123','phone' => '12328347284728','email' => 'refnamasaya@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$CWNkB7D0GdQpOdZjoDypdeE3WLhRKtZkkQ3ZvlKsmPYCeq1r.JVYy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => 'Refferal','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 05:51:32','updated_at' => '2021-07-31 05:51:32','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '56','referal' => 'pingpong','rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'rePingpong123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'rePingpong123','nomor_rekening' => '123131231','phone' => '123131231321','email' => 'rePingpong123@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$GX87NrXqyiU6apiHiVNM9OAddmPo.mdbFTZiGFsDOe68oJmQX4Fza','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 07:35:06','updated_at' => '2021-07-31 07:35:06','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '57','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testingdong','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Testing Dong','nomor_rekening' => '121212','phone' => '12345678','email' => 'testingdong@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$5qh.vWzvVaocSDd9VhC31ul0XTD3WSPiBF2/5nHvS5c7bJvtRXROm','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-31 08:13:10','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 08:12:28','updated_at' => '2021-07-31 08:13:10','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '59','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'raymond','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Raymond12!@','nomor_rekening' => '342323234','phone' => '13232323','email' => 'Raymond12!@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$/p0V/6ibcdkud.1d1ZxaY.9kuMge8zQymUpARzqNx6TIa1LY1PDze','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 15:34:09','updated_at' => '2021-07-31 15:34:09','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '60','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'raymond1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Raymond12!@','nomor_rekening' => '2343234','phone' => '2323423423423','email' => 'rey@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$gKmA1lbH5S4q0A0PWdby..ewsBFWHlyVAPJbOvnOqXnVODwAAnHTS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 15:42:37','updated_at' => '2021-07-31 15:42:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '61','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpongwhatever','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'T H','nomor_rekening' => '777777777','phone' => '8888888888','email' => 'tarek@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$urzhh93FZdbNf6DgTznTkelVlTgpbkVgpHLkw84W7RSYF.ON6xT.i','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 15:49:18','updated_at' => '2021-07-31 15:49:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '62','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpong22','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'T H','nomor_rekening' => '88888888888','phone' => '888888888','email' => 'tss@rrr.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$UtkERTxitrmTek9zfEgnHOvQ/3.DYgWgQvJAZx7nl6LyDoTwLFKqe','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 16:20:59','updated_at' => '2021-07-31 16:20:59','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '63','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpongPingpong','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'T H','nomor_rekening' => '78888888888','phone' => '888888888888','email' => 'ty@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$dgQ5zjwVcGxzD8Br.D8XJ.AqodbI8vhmw4EPtZsh5/pEGdj2ig422','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 16:28:14','updated_at' => '2021-07-31 16:28:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '64','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Raymond12','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '4','nama_rekening' => 'Raymond12','nomor_rekening' => '4234234','phone' => '4234324234','email' => 'Raymond12@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$pFU6UBq/GNh0jvICjixDBOsR4mWrvib.4Ll00qmC.NsJDt/vs3P52','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 16:40:32','updated_at' => '2021-07-31 16:40:32','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '65','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingpong500','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '3','nama_rekening' => 'Tarek','nomor_rekening' => '44444444444','phone' => '88888888888','email' => 'tarek500@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$VaGN29TCZPObjh5hqL8R5.Et0dWnTgfMP297UQV.FJ93MBNJBAP7a','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 16:42:17','updated_at' => '2021-07-31 16:42:17','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '66','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasaru','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '2','nama_rekening' => 'adfadfasdf','nomor_rekening' => '2324324234324','phone' => '234234324','email' => 'kartikasaru@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Km1kGD/c.iDsheHn1Zj/0uGVFp0hGY9IWE3YuQT//SY7gUBehJD0W','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-07-31 23:21:49','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => 'Google','provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-07-31 23:20:40','updated_at' => '2021-07-31 23:21:49','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '88','referal' => NULL,'rek_member_id' => '1','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '200000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tesmember','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '08912313','email' => 'tesMember@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$0stUWU7PpgRbQTunSGEJ0u/vMUrUx3rt8VfyF5uy6.Q7lWXeXUfUK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-06 08:54:40','last_login_ip' => '185.54.231.75','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-06 08:48:27','updated_at' => '2021-08-06 08:54:40','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '89','referal' => NULL,'rek_member_id' => '6','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'cekMember','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0931231423424','email' => 'cekMember@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$RGxXYgsFShCBBW9TjI.PGO4YRjN0PeJP7lrL3Y59k9kjzcP4FMJzy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-06 09:00:27','last_login_ip' => '185.54.231.75','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-06 09:00:19','updated_at' => '2021-08-06 09:00:27','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '90','referal' => '32456677','rek_member_id' => '3','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Wildan24','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '628923842345','email' => 'wildan24@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$9cuDaBctTizVd1OabixKFuqc3rosqH3bySe9sewYC6eqklDG2eXeC','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-09 06:30:55','last_login_ip' => '118.137.176.179','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-06 21:58:35','updated_at' => '2021-08-09 06:30:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '91','referal' => '44','rek_member_id' => '4','type' => 'user','is_cash' => '0','bonus_referal' => '6496.10','credit' => '56270.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'galihprawiracika','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082235564479','email' => 'galih@cikatechgmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$x7p9Y5CvMBzzNUw03yhjMu0IJDNDFGk9FqPmh5eng/uiCsqCUttOS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-28 00:26:52','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-06 23:38:42','updated_at' => '2021-09-02 23:55:58','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '92','referal' => 'namasaya','rek_member_id' => '5','type' => 'user','is_cash' => '0','bonus_referal' => '11551.51','credit' => '3743.55','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'pragmatic','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '048324834','email' => 'pragmatictest@gmail.com','rekening_id_tujuan_depo' => '22','email_verified_at' => NULL,'password' => '$2y$10$6rLUypqL6Im2802IHCt2xu7UPs2KJUdE9UEAZoDj5VEFJMMhBnhiK','password_changed_at' => '2021-09-15 19:28:30','active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-21 20:28:47','last_login_ip' => '195.69.223.146','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-07 00:17:17','updated_at' => '2021-09-21 20:28:47','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '93','referal' => '123134234','rek_member_id' => '7','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Wildan123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '234723648726348','email' => 'wildan123@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Qpqy/qjPQP2h4h4qtgqwYuuX5zZyKBDljvjiIMv4xF586ej7IHpuS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-07 02:38:34','last_login_ip' => '118.137.176.179','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-07 02:38:10','updated_at' => '2021-08-07 02:38:34','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '94','referal' => '445','rek_member_id' => '9','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Darintuna','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082269877335','email' => 'darin@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$oZmNJYWZ552E1jomU99uIuD7/Jmu2K63WYNET0BFtYp1cp9ROY.GW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-07 07:12:18','updated_at' => '2021-08-07 07:12:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '95','referal' => '4456','rek_member_id' => '10','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'dadangburhan','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0822114578988','email' => 'dadang@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$tvJPB2XB4we/8Xw4.TPXHObSTVkLrp6.OuMFFleuPn9HgbtgraO1G','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-07 07:47:27','updated_at' => '2021-08-07 07:47:27','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '97','referal' => '444','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'cukalmuhamad','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'cikal@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '98','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari1@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '99','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari2@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '100','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari3','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari3@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '101','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari4','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari4@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '102','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari5','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari5@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '103','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari6','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => 'a','phone' => '022566888979','email' => 'kartikasari6@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-10 02:14:31','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '104','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari7','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari7@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '105','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari8','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari8@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '106','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari9','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari9@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '107','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari10','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari10@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '108','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari11','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari11@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '109','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari12','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari12@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '110','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari13','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari13@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '111','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari14','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari14@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '112','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari15','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari15@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '113','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari16','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari16@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '114','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari17','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari17@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '115','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari18','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari18@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '116','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari19','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari19@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '117','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari20','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari20@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '118','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari21','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari21@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-08-08 06:10:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '119','referal' => 'kartikasari','rek_member_id' => '11','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '5000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasari22','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '022566888979','email' => 'kartikasari22@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1oJuSUs.ePSvavm0hWd/EecDJPpEA3JDNvp59yzZKIrP0UPMh7Xy2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 06:10:14','updated_at' => '2021-09-06 05:03:57','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '120','referal' => 'pingpong','rek_member_id' => '14','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi007','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '1','nama_rekening' => 'name','nomor_rekening' => '','phone' => '08234848484848','email' => 'rizkybond007@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$9EnVXikKrfFhN7vTYyf7LeXy7.TsHwyxLxgUraz..VJfkkkoaI/TW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 23:05:54','updated_at' => '2021-08-10 02:14:57','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '121','referal' => 'pingpong','rek_member_id' => '15','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'asdasdasd','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12312455345','email' => 'kjhasdio213@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Z5af3MthVkL830vraEUp0.iJ20lhxws6xcKTvY9DTuUsp5BGHAqAa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-08 23:15:26','updated_at' => '2021-08-08 23:15:26','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '122','referal' => '44','rek_member_id' => '17','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'adamgalih','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082295211304','email' => 'adam@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$XKy3HIxKGh3rrFLQEn8Sw.2WlyRy/GzrQiSTkpMwjEEhrXl0xMhPW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-09 22:43:45','last_login_ip' => '95.142.120.44','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-09 22:43:27','updated_at' => '2021-08-09 22:43:45','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '123','referal' => '19','rek_member_id' => '18','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Wildan234','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '+64756345','email' => 'wildan@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$Thgg8.AJvLsMJ8zRGQXT0eWDCQCb/.aQtDGMtBZ9zOXX58Rin/pP.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-10 07:40:16','last_login_ip' => '118.137.176.179','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-10 04:40:29','updated_at' => '2021-08-14 06:23:38','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '124','referal' => '45345','rek_member_id' => '19','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'masuknama11','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '4534676767','email' => 'nama@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7YLo7MY07uvLqFpcMxsAMuzGCzYRFxFmxVDS/Ne9whdwpDRuGlOuO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-10 07:57:48','updated_at' => '2021-08-10 07:57:48','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '125','referal' => '234234234','rek_member_id' => '20','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Garam123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '34345345','email' => 'garam@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$kMky9TM659gve1uzVnmTS.1ArRbaZIX/DRpKYyVHG4x5.XtV3PtAq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Lain-lain','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-11 01:06:21','last_login_ip' => '118.137.176.179','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-10 08:51:02','updated_at' => '2021-08-11 01:06:21','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '126','referal' => '4','rek_member_id' => '23','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'testpassword','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '5','nama_rekening' => 'ojes','nomor_rekening' => '123123213','phone' => '1234343433','email' => 'testpassword@gmail.com','rekening_id_tujuan_depo' => '34','email_verified_at' => NULL,'password' => '$2y$10$jeO4zi0s5Vg/qIzRFCKdHex7cOMOZBYYBJNZuwbA9w2v9KpFMShou','password_changed_at' => '2021-08-12 12:23:02','active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-11 14:10:05','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-11 14:09:47','updated_at' => '2021-08-14 06:21:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '127','referal' => '94','rek_member_id' => '24','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Seofranky','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082238820685','email' => 'riko.anji7788788934@yahoo.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$qEtf9or1svCox7Xe9mesqO3r4CFY8SeXWgujtEgGhVS25vvtsOs4.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-13 10:41:01','updated_at' => '2021-08-14 03:22:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '128','referal' => '4','rek_member_id' => '27','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Murah4d','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => '10','nama_rekening' => 'murah7Dd','nomor_rekening' => '123123','phone' => '083366998866','email' => 'ahshshhas@gmail.com','rekening_id_tujuan_depo' => '36','email_verified_at' => NULL,'password' => '$2y$10$sxCAVGc/FwMPvLhx1noENOttosC6LPX.3R1.a3tL32Rzbja/g6crW','password_changed_at' => '2021-08-14 03:23:30','active' => '0','status' => '2','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-13 11:10:22','last_login_ip' => '5.62.34.22','to_be_logged_out' => '1','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-13 11:09:57','updated_at' => '2021-08-14 06:15:03','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '129','referal' => 'pingpong','rek_member_id' => '28','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Yogs123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'Yog@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$4SRS0VoHxW8bhn8UOcOJseBbHmbxVcNnz34Uli0bJRewAPn4A8vKu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 01:48:33','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-14 06:18:57','updated_at' => '2021-08-26 01:48:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '130','referal' => NULL,'rek_member_id' => '29','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'josbar30','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082167892644','email' => 'josua.cikatech@gmail.com','rekening_id_tujuan_depo' => '6','email_verified_at' => NULL,'password' => '$2y$10$GrkVGqUCrHl.PnFQkkMcmeZ2x1OsJU0gfjB0VZIXusck2tsqqaKcG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Lain-lain','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-22 03:29:46','last_login_ip' => '185.54.229.37','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-16 23:44:01','updated_at' => '2021-08-22 18:57:28','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '131','referal' => NULL,'rek_member_id' => '30','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '99999959399.99','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'playtech','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '987656789','email' => 'playtech@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7aNzHiD2sGhEuAjS/9XHaOKmiUjX1TEgUIW.osp2TrM/Na3Rn5wmG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-20 23:22:18','last_login_ip' => '13.211.216.41','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:13:19','updated_at' => '2021-09-20 23:25:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '132','referal' => NULL,'rek_member_id' => '31','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysian2turi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12312545666','email' => 'okeokesekali@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$kDyWmgI07glMJUUO8FgUx.axZ1wKmpHZY3u5F0jplQ7z9V6pVqvsK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:17:10','updated_at' => '2021-08-17 05:17:10','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '133','referal' => '44','rek_member_id' => '32','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'asdsad','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082295211304','email' => 'asdsad@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$U0Ep2mJrwc32pGOwlaa64.D0rHm3S2Z78wf0DKJjKwxumRaclOsky','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:20:26','updated_at' => '2021-08-17 05:20:26','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '134','referal' => NULL,'rek_member_id' => '33','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'helmuth','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081264758674','email' => 'helmuth@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$d6SU9d8P1.6xVsjS9o51CuVNyaXIOFzCpQlBi49ntLa1tDVuGRjqC','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:28:56','updated_at' => '2021-08-17 05:28:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '135','referal' => NULL,'rek_member_id' => '34','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysia2nturi2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '4567883345','email' => 'rizkysianturi@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$X.4X.fejn5N5L9KTbxdFv.Thp//DTJ6o5DDd.p258YVQcqiRmVxie','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:28:57','updated_at' => '2021-08-17 05:28:57','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '136','referal' => NULL,'rek_member_id' => '35','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi11','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '234346345','email' => 'sdawew@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$JuvkexDNMi9tdZlCIWH/MON5AYi47TEpywfosJ2M797G0LtwlgpEu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:29:27','updated_at' => '2021-08-17 05:29:27','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '137','referal' => NULL,'rek_member_id' => '36','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'contoh12','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '08126234475','email' => 'contoh@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$mTAgPsC7RI3gAqDTaG2qQOqjOPn/2E0InnVF0UXnlCWrWVsQEHLb2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:50:07','updated_at' => '2021-08-17 05:50:07','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '138','referal' => NULL,'rek_member_id' => '37','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'raymondx','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '234234234324324','email' => 'test@luffy.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$dDQeODd9g/MvjPqE.ddlouhQXwFNA3wIMNs1KOk93SAm.jY3i71xW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 05:58:26','updated_at' => '2021-08-17 05:58:26','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '139','referal' => NULL,'rek_member_id' => '38','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'nanadanang','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '085542123889','email' => 'nana@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$BckoF8AVhF.FGzpdrOXt3es6JzwoMZzMyv0WSmfuRfzOkvNdnIIYO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-17 06:03:54','last_login_ip' => '95.142.120.145','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 06:02:09','updated_at' => '2021-08-17 06:03:54','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '140','referal' => NULL,'rek_member_id' => '39','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizky123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081262626372','email' => 'rizky@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$YM3GtPvwB5uQMafqHkyJtuV.tXRSsFQQAVsyQThW7WIQgjfctcJf2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 06:04:52','updated_at' => '2021-08-17 06:04:52','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '141','referal' => NULL,'rek_member_id' => '40','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'dafa90','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082214556','email' => 'dafa@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$PGStzOcgWPiP3P3wUctTye7n79SLsUojOtrZDaAW7ioQ.Z5qYiSDO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 08:08:01','updated_at' => '2021-08-17 08:08:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '142','referal' => NULL,'rek_member_id' => '41','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'dshajkdhasjk','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '478912739089','email' => 'rizkysiantury@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$ulvgGw4Ei25vXO70TbPFouw4kkkwU0CPaO5z0lXDmTLKFaQjrNBl.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 11:08:17','updated_at' => '2021-08-17 11:08:17','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '143','referal' => NULL,'rek_member_id' => '42','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'pingoo','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '6211111478','email' => 'rrr@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$x5GhlHt/McRAwM.S5xHnIOY29ICeNzCy20dtdoEKzkXuOruzLoiXi','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 14:14:34','updated_at' => '2021-08-17 14:14:34','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '145','referal' => 'kartikasari','rek_member_id' => '44','type' => 'user','is_cash' => '0','bonus_referal' => '12.00','credit' => '122256.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikareferal','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '23423432424','email' => 'test@kartikareferal.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$.587HQgjsVK9Eycd1iPjiuiANCDeVQKhSeygSIyF3PbYiAa1pDUJq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-17 21:36:11','last_login_ip' => '27.109.115.155','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 21:35:57','updated_at' => '2021-08-17 21:39:34','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '146','referal' => NULL,'rek_member_id' => '45','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikareferals','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '14423432','email' => 'kartikareferals@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$HGXOaRwmyIR/l2Dh71xGFOPC3s63PJ4zIl.27YHbGSNEYSwwYDG16','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 22:07:33','updated_at' => '2021-08-17 22:07:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '147','referal' => NULL,'rek_member_id' => '46','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysian22turi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '235566345','email' => 'rizkushc@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$WGznewmeT7ordov655NXBOA.RLkF0Jo55GVQ1QRybchzQ8cjN7dDK','password_changed_at' => '2021-08-17 22:12:04','active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 22:08:54','updated_at' => '2021-08-17 22:12:04','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '148','referal' => 'rizkysianturi','rek_member_id' => '47','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refrizky1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '456789879','email' => 'user@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$kln41E8kz/XzEq5FoVCnX.JY0mh7FCznjI3WRONOlURu2P/wqJaeW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 22:35:21','updated_at' => '2021-08-17 22:35:21','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '149','referal' => 'rizkysianturi','rek_member_id' => '48','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'horas123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '678909876','email' => 'aaaa@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$6sgaouf6yA0IYzDKcm.FWOjZq9I.h5crFZ5gguokK5eGURd2CZCO2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 22:36:19','updated_at' => '2021-08-17 22:36:19','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '150','referal' => 'rizkysianturi','rek_member_id' => '49','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'jshdksajhdkaj','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '25352554','email' => 'evos@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7HH2HiLH3Ri5EXcaZhbUMeJNF2yOvKul4oz/ZT0EnSMbC1djn6miy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 22:37:20','updated_at' => '2021-08-17 22:37:20','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '151','referal' => 'rizkysianturi','rek_member_id' => '50','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refrizky2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '098764896','email' => 'errw92@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$3tr6F1oW2FXruiiJ2TkofOpW7p5CxidA9eQ6TydaNJa0uYp7w0fwu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 23:06:59','updated_at' => '2021-08-17 23:06:59','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '152','referal' => 'rizkysianturi','rek_member_id' => '51','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'refrizky3','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0899784543721','email' => 'okeokeeawr@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$h4O2V6Lhze8rkUn2a/L8suCzTNabqPduRF5Yg4sk9z6lKXw3GIv4y','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-17 23:07:41','updated_at' => '2021-08-17 23:07:41','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '153','referal' => 'kartikasari','rek_member_id' => '52','type' => 'user','is_cash' => '0','bonus_referal' => '0.80','credit' => '3023.90','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kartikasarref2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '25235235','email' => 'kartikasarref2@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$ydRWcjlsdimakcm0iGrPy.Vm8mhrOwjvXmdwjVIUkdMPBB.Bzhyh.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 01:21:45','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 01:21:38','updated_at' => '2021-08-24 18:10:29','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '154','referal' => NULL,'rek_member_id' => '53','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$0WTJHE763FR.HkmBU3I68.UVJf1pFDwqx7FtuQzjlh23LmdqP4UMO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 03:51:08','last_login_ip' => '185.54.231.74','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 03:50:46','updated_at' => '2021-08-18 03:51:08','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '155','referal' => NULL,'rek_member_id' => '54','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test1@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$UobwZUVfHl0Xtmq.7nGsYuu5HKitimk6Uvy8/Y1ZDI2dI3Z64hcfm','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 03:52:30','updated_at' => '2021-08-18 03:52:30','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '156','referal' => NULL,'rek_member_id' => '55','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting12','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test2@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$5T7ce9Nr0KU6DKheqyYa.eKfQLWwB9kqrY6wfOHKt4blv0XwozpY.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 03:56:21','updated_at' => '2021-08-18 03:56:21','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '157','referal' => NULL,'rek_member_id' => '56','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teest123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '099781231','email' => 'teest@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$QvDlXcdCaayhMky3bMlYyuu4TUboRwZS/iPujRaBv25KMPmyRP9vS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:00:30','updated_at' => '2021-08-18 04:00:30','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '158','referal' => NULL,'rek_member_id' => '57','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test23@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$YZuA7EOD3nU2x5pr3tsgA.jPPoir8I11q3bEbtvj2sJqwuv7YufNa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:06:05','updated_at' => '2021-08-18 04:06:05','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '159','referal' => NULL,'rek_member_id' => '58','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting1234','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test234@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$WXWGvoAXO8kblUYEVZJRjeTMmXPaZ0tI/4pY42Ig7bY7UB4rXEhHy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:08:21','updated_at' => '2021-08-18 04:08:21','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '160','referal' => NULL,'rek_member_id' => '59','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting12345','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test2345@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$XF/xpJfrvgI2Y3Kcl9bD8ufwsNRDPrqbxseeSgY2QBQ/HY1v5Jm7S','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:21:53','updated_at' => '2021-08-18 04:21:53','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '161','referal' => NULL,'rek_member_id' => '60','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'teesting123456','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test23456@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$ngH/gI8uw/BUNxHyOxJc5uRtVQKmjUHiPypea70Wjn.aPcJYKj7Be','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:24:01','updated_at' => '2021-08-18 04:24:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '162','referal' => NULL,'rek_member_id' => '61','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '110000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'teesting1234567','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test234567@test','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$wRTVxm3HnDxAx5/LOgqEyOJl8c0gJ/APgp//QawfcEG.I0aDpzWY6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 05:13:34','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:45:03','updated_at' => '2021-08-18 05:16:38','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '163','referal' => NULL,'rek_member_id' => '62','type' => 'user','is_cash' => '0','bonus_referal' => '29387.42','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'namakita','device' => '(Mobile) Brand name: iPhone. Model: phone','is_next_deposit' => '0','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '48562312534','email' => 'namakita@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$yyPbzDdya/foerms6OrZTehedCVmNwuRpwp1QBt.bBb3nccBALYtu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 02:02:21','last_login_ip' => '185.246.210.166','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 04:52:32','updated_at' => '2021-09-23 02:02:22','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '164','referal' => NULL,'rek_member_id' => '63','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'teesting12345678','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test2345678@test','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$5srM0VpXoFNrRkY/Mmdwk.NbxFPHtXxIoH2TAN/YUAKcczmpUzUmy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 05:19:11','updated_at' => '2021-08-18 05:19:11','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '165','referal' => NULL,'rek_member_id' => '64','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'teesting000','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'test000@tes.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$UCwJGe0FXw00yfy1JhOzde6arVWx9AT72bbeYGddOh0tMrTagjrwu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 05:23:09','updated_at' => '2021-08-18 05:23:09','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '166','referal' => NULL,'rek_member_id' => '65','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'rizky22sianturi','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '088005552322','email' => 'rizkyasianturi@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$BtOsWNd191IcNyGUEzq2sOo62ZZHnLYgDRZGXCGu7IBiX4W52SZea','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 05:25:01','last_login_ip' => '185.54.231.56','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 05:25:01','updated_at' => '2021-08-18 05:25:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '167','referal' => NULL,'rek_member_id' => '66','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '170000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '27','username' => 'rizkysianturi44','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '089770099234','email' => 'kosongemail@gmail.com','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$1Cfc0SqNzVCvycqYJgUgreySMFwNDr.0Vk7WQOnKd05noMHng1SP.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 05:27:34','last_login_ip' => '185.54.231.56','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 05:27:34','updated_at' => '2021-08-18 05:37:51','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '168','referal' => NULL,'rek_member_id' => '67','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'polanautologin','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '232342343','email' => 'polanautologin@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$LwLIWLPVZgjZuhQyadHzM.OjQbAZ/2YUy34etw6YcW1p.9GiejjXa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 05:53:23','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 05:53:23','updated_at' => '2021-08-18 05:53:23','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '169','referal' => NULL,'rek_member_id' => '68','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi666','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0798274518','email' => 'gmailgmail@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$nOJ5KpluoCessozatnHZEOyhQOcj1AkDO1jrJSF8eea5lHG9Bc4JG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 06:07:55','last_login_ip' => '185.54.231.62','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 06:07:55','updated_at' => '2021-08-18 06:07:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '170','referal' => NULL,'rek_member_id' => '69','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'alessacantik','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '523525235','email' => 'alessacantik@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$cp82ysC19cRZr5hqDMxj..l3YQkFHU7Edt92Vie6xRck6YbcrXhA6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 06:09:41','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 06:09:40','updated_at' => '2021-08-18 06:09:41','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '171','referal' => NULL,'rek_member_id' => '70','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'asdfasf','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '255345345','email' => 'asdfasf@asdfas.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$XkT6biQ8i1bwMWsnOLJ22eEa048teKqMqWwgTeTDqbmRR6v2GDyW6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 06:10:36','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 06:10:36','updated_at' => '2021-08-18 06:10:36','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '172','referal' => NULL,'rek_member_id' => '72','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '27','username' => 'refrizky4','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '087756348291','email' => 'gmailmainan@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7yPO0ORK6pTXFj6gPPw6Qu3ViiwUN83XsPmi3AQe6bEnddRZrvEOe','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 07:11:56','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 07:11:55','updated_at' => '2021-08-18 07:11:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '173','referal' => NULL,'rek_member_id' => '73','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '27','username' => 'refRizky','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '090990724555','email' => 'apaansi@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$SwIeFkIujICjoEbOuSByh.8WZMaekvwLw.EXvXHbPOJvybwo5dUNq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 07:15:40','last_login_ip' => '185.54.231.65','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 07:15:40','updated_at' => '2021-08-18 07:15:40','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '174','referal' => NULL,'rek_member_id' => '74','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'abangjago','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '225234234234','email' => 'abangjago@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$fthO57sCDPxQGvWwpSbfu.kU7BoX.i.yd89Vrfg1XLmY9Mscljnm6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 07:29:24','last_login_ip' => '103.115.175.241','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 07:29:23','updated_at' => '2021-08-18 07:29:24','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '175','referal' => NULL,'rek_member_id' => '75','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '130000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi88','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '09776222222','email' => 'yoyoyoy@gmail.com','rekening_id_tujuan_depo' => '6','email_verified_at' => NULL,'password' => '$2y$10$LxVfLPWc/OdN1IqyLqEB0e.QuoEIUEts6HxrB124XTlyCL61HMX6C','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 07:54:45','last_login_ip' => '185.54.231.65','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 07:54:45','updated_at' => '2021-08-18 07:56:20','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '176','referal' => NULL,'rek_member_id' => '76','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1030000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi900','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '998826490022','email' => 'iotottjtaa@gmail.com','rekening_id_tujuan_depo' => '6','email_verified_at' => NULL,'password' => '$2y$10$FVR/cs3PrflMcC6LdMufFO2px./RXA4fpFhb5r59YWam4hAVlTEyi','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 07:57:59','last_login_ip' => '185.54.231.65','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 07:57:58','updated_at' => '2021-08-18 07:58:24','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '177','referal' => NULL,'rek_member_id' => '77','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'cektes','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'cektes@tes.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$okAtLxexeDAr3u1syuwTL.ujUQupejpGzGCSzRmnuGBAe9eDQ0S76','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-18 08:13:35','last_login_ip' => '185.54.231.46','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-18 08:13:19','updated_at' => '2021-08-18 08:13:35','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '178','referal' => NULL,'rek_member_id' => '78','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'namakamu','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '415641546','email' => 'namakamu@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$qzxldUTYkZs0ymm6YWh3ze54ffdEr3WHeuNc.HcGFRFnsh2c3.UCu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-20 22:49:47','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 01:31:07','updated_at' => '2021-09-20 22:49:47','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '179','referal' => NULL,'rek_member_id' => '79','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'namadia','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '4645534454','email' => 'namadia@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$h3GPHCJLi44G4zRa8rbz0OtJUF7M7ppL3VY8aFvtbUlRmn2BUHCpC','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 01:32:00','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 01:32:00','updated_at' => '2021-08-19 01:32:00','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '180','referal' => NULL,'rek_member_id' => '80','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkymartin','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '08973473731111','email' => 'marrtingarix@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$AukvkYdHnNM3pnEMRTUAv.AjjAIDloQiOMVYs41Vx60DSW3b7pL1.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 05:19:51','last_login_ip' => '185.54.231.25','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 02:00:44','updated_at' => '2021-08-19 05:19:51','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '181','referal' => NULL,'rek_member_id' => '81','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '180','username' => 'rizkymartinRef1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '990027461811144','email' => 'okeyoyotoke@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$06mUxAUF.hAS8.saLA08..AK0kEVGo3cOpLoZ1G19S3av5KyVFw4S','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 02:01:47','last_login_ip' => '185.54.231.25','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 02:01:47','updated_at' => '2021-08-19 02:01:47','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '182','referal' => NULL,'rek_member_id' => '82','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '2000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '180','username' => 'rizkymartinRef2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => 'e','nomor_rekening' => '','phone' => '09998827111350','email' => 'gmail2mainan@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$2CF7qnTe82M6rzppHckwLe4sz1zSXF2.w0Xb4OlJVO7gJ9SWA6/6q','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 02:03:15','last_login_ip' => '185.54.231.25','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 02:03:14','updated_at' => '2021-08-21 14:49:11','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '183','referal' => NULL,'rek_member_id' => '83','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '78327235.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'bangbangtut','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '123454321','email' => 'bangbangtut_Di_EDIT@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$RdHMTVkEbhtmPZJmtrsSOuBa6Xq139yKBU6ORJZpNDlf363GIf2i.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 09:32:07','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 09:32:07','updated_at' => '2021-08-25 22:33:53','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '185','referal' => NULL,'rek_member_id' => '85','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '255000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'tesbonus','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'tesbonus@tes.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$Ri24apU9aj2mzusoBzO9v..MwZPFlBJVXSwvBoofrPvkTQojyiyO2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 11:32:50','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 11:30:34','updated_at' => '2021-08-19 11:46:10','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '186','referal' => NULL,'rek_member_id' => '86','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '110000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'tesbonus123','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'tesbonus123@tes.com','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$HPeX/OXFsg.woQoXEL1z5eM9br9HBY6VtNJAfGHnvp30K9ZgqL2x2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 11:55:35','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 11:54:04','updated_at' => '2021-08-19 12:00:45','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '187','referal' => NULL,'rek_member_id' => '87','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '5080000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'tesBaru','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'tesBaru@tes.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$dh.4m/VqiQuF.f6362vo5eAxzS5bdi.lshCW7bMj5Yz/CoTsyYVja','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 12:09:42','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 12:08:36','updated_at' => '2021-08-20 06:20:48','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '188','referal' => NULL,'rek_member_id' => '88','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '4030000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'newTes','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'newTes@tes.com','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$dTcAm86UOTTWVgyfYkmpf.TsL3F/9PcKqaAznwuZqKQFa2PTodcMW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 01:49:41','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 12:21:14','updated_at' => '2021-08-26 03:05:50','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '189','referal' => NULL,'rek_member_id' => '89','type' => 'user','is_cash' => '0','bonus_referal' => '7203800.00','credit' => '839225000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'newTes1','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'newTe1s@tes.com','rekening_id_tujuan_depo' => '29','email_verified_at' => NULL,'password' => '$2y$10$fi.PDBEDHkTuIYaXWdNm3OUiQO6zkf29fyWz5REN72Ifon8op2Rb.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-20 04:04:28','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 22:56:52','updated_at' => '2021-08-20 04:12:24','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '190','referal' => NULL,'rek_member_id' => '90','type' => 'user','is_cash' => '0','bonus_referal' => '1464000.00','credit' => '60500000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'hahahaha','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '055888666','email' => 'haha@gmail.com','rekening_id_tujuan_depo' => '29','email_verified_at' => NULL,'password' => '$2y$10$NnBCrBf0SLHwm330WMa19OHJiV6x1b/4O0mrg2cII8rCAa2whptnG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 23:01:04','last_login_ip' => '95.142.120.34','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 23:01:04','updated_at' => '2021-08-19 23:41:52','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '191','referal' => NULL,'rek_member_id' => '91','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '120000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '27','username' => 'rizkysianturi48','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '90882700474611','email' => 'gmaildoangkaga@gmail.com','rekening_id_tujuan_depo' => '35','email_verified_at' => NULL,'password' => '$2y$10$RPaQ7fxcNg4pIRrDi8KJvegER9ROlF2mIWkjgIKbrHgHTRbY49gOq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 23:09:10','last_login_ip' => '185.54.231.54','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 23:09:09','updated_at' => '2021-08-19 23:09:47','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '192','referal' => NULL,'rek_member_id' => '92','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '430000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '27','username' => 'rizkysianturi49','device' => '','is_next_deposit' => '0','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082923445512','email' => 'kagaada@gmail.com','rekening_id_tujuan_depo' => '15','email_verified_at' => NULL,'password' => '$2y$10$8VHksI0GrwtFnALaG1CYE.bDh1MnKIFqDraiwdSubE8FHQcNrZvfm','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-19 23:11:02','last_login_ip' => '185.54.231.54','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 23:11:02','updated_at' => '2021-08-19 23:12:51','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '193','referal' => NULL,'rek_member_id' => '93','type' => 'user','is_cash' => '0','bonus_referal' => '705030.00','credit' => '189608500.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'loudwire21','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '085556654','email' => 'loud@gmail.com','rekening_id_tujuan_depo' => '29','email_verified_at' => NULL,'password' => '$2y$10$Cug/blb.RdZNWIhQVQlKlewArUM3pZ85CL/nb0H5qp9xXTJdKbOq6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-20 11:20:46','last_login_ip' => '95.142.120.51','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-19 23:46:28','updated_at' => '2021-08-20 11:20:46','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '194','referal' => NULL,'rek_member_id' => '102','type' => 'user','is_cash' => '0','bonus_referal' => '45300.00','credit' => '88945800.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '0','username' => 'forReferralRizky','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => 'oke ok','nomor_rekening' => '','phone' => '0823177374411110','email' => 'untukreferald1@gmail.com','rekening_id_tujuan_depo' => '6','email_verified_at' => NULL,'password' => '$2y$10$z.bXI.Ge3OixQz2WkA07IedZT5y3PtPlPQ0MDRqycLDDkF8k5uJoa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-28 00:18:44','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 01:07:43','updated_at' => '2021-08-28 00:21:02','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '195','referal' => NULL,'rek_member_id' => '95','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '194','username' => 'ReferralRizky1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '089911332200110','email' => 'refrizky11@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$QMndq2HWZaIqyNxniCLWe.mU.hRqJxO1Vwx/b6KIZe3mUHnErZmZG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-28 02:25:46','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 01:10:34','updated_at' => '2021-08-28 02:25:46','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '196','referal' => NULL,'rek_member_id' => '96','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'celestine','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '2348104222808','email' => 'stephen.cikatech@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$nbhPYTItwogJamNU.P0JYuBvQnTRBdwgyRg0IZyxQA8ITt3Sz8tQK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-09 21:38:23','last_login_ip' => '102.91.4.226','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 01:34:03','updated_at' => '2021-09-09 21:38:23','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '197','referal' => NULL,'rek_member_id' => '97','type' => 'user','is_cash' => '0','bonus_referal' => '1478.00','credit' => '106200.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'galihadam','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '02255522541','email' => 'galih@gmail.com','rekening_id_tujuan_depo' => '39','email_verified_at' => NULL,'password' => '$2y$10$fpXy/xBiE3.CinIjFiI2duJ/9YFqgwRSJKlw4wSoqEdWp7Vt2XQFy','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-28 10:34:35','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 01:43:28','updated_at' => '2021-08-28 10:34:35','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '198','referal' => NULL,'rek_member_id' => '98','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '196','username' => 'celestine2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'celestine2@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$kshZ3V8zvJCO3aJdMrixce9Nh2J6VvRmE0VgEzp/6S2ge/nso8ILG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-07 20:03:59','last_login_ip' => '197.210.54.61','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 02:22:02','updated_at' => '2021-09-07 20:03:59','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '199','referal' => NULL,'rek_member_id' => '99','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '194','username' => 'galihcika','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '082295211300','email' => 'galihcika@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$oYCPCO00YMcci2XD3YN/vuxnGQrY4/jsF837I4QerrE1aPFRpw3U.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Instagram','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-22 02:26:49','last_login_ip' => '92.223.85.73','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 03:05:04','updated_at' => '2021-08-22 02:26:49','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '200','referal' => NULL,'rek_member_id' => '100','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'rizkysianturi1','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '112315690055','email' => 'rizkysianturi1@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$iqAsrLDJ9mFL8DYN593uLO8f1RsjhFMvkhm8goBPVXlrt6IodLEaa','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Twitter','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-20 04:57:33','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 04:57:33','updated_at' => '2021-08-20 04:57:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '201','referal' => NULL,'rek_member_id' => '118','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1422000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'bugTes','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => 'CIMB','nomor_rekening' => '','phone' => '12374892','email' => 'bugTes@tes.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$4h.1mNi0cCjrL5GNYfQ4De4GajuGAhEFNNGddP20Rgjo1LF5tqILC','password_changed_at' => '2021-08-28 01:32:44','active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 03:43:23','last_login_ip' => '139.255.140.171','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 06:20:01','updated_at' => '2021-08-28 01:34:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '202','referal' => NULL,'rek_member_id' => '103','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'referralRizky2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '1231234111123','email' => 'mmnasdkkjh@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$zCI.NrQMM2.4/T3xXIf0Le6ztC6dJrObaw40H/HJv3jjT8ZbJ7c2a','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-20 21:25:31','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-20 21:25:31','updated_at' => '2021-08-20 21:25:31','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '203','referal' => NULL,'rek_member_id' => NULL,'type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'haloooo','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '47291038','email' => 'jkahsioda@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$.kO8GIH87GnYc/4S1NBDUeUxMiumJWioA.aceUyxwL878OmYPCco.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-22 04:14:49','updated_at' => '2021-08-22 04:14:49','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '204','referal' => NULL,'rek_member_id' => '105','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1000000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'halooo1','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '7856745','email' => 'halooo@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$PrG6jlmrwjfueb6tHc.j/uZLF/0oUnYA4jXeSuGPSstu1Ge.JFdia','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-22 04:16:07','last_login_ip' => '185.54.231.69','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-22 04:15:51','updated_at' => '2021-08-22 04:19:59','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '205','referal' => NULL,'rek_member_id' => '106','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1020000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '19','username' => 'halooo2','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => 'asdsad','nomor_rekening' => '','phone' => '7856745','email' => 'halooo2@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$Rsi66FfdyMyMkKsJ2/uPmeVNOHlXL4RLMfd62A8WXQ51q2MnGmHUu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-22 04:28:11','last_login_ip' => '185.54.231.69','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-22 04:19:50','updated_at' => '2021-08-23 03:57:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '206','referal' => NULL,'rek_member_id' => '107','type' => 'user','is_cash' => '0','bonus_referal' => '2000.00','credit' => '200000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tesdepo','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '8967912456','email' => 'testdepo@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$i7DawG0/M4yYZBa4GlOSAeuleq/Zq8OOCnTRUt614/I9EY3vd66Te','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-24 04:54:23','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-23 09:54:12','updated_at' => '2021-08-25 10:28:31','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '207','referal' => NULL,'rek_member_id' => '114','type' => 'user','is_cash' => '0','bonus_referal' => '1235086863.30','credit' => '60450110.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'jokergaming','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12121212','email' => 'jokergaming@email.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$0doZztKyaG98.uw1xH68QObmRtSVaNjb3VtrQkjVDRbOLCI1rFxsW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 09:18:51','last_login_ip' => '194.5.49.33','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-24 01:48:13','updated_at' => '2021-09-23 09:18:51','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '208','referal' => NULL,'rek_member_id' => '115','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Devjambispirit','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081366020805','email' => 'devjambispirit@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$20w2FVY4HWz1o5FJDPEiaOq8haqhmgHkr7Ph39IZtrgzsoHDzY/Yi','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-24 03:01:45','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-24 03:01:44','updated_at' => '2021-08-24 03:01:45','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '209','referal' => NULL,'rek_member_id' => '116','type' => 'user','is_cash' => '0','bonus_referal' => '30000000654.38','credit' => '-99999998238.75','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'habanero','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => 'habanero','nomor_rekening' => '','phone' => '263153245','email' => 'habanero@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$5J44vI9O7X6KUegvdEZM1OxdJVkERprnJftLXXIrT8TH2.XdXuRk.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-24 17:38:29','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-24 03:44:06','updated_at' => '2021-08-24 17:59:52','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '210','referal' => NULL,'rek_member_id' => '124','type' => 'user','is_cash' => '0','bonus_referal' => '1001225877.50','credit' => '995509.99','rekening_tujuan_depo_id' => NULL,'referrer_id' => '36','username' => 'pgsoft','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '25235232','email' => 'pgsoft@email.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$/nm5tWZvW.Db7lTtS1EtNednIu/HcZY9XW1BEZG2s1Yk.mvWeZ3SW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-10 16:23:51','last_login_ip' => '60.50.146.249','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-24 15:10:25','updated_at' => '2021-09-10 16:25:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '211','referal' => NULL,'rek_member_id' => '126','type' => 'user','is_cash' => '0','bonus_referal' => '1000000.00','credit' => '16630000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '194','username' => 'testdoang11','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0981237641231123','email' => 'testoapsodqw123@gmail.com','rekening_id_tujuan_depo' => '29','email_verified_at' => NULL,'password' => '$2y$10$Pur.LR3IHdN7qB0q2JZh3uVeaXzEurYcjqIil3Dd5HVTcKJwopPX6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Forum','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-25 23:57:33','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-25 00:05:46','updated_at' => '2021-08-26 00:05:14','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '212','referal' => NULL,'rek_member_id' => '127','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '99000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'sqsqsq','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0885552211','email' => 'sasaEDIT@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$dbIZaC6u3L5PHX5UTQClGOpIdORLYrf3ntjTCXPlVVFc18kBKD0Ju','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-25 00:48:57','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-25 00:48:57','updated_at' => '2021-09-16 03:46:05','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '213','referal' => NULL,'rek_member_id' => '128','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '149000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'jajang91','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '085522556','email' => 'jajang@gmail.com','rekening_id_tujuan_depo' => '22','email_verified_at' => NULL,'password' => '$2y$10$J9Ak8ev4IOfSKf2sorauCug3n5BUvtSNlH8jNSPf96LBc7U4Q0ksS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-27 04:06:52','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-25 22:45:43','updated_at' => '2021-09-16 07:15:44','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '214','referal' => NULL,'rek_member_id' => '129','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '149000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'lala91','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0258899223','email' => 'lala@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$bE0BCXAZ5ytiTGroLga4I.8sdXc6Etb4aq0D3eQ4BQcArDh/y1CY2','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-25 23:59:43','updated_at' => '2021-09-16 07:15:40','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '215','referal' => NULL,'rek_member_id' => '130','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'kosim88','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '085522244','email' => 'kosim@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$rdALLSKfYxd6xGVkqrvbneDBiTnVprbp8J4dhc.rTf71mKeN4M6jC','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-26 00:26:55','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-26 00:08:18','updated_at' => '2021-08-26 00:26:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '216','referal' => NULL,'rek_member_id' => '134','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1119000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'tesBaru123','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'tesBaru123@tes.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$hJUW2j1cb75pl/4T0cIl0OIu5/0BRStPOgY78DIFz30/d2imRTRYW','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-27 02:30:07','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-27 02:29:50','updated_at' => '2021-09-16 03:47:02','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '217','referal' => NULL,'rek_member_id' => '135','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1199000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'cikaslot123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0812606109991','email' => 'asassaedit@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$15XpfusT95LjuBRj461/7eKe6JN/O0oNvByYfVzylQQf4Q7gH9R0W','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-27 21:36:52','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-27 21:13:21','updated_at' => '2021-09-16 03:46:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '218','referal' => NULL,'rek_member_id' => '137','type' => 'user','is_cash' => '0','bonus_referal' => '40000.00','credit' => '-577500.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '163','username' => 'namaaku','device' => '','is_next_deposit' => '1','is_new_member' => '0','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'namaaku@tes.com','rekening_id_tujuan_depo' => '8','email_verified_at' => NULL,'password' => '$2y$10$zXLfGC4la.v9KnuJ8a1sCeFLfxqw.JF4iig1UgtF7hXZbYDZQCS0u','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-28 00:18:50','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-28 00:18:33','updated_at' => '2021-09-16 07:32:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '219','referal' => NULL,'rek_member_id' => '138','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '149000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'devjambispirit2','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '08647357273','email' => 'devjambispirit2@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7Jbb6SoQzVDnYBuNaWMT9.crgbBITXviVChiu7fwIHuYyGZOVB/5.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Refferal','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-08-29 14:58:24','last_login_ip' => '3.0.47.49','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-08-29 14:58:24','updated_at' => '2021-09-16 07:32:02','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '220','referal' => NULL,'rek_member_id' => '143','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '1242132.20','rekening_tujuan_depo_id' => NULL,'referrer_id' => '163','username' => 'namaku','device' => 'Chrome','is_next_deposit' => '0','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'namaku@tes.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$SKhWESHRb5/atLskConvgOpo/UalzWqaWW1YZDnnXoFkhwd1hU0uG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 02:19:25','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-02 10:14:58','updated_at' => '2021-09-23 02:21:46','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '221','referal' => NULL,'rek_member_id' => '145','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '4000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'cantikkah','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '342234234','email' => 'cantikkah@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$CUWMODcuoPXvZWw.6Ro0..06b6wCjATk2snGnC5eKAfsfMhimu.gq','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'BBM','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-03 11:18:51','last_login_ip' => '103.115.175.240','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-03 11:18:51','updated_at' => '2021-09-07 08:27:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '222','referal' => NULL,'rek_member_id' => '146','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '2000.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Cakijo123','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '083811221808','email' => 'ahmadsamsuri096@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$bZSm0yqXs2jNr2DdRpfop.RZ6g.6fQF2DXZbH0E7vhpiabRylBWS.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-06 10:37:37','last_login_ip' => '114.79.3.254','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:37:36','updated_at' => '2021-09-07 08:27:37','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '223','referal' => NULL,'rek_member_id' => '147','type' => 'user','is_cash' => '0','bonus_referal' => '36.00','credit' => '155580.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'tigerganteng','device' => '(Mobile) Brand name: iPhone. Model: phone','is_next_deposit' => '0','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '123456789','email' => 'tigerganteng@gmail.com','rekening_id_tujuan_depo' => '43','email_verified_at' => NULL,'password' => '$2y$10$AftLKEJ1rGLaMahOlD/.aOcTPbBj862oGwzk64zkozjSvOgC4ryLC','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-13 08:21:42','last_login_ip' => '103.115.175.244','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 10:59:06','updated_at' => '2021-09-13 08:22:44','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '224','referal' => NULL,'rek_member_id' => '149','type' => 'user','is_cash' => '0','bonus_referal' => '602.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'flytech','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '628115646464646','email' => 'cika4d@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$b2U5tYCMtRyTmhSjiT7ERuDbsfk4b.yJCM2rooC0mAUsrh1J7HS/S','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-06 23:05:55','last_login_ip' => '103.114.88.114','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 23:05:54','updated_at' => '2021-09-14 09:42:25','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '225','referal' => NULL,'rek_member_id' => '150','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '163','username' => 'winterbear','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081404520875','email' => 'ilovemcdandkfc@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$s0JL6ypJ6KzUtHBHFT2Btuj9Hfs3XzB6N3quhUKmDMpHZtP84Jpg.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Lain-lain','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-06 23:07:19','last_login_ip' => '5.62.34.18','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-06 23:07:19','updated_at' => '2021-09-14 09:35:33','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '226','referal' => 'kartikasari','rek_member_id' => '152','type' => 'user','is_cash' => '0','bonus_referal' => '33308.50','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '13','username' => 'josbar300119','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '456786786','email' => 'test123@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$NqFAcl6aNOgj5Qhw84t0DeMGlwHeJlD1I20oLyjwK51p9seXT23FG','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Teman','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 04:20:19','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-07 23:56:54','updated_at' => '2021-09-23 04:20:19','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '227','referal' => NULL,'rek_member_id' => '153','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Newmember','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '6281937481272','email' => 'ghuvroon@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$1LKmDZRaZzbujJEjfaQUL.Vipf3N23gm4hw1aMi/irnMK6aUlBnXu','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-08 17:21:06','last_login_ip' => '125.164.11.205','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-08 17:21:05','updated_at' => '2021-09-14 09:37:55','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '228','referal' => NULL,'rek_member_id' => '169','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Devjambispirits','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081366020805','email' => 'devjambispirits@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$qdrijDi8cJJBbfcn94yQ2.xdRtQdhoXZCp23VpVz0RbmP4D7PVvgS','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-11 16:09:20','last_login_ip' => '103.167.166.134','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-11 15:57:28','updated_at' => '2021-09-14 08:45:20','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '229','referal' => NULL,'rek_member_id' => '170','type' => 'user','is_cash' => '0','bonus_referal' => '99.50','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'dodolduren','device' => '(Mobile) Brand name: Samsung. Model: phone','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '081366556677','email' => 'dodolduren@gmail.com','rekening_id_tujuan_depo' => '9','email_verified_at' => NULL,'password' => '$2y$10$ZRo0wNbTKiVpx7OxSNj/je9GAS/6xcNFH.b1YQpxX1KnnKHMPk5UO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-20 04:51:18','last_login_ip' => '103.167.166.134','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-14 13:36:13','updated_at' => '2021-09-20 04:51:18','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '230','referal' => NULL,'rek_member_id' => '171','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '1','username' => 'yordan7','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'yordan@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$7M2jR1oq3LSmKFc6y2p/kOerO5eGRqwZseZBPCBLDeNJDCN22bZh6','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-15 06:09:22','last_login_ip' => '1231231','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-15 06:05:12','updated_at' => '2021-09-16 07:31:48','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '231','referal' => NULL,'rek_member_id' => '172','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => '11','username' => 'celestine32','device' => '','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'celestine2ee@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$d3hL3z1OeGpTW3tL8pkfTOOGLoLpvyM9IMY7ys1at6hkkI15Jo1L.','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Facebook','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => NULL,'last_login_ip' => NULL,'to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-15 06:06:32','updated_at' => '2021-09-16 07:01:01','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '232','referal' => NULL,'rek_member_id' => '173','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'Ggdot17','device' => '(Mobile) Brand name: iPhone. Model: phone','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '0895380015000','email' => 'edotkunyul@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$w1grBA8uU9D6an544BrQXOFj4665iQcVrHcpGaV4mpnnC7tySQ2Ou','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => 'Google','info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-16 16:48:45','last_login_ip' => '223.255.229.11','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-16 16:48:06','updated_at' => '2021-09-16 16:48:45','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '233','referal' => NULL,'rek_member_id' => '174','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'akubaru','device' => 'Chrome','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12374892','email' => 'akubaru@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$tsbQg8oUZDQxRWC6jhrnG.F1j8PgtKZ/LyBpclo7ZCEU/keeprPcO','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-23 03:18:56','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-23 03:18:46','updated_at' => '2021-09-23 03:18:56','deleted_at' => NULL]);
        \DB::table('members')->insert(['id' => '234','referal' => NULL,'rek_member_id' => '177','type' => 'user','is_cash' => '0','bonus_referal' => '0.00','credit' => '0.00','rekening_tujuan_depo_id' => NULL,'referrer_id' => NULL,'username' => 'hanancikatech','device' => '(Mobile) Brand name: Nexus. Model: phone','is_next_deposit' => '1','is_new_member' => '1','constant_rekening_id' => NULL,'nama_rekening' => NULL,'nomor_rekening' => '','phone' => '12314512315','email' => 'hasyrawi@gmail.com','rekening_id_tujuan_depo' => NULL,'email_verified_at' => NULL,'password' => '$2y$10$k8AXiJPihXUQExkVncSsUOU6R.4Xe9KXgW4T5YSseUfWy9ChdM/sK','password_changed_at' => NULL,'active' => '1','status' => '1','info_dari' => NULL,'info_dari_lainnya' => NULL,'timezone' => NULL,'last_login_at' => '2021-09-24 19:26:47','last_login_ip' => '139.255.140.219','to_be_logged_out' => '0','provider' => NULL,'provider_id' => NULL,'remember_token' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2021-09-24 19:14:20','updated_at' => '2021-09-24 19:26:47','deleted_at' => NULL]);
        

        // \DB::table('bets_togel')->insert([
        //     'id' => '1',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '8',
        //     'number_4' => '6',
        //     'number_5' => '1',
        //     'number_6' => '5',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '130000.00',
        //     'togel_setting_game_id' => '1',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '1',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '2',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '7',
        //     'number_5' => '2',
        //     'number_6' => '6',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '550000.00',
        //     'togel_setting_game_id' => '1',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '3',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '5',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '8',
        //     'number_5' => '3',
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5100000.00',
        //     'togel_setting_game_id' => '57',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '100000.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '1',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '4',
        //     'togel_game_id' => '1',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '8',
        //     'number_4' => '6',
        //     'number_5' => '1',
        //     'number_6' => '5',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '200000.00',
        //     'togel_setting_game_id' => '1',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '100000.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '1',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '8',
        //     'togel_game_id' => '5',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => '7',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '5',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '9',
        //     'togel_game_id' => '5',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => '9',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '5',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '19',
        //     'togel_game_id' => '6',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => '5',
        //     'number_6' => '7',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '6',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '10000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '20',
        //     'togel_game_id' => '6',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => '3',
        //     'number_6' => '5',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '6',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '10000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '21',
        //     'togel_game_id' => '6',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => '5',
        //     'number_6' => '5',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '6',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '10000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '22',
        //     'togel_game_id' => '7',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '5',
        //     'number_5' => '7',
        //     'number_6' => '2',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '7',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '23',
        //     'togel_game_id' => '7',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '3',
        //     'number_5' => '5',
        //     'number_6' => '0',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '7',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '24',
        //     'togel_game_id' => '7',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => '2',
        //     'number_5' => '9',
        //     'number_6' => '4',
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '7',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '26',
        //     'togel_game_id' => '8',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => '8',
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => 'as',
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '8',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '27',
        //     'togel_game_id' => '8',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => '4',
        //     'tebak_as_kop_kepala_ekor' => 'ekor',
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '8',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '28',
        //     'togel_game_id' => '9',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => 'kecil',
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '9',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '29',
        //     'togel_game_id' => '9',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => 'genap',
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '9',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '30',
        //     'togel_game_id' => '9',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => 'tepi',
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '9',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '0.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '33',
        //     'togel_game_id' => '10',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => 'ekor',
        //     'tebak_besar_kecil' => 'besar',
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '10',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '34',
        //     'togel_game_id' => '10',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => 'kop',
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => 'ganjil',
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '10',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '-200.00',
        //     'pay_amount' => '10200.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '35',
        //     'togel_game_id' => '10',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => 'ekor',
        //     'tebak_besar_kecil' => 'besar',
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '10',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '-200.00',
        //     'pay_amount' => '10200.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '1',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '42',
        //     'togel_game_id' => '11',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => 'tengah',
        //     'tebak_mono_stereo' => 'stereo',
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '11',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '-200.00',
        //     'pay_amount' => '10200.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '43',
        //     'togel_game_id' => '11',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => 'belakang',
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => 'kembang',
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '10000.00',
        //     'togel_setting_game_id' => '11',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '-200.00',
        //     'pay_amount' => '10200.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '44',
        //     'togel_game_id' => '12',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => 'kecil',
        //     'tebak_genap_ganjil' => 'ganjil',
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => 'tengah',
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '12',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '45',
        //     'togel_game_id' => '12',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => 'besar',
        //     'tebak_genap_ganjil' => 'ganjil',
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => 'depan',
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '12',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '46',
        //     'togel_game_id' => '13',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => 'ganjil',
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '13',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '47',
        //     'togel_game_id' => '13',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => 'kecil',
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => NULL,
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '13',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '48',
        //     'togel_game_id' => '14',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => '9',
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '14',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
        //   \DB::table('bets_togel')->insert([
        //     'id' => '49',
        //     'togel_game_id' => '14',
        //     'constant_provider_togel_id' => '1',
        //     'period' => '1',
        //     'number_1' => NULL,
        //     'number_2' => NULL,
        //     'number_3' => NULL,
        //     'number_4' => NULL,
        //     'number_5' => NULL,
        //     'number_6' => NULL,
        //     'tebak_as_kop_kepala_ekor' => NULL,
        //     'tebak_besar_kecil' => NULL,
        //     'tebak_genap_ganjil' => NULL,
        //     'tebak_tengah_tepi' => NULL,
        //     'tebak_depan_tengah_belakang' => NULL,
        //     'tebak_mono_stereo' => NULL,
        //     'tebak_kembang_kempis_kembar' => NULL,
        //     'tebak_shio' => '6',
        //     'win_lose_status' => '0',
        //     'togel_results_number_id' => NULL,
        //     'win_nominal' => NULL,
        //     'bet_amount' => '5000.00',
        //     'togel_setting_game_id' => '14',
        //     'discount_kei_amount_result' => '0.00',
        //     'tax_amount' => '0.00',
        //     'pay_amount' => '5000.00',
        //     'buangan_before_submit' => '0.00',
        //     'buangan_after_submit' => '0.00',
        //     'buangan_terpasang' => '0.00',
        //     'is_bets_buangan' => '0',
        //     'is_bets_buangan_terpasang' => '0',
        //     'buangan_terpasang_date' => '0000-00-00 00:00:00',
        //     'buangan_terpasang_by' => '0',
        //     'created_by' => '2',
        //     'updated_by' => NULL,
        //     'deleted_by' => NULL,
        //     'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        //     'deleted_at' => NULL
        //   ]);
    }
}

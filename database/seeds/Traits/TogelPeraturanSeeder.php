<?php

use Illuminate\Database\Seeder;

class TogelPeraturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('website_contents')->insert([
        'title' => '4D/3D/2D',
        'slug' => '4d3d2d',
        'contents' => '<div><strong>Hadiah : 4D= 3000 x | 3D= 400 x | 2D= 70 x | 2D Dpn= 65 x | 2D Tgh= 65 x<br>Min BET : 4D= 100 | 3D= 100 | 2D= 100 | 2D Dpn= 100 | 2D Tgh= 100<br>Max BET : 4D= 200,000 | 3D= 1,000,000 | 2D= 10,000,000 | 2D Dpn= 10,000,000| 2D Tgh= 10,000,000</strong><br><br><strong>4D, 3D dan 2D</strong><br>Menebak 4 angka, 3 angka dan 2 angka.<br><br></div><div>Struktur: ABCD<br><br></div><div>Misalnya keluar : 4321<br>Berarti pemenang untuk<br>4D = 4321<br>3D=321<br>2D=21<br><br></div><div>Aturan permainan:<br>1. Jika anda membeli diluar dari nomor yang dikeluarkan, berarti anda kalah dan uang tidak dikembalikan sama sekali.<br>2. Jika anda membeli masing 100rb untuk angka:<br>4D = 4321<br>3D=321<br>2D=21<br><br></div><div>(Khusus untuk 4D,3D dan 2D diberikan diskon tambahan. Diskon akan makin besar jika nilai akumulasi betting dalam satu periode makin besar)<br><br></div><div>Berarti kemenangan anda adalah:<br>4D = 100rb x [Indeks kemenangan untuk 4D]<br>3D = 100rb x [Indeks kemenangan untuk 3D]<br>2D = 100rb x [Indeks kemenangan untuk 2D]<br>(Catatan: nilai bet 100rb tidak dikembalikan ke member)<br><br></div><div><strong>QUICK BET 2D</strong><br>Untuk memudahkan pembelian khusus 2D Depan, 2D Tengah, 2D(Belakang) dalam jumlah banyak dengan kombinasi nomor berurutan dan jumlah bet yang sama, misalnya:<br>2D(Belakang) Besar = 50rb ,artinya 2D yang di bet adalah:<br>50 = 50rb<br>51 = 50rb<br>52 = 50rb<br>53 = 50rb<br>54 = 50rb<br>55 = 50rb sampai dengan 99 = 50rb<br>Jumlah LINE dalam Besar, Kecil, Ganjil, dan Genap adalah selalu 50 LINE baik 2D Depan, 2D Tengah maupun 2D(Belakang)<br><br></div><div><strong>2D Posisi<br></strong><br></div><div>Struktur: ABCD<br>AB = DEPAN, BC = TENGAH, CD = BELAKANG<br>Besar/Kecil: 0-4=kecil, 5-9=besar<br>Ganjil/Genap : 1=ganjil, 2=genap dan seterusnyaMisalnya keluar nomor = 1234<br><br></div><div><br>berati pemenang untuk 2D Depan adalah = 12<br>berati pemenang untuk 2D Tengah adalah = 23<br>berati pemenang untuk 2D Belakang adalah = 34</div><div>NB: Indeks menang dan diskon dapat dilihat di bagian Peraturan<br><br></div><div><br><br></div>',
        'type' => 'game',
        'created_by' => '40',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Colok Bebas',
        'slug' => 'colok-bebas',
        'contents' => '<div><strong>Diskon : 5%<br>Hadiah : 1.5 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><strong>Colok Angka</strong><br>Lebih di kenal <strong>COLOK BEBAS<br></strong><br></div><div>Menebak salah satu angka dari 4D. Posisi angka bisa dimana saja<br><br></div><div>Struktur: ABCD<br><br></div><div>Analisis I:<br>Keluar : 4321<br>Misalnya pembelian Angka 3 dengan nilai taruhan 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk colok angka]<br><br></div><div>Analisis II:<br>Keluar : 4331<br>Misalnya pembelian Angka 3 dengan nilai taruhan 100rb.<br>Berarti menang:<br>100rb + ([Indeks kemenangan untuk colok Angka] x 2)<br><br></div><div>dan seterusnya untuk setiap kembaran yang berhasil ditebak, otomatis mendapat kelipatan [Indeks kemenangan untuk colok angka]<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Macau',
        'slug' => 'macau',
        'contents' => '<div><strong>Diskon : 0%<br>Hadiah : 6 x | 12 x | 18 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><br><strong>Macau / Colok bebas 2D</strong><br>Cara kerja seperti colok angka tapi mesti yang keluar 2 angka dari 4D.<br><br></div><div>Struktur: ABCD<br><br></div><div>Analisis I:<br>Keluar : 4321<br>Misalnya dibeli 4 dan 2 dengan nilai 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk Macau, kategori: 2 digit]<br><br></div><div>Analisis II:<br>Keluar : 4321<br>Misalnya dibeli 4 dan 6 dengan nilai 100rb.<br>Berarti KALAH dan nilai betting tidak dikembalikan<br><br></div><div>Analisis III:<br>Keluar : 4331<br>Misalnya dibeli 4 dan 3 dengan nilai 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk Macau, kategori: 3 digit]<br><br></div><div>Analisis IV:<br>Keluar : 4334<br>Misalnya dibeli 4 dan 3 dengan nilai 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk Macau, kategori: 4 digit]<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Colok Naga',
        'slug' => 'colok-naga',
        'contents' => '<div><strong>Diskon : 0%<br>Hadiah : 20 x | 29 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><br><strong>Colok Naga</strong><br>Cara kerja seperti colok bebas 2D / MACAU tapi mesti yang keluar 3 angka dari 4D.<br><br></div><div>Struktur: ABCD<br><br></div><div>Analisis I:<br>Keluar : 4321<br>Misalnya dibeli 4 ,2 dan 3 dengan nilai 100rb.<br>Berarti menang:<br>karena keluar 3 digit,angka 4,2 dan 3.<br>100rb + [Indeks kemenangan untuk colok naga , kategori: 3 digit]<br><br></div><div>Analisis II:<br>Keluar : 4321<br>Misalnya dibeli 4,2 dan 6 dengan nilai 100rb.<br>Berarti KALAH<br>karena keluar hanya 2 digit,angka 4 dan 2 .dan angka 6 tidak muncul<br>nilai betting tidak dikembalikan<br><br></div><div>Analisis III:<br>Keluar : 4331<br>Misalnya dibeli 4,3 dan 3 dengan nilai 100rb.<br>Berarti menang:<br>karena keluar 3 digit,angka 4,3 dan 3.<br>100rb + [Indeks kemenangan untuk colok naga , kategori: 3 digit]<br><br></div><div>Analisis IV:<br>Keluar : 4334<br>Misalnya dibeli 4,3 dan 3 dengan nilai 100rb.<br>karena keluar 4 digit,angka 4,3 dan 3.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk colok naga, kategori: 4 digit]<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Colok Jitu',
        'slug' => 'colok-jitu',
        'contents' => '<div><strong>Diskon : 0%<br>Hadiah : 8 x&nbsp; + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><br><strong>Colok Jitu</strong><br>Menebak satu angka pada posisi tertentu dari 4D.<br><br></div><div>Struktur: ABCD<br><br></div><div>Analisis I:<br>Keluar : 4321<br>Misalnya dibeli 4 pada posisi AS dengan nilai 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk colok jitu]<br><br></div><div>Analisis II:<br>Keluar : 4331<br>Misalnya dibeli 3 pada posisi KOP dengan nilai 100rb.<br>Berarti menang:<br>100rb + [Indeks kemenangan untuk colok jitu]. Hasilnya sama dengan analisis I karena hanya memperhatikan posisi yang dipasang.<br><br></div><div>Analisis III:<br>Keluar : 4331<br>Misalnya dibeli 4 pada posisi EKOR dengan nilai 100rb.<br>Berarti kalah. Biarpun nilai 4 keluar pada posisi AS tapi tidak akan mepengaruhi pemilihan di pososi EKOR<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => '50-50 Umum',
        'slug' => '50-50-umum',
        'contents' => '<div><strong>Kei Besar : -1.5%, Kecil : -1.5%, Genap : -1.5%, Ganjil : -1.5%, Tengah : -1.5%, Tepi : -1.5%, <br>Hadiah : 1 x + Modal<br>Min BET : 10,000<br>Max BET : 50,000,000</strong><br><br><br><strong>50-50</strong><br><br>Permainan ganjil/genap, besar/kecil, dan tengah/ tepi UMUM<br><br></div><div>Struktur: CD ( hanya dua angka belakang yang dihitung)<br>Menebak ganjil/genap dan besar/kecil dari posisi:<br>C=KEPALA<br>D=EKOR<br>Besar/Kecil: 0-4=kecil, 5-9=besar<br>Ganjil/Genap : 1=ganjil, 2=genap dan seterusnya<br><br></div><div>Tengah/Tepi : Tengah: angka 25 s/d 74. TEPI : angka 75 s/d 99, dan 00s/d 24</div><div>Analisis I:<br>Keluar : 6789, Berarti hasil 89<br>Berarti pemenang adalah yang memilih:<br><br></div><div>BESAR<br>GANJIL<br>TEPI</div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => '50-50 Special',
        'slug' => '50-50-special',
        'contents' => '<div><strong>Kei AsGanjil : -2.0%, AsGenap : -2.0%, AsBesar : -2.0%, AsKecil : -2.0%, KopGanjil : -2.0%, KopGenap : -2.0%, KopBesar : -2.0%, KopKecil : -2.0%, KepalaGanjil : -2.0%, KepalaGenap : -2.0%, KepalaBesar : -2.0%, KepalaKecil : -2.0%, EkorGanjil : -2.0%, EkorGenap : -2.0%, EkorBesar : -2.0%, EkorKecil : -2.0%,&nbsp; &nbsp; <br>Hadiah : 1 x + Modal<br>Min BET : 10,000<br>Max BET : 50,000,000</strong><br><br><strong>Peraturan Game 50-50 Special</strong><br>Menebak ganjil/genap, besar/kecil<br>Permainan ini sangat menarik karena pasarannya naik turun sesuai keinginan market pada waktu tersebut. Dengan demikian, nilai pembelian dipengaruhi kei (pasaran)..<br><br></div><div>Struktur: ABCD<br>Menebak ganjil/genap dan besar/kecil dari posisi:<br>A=AS<br>B=KOP<br>C=KEPALA<br>D=EKOR<br>Besar/Kecil: 0-4=kecil, 5-9=besar<br>Ganjil/Genap : 1=ganjil, 2=genap dan seterusnya<br><br></div><div>Analisis I:<br>Keluar : 4327<br>Berarti pemenang adalah yang memilih:<br>AS GENAP/KECIL<br>KOP GANJIL/KECIL<br>KEPALA GENAP/KECIL<br>EKOR GANJIL/BESAR<br>Misal anda membeli dengan dana Rp.100rb untuk AS Genap, menang = 100rb + [indeks pasaran AS Genap 50-50]<br>Atau:<br>Jika membeli dengan dana Rp.100rb untuk Ekor Ganjil, menang = 100rb + [indeks pasaran Ekor Ganjil 50-50]<br>Atau:<br>Jika membeli dengan dana Rp.100rb untuk AS Ganjil, kalah = 100rb + [indeks pasaran AS Ganjil 50-50]<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => '50-50 Kombinasi',
        'slug' => '50-50-kombinasi',
        'contents' => '<div><strong>Kei BelakangMono : -2%, BelakangStereo : -2%, BelakangKembang : -2%, BelakangKempis : -2%, BelakangKembar : 43%, TengahMono : -2%, TengahStereo : -2%, TengahKembang : -2%, TengahKempis : -2%, TengahKembar : 43%, DepanMono : -2%, DepanStereo : -2%, DepanKembang : -2%, DepanKempis : -2%, DepanKembar : 43%,<br>Hadiah : 1 x + Modal<br>Min BET : 10,000<br>Max BET : 50,000,000</strong><br><br><br><strong>SILANG HOMO</strong><br><strong>Menebak dari posisi Depan,Tengah,Belakang.</strong><br><strong>Contoh no 1234</strong><br>Yang dimaksud dengan Posisi Depan adalah 2 no terdepan yaitu 12<br>Yang dimaksud dengan Posisi Tengah adalah 2 no ditengah yaitu 23<br>Yang dimaksud dengan Posisi Belakang adalah 2 no terbelakang yaitu 34<br><strong>SILANG</strong> = Terdapat Ganjil dan Genap<br><strong>HOMO</strong> = Terdapat 1 pasang Ganjil atau 1 pasang Genap<br><br></div><div><strong>Analisis I: Beli Posisi Depan</strong><br>Keluar : 4321.<br>Yang menjadi pedoman adalah posisi Depan, berarti 12<br>12 =&gt; 1=ganjil dan 2=genap , berarti hasil = SILANG<br><br></div><div><strong>Analisis II: Beli Posisi Tengah</strong><br>Keluar : 4326.<br>Yang menjadi pedoman adalah posisi Tengah, berarti 32<br>32 =&gt; 3=ganjil dan 2=genap , berarti hasil = SILANG<br><br></div><div><strong>Analisis III: Beli Posisi Belakang</strong><br>Keluar : 4533.<br>Yang menjadi pedoman adalah posisi Belakang, berarti 33<br>33 =&gt; 3=ganjil dan 3=ganjil , berarti hasil = HOMO<br>Jika dilakukan pembelian dengan 100rb dan menang maka: Menang = 100rb + [Indeks kemenangan untuk SILANG HOMO]<br><br></div><div><strong>KEMBANG KEMPIS KEMBAR</strong><br>Struktur=ABCD<br>Jika Menebang posisi Depan maka yang menjadi fokus adalah AB<br>Jika Menebang posisi Tengah maka yang menjadi fokus adalah BC<br>Jika Menebang posisi Belakang maka yang menjadi fokus adalah CD<br>KEMBANG jika A &lt; B ataupun B &lt; C ataupun C &lt; D<br>KEMPIS jika A &gt; B ataupun B &gt; C ataupun C &gt; D<br>KEMBAR jika A = B ataupun B = C ataupun C = D<br><br></div><div><strong>Analisis I: Beli Posisi Depan</strong><br>Keluar : 4321<br>Yang menjadi pedoman adalah posisi Depan, berarti 43<br>43 =&gt; 4 &gt; 3, hasil = KEMPIS<br><br></div><div><strong>Analisis II: Beli Posisi Tengah</strong><br>Keluar : 4236<br>Yang menjadi pedoman adalah posisi Tengah, berarti 23<br>23 =&gt; 2 &lt; 3, hasil = KEMBANG<br><br></div><div><strong>Analisis III : Beli Posisi Belakang:</strong><br>Keluar : 4099<br>Yang menjadi pedoman adalah posisi Belakang, berarti 99<br>99 =&gt; Hasil = KEMBAR<br><br></div><div><strong>Jika dilakukan pembelian dengan 100rb dan menang maka:</strong><br><strong>Menang = 100rb + [Indeks kemenangan untuk KEMBANG-KEMPIS]<br></strong><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Kombinasi',
        'slug' => 'kombinasi',
        'contents' => '<div><strong>Diskon : 0 % <br>Hadiah : 2.8 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><br><strong>KOMBINASI<br></strong><br></div><div>Struktur ABCD<br>AB = DEPAN, BC = TENGAH, CD = BELAKANG<br>Besar/Kecil: 0-4=kecil, 5-9=besar<br>Ganjil/Genap : 1=ganjil, 2=genap dan seterusnya<br><br></div><div>Anda dapat menebak Genap/Ganjil, Besar/Kecil<br>dari 2 kombinasi antara DEPAN, TENGAH, BELAKANG<br><br></div><div>Analisis : keluar nomor 1845<br><br></div><div>berarti pemenang untuk :<br>DEPAN Kecil/Genap<br>TENGAH Besar/Genap<br>BELAKANG Kecil/Ganjil<br><br></div><div>Misalnya anda membeli BELAKANG KECIl dan GANJIL seharga 100rb,<br>maka menang = 100rb + [indeks kemenangan untuk kombinasi 2]<br>atau :<br>jika membeli DEPAN KECIL dan GENAP seharga 100rb,<br>maka menang = 100rb + [indeks kemenangan untuk kombinasi 2]<br>atau :<br>jika membeli TENGAH KECIL dan GENAP seharga 100rb, berarti KALAH<br>( Anda harus menebak keduanya dengan Benar diantara DEPAN,TENGAH,BELAKANG agar Menang )<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Dasar',
        'slug' => 'dasar',
        'contents' => '<div><strong>Kei Ganjil : -25%, Genap : 0%, Besar : -25%, Kecil : 0%, <br>Hadiah : 1 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><strong>Dasar</strong><br>Menebak ganjil/genap dan besar/kecil dari penjumlah angka-angka 2D.<br>Nilai pembelian ditentukan pasaran (kei) pada saat itu.<br><br>Struktur: CD (2 angka terakhir)<br>Kecil = angka 0-4<br>Besar = angka 5-9<br>Ganjil = 1,3,5,7,9<br>Genap = 0,2,4,6,8<br><br>Analisis I:<br>Keluar : 1234,<br>3+4 = 7<br>Berarti keluar : Ganjil dan Besar<br><br>Analisis II:<br>Keluar : 5678,<br>7+8 = 15<br>Karena angka 15 lebih besar dari 9, kembali dihitung 1+5=6<br>Berarti keluar : Genap dan Besar<br><br>Analisis III:<br>Keluar : 1204,<br>0+4 = 4<br>Berarti keluar : Genap dan Kecil<br>Misal anda membeli dengan Rp.100rb untuk Genap, menang = 100rb + [indeks menang untuk Dasar]<br><br>NB: Indeks menang dan diskon dapat dilihat di bagian Peraturan</div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);
      \DB::table('website_contents')->insert([
        'title' => 'Shio',
        'slug' => 'shio',
        'contents' => '<div><strong>Diskon : 0 %<br>Hadiah : 9 x + Modal<br>Min BET : 5,000<br>Max BET : 20,000,000</strong><br><br><br><strong>Shio<br></strong><br></div><div><strong>Struktur: ABCD</strong><br>Menebak SHIO dari posisi 2D, SHIO merupakan 12 lambang kelahiran dalam penanggalan China. Dalam permainan ini, setiap lambang diwakili dengan satu nomor.<br><br></div><div>&nbsp;<br><br></div><div><strong>Analisis I:</strong><br>Keluar : 4321<br>Permainan ini hanya memperhatikan posisi 2D, berarti yang dipedomanin = 21<br>Hasil = 21-12 = 9 (shio disesuaikan dengan tabel diatas)<br>catatan: nilai yang dikurangi merupakan kelipatan 12.<br><br></div><div>Jika dilakukan pembelian dengan 100rb dan menang maka:<br>Menang = 100rb + [Indeks kemenangan untuk SHIO]<br><br></div><div>NB: Indeks menang dan diskon dapat dilihat di bagian Peraturan<br><br></div>',
        'type' => 'game',
        'created_by' => '1',
        'updated_by' => '1',
        'deleted_by' => NULL,
        'created_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'updated_at' => (new \DateTime())->format("Y-m-d H:i:s"),
        'deleted_at' => NULL
      ]);        
    }
}

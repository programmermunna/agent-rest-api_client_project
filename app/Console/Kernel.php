<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use App\Helpers\BcaHelper;
use Carbon\Carbon;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('activitylog:clean')->daily();

        // $schedule->call(function () {
        //     $controller = new \App\Http\Controllers\Backend\BcaController();
        //     $controller->cronMutasi();
        // })->everyMinute();

        # mau pakai di bawah ini jg jalan
        // $schedule->call(function(){
        //     $this->cronBcaMutasi();
        // })->everyMinute();

        // $schedule->call(function () {
        //     $controller = new \App\Http\Controllers\Api\v1\MemberController();
        //     $controller->setBonusNextDeposit();
        // })->dailyAt('23:59');

        // $schedule->call('\App\Http\Controllers\Api\v1\MemberController@bonus')->weekly()->mondays()->at('13:00');

        #update is cash (is_cash ==  0 ? belum dapat cashback : sudah dapat cashback)

        ## ->weeklyOn(1, '8:00'); #Run the task every week on Monday at 8:00
        ## this one works:
        // $schedule->call('down')->weeklyOn(3, '16:48')->timezone('Asia/Jakarta');

        ## ->weeklyOn(1, '8:00'); #Run the task every week on Monday at 8:00
        ## ->monthlyOn(4, '15:00'); #Run the task every month on the 4th at 15:00

        #reset is_cash to be 0
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\Backend\BonusController();
            $controller->updateIsCash();
        })
        ->weeklyOn(1, '00:05')->timezone('Asia/Jakarta');

        #bonus cashback
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\Backend\BonusController();
            $controller->bonusCashback();
        })
        ->weeklyOn(1, '8:00')->timezone('Asia/Jakarta');

        #reset is_turnover to be 0
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\Backend\BonusController();
            $controller->updateIsTurnover();
        })
        ->monthlyOn(1, '00:05')->timezone('Asia/Jakarta');

        // #bonus turnover
        $schedule->call(function () {
            $controller = new \App\Http\Controllers\Backend\BonusController();
            $controller->bonusTurnover();
        })
        ->monthlyOn(1, '15:00')->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function cronBcaMutasi()
    {
        // $todayDate = Carbon::now()->format('Y-m-d');
        // $todayDateTime = Carbon::now()->format('Y-m-d H:i:s');
        // $countMutasiBcaInDate = DB::table('mutasi_bca')
        //                             ->where('tanggal', $todayDate)
        //                             ->whereDate('tanggal', $todayDate)
        //                             ->count();
        ///////////////////////////////////////////
        // if in databse not have same date
        // if($countMutasiBcaInDate == 0){
        //     $mutasiData=[
        //         'tanggal'  => $todayDate,
        //         'keterangan' => 'keterangan blah blah blah',
        //         'mutasi' => 400000.00,
        //         'mkode' => 'DB',
        //         'userbca' => 456,
        //         'created_at' => $todayDateTime
        //     ];
        //     # Can insert up to 20K, use raw :) // rey
        //     DB::table('mutasi_bca')->insert($mutasiData);
        // }

        

        // $setting = DB::table('orchardpools_settings')->first();
        // // $todayDate = date('Y-m-d');
        // $todayDate = Carbon::now()->format('Y-m-d');
        // $countItemInDate = DB::table('orchardpools_draw')->whereDate('date_for_number', $todayDate)->count();
        // // if in databse not have same date
        // if($countItemInDate == 0){
        //     // if launching date not empty
        //     if($setting->launching_date != NULL || $setting->launching_date != ''){
        //         // if today not more than launching date
        //         if(strtotime($todayDate) < strtotime($setting->launching_date)){
        //             $draw_no = DB::table('orchardpools_draw')->insertGetId([
        //                 'date_for_number' => $todayDate
        //             ]);
        //             $dataWinner = $this->generateRandomNumber($draw_no, 3, FALSE);
        //             $dataConsolation = $this->generateRandomNumber($draw_no);
        //             // validate consolation to winner
        //             if($this->validationNumber($dataConsolation, $dataWinner) == TRUE){ // if true re generate number
        //                 $dataConsolation = $this->generateRandomNumber($draw_no);
        //             }
        //             $dataStarter = $this->generateRandomNumber($draw_no);
        //             // validate starter to winner
        //             if($this->validationNumber($dataStarter, $dataWinner) == TRUE){ // if true re generate number
        //                 $dataStarter = $this->generateRandomNumber($draw_no);
        //             }
        //             // validate starter to consolation
        //             if($this->validationNumber($dataStarter, $dataConsolation) == TRUE){ // if true re generate number
        //                 $dataStarter = $this->generateRandomNumber($draw_no);
        //             }
        //             // insert data
        //             DB::table('orchardpools_consolation')->insert($dataConsolation);
        //             DB::table('orchardpools_starter')->insert($dataStarter);
        //             DB::table('orchardpools_winner')->insert($dataWinner);
                
        //             $consolations = DB::table('orchardpools_consolation')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //             $starter = DB::table('orchardpools_starter')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //             $winner = DB::table('orchardpools_winner')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //             // get min and max random reload time from setting
        //             $minRandom = $setting->min_count_reload_time;
        //             $maxRandom = $setting->max_count_reload_time;
        //             $clock = $setting->countdown_stop;
        //             // looping update consolation
        //             foreach($consolations as $value){
        //                 $randomTime = rand($minRandom, $maxRandom);
        //                 $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //                 DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //             }
        //             // looping update starter
        //             foreach($starter as $value){
        //                 $randomTime = rand($minRandom, $maxRandom);
        //                 $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //                 DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //             }
        //             // looping update winner
        //             foreach($winner as $value){
        //                 $randomTime = rand($minRandom, $maxRandom);
        //                 $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //                 DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //             }
        //         }
        //     }else{
        //         $draw_no = DB::table('orchardpools_draw')->insertGetId([
        //         'date_for_number' => $todayDate
        //         ]);
        //         $dataWinner = $this->generateRandomNumber($draw_no, 3, FALSE);
        //         $dataConsolation = $this->generateRandomNumber($draw_no);
        //         // validate consolation to winner
        //         if($this->validationNumber($dataConsolation, $dataWinner) == TRUE){ // if true re generate number
        //         $dataConsolation = $this->generateRandomNumber($draw_no);
        //         }
        //         $dataStarter = $this->generateRandomNumber($draw_no);
        //         // validate starter to winner
        //         if($this->validationNumber($dataStarter, $dataWinner) == TRUE){ // if true re generate number
        //         $dataStarter = $this->generateRandomNumber($draw_no);
        //         }
        //         // validate starter to consolation
        //         if($this->validationNumber($dataStarter, $dataConsolation) == TRUE){ // if true re generate number
        //         $dataStarter = $this->generateRandomNumber($draw_no);
        //         }
        //         // insert data
        //         DB::table('orchardpools_consolation')->insert($dataConsolation);
        //         DB::table('orchardpools_starter')->insert($dataStarter);
        //         DB::table('orchardpools_winner')->insert($dataWinner);
        
        //         $consolations = DB::table('orchardpools_consolation')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //         $starter = DB::table('orchardpools_starter')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //         $winner = DB::table('orchardpools_winner')->where('draw_id', $draw_no)->orderBy('id', 'desc')->get();
        //         // get min and max random reload time from setting
        //         $minRandom = $setting->min_count_reload_time;
        //         $maxRandom = $setting->max_count_reload_time;
        //         $clock = $setting->countdown_stop;
        //         // looping update consolation
        //         foreach($consolations as $value){
        //         $randomTime = rand($minRandom, $maxRandom);
        //         $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //         DB::table('orchardpools_consolation')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //         }
        //         // looping update starter
        //         foreach($starter as $value){
        //         $randomTime = rand($minRandom, $maxRandom);
        //         $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //         DB::table('orchardpools_starter')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //         }
        //         // looping update winner
        //         foreach($winner as $value){
        //         $randomTime = rand($minRandom, $maxRandom);
        //         $clock = date("$todayDate H:i:s",strtotime("+$randomTime minutes",strtotime($clock)));
        //         DB::table('orchardpools_winner')->where('id', $value->id)->update(['time_show'=>"$clock"]);
        //         }
        //     }
        // }
    }
}

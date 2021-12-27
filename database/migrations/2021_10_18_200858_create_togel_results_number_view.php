<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTogelResultsNumberView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared('DROP VIEW IF EXISTS togel_results_number_view');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView()
    {
        return "
        DROP VIEW IF EXISTS togel_results_number_view;
        CREATE VIEW togel_results_number_view AS
            select
            concat(b.name_initial, '-', b.period) as 'pasaran'
            , DATE_FORMAT(a.result_date, '%d %M %Y') as 'tanggal'
            , dayname(a.result_date) as 'hari'
            , concat(
                a.number_result_3
                , a.number_result_4
                , a.number_result_5
                , a.number_result_6
            ) as 'nomor'
            from
            togel_results_number a
            join constant_provider_togel b on a.constant_provider_togel_id = b.id;
        ";
    }
}

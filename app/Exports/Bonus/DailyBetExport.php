<?php

namespace App\Exports\Bonus;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DailyBetExport implements FromView
{
    protected $data;
    protected $view_type;

    public function __construct($data, $view_type = 'bonus.daily-bet')
    {
        $this->data = $data;
        $this->view_type = $view_type;
    }

    public function view(): View
    {
        return view("backend.exports.{$this->view_type}", [
            'data' => $this->data,
        ]);
    }
}

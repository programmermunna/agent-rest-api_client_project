<?php

namespace App\Exports\Bonus;

use Illuminate\Contracts\View\View;

class DailyBonusExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('backend.exports.bonus.daily-upload', [
            'data' => $this->data,
        ]);
    }
}
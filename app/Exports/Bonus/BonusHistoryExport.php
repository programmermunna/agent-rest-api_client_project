<?php

namespace App\Exports\Bonus;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BonusHistoryExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('backend.exports.bonus.bonus-history', [
            'data' => $this->data,
        ]);
    }
}
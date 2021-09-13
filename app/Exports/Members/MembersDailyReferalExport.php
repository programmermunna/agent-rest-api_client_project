<?php

namespace App\Exports\Members;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MembersDailyReferalExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('backend.exports.members.daily-referal', [
            'data' => $this->data,
        ]);
    }
}

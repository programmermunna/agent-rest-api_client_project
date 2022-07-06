<?php

namespace App\Imports;

use App\Models\BonusModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BonusImport implements ToModel, WithHeadingRow
{
    protected $uploadId;

    public function __construct($uploadId)
    {
        $this->uploadId = $uploadId;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BonusModel([
            'name' => $row['name'],
            'event' => $row['event'],
            'amount' => $row['amount'],
            'event_type' => $row['event_type'],
            'upload_bonus_id' => $this->uploadId,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);
    }
}
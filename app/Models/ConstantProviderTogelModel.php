<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConstantProviderTogelModel extends Model
{

    use SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'constant_provider_togel';

    /**
     * For Each Provider have many result number
     */
    public function resultNumber(): HasMany
    {
        return $this->hasMany(TogelResultNumberModel::class, 'constant_provider_togel_id')
            ->select([
                'id', 'constant_provider_togel_id', 'number_result_1', 'number_result_2',
                'number_result_3', 'number_result_4', 'number_result_5', 'number_result_6',
                'period',
                'result_date',
            ])
            ->orderBy('period', 'desc');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(LotteryMarketSchedule::class, 'constant_provider_togel_id');
    }

}

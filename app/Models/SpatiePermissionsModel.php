<?php

namespace App\Models;

use App\Domains\Auth\Models\Permission;
use Illuminate\Support\Facades\Log;

//use Illuminate\Database\Eloquent\Model;

class SpatiePermissionsModel extends Permission
{
    public function moduleUserPermissions()
    {
        $items = $this->get()->filter(function ($item) {
            //Name Pattern Must Follow user.access.*
            try {
                $level = explode('.', $item->name);
                $condition2 = count($level) >= 2 && $level[0] === 'user' && $level[1] === 'access';
                return $item->type === 'user' && $condition2;
            } catch (\Exception $e) {
                Log::error($e);
                return false;
            }
        })->map(function ($item) {
            $itemLevels = explode('.', $item->name);
            if (count($itemLevels) > 3) {
//                $item = $item->toArray();
                $newItem['sub_module_name'] = $itemLevels[3];
                $newItem['items'][$itemLevels[3]] = $item->toArray();
            } else {
                $newItem['items'] = collect($item->toArray());
            }
            $newItem['module_name'] = $itemLevels[2];
            return $newItem;
        });

        return $items->groupBy('module_name');
    }
}

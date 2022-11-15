<?php

namespace App\Repositories;

use App\Interfaces\Repository\OrganizationServiceRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationServiceRepository implements OrganizationServiceRepositoryInterface
{
    protected Collection $items;
    public function __construct()
    {
        $fromJson = $this->parseFromJson('internalservices.json');

        $items = (array) $fromJson['services'];
        //dd($items);
        $this->items = $this->parse($items);
    }
    public function getAllItems()
    {
        return $this->items;
    }

    private function parseFromJson($file): Collection
    {
        $path = resource_path() .'/json/'. $file;

        $content = (array) json_decode(file_get_contents($path));

        return collect($content);
    }

    protected function parse($data): Collection
    {
        if ($data instanceof Collection) {
            return $data;
        }

        return collect($data);
    }
}

<?php

namespace App\Providers;

use App\Interfaces\Repository\OrganizationServiceRepositoryInterface;
use App\Repositories\OrganizationServiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repository = [
        OrganizationServiceRepositoryInterface::class => OrganizationServiceRepository::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->repository as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}

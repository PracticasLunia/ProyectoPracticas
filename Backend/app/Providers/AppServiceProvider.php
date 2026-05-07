<?php

namespace App\Providers;

use App\Repositories\Autor\AutorRepositoryInterface;
use App\Repositories\Autor\EloquentAutorRepository;
use App\Repositories\Genero\EloquentGeneroRepository;
use App\Repositories\Genero\GeneroRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* De esta forma, cuando los controladores pidan la interfaz,
        Laravel resolverá automáticamente la implementación correcta.*/
        $this->app->bind(
            AutorRepositoryInterface::class,
            EloquentAutorRepository::class
        );

        $this->app->bind(
            GeneroRepositoryInterface::class,
            EloquentGeneroRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace PersistableEvents;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use PersistableEvents\PersistableEvent;
use PersistableEvents\Exceptions\StorageDriverNotFoundException;

class PersistableEventServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/event-store.php' => config_path('event-store.php')
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../../migrations');

        $writer = $this->app->make('PersistableEvents\Services\EventWriter');

        Event::listen('*', function ($eventName, array $data) use ($writer) {
            if ($data[0] instanceof PersistableEvent) {
                $writer->store($data[0]);
            }
        });

    }

    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/event-store.php', 'event-store'
        );

        $this->app->bind('PersistableEvents\Repositories\EventRepositoryInterface', function ($app) {
            switch ($app->config->get('event-store.driver')) {
                case 'database':
                    $connectionName = $app->config->get('event-store.connection', $app->config->get('database.default'));
                    $dbConnection = $app->make('db')->connection($connectionName);
                    return new \PersistableEvents\Repositories\SqlEventRepository($dbConnection);
                    break;
                default:
                    throw new StorageDriverNotFoundException;
            }
        });
    }
}

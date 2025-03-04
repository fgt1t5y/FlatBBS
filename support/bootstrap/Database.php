<?php

namespace support\bootstrap;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Events\Dispatcher;
use support\Container;
use Throwable;
use Webman\Bootstrap;
use Workerman\Timer;
use Workerman\Worker;
use function class_exists;
use function config;

class Database implements Bootstrap
{
    /**
     * @param Worker|null $worker
     *
     * @return void
     */
    public static function start(?Worker $worker)
    {
        if (!class_exists(Capsule::class)) {
            return;
        }

        $connection = config('database', []);
        if (!$connection) {
            return;
        }

        $capsule = new Capsule(IlluminateContainer::getInstance());

        $capsule->addConnection($connection);

        if (class_exists(Dispatcher::class) && !$capsule->getEventDispatcher()) {
            $capsule->setEventDispatcher(Container::make(Dispatcher::class, [IlluminateContainer::getInstance()]));
        }

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        Relation::enforceMorphMap([
            'topic' => 'app\model\Topic',
            'user' => 'app\model\User'
        ]);

        // Heartbeat
        if ($worker) {
            Timer::add(55, function () use ($capsule) {
                foreach ($capsule->getDatabaseManager()->getConnections() as $connection) {
                    /* @var MySqlConnection $connection **/
                    if ($connection->getConfig('driver') == 'mysql') {
                        try {
                            $connection->select('select 1');
                        } catch (Throwable $e) {
                        }
                    }
                }
            });
        }
    }
}


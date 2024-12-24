<?php

namespace support;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Cursor;
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

        // Paginator
        // if (class_exists(Paginator::class)) {
        //     if (method_exists(Paginator::class, 'queryStringResolver')) {
        //         Paginator::queryStringResolver(function () {
        //             $request = request();
        //             return $request ? $request->queryString() : null;
        //         });
        //     }
        //     Paginator::currentPathResolver(function () {
        //         $request = request();
        //         return $request ? $request->path(): '/';
        //     });
        //     Paginator::currentPageResolver(function ($pageName = 'page') {
        //         $request = request();
        //         if (!$request) {
        //             return 1;
        //         }
        //         $page = (int)($request->input($pageName, 1));
        //         return $page > 0 ? $page : 1;
        //     });
        //     if (class_exists(CursorPaginator::class)) {
        //         CursorPaginator::currentCursorResolver(function ($cursorName = 'cursor') {
        //             return Cursor::fromEncoded(request()->input($cursorName));
        //         });
        //     }
        // }
    }
}


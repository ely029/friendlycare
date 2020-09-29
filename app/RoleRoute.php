<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\Route;
use ReflectionClass;
use Str;

class RoleRoute
{
    protected $routes;

    protected $namespaces;

    public function __construct()
    {
        $this->namespaces = collect([
            'Dashboard' => 'App\Http\Controllers\Dashboard',
            'ApiDoc' => (new ReflectionClass(\Mpociot\ApiDoc\Http\Controller::class))->getNamespaceName(),
        ]);

        $this->routes = collect(Route::getRoutes())->filter(function ($router) {
            // We use endsWith since some namespaces have '\' as a prefix.
            return Str::endsWith($router->action['namespace'], $this->namespaces->toArray());
        })->values();
    }

    public static function all()
    {
        return (new RoleRoute())->routes;
    }

    public static function transformed()
    {
        $static = new RoleRoute();

        return $static->routes->map(static function ($route) use ($static) {
            $action = $route->getActionName();
            $controller = $static->getController($action);

            return collect([
                'controller' => $action,
                'controller_name' => $controller['name'],
                'controller_label' => $static->getRouteLabel($action),
                'controller_action' => $controller['action'],
            ]);
        })->groupBy(static function ($item) {
            return $item['controller_name'];
        })->map(static function ($router) {
            return $router->flatMap(static function ($item) use ($router) {
                return [
                    'label' => $item['controller_label'],
                    'actions' => $router,
                ];
            });
        });
    }

    public static function getActionName()
    {
        return static::all()->map->getActionName();
    }

    protected function getController($route)
    {
        [$name, $action] = explode('@', class_basename($route));

        return compact('name', 'action');
    }

    protected function getRouteLabel($route)
    {
        $namespace = $this->namespaces->first(static function ($value) use ($route) {
            return Str::contains($route, $value);
        });
        $step1 = explode($namespace, $route)[1];
        $step2 = stripslashes($step1);
        $step3 = Str::title(Str::snake($step2));
        $step4 = array_unique(explode('_', $step3));
        $step5 = implode('', $step4);
        $step6 = explode('Controller@', $step5)[0];

        if ($step6 === '') {
            $step6 = array_search($namespace, $this->namespaces->toArray());
        }

        return Str::title(Str::snake($step6, ' ')); // Step 7
    }
}

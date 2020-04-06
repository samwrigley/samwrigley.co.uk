<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait HasRoutes
{
    public function createRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'create',
            'key' => 'id',
            'namespace' => 'admin',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    public function storeRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'store',
            'key' => 'id',
            'namespace' => 'admin',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    public function showRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'show',
            'key' => 'slug',
            'namespace' => 'web',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    public function editRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'edit',
            'key' => 'id',
            'namespace' => 'admin',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    public function updateRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'update',
            'key' => 'id',
            'namespace' => 'admin',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    public function destroyRoute(array $parameters = []): ?string
    {
        $defaultParameters = [
            'action' => 'destroy',
            'key' => 'id',
            'namespace' => 'admin',
        ];

        return $this->getRoute(array_merge($defaultParameters, $parameters));
    }

    protected function getRoute(array $parameters): ?string
    {
        if (!Arr::has($parameters, ['action', 'key', 'namespace'])) {
            return null;
        }

        $routeName = $this->getRouteName($parameters['namespace'], $parameters['action']);

        if (!Route::has($routeName)) {
            return null;
        }

        return route($routeName, [$this->{$parameters['key']}]);
    }

    protected function getRouteName(string $namespace, string $action): ?string
    {
        if (empty($this->routeNamespaces)) {
            return null;
        }

        $routeNamespace = $this->routeNamespaces[$namespace];

        if (empty($routeNamespace)) {
            return null;
        }

        return Str::finish($routeNamespace, '.') . $action;
    }
}

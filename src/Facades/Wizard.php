<?php

namespace Ycs77\LaravelWizard\Facades;

use Illuminate\Support\Facades\Facade;

class Wizard extends Facade
{
    /**
     * Undocumented function
     *
     * @param  string  $uri
     * @param  string  $controllerClass
     * @param  string  $name
     * @param  array  $options
     * @return void
     */
    static public function routes(
        string $uri,
        string $controllerClass,
        string $name,
        $options = []
    )
    {
        $options = array_merge([
            'create' => 'create',
            'store' => 'store',
            'done' => 'done',
            'done_url' => 'done',
            'use_done' => true,
        ], $options);

        /** @var \Illuminate\Routing\Router $router */
        $router = static::$app['router'];

        if ($options['use_done']) {
            $router->get(
                "$uri/{$options['done_url']}",
                "$controllerClass@{$options['done']}"
            )->name("$name.{$options['done']}");
        }

        $router->get(
            "$uri/{step?}",
            "$controllerClass@{$options['create']}"
        )->name("$name");

        $router->post(
            "$uri/{step}",
            "$controllerClass@{$options['store']}"
        )->name("$name.{$options['store']}");
    }
}

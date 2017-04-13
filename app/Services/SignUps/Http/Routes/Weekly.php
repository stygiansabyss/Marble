<?php

namespace App\Services\SignUps\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class Weekly extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\SignUps\Http\Controllers';

    public $prefix = 'sign-up';

    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        $router->get('weekly')
               ->name('sign-up.weekly')
               ->uses('Weekly@index');

        $router->post('weekly')
               ->name('sign-up.weekly')
               ->uses('Weekly@store');
    }
}

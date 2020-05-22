<?php


use App\Controller\Test;
use App\Controller\Tmpl;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('register', '/register')
        ->controller([Test::class, 'getPage'])
        ->methods(['get'])
        ;

};

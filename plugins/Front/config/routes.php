<?php
use Cake\Routing\Router;

Router::plugin('Front', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});


/*
Router::scope('/', ['plugin' => 'Front'], function ($routes) {
    $routes->connect('/', ['controller' => 'Front', 'action'=>'index']);
    $routes->fallbacks('InflectedRoute');
});
*/
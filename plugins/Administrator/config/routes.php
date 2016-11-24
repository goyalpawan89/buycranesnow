<?php
use Cake\Routing\Router;

Router::plugin('Administrator', function ($routes) {
    $routes->fallbacks();
});

<?php

$router = new Phalcon\Mvc\Router();

$router->add(
    '/login',
    array(
        'controller' => 'users',
        'action' => 'login',
    )
);

return $router;
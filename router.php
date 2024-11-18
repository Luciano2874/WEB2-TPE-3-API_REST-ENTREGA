<?php 

require_once 'libs/router.php';

require_once 'app/controllers/videogames.api.controller.php';

$router = new Router();

$router->addRoute('videogames',   'GET',   'VideogamesApiController', 'getAll');
$router->addRoute('videogames/:id_juego',   'GET',   'VideogamesApiController', 'get');
$router->addRoute('videogames/:id_juego',   'DELETE',   'VideogamesApiController', 'delete');
$router->addRoute('videogames',   'POST',   'VideogamesApiController', 'create');
$router->addRoute('videogames/:id_juego',   'PUT',   'VideogamesApiController', 'update');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);


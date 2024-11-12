<?php
    require_once 'libs/router.php';
    require_once 'api/controllers/FabricasApiController.php';
    require_once 'api/controllers/UserApiController.php';
    require_once 'api/middlewares/jwt.auth.middlewares.php';

    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    $router->addRoute('fabrica', 'GET', 'FabricasApiController','getAllFabricas');
    $router->addRoute('fabrica/:id', 'GET', 'FabricasApiController','getFabrica');
    $router->addRoute('fabrica/:id','DELETE', 'FabricasApiController','delete');
    $router->addRoute('fabrica','POST', 'FabricasApiController','create');
    $router->addRoute('fabrica/:id', 'PUT', 'FabricasApiController', 'edit');

    $router->addRoute('usuarios/token', 'GET', 'UserApiController', 'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>
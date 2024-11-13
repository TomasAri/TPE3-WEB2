<?php
    require_once 'libs/router.php';
    require_once 'api/controllers/FabricasApiController.php';
    require_once 'api/controllers/ModelosApiController.php';
    require_once 'api/controllers/UserApiController.php';
    require_once 'api/middlewares/jwt.auth.middlewares.php';

    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    // Tabla Fabricas
    $router->addRoute('fabrica', 'GET', 'FabricasApiController','getAllFabricas');
    $router->addRoute('fabrica/:id', 'GET', 'FabricasApiController','getFabrica');
    $router->addRoute('fabrica/:id','DELETE', 'FabricasApiController','delete');
    $router->addRoute('fabrica','POST', 'FabricasApiController','create');
    $router->addRoute('fabrica/:id', 'PUT', 'FabricasApiController', 'edit');

    // Tabla Modelos
    $router->addRoute('modelo', 'GET', 'ModelosApiController', 'getAllModelos');
    $router->addRoute('modelo/:id', 'GET', 'ModelosApiController','getModelo');
    $router->addRoute('modelo/:id','DELETE', 'ModelosApiController','delete');
    $router->addRoute('modelo','POST', 'ModelosApiController','create');
    $router->addRoute('modelo/:id', 'PUT', 'ModelosApiController', 'edit');

    $router->addRoute('usuarios/token', 'GET', 'UserApiController', 'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

?>
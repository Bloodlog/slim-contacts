<?php
// Routes
$app->get('/', function ($request, $response, $args) use ($app){
	$this->logger->info("'/products/index' route");
	$container = $app->getContainer();
	$controller = new App\controllers\ContactsController($container, $container->get('view'));
	return $controller->actionIndex($request, $response, $args);
})->setName('index');

$app->map(['GET', 'POST'] ,'/create', function ($request, $response, $args) use ($app){
	$this->logger->info("'/products/create' route");
	$container = $app->getContainer();
	$controller = new App\controllers\ContactsController($container, $container->get('view'));
	return $controller->actionCreate($request, $response, $args);
})->setName('create');

$app->map(['GET', 'POST'], '/update/{id:[0-9]+}', function ($request, $response, $args) use ($app){
	$this->logger->info("'/products/update' route");
	$container = $app->getContainer();
	$controller = new App\controllers\ContactsController($container, $container->get('view'));
	return $controller->actionUpdate($request, $response, $args);
})->setName('update');

$app->get('/view/{id:[0-9]+}', function ($request, $response, $args) use ($app){
	$this->logger->info("'/products/view' route");
	$container = $app->getContainer();
	$controller = new App\controllers\ContactsController($container, $container->get('view'));
	return $controller->actionView($request, $response, $args);
})->setName('view');

$app->get('/delete/{id:[0-9]+}', function ($request, $response, $args) use ($app){
	$this->logger->info("'/products/delete' route");
	$container = $app->getContainer();
	$controller = new App\controllers\ContactsController($container, $container->get('view'));
	return $controller->actionDelete($request, $response, $args);
})->setName('delete');

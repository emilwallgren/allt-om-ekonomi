<?php  
require __DIR__.'/config_with_app.php';

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('AnvandareController', function() use ($di) {
    $controller = new Anax\Anvandare\AnvandareController();
    $controller->setDI($di);
    return $controller;
});

$di->set('FragorController', function() use ($di) {
    $controller = new Anax\Fragor\FragorController();
    $controller->setDI($di);
    return $controller;
});

$di->set('TaggarController', function() use ($di) {
    $controller = new Anax\Taggar\TaggarController();
    $controller->setDI($di);
    return $controller;
});

$di->set('OmossController', function() use ($di) {
    $controller = new Anax\Omoss\OmossController();
    $controller->setDI($di);
    return $controller;
});

$di->set('ProfilController', function() use ($di) {
    $controller = new Anax\Profil\ProfilController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$app = new \Anax\MVC\CApplicationBasic($di);
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

//Start Routing
 
$app->router->add('', function() use ($app) {
	
	$app->theme->setTitle("Hem");
	
 	$app->views->add('firstpage/index');
 
});

$app->router->add('fragor', function() use ($app) {
	$app->dispatcher->forward([
	    'controller' => 'fragor',
	    'action'     => 'index',
	]); 
});

$app->router->add('taggar', function() use ($app) {
 	$app->dispatcher->forward([
 	    'controller' => 'taggar',
 	    'action'     => 'index',
 	]); 
});

$app->router->add('anvandare', function() use ($app) {
 	$app->dispatcher->forward([
     'controller' => 'anvandare',
     'action'     => 'index',
 ]); 
});

$app->router->add('omoss', function() use ($app) {
 	$app->dispatcher->forward([
 	    'controller' => 'omoss',
 	    'action'     => 'index',
 	]); 
});

$app->router->add('profil', function() use ($app) {
 	$app->dispatcher->forward([
 	    'controller' => 'profil',
 	    'action'     => 'index',
 	]); 
});

$app->router->handle();
$app->theme->render();
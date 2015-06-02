<?php
// load required files
require_once 'Slim/Slim.php';
require_once 'RedBean/rb.php';
require_once'conf/sql.php';
//include files which contain the hooks for actions
require_once 'webservices/root.php';
require_once 'webservices/social.php';
require_once 'webservices/users.php';

// register Slim auto-loader
\Slim\Slim::registerAutoloader();

// set up database connection
R::setup("mysql:host=$MYSQL_HOSTNAME;dbname=$MYSQL_DATABASE","$MYSQL_USERNAME","$MYSQL_PASSWORD");
//R::freeze(true);

// initialize app
$app = new \Slim\Slim(array(
    'debug' => true
));



$arrEntities = array('social'); //'users', 

foreach ($arrEntities as $entity) {
	$entityObj = new $entity ($entity);
	// handle GET requests for /users
	//the second argument is a pointer to a function, which in php are called callables
	//so this is how we call callables prior to php 5.4
	$app->get('/s.php/'.$entity .'/', array($entityObj, 'getAllRecords'));
	$app->delete('/s.php/'.$entity .'/', array($entityObj, 'deleteAllRecords'));
	
	if ($entity == 'social') {
		$app->get('/s.php/social/:socialType/', array($entityObj, 'getAllSocialUsersForType'));
		$app->get('/s.php/social/:socialType/:id/', array($entityObj, 'getSocialUser'));
		// handle POST requests to /users
		$app->post('/s.php/social/', array($entityObj, 'createSocialProfile'));
		$app->delete('/s.php/social/:socialType/', array($entityObj, 'deleteAllSocialUsersForType'));
		$app->delete('/s.php/social/:socialType/:id/', array($entityObj, 'deleteSocialUser'));
	}
}

if ($DEBUG_LEVEL == 2) {
	$req = $app->request;
	print_r($req);
	$router = $app->router();
	 echo "Router!!<br />";
	print_r($router);
	if ($app->request->isPost()) {
	 echo "Post!!<br />";
	}
}

// run
$app->run();



?>
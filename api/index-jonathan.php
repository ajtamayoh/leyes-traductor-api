<?php

//Require the Slim Framework
require 'Slim/Slim.php';

//Register Slim auto-loader
\Slim\Slim::registerAutoloader();

//Instantiate a Slim application
$app = new \Slim\Slim();

$app->get('/leyes', 'getLeyes');
$app->get('/leyes/1', 'getLeyesById');

function getLeyes() {
		echo '{"leyes":[{"id": 1, "nombre":"Ley #1"},{"id": 2, "nombre":"Ley #2"},{"id": 3, "nombre":"Ley #3"}]}';
}

function getLeyesById() {
                echo '{"leyes":[{"id": 1, "nombre":"Ley #1"}]}';
}


//Run the Slim application
$app->run();

?>

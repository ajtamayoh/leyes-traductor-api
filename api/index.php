<?php
/**
*
* Proyecto Integrador - Universidad de Antioquia
* Antonio Tamayo - Cesar Guapacha - Jose F. Jaramillo
* Leyes Traductor
* 2013
* 
**/

//Require the Slim Framework
require 'Slim/Slim.php';

//Register Slim auto-loader
\Slim\Slim::registerAutoloader();

//Instantiate a Slim application
$app = new \Slim\Slim();

//get methods
$app->get('/leyes', 'getLeyes');
$app->get('/fuente/:ft', 'getLeyesPorFuente');
$app->get('/keyWord/:pc', 'getLeyesPorKeyWord');
$app->get('/anio/:an', 'getLeyesPorAnio');
$app->get('/tipo/:tp', 'getLeyesPorTipo');
$app->get('/fecha/:fecha', 'getLeyesPorFecha');
//prueba
$app->get('/prueba', 'getPrueba');

/***
* Functions
**/

//Esta funcion crea las conecciones con la base de datos
function connectToBDMongo($bd, $collection){

	//conectar
	$con = new MongoClient();
	//obtener base de datos	
	$baseDatos = $con->$bd;
	//seleccionar coleccion
	$coleccion = $baseDatos->$collection;

	return $coleccion;
}


//prueba con BD de prueba
//get documento de BD tienda, bd de prueba
function getPrueba(){

	$prueba = connectTOBDMongo('database', 'prueba')->find();

	$formatoJSON = '{"leyes":[';

	foreach($prueba as $doc){

		//var_dump($doc);
		//var_dump(json_encode($doc));
		$formatoJSON = $formatoJSON.json_encode($doc).', ';
		//echo "<br><br>";
	}

	$formatoJSON = substr($formatoJSON, 0, -2);
	$formatoJSON = $formatoJSON.']}';
	echo $formatoJSON;
}


//get all Leyes
function getLeyes() {
      
	//Nos conectamos a la bd y obteneos todas las leyes almacenadas.
	$leyes = connectToBDMongo('bd_leyes_traductor', 'leyes')->find();

	 $formatoJSON = '{"leyes":[';

	//Recorremos el arreglo que contiene las leyes y las separamos por tres espacios.
	foreach($leyes as $AllLeyes){

		 $formatoJSON = $formatoJSON.json_encode($AllLeyes).', ';

	}

	$formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;

 
}

//Buscar leyes por fuente
function getLeyesPorFuente($ft){

	//Nos conectamos a la BD
	$collection = connectToBDMongo('bd_leyes_traductor', 'leyes');

	$leyes = array('fuente' => $ft);

	$cursor = $collection->find($leyes);

	 $formatoJSON = '{"leyes":[';


	foreach ($cursor as $leyesPorFuente) {

    		 $formatoJSON = $formatoJSON.json_encode($leyesPorFuente).', ';

        }

        $formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;

}

//Buscar leyes por tipo
function getLeyesPorTipo($tp){

	//Nos conectamos a la BD
	$collection = connectToBDMongo('bd_leyes_traductor', 'leyes');
	
	$leyes = array('tipo' => $tp);

	$cursor = $collection->find($leyes);

	$formatoJSON = '{"leyes":[';

	foreach($cursor as $leyesPorTipo){
	
		$formatoJSON = $formatoJSON.json_encode($leyesPorTipo).', ';

        }

        $formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;


}

//Buscar leyes por Anio
function getLeyesPorAnio($an){

	//Nos conectamos a la BD
	$collection = connectToBDMongo('bd_leyes_traductor', 'leyes');

	$leyes = array('anio' => $an);

	$cursor = $collection->find($leyes);

	 $formatoJSON = '{"leyes":[';

	foreach($cursor as $leyesPorAnio){

		$formatoJSON = $formatoJSON.json_encode($leyesPorAnio).', ';

        }

        $formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;

}

//Buscar leyes por fecha
function getLeyesPorFecha($fecha){

	//Nos conectamos a la BD
	$collection = connectToDBMongo('bd_leyes_traductor', 'leyes');

	$leyes = array('fecha_norma' => $fecha);

	$cursor = $collection->find($leyes);

	$formatoJSON = '{"leyes":[';

	foreach($cursor as $leyesPorFecha){

		$formatoJSON = $formatoJSON.json_encode($leyesPorFecha).', ';

        }

        $formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;



}

//Buscar leyes por keyword
function getLeyesPorKeyWord($palabraClave){

	//Nos conectamos con la BD
	$collection = connectToBDMongo('bd_leyes_traductor', 'leyes');

	//$keywordLike = '/'.$palabraClave.'/';

	$leyes = array('keyword' => $palabraClave);

	$cursor = $collection->find($leyes);

	//$cursor = $collection->find({"keyword": "/".$palabraClave."/"})

	$formatoJSON = '{"leyes":[';

	foreach ($cursor as $leyesPorKeyWord) {
    		
		$formatoJSON = $formatoJSON.json_encode($leyesPorKeyWord).', ';

        }

        $formatoJSON = substr($formatoJSON, 0, -2);
        $formatoJSON = $formatoJSON.']}';
        echo $formatoJSON;

}

//Run the Slim application
$app->run();

?>

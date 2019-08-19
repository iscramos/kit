<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id_transaccion = NULL;
$codigo_asociado = NULL;
$nombre = NULL;
$clave = NULL;
$fecha = NULL;

/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$descripcion = $_POST["descripcion"];
		

		// new object
		$proveedores = new Herramientas_proveedores();
		$proveedores->id = $id;
		$proveedores->descripcion = $descripcion;
		$proveedores->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		
		$codigo_asociado = $_POST["codigo_asociado"];
		$nombre = $_POST["nombre"];
		

		// new object
		$temporal = new Herramientas_temporal();
		//$categoria->id = $id;
		$temporal->codigo_asociado = $codigo_asociado;
		
		
		$q = "SELECT * FROM herramientas_temporal WHERE codigo_asociado = $codigo_asociado";
		$temporales = Herramientas_temporal::getAllByQuery($q);

		$siguiente = 1;
		$maximo = Herramientas_transacciones::getAllMax();
		if(count($maximo) > 0)
		{
			$siguiente = $maximo[0]->id + 1;
		}

		$fecha = date("Y-m-d");

		
		$query = "";
		$longitud = count($temporales);
		foreach ($temporales as $temporal) 
		{
			$longitud --;

			$id_transaccion = $siguiente;
			$clave = $temporal->clave;
			$cantidad = $temporal->cantidad;
			$codigo_asociado = $temporal->codigo_asociado;
			$fecha = $fecha;

			$query.= "(";
                $query.= "$siguiente, '$clave', '$cantidad', $codigo_asociado, '$nombre', '$fecha'";    
            $query.= ")";
              
            if($longitud >= 1)
            {
            	$query.= ", ";
            }
           
		}

		//echo $query;
		// insercion masiva de productos
		$transaccion = new Herramientas_transacciones();
	    $transaccion->q = $query;
	    $transaccion->inserta_dura();

	    // descontando de stock
	    $stock = new Herramientas_stock();
	    foreach ($temporales as $temporal) 
		{
			$stock->clave = $temporal->clave;
			$stock->stock = $temporal->cantidad;
			$stock->update_resta();
		}

	    // Eliminando de la tabla temporal
	    // Execute database query
		$temporal = new Herramientas_temporal();
		$temporal->codigo_asociado = $codigo_asociado;
		$temporal->deleteAll();

		$str = "";

		echo $str;
		
	}
}

//redirect_to('indexHerramientas_proveedores.php');

?>
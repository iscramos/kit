<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str = "";
if($_SESSION["type"] == 9 ) // para zancos
{	
	
	$q = "SELECT zancos_movimientos.*, zancos_tamanos.tamano AS descripcion_tamano, zancos_tamanos.limite_semana, zancos_acciones.accion, zancos_problemas.descripcion AS problema_descripcion
			FROM  zancos_movimientos
			INNER JOIN zancos_tamanos ON zancos_movimientos.tamano = zancos_tamanos.id
			INNER JOIN zancos_acciones ON zancos_movimientos.tipo_movimiento = zancos_acciones.id
			LEFT JOIN zancos_problemas ON zancos_movimientos.descripcion_problema = zancos_problemas.id
			ORDER BY zancos_movimientos.id_registro DESC";
			
	//$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);


	function getArraySQL($sql)
	{
	    //Creamos la conexión con la función anterior
	    
	    $conexion = new Database();

	    //generamos la consulta

	    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

	    if(!$result = mysqli_query($conexion, $sql)) die(); //si la conexión cancelar programa

	    $rawdata = array(); //creamos un array

	    //guardamos en un array multidimensional todos los datos de la consulta
	    $i=0;

	    while($row = mysqli_fetch_array($result))
	    {
	        $rawdata[$i] = $row;
	        $i++;
	    }

	    // Close database connection
		$conexion->close();

	    return $rawdata; //devolvemos el array
	}

	$myArray = getArraySQL($q);
	echo json_encode($myArray);

}

else
{
	echo "NO REQUEST";
}


?>

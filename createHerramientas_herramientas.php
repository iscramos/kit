<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$clave = NULL;
$id_categoria = NULL;
$id_marca = NULL;
$descripcion = NULL;
$precio_unitario = NULL;
$fecha_entrada = NULL;

$id_almacen = NULL;
$archivo = NULL;
$activaStock = NULL;
$id_udm = NULL;

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
		$id_marca = $_POST["id_marca"];

		$descripcion = $_POST["descripcion"];
		$precio_unitario = $_POST["precio_unitario"];
		$id_almacen = $_POST["id_almacen"];

		if (isset($_POST['stock'])) 
		{
			$activaStock = 1;
		}
		else
		{
			$activaStock = 0;
		}
		$id_udm = $_POST["id_udm"];

		// new object
		$herramientas = new Herramientas_herramientas();
		$herramientas->id = $id;
		$herramientas->id_marca = $id_marca;
		$herramientas->descripcion = $descripcion;
		$herramientas->precio_unitario = $precio_unitario;
		$herramientas->activaStock = $activaStock;
		$herramientas->id_udm = $id_udm;

		$herramientas->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$clave = $_POST["clave"];
		$id_categoria = $_POST["id_categoria"];
		$id_marca = $_POST["id_marca"];
		$descripcion = $_POST["descripcion"];
		$precio_unitario = $_POST["precio_unitario"];
		$id_almacen = $_POST["id_almacen"];

		if (isset($_POST['stock'])) 
		{
			$activaStock = 1;
		}
		else
		{
			$activaStock = 0;
		}
		$id_udm = $_POST["id_udm"];

		//------- para el nombre del archivo --------------------
		$letras=array(0=>"A",1=>"B",2=>"C",3=>"D",4=>"E",5=>"F",6=>"G",7=>"H",8=>"I",9=>"J",10=>"K",11=>"L",12=>"M",13=>"N",14=>"O",15=>"P",16=>"Q",17=>"R",18=>"S",19=>"T",20=>"U",21=>"V",22=>"W",23=>"X",24=>"Y",25=>"Z");
   		$claveunica='';
		$clavetxt = date('m d');
		$clavetxt = str_replace(" ","",$clavetxt);
		$clavetxt .= $letras[rand(0,25)];
		$clavetxt .= $letras[rand(0,25)];
		$clavetxt = $letras[rand(0,25)].$clavetxt;
		$claveunica=$clavetxt;
	
 		$archivo=""; // variable vacía
 	
 	
	 	if (isset($_FILES['archivo']["tmp_name"]) && strlen($_FILES['archivo']["tmp_name"])>4) 
	 	{
		  	$nombre=$_FILES['archivo']['name']; // obtiene el nombre del archivo

			$nombre=strtolower($nombre);
			$cadena_1=array(" ","ñ","á","é","í","ó","ú","à","è","ì","ò","ù","ü");
			$cadena_2=array("_","n","a","e","i","o","u","a","e","i","o","u","u");
			$nombre=str_replace($cadena_1, $cadena_2, $nombre);
			$nombre=preg_replace('/[^0-9a-z\.\_\-]/i','',$nombre);	
			$nombre=number_format(rand(1,9999),0,'','')."_".$nombre;
		  
		  	$destino = $content; // lugar donde será guardado físicamente
		  
			$tamano = intval($_FILES['archivo']['size']); // Leemos el tamaño del fichero 
			
			if($tamano < 10485760)
			{
				if (copy($_FILES['archivo']['tmp_name'],"".$destino.'/'.$nombre))
				{
					$archivo=$nombre;	
				}
				else
				{
					die("Error al subir el archivo");
				}
			} 
			else
			{
				die('No se pudo subir el archivo '.$_FILES['archivo']['name'].' Verifique que el archivo no esté abierto y que no exceda el tamaño máximo permitido.');
			}
				
			
		}
		// --------------------------------------------------------------
		

		// new object
		$herramientas = new Herramientas_herramientas();
		//$herramientas->id = $id;
		$herramientas->clave = $clave;
		$herramientas->id_almacen = $id_almacen;
		$herramientas->id_categoria = $id_categoria;
		$herramientas->id_marca = $id_marca;
		$herramientas->descripcion = $descripcion;
		$herramientas->precio_unitario = $precio_unitario;
		$herramientas->fecha_entrada = date("Y-m-d H:i:s");
		$herramientas->archivo = $archivo;
		$herramientas->activaStock = $activaStock;
		$herramientas->id_udm = $id_udm;

		$herramientas->save();
	}
}

redirect_to('indexHerramientas_herramientas.php');

?>
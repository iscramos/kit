<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 5) ) // para herramientas
{	
	//$mes = $_GET['mes'];
	$consulta = $_REQUEST['consulta'];
	
	if($consulta == "PRODUCTOS_CATEGORIA")
	{
		$id_categoria = $_REQUEST["id_categoria"];

		$consulta = "SELECT herramientas_herramientas.*,
					(SELECT herramientas_movimientos.tipo_movimiento
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS tipo_movimiento,
					(SELECT herramientas_movimientos.fecha_entrega
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_entrega,
					(SELECT herramientas_movimientos.fecha_servicio
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_servicio,
					(SELECT herramientas_movimientos.descripcion_problema
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS descripcion_problema
				FROM herramientas_herramientas
				WHERE herramientas_herramientas.id_categoria = $id_categoria";

				//echo $consulta;

		$herramientas_herramientas = Herramientas_herramientas::getAllByQuery($consulta);
		if(count($herramientas_herramientas) > 0)
		{
			foreach ($herramientas_herramientas as $articulo) 
	        {
	            $str.="<div class='col-sm-2 col-md-3'>
	                <div class='thumbnail' style=' padding:0px!important'>
	                <span style='font-size:10px; background:#5C4283; color:white; float:left; padding:3px; border-radius:3px; width:60px; text-align: left; position:absolute; left:11px;'> $ ".$articulo->precio_unitario."</span>
	                  <img style='width:140; height:100px;'  src='content/".$articulo->archivo."' >
	                    <div class='caption' style='height:90px; padding: 3px 3px !important;'>
	                        <h5 style='margin-bottom:0px; margin-top:0px; text-align:left;'>".$articulo->clave."</h5>
	                        <p style='font-size:11px; text-align:left;'>".$articulo->descripcion."</p>
	                        <br>
	                        <p style='margin-bottom:15px !important; text-align:center; position:absolute; bottom:10px;'>";

	                            if( ($articulo->fecha_entrega > 0 && $articulo->salida > 0 && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";

	                                $str.="<a href='indexHerramientas_movimientos_actualizar.php?action=NEW_CON_ART&reg=0&mov=0&clave=$articulo->clave' class='btn btn-success btn-xs pull-center prestar' id_herramienta='".$articulo->id."' role='button' title='Prestar Articulo'>PRESTAR
	                                </a>";
	                            }
	                            else
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";
	                            }
	                            
	                       $str.="</p> 
	                      </div>
	                </div>
	            </div>";
	        }
		}
		else
		{
			$str.="<h4>NO SE ENCONTRARON ARTICULOS PARA ESTA CATEGORIA</h4>";
		}
		
		
    	
	}
	elseif($consulta == "PRODUCTOS_MARCA")
	{
	
    	$id_marca = $_REQUEST["id_marca"];

		$consulta = "SELECT herramientas_herramientas.*,
					(SELECT herramientas_movimientos.tipo_movimiento
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS tipo_movimiento,
					(SELECT herramientas_movimientos.fecha_entrega
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_entrega,
					(SELECT herramientas_movimientos.fecha_servicio
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_servicio,
					(SELECT herramientas_movimientos.descripcion_problema
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS descripcion_problema
				FROM herramientas_herramientas
				WHERE herramientas_herramientas.id_marca = $id_marca";

		$herramientas_herramientas = Herramientas_herramientas::getAllByQuery($consulta);
		if(count($herramientas_herramientas) > 0)
		{
			foreach ($herramientas_herramientas as $articulo) 
	        {
	            $str.="<div class='col-sm-2 col-md-3'>
	                <div class='thumbnail' style=' padding:0px!important'>
	                <span style='font-size:10px; background:#5C4283; color:white; float:left; padding:3px; border-radius:3px; width:60px; text-align: left; position:absolute; left:11px;'> $ ".$articulo->precio_unitario."</span>
	                  <img style='width:140; height:100px;'  src='content/".$articulo->archivo."' >
	                    <div class='caption' style='height:90px; padding: 3px 3px !important;'>
	                        <h5 style='margin-bottom:0px; margin-top:0px; text-align:left;'>".$articulo->clave."</h5>
	                        <p style='font-size:11px; text-align:left;'>".$articulo->descripcion."</p>
	                        <br>
	                        <p style='margin-bottom:15px !important; text-align:center; position:absolute; bottom:10px;'>";

	                            if( ($articulo->fecha_entrega > 0 && $articulo->salida > 0 && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";

	                                $str.="<a href='indexHerramientas_movimientos_actualizar.php?action=NEW_CON_ART&reg=0&mov=0&clave=$articulo->clave' class='btn btn-success btn-xs pull-center prestar' id_herramienta='".$articulo->id."' role='button' title='Prestar Articulo'>PRESTAR
	                                </a>";
	                            }
	                            else
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";
	                            }
	                            
	                       $str.="</p> 
	                      </div>
	                </div>
	            </div>";
	        }
		}
		else
		{
			$str.="<h4>NO SE ENCONTRARON ARTICULOS PARA ESTA MARCA</h4>";
		}
	}
	elseif($consulta == "ARTICULO")
	{
	
    	$clave = $_REQUEST["clave"];

		$consulta = "SELECT herramientas_herramientas.*,
					(SELECT herramientas_movimientos.tipo_movimiento
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS tipo_movimiento,
					(SELECT herramientas_movimientos.fecha_entrega
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_entrega,
					(SELECT herramientas_movimientos.fecha_servicio
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS fecha_servicio,
					(SELECT herramientas_movimientos.descripcion_problema
						FROM herramientas_movimientos 
							WHERE clave = herramientas_herramientas.clave
								ORDER BY herramientas_herramientas.clave 
									DESC LIMIT 1
					)  AS descripcion_problema
				FROM herramientas_herramientas
				WHERE herramientas_herramientas.clave = '$clave'";
				//echo $consulta;
		$herramientas_herramientas = Herramientas_herramientas::getAllByQuery($consulta);
		if(count($herramientas_herramientas) > 0)
		{
			foreach ($herramientas_herramientas as $articulo) 
	        {
	            $str.="<div class='col-sm-2 col-md-3'>
	                <div class='thumbnail' style=' padding:0px!important'>
	                <span style='font-size:10px; background:#5C4283; color:white; float:left; padding:3px; border-radius:3px; width:60px; text-align: left; position:absolute; left:11px;'> $ ".$articulo->precio_unitario."</span>
	                  <img style='width:140; height:100px;'  src='content/".$articulo->archivo."' >
	                    <div class='caption' style='height:90px; padding: 3px 3px !important;'>
	                        <h5 style='margin-bottom:0px; margin-top:0px; text-align:left;'>".$articulo->clave."</h5>
	                        <p style='font-size:11px; text-align:left;'>".$articulo->descripcion."</p>
	                        <br>
	                        <p style='margin-bottom:15px !important; text-align:center; position:absolute; bottom:10px;'>";

	                            if( ($articulo->fecha_entrega > 0 && $articulo->salida > 0 && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";

	                                $str.="<a href='indexHerramientas_movimientos_actualizar.php?action=NEW_CON_ART&reg=0&mov=0&clave=$articulo->clave' class='btn btn-success btn-xs pull-center prestar' id_herramienta='".$articulo->id."' role='button' title='Prestar Articulo'>PRESTAR
	                                </a>";
	                            }
	                            else
	                            {
	                            	$str.="<a href='indexherramientas_movimientos.php?clave=".$articulo->clave."' class='btn btn-warning btn-xs pull-center ' role='button' title='Ver préstamos'>HISTORIAL</a>";
	                            }
	                            
	                       $str.="</p> 
	                      </div>
	                </div>
	            </div>";
	        }
		}
		else
		{
			$str.="<h4>NO SE ENCONTRÓ EL ARTÍCULO</h4>";
		}
	}
	elseif($consulta == "ASOCIADO")
	{
		/*$codigo = $_REQUEST['codigo'];

		$datos = Zancos_lideres::getByNs($codigo);
		
    	if($datos->ns > 0)
    	{
			$str.=$datos->nombre;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}*/
    	$asociado = $_REQUEST["codigo"];

	    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$asociado;
	    $json_asociado = file_get_contents($direccion0);
	    $asociadoData = json_decode($json_asociado, true);

	    if(count($asociadoData) > 0)
	    {
	        $str=$asociadoData[0]['codigo']."&".$asociadoData[0]['nombre']."&".$asociadoData[0]['departamento']."&".$asociadoData[0]['puesto']."&".$asociadoData[0]['lider']."&".$asociadoData[0]['status'];
	    }
	    else
	    {
	      	$str="*NO ENCONTRADO*";
	    }
    	
	}
	elseif ($consulta == "WK") 
	{
		$fecha = $_REQUEST['fecha'];

		$datos = Disponibilidad_calendarios::getByDia($fecha);
		
    	if($datos[0]->semana > 0)
    	{
			$str=$datos[0]->semana;
    	}
    	else
    	{
    		$str="*NO ENCONTRADO*";
    	}
	}
	elseif ($consulta == "EXISTE_CLAVE") 
	{
		$clave = $_REQUEST['clave'];

		$datos = Herramientas_herramientas::buscaClave($clave);

		if(isset($datos[0]))
  		{
  			$str="SI";
  		}
  		else
  		{
  			$str="NO";
  		}
	}

	
}

else
{
	$str.="NO REQUEST";
}


echo $str;
?>
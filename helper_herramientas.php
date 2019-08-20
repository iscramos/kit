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
	                        	
	                        	if($articulo->activaStock == 1)
	                        	{
	                        		$str.= "<h5><a href='indexHerramientas_salidas.php' style='color: #337AB7;'>Ver artículos salida</a></h5>";
	                        	}
	                            else if( ($articulo->fecha_entrega && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
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

	                        	if($articulo->activaStock == 1)
	                        	{
	                        		$str.= "<h5><a href='indexHerramientas_salidas.php' style='color: #337AB7;'>Ver artículos salida</a></h5>";
	                        	}
	                            else if( ($articulo->fecha_entrega > 0 && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
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

	                        	if($articulo->activaStock == 1)
	                        	{
	                        		$str.= "<h5><a href='indexHerramientas_salidas.php' style='color: #337AB7;'>Ver artículos salida</a></h5>";
	                        	}
	                            else if( ($articulo->fecha_entrega > 0 && $articulo->descripcion_problema > 0) || $articulo->tipo_movimiento == null)
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
	elseif ($consulta == "IMAGEN") 
	{
		$clave = $_REQUEST['clave'];

		$datos = Herramientas_herramientas::buscaClave($clave);

		if(isset($datos[0]))
  		{
  			$str = "<img src='".$contentRead.$datos[0]->archivo."' width='100px' height='90px'>";
  		}
  		else
  		{
  			$str = "<img src='dist/img/no_disponible.png' width='100px' height='90px'>";
  		}
	}
	elseif ($consulta == "PIEZAS") 
	{
		// Open database connection
		$database2 = new Database();

		$sql = "SELECT clave FROM herramientas_herramientas WHERE activaStock = 1";
		$query = $database2->query($sql);
		$data = array();
		while($r = $query->fetch_row()){
			$data[] = $r[0];
		}

		// Close database connection
		$database2->close();

		$str = json_encode($data);
		//$str.='["item1","item2","item3"]';
	}
	elseif ($consulta == "VALIDA_STOCK") 
	{
		$codigo = $_REQUEST["codigo"];
		$clave = $_REQUEST["clave"];
		$cantidad_pedida = $_REQUEST["cantidad"];
		$cantidad_temporal = 0;
		$cantidad_stock = 0;

		$sql = "SELECT stock FROM herramientas_stock WHERE clave = '$clave' ";
		$data_stock = Herramientas_stock::getAllByQuery($sql);
		//ECHO $sql;
		

		if(count($data_stock) > 0)
		{
			$cantidad_stock = $data_stock[0]->stock;
			$q = "SELECT cantidad FROM herramientas_temporal WHERE codigo_asociado = $codigo AND clave = '$clave' ";
			//echo $q;
			$data_temporal = Herramientas_temporal::getAllByQuery($q);
			
			if(count($data_temporal) > 0)
			{
				$cantidad_temporal = $data_temporal[0]->cantidad;
			}

			if($cantidad_stock >= ($cantidad_pedida + $cantidad_temporal) )
			{

				$str = "SI";	
			}
			else
			{
				$str = "NO";	
			}
		} 
		else
		{
			$str = "NO";
		}
		
	}
	elseif ($consulta == "PIEZAS_DETALLES") 
	{
		// Open database connection
		$clave = $_REQUEST['clave'];

		$sql = "SELECT herramientas_herramientas.*, herramientas_udm.descripcion AS udm_descripcion
					FROM herramientas_herramientas
						INNER JOIN herramientas_udm ON herramientas_herramientas.id_udm = herramientas_udm.id
							WHERE herramientas_herramientas.clave = '$clave'
								AND herramientas_herramientas.activaStock = 1 ";
					
		$piezas = Herramientas_herramientas::getAllByQuery($sql);

		if (count($piezas) > 0) 
		{
			$str.="<div class='form-group'>
                        <label class='col-sm-4 control-label'>Descripción</label>
                        <div class='col-sm-8'>
                            
                            <input type='text' class='typeahead form-control input-sm' id='descripcion' name='descripcion' value='".$piezas[0]->descripcion."' readonly required='required'>
                        </div>
                    </div>";

            $str.="<div class='form-group'>
                        <label class='col-sm-4 control-label'>Unidad de medida</label>
                        <div class='col-sm-8'>
                            
                            <input type='text' class='form-control input-sm' id='udm' name='udm' value='".$piezas[0]->udm_descripcion."' readonly required='required'>
                        </div>
                    </div>";

            $str.="<div class='form-group'>
                        <label class='col-sm-4 control-label'>Cantidad</label>
                        <div class='col-sm-8'>
                            
                            <input type='text' class='form-control input-sm' id='cantidad' name='cantidad' value='' required='required' autocomplete='off'>
                        </div>
                    </div>";
		}
		else
		{
			$str = "<h5 style='text-align:center; '>PIEZA NO ENCONTRADA EN LA BD...</h5>";
		}
	}
	elseif ($consulta == "BUSQUEDA_POR_ASOCIADO") 
	{
		$ns = $_REQUEST['ns'];

		$consulta = "SELECT herramientas_movimientos.*, zancos_problemas.descripcion AS problema_descripcion
						FROM herramientas_movimientos
							LEFT JOIN zancos_problemas ON herramientas_movimientos.descripcion_problema = zancos_problemas.id
						WHERE herramientas_movimientos.ns_salida_lider = $ns
						ORDER BY herramientas_movimientos.id_registro DESC";
		$datos = Herramientas_movimientos::getAllByQuery($consulta);

		if(isset($datos[0]))
  		{
  			$str.="<h4>TRANSACCIONES</h4>";
  			$str.= "<table class='table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action'>";
  				$str.= "<thead>";
  					$str.= "<tr>";
  						$str.="<th style='text-align: center;'>Reg</th>";
                        $str.="<th>Clave</th>";
                        $str.="<th style='text-align: center;'>Gh</th>";
                        $str.="<th style='text-align: center;'>Fecha Act.<br> Baja</th>";
                        //$str.="<th style='text-align: center;'>Líder</th>";
                        $str.="<th style='text-align: center;'>Nombre</th>";
                        $str.="<th style='text-align: center;'>Fecha <br> Salida</th>";
                        $str.="<th style='text-align: center;'>WK <br> Salida</th>";
                        $str.="<th style='text-align: center;'>Desfase <br> (WK) </th>";
                        $str.="<th style='text-align: center;'>Fecha <br> Entrega</th>";
                        $str.="<th style='text-align: center;'>WK <br> Entrega</th>";
                        $str.="<th style='text-align: center;'>Fecha <br> Servicio</th>";
                        $str.="<th style='text-align: center;'>Problema</th>";
  					$str.= "</tr>";
  				$str.= "</thead>";
  				$str.= "<tbody>";
  					foreach ($datos as $m) 
  					{
  						$str.="<tr>";
	  						$str.="<td style='text-align: center; color:red;'>".$m->id_registro."</td>";
	                        $str.="<td style='text-align: right; border-right: 1px dashed;'>".$m->clave."</td>";
	                          
	                        $str.="<td style='text-align: center;'>".$m->gh."</td>";

	                        if($m->fecha_activacion_o_baja > 0)
	                        {
	                            $str.="<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_activacion_o_baja))."</td>";
	                        }
	                        else
	                        {
	                            $str.="<td style='text-align:center;'> - </td>";
	                        }
	                                                
	                        
	                        $str.="<td>".utf8_encode($m->nombre_lider_salida)."</td>";
	                        if($m->tipo_movimiento == 3) // salida
	                        {
	                            if($m->fecha_salida > 0)
	                            {
	                                $str.="<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_salida))."</td>";
	                                $str.="<td style='text-align:center;'>".$m->wk_salida."</td>";
	                            }
	                            else
	                            {
	                                $str.="<td style='text-align:center;'> - </td>";
	                                $str.="<td style='text-align:center;'> - </td>";
	                            }

	                            // aquí sacamos el desfase
	                            $fechaHoy = date_create(date("Y-m-d"));
	                            $f_salida = date_create($m->fecha_salida);

	                            
	                            if($m->fecha_entrega > 0 && $m->fecha_salida > 0)
	                            {
	                                $str.="<td style='text-align:center;'> - </td>";
	                            }
	                            else
	                            {
	                                $d_dias = date_diff($fechaHoy, $f_salida);
	                                $d_dias = $d_dias->format('%a');
	                                $semanas_limite = 0;/*$m->limite_semana;*/
	                                $semanas_convertidas = $d_dias / 7;
	                                $semanas_convertidas = round($semanas_convertidas, 2);
	                                
	                                if($semanas_convertidas > $semanas_limite)
	                                {
	                                    $diferencia_semanas = $semanas_convertidas - $semanas_limite;
	                                    $str.="<td class='invalid' style='text-align:center; background:#C9302C; color: white;'>".$diferencia_semanas."</td>";    
	                                }
	                                else
	                                {
	                                    $str.="<td style='text-align:center; '> - </td>";
	                                }

	                                
	                                
	                                
	                            }
	                            
	                            
	                            if($m->fecha_entrega > 0)
	                            {
	                                $str.="<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_entrega))."</td>";
	                                $str.="<td style='text-align:center;'>".$m->wk_entrega."</td>";
	                            }
	                            else
	                            {
	                                $str.="<td style='text-align:center;'> - </td>";
	                                $str.="<td style='text-align:center;'> - </td>";
	                            }
	                            

	                            if($m->fecha_servicio > 0)
	                            {
	                                $str.="<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_servicio))."</td>";
	                            }
	                            else
	                            {
	                                $str.="<td style='text-align:center;'> - </td>";
	                            }
	                            
	                            if($m->descripcion_problema > 0)
	                            {
	                                $str.="<td style='text-align:center;'>".$m->problema_descripcion."</td>";
	                            }
	                            else
	                            {
	                                $str.="<td style='text-align:center;'> - </td>";
	                            }
	                        }
	                    $str.="</tr>";
  					}
  				$str.= "</tbody>";
  			$str.= "</table>";
  		}
  		else
  		{
  			$str="*NO ENCONTRADO*";
  		}
	}
	elseif($consulta == "NUEVO")
	{
		$clave = $_REQUEST['clave'];
		$q = "SELECT * 
				FROM herramientas_herramientas
				WHERE clave = '$clave'";

		$bd = herramientas_herramientas::getAllByQuery($q);

    	if(count($bd) > 0) // ultimo movimiento de nuestro zanco
    	{
    		$consulta = "SELECT m.*, herramientas_herramientas.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion

			FROM herramientas_movimientos m
			INNER JOIN
			(
			    SELECT max(id_registro) reg, clave
			    FROM herramientas_movimientos
			    GROUP BY clave
			) m2
			  ON m.clave = m2.clave
			  INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
			  INNER JOIN herramientas_herramientas ON m.clave = herramientas_herramientas.clave
			  AND m.id_registro = m2.reg
			  AND m.clave = '$clave'
			  ORDER BY m.clave DESC
			  LIMIT 1";
				//echo $consulta;

			$herramientas_movimientos = Herramientas_movimientos::getAllByQuery($consulta);
			$herramientas_acciones = Zancos_acciones::getAllByOrden("accion", "ASC");
			$herramientas_ghs = Zancos_ghs::getAllByOrden("gh", "ASC");
			$herramientas_problemas = Zancos_problemas::getAllByOrden("descripcion", "ASC");
			
			if(count($herramientas_movimientos) > 0)
			{

				if( ($herramientas_movimientos[0]->fecha_entrega > 0 && $herramientas_movimientos[0]->descripcion_problema > 0) || $herramientas_movimientos[0]->tipo_movimiento == null)
	            {

	            	$movimiento_max = Herramientas_movimientos::getAllLastInsert();
					$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;

	            	$str.="<div style='text-align: center;'>";    
                                        
	                    $str.="<div class='row'>
			                        <div class='form-group col-sm-12' >
			                            <label style='font-size: large; text-align: right;'>No de registro: <b style='color: orangered;'>".$registro_autoincrementa."</b></label>
			                            <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='' autocomplete=''  readonly='true'>
			                        </div>
			                    </div>
			                    <div class='row'>

			                    	<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
			                            <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
			                                <h6 style='color: #F3D93A;' id='departamento'></h6>
			                                <h6 style='color: #F3D93A;' id='puesto'></h6>
			                                <h6 style='color: #F3D93A;' id='estatus'></h6>
			                                <h6 style='color: #F3D93A;' id='lider'></h6>
			                            </div>

			                            <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>
										<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>
			                            
			                            
			                            
			                        </div>
			                    </div>";

				        $str.="<div class='row'>
		                            <div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='number' class='form-control' name='tamano' id='tamano' value='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='' autocomplete='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4 hidden'>   
		                                <label >Límite semanal</label>
		                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='' autocomplete='' readonly='true'>
		                            </div> 
		                            <div class='form-group col-sm-4'>
		                                <label >Tipo de movimiento</label>
		                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
		                                    
		                                    
		                                        foreach ($herramientas_acciones as $a) 
                                                {
                                                    if($a->id == 3)
                                                    {
                                                        $str.="<option value='".$a->id."' style='display:none;'>".$a->accion."</option>";
                                                    }
                                                }
		                                    
		                                $str.="</select>
		                            </div> 
		                            <div class='form-group col-sm-4'>
			                            <label >Invernadero</label>
			                            <select class='form-control' name='gh' id='gh' required='required'>
			                                <option value='' style='display: none;'>Seleccione</option>";
			                                
			                                    foreach ($herramientas_ghs as $g) 
                                                {
                                                    $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
                                                }
			                                
			                          	$str.="</select>
			                        </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Zona</label>
			                            <input type='text' class='form-control' name='zona' id='zona' value='' autocomplete='' required='required' readonly='true'>
			                        </div>
		                        </div>";

		                $str.="<div class='row hidden'>
			                        
			                        
			                        <div class='form-group col-sm-4'>
			                            <label >Fecha activación / baja</label>
			                            <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' readonly='true' autocomplete='off'>
			                        </div>
			                    </div>";

			            $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Código asociado</label>
	                                    <div class='input-group ' style='margin-bottom: 0px;'>
	                                        <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
	                                        <span class='input-group-btn'>
	                                            <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar asociado'> <span class='glyphicon glyphicon-search'></span> </button>
	                                        </span>
	                                    </div>
	                                </div>

	                                <div class='form-group col-sm-4'>
	                                    <label >Nombre asociado</label>
	                                    <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
	                                </div>";

	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha salida</label>
	                                        <div class='input-group date' id='datetimepicker2'>
	                                            <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' required>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana salida</label>
	                                    <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='' autocomplete='' required readonly='true'>
	                                </div>";

	                                    
				                    $str.="<div class='form-group col-sm-4'>
			                                    <label >Semanas desfase</label>
			                                    <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
			                                </div>";
                        

	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha entrega</label>
	                                        <div class='input-group date' id='datetimepicker3'>
	                                            <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana entrega</label>
	                                    <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='' autocomplete='' required readonly='true'>
	                                </div>

	                                <div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha servicio</label>
	                                        <div class='input-group date' id='datetimepicker4'>
	                                            <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                                
	                                
	                                <div class='form-group col-sm-4'>
	                                    <label >Problema</label>
	                                    <select class='form-control' name='descripcion_problema' id='descripcion_problema'>
	                                    	<option value='' style='display: none;' >Seleccione</option>";
	                                        
	                                            foreach ($herramientas_problemas as $p) 
                                                {
                                                    $str.="<option value='".$p->id."'>".$p->descripcion."</option>";  
                                                } 
	                                        
	                                  	$str.="</select>
	                                </div>
	                            </div>"; 
	                $str.="</div>";
	            }
	            else
	            {
	            	$str.="<div style='text-align: center;'>";    
                                        
	                    $str.="<div class='row'>
			                        <div class='form-group col-sm-12' >
			                            <label style='font-size: large; text-align: right;'>No de registro: <b style='color: orangered;'>".$herramientas_movimientos[0]->id_registro."</b></label>
			                            <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='".$herramientas_movimientos[0]->id_registro."' autocomplete=''  readonly='true'>
			                        </div>
			                    </div>
			                    <div class='row'>";

			                        
			                            $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$herramientas_movimientos[0]->ns_salida_lider;
			                            $json_asociado = file_get_contents($direccion0);
			                            $asociadoData = json_decode($json_asociado, true);

			                            $a_departamento = null;
			                            $a_puesto = null;
			                            $a_estatus = null;
			                            $a_lider = null;

			                            if(count($asociadoData) > 0)
			                            {
			                                $a_departamento = "Departamento: ".$asociadoData[0]['departamento'];
			                                $a_puesto = "Puesto: ".$asociadoData[0]['puesto'];
			                                $a_estatus = "Estatus:".$asociadoData[0]['status'];
			                                $a_lider = "Líder: ".$asociadoData[0]['lider'];
			                            }
			                       
			                       
			                    $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
			                            <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
			                                <h6 style='color: #F3D93A;' id='departamento'>".$a_departamento."</h6>
			                                <h6 style='color: #F3D93A;' id='puesto'>".$a_puesto."</h6>
			                                <h6 style='color: #F3D93A;' id='estatus'>".$a_estatus."</h6>
			                                <h6 style='color: #F3D93A;' id='lider'>".$a_lider."</h6>
			                            </div>";

			                            $str.="<label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";

			                            
			                                if(isset($herramientas_movimientos[0]->ns_salida_lider) > 0)
			                                {
			                                    
			                                    $str.="<img  class='imagenPerfil img-circle' src='../col2/ch/perfils/".$herramientas_movimientos[0]->ns_salida_lider.".jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
			                                }
			                                else
			                                {
			                                    $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
			                                }
			                            
			                            
			                            
			                        $str.="</div>
			                    </div>";

				        $str.="<div class='row'>
		                            <div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='number' class='form-control' name='tamano' id='tamano' value='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4 '>   
		                                <label >Tamaño</label>
		                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='' autocomplete='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Límite semanal</label>
		                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='' autocomplete='' readonly='true'>
		                            </div> 
		                            <div class='form-group col-sm-4'>
		                                <label >Tipo de movimiento</label>
		                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
		                                    
		                                    
		                                        foreach ($herramientas_acciones as $a) 
		                                        {
		                                            if($a->id == $herramientas_movimientos[0]->tipo_movimiento)
		                                            {
		                                                $str.="<option value='".$a->id."' style='display:none;'>".$a->accion."</option>";
		                                            }
		                                        }
		                                    
		                                $str.="</select>
		                            </div> 
		                        </div>";

		                $str.="<div class='row'>
			                        <div class='form-group col-sm-4'>
			                            <label >Invernadero</label>
			                            <select class='form-control' name='gh' id='gh' required='required'>
			                                <option value='".$herramientas_movimientos[0]->gh."' style='display: none;'>".$herramientas_movimientos[0]->gh."</option>";
			                                
			                                    foreach ($herramientas_ghs as $g) 
			                                    {
			                                        $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
			                                    } 
			                                
			                          	$str.="</select>
			                        </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Zona</label>
			                            <input type='text' class='form-control' name='zona' id='zona' value='".$herramientas_movimientos[0]->zona."' autocomplete='' required='required' readonly='true'>
			                        </div>
			                        
			                        <div class='form-group col-sm-4'>
			                            <label >Fecha activación / baja</label>
			                            <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' readonly='true' autocomplete='off'>
			                        </div>
			                    </div>";

			            $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Código asociado</label>
	                                    <div class='input-group ' style='margin-bottom: 0px;'>
	                                        <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='".$herramientas_movimientos[0]->ns_salida_lider."' required='required'>
	                                        <span class='input-group-btn'>
	                                            <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar asociado'> <span class='glyphicon glyphicon-search'></span> </button>
	                                        </span>
	                                    </div>
	                                </div>

	                                <div class='form-group col-sm-4'>
	                                    <label >Nombre asociado</label>
	                                    <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='".$herramientas_movimientos[0]->nombre_lider_salida."' autocomplete='' required readonly='true'>
	                                </div>";

	                                
	                                    $f_salida = null;
	                                    $w_salida = null;

	                                    $f_entrega = null;
	                                    $w_entrega = null;

	                                    $f_servicio = null;

	                                    if($herramientas_movimientos[0]->fecha_salida > 0)
	                                    {
	                                       $f_salida = $herramientas_movimientos[0]->fecha_salida;
	                                       $w_salida = $herramientas_movimientos[0]->wk_salida;
	                                    }

	                                    if($herramientas_movimientos[0]->fecha_entrega > 0)
	                                    {
	                                       $f_entrega = $herramientas_movimientos[0]->fecha_entrega;
	                                       $w_entrega = $herramientas_movimientos[0]->wk_entrega;
	                                    }

	                                    if($herramientas_movimientos[0]->fecha_servicio > 0)
	                                    {
	                                       $f_servicio = $herramientas_movimientos[0]->fecha_servicio;
	                                    }
	                                
	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha salida</label>
	                                        <div class='input-group date' id='datetimepicker2'>
	                                            <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='".$f_salida."' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana salida</label>
	                                    <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='".$w_salida."' autocomplete='' required readonly='true'>
	                                </div>";

	                                    if($herramientas_movimientos[0]->fecha_entrega > 0 && $herramientas_movimientos[0]->fecha_salida > 0)
	                                    {

	                                        $str.="<div class='form-group col-sm-4'>
	                                                <label >Semanas desfase</label>
	                                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
	                                            </div>";
	                                    }
	                                    else
	                                    {
	                                        // aquí sacamos el desfase
	                                        $fechaHoy = date_create(date("Y-m-d"));
	                                        $f_salida = date_create($herramientas_movimientos[0]->fecha_salida);

	                                        $d_dias = date_diff($fechaHoy, $f_salida);
	                                        $d_dias = $d_dias->format('%a');
	                                        $semanas_limite = 0;/*$herramientas_movimientos[0]->limite_semana;*/
	                                        $semanas_convertidas = $d_dias / 7;
	                                        $semanas_convertidas = round($semanas_convertidas, 2);
	                                        
	                                        if($semanas_convertidas > $semanas_limite)
	                                        {
	                                            $diferencia_semanas = $semanas_convertidas - $semanas_limite;
	                                            

	                                            $str.="<div class='form-group col-sm-4'>
	                                                <label >Semanas desfase</label>
	                                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='".$diferencia_semanas."' autocomplete='' required readonly='true'>
	                                            </div>";   
	                                        }
	                                        else
	                                        {
	                                            $str.="<div class='form-group col-sm-4'>
	                                                <label >Semanas desfase</label>
	                                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
	                                            </div>";
	                                        }
	                                        
	                                    }
	                                

	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha entrega</label>
	                                        <div class='input-group date' id='datetimepicker3'>
	                                            <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='".$f_entrega."' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana entrega</label>
	                                    <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='".$w_entrega."' autocomplete='' required readonly='true'>
	                                </div>

	                                <div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha servicio</label>
	                                        <div class='input-group date' id='datetimepicker4'>
	                                            <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='".$f_servicio."' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                                
	                                
	                                <div class='form-group col-sm-4'>
	                                    <label >Problema</label>
	                                    <select class='form-control' name='descripcion_problema' id='descripcion_problema'>";
	                                        
	                                        
	                                            if($herramientas_movimientos[0]->descripcion_problema <= 0)
	                                            {
	                                                $str.="<option value='' style='display: none;' >Seleccione</option>";
	                                            }
	                                            foreach ($herramientas_problemas as $p) 
	                                            {
	                                                if($herramientas_movimientos[0]->descripcion_problema == $p->id )
	                                                {
	                                                    $str.="<option value='".$herramientas_movimientos[0]->descripcion_problema."' style='display: none;' selected='selected'>$p->descripcion</option>";
	                                                }
	                                                
	                                                $str.="<option value='".$p->id."'>".$p->descripcion."</option>";
	                                            } 
	                                        
	                                  	$str.="</select>
	                                </div>
	                            </div>"; 
	                $str.="</div>";
	            }
				       
				
			}
			else
			{
				$movimiento_max = Herramientas_movimientos::getAllLastInsert();
					$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;

	            	$str.="<div style='text-align: center;'>";    
                                        
	                    $str.="<div class='row'>
			                        <div class='form-group col-sm-12' >
			                            <label style='font-size: large; text-align: right;'>No de registro: <b style='color: orangered;'>".$registro_autoincrementa."</b></label>
			                            <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='' autocomplete=''  readonly='true'>
			                        </div>
			                    </div>
			                    <div class='row'>

			                    	<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
			                            <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
			                                <h6 style='color: #F3D93A;' id='departamento'></h6>
			                                <h6 style='color: #F3D93A;' id='puesto'></h6>
			                                <h6 style='color: #F3D93A;' id='estatus'></h6>
			                                <h6 style='color: #F3D93A;' id='lider'></h6>
			                            </div>

			                            <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>
										<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>
			                            
			                            
			                            
			                        </div>
			                    </div>";

				        $str.="<div class='row'>
		                            <div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='number' class='form-control' name='tamano' id='tamano' value='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4 '>   
		                                <label >Tamaño</label>
		                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='' autocomplete='' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Límite semanal</label>
		                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='' autocomplete='' readonly='true'>
		                            </div> 
		                            <div class='form-group col-sm-4'>
		                                <label >Tipo de movimiento</label>
		                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
		                                    
		                                    
		                                        foreach ($herramientas_acciones as $a) 
                                                {
                                                    if($a->id == 3)
                                                    {
                                                        $str.="<option value='".$a->id."' style='display:none;'>".$a->accion."</option>";
                                                    }
                                                }
		                                    
		                                $str.="</select>
		                            </div> 
		                        </div>";

		                $str.="<div class='row'>
			                        <div class='form-group col-sm-4'>
			                            <label >Invernadero</label>
			                            <select class='form-control' name='gh' id='gh' required='required'>
			                                <option value='' style='display: none;'>Seleccione</option>";
			                                
			                                    foreach ($herramientas_ghs as $g) 
                                                {
                                                    $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
                                                }
			                                
			                          	$str.="</select>
			                        </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Zona</label>
			                            <input type='text' class='form-control' name='zona' id='zona' value='' autocomplete='' required='required' readonly='true'>
			                        </div>
			                        
			                        <div class='form-group col-sm-4'>
			                            <label >Fecha activación / baja</label>
			                            <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' readonly='true' autocomplete='off'>
			                        </div>
			                    </div>";

			            $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Código asociado</label>
	                                    <div class='input-group ' style='margin-bottom: 0px;'>
	                                        <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
	                                        <span class='input-group-btn'>
	                                            <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar asociado'> <span class='glyphicon glyphicon-search'></span> </button>
	                                        </span>
	                                    </div>
	                                </div>

	                                <div class='form-group col-sm-4'>
	                                    <label >Nombre asociado</label>
	                                    <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
	                                </div>";

	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha salida</label>
	                                        <div class='input-group date' id='datetimepicker2'>
	                                            <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' required>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana salida</label>
	                                    <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='' autocomplete='' required readonly='true'>
	                                </div>";

	                                    
				                    $str.="<div class='form-group col-sm-4'>
			                                    <label >Semanas desfase</label>
			                                    <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
			                                </div>";
                        

	                                $str.="<div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha entrega</label>
	                                        <div class='input-group date' id='datetimepicker3'>
	                                            <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>";

	                    $str.="<div class='row'>
	                                <div class='form-group col-sm-4'>
	                                    <label >Semana entrega</label>
	                                    <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='' autocomplete='' required readonly='true'>
	                                </div>

	                                <div class='form-group'>
	                                    <div class='col-sm-4'>
	                                        <label >Fecha servicio</label>
	                                        <div class='input-group date' id='datetimepicker4'>
	                                            <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off'>
	                                            <span class='input-group-addon'>
	                                                <span class='glyphicon glyphicon-calendar'></span>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
	                                
	                                
	                                <div class='form-group col-sm-4'>
	                                    <label >Problema</label>
	                                    <select class='form-control' name='descripcion_problema' id='descripcion_problema'>
	                                    	<option value='' style='display: none;' >Seleccione</option>";
	                                        
	                                            foreach ($herramientas_problemas as $p) 
                                                {
                                                    $str.="<option value='".$p->id."'>".$p->descripcion."</option>";  
                                                } 
	                                        
	                                  	$str.="</select>
	                                </div>
	                            </div>"; 
	                $str.="</div>";
			}

			$str.="<script type='text/javascript'>

	            function creaAjax()
	            {
	                var objetoAjax=false;
	                try {
	                    /*Para navegadores distintos a internet explorer*/
	                    objetoAjax = new ActiveXObject('Msxml2.XMLHTTP');
	                } catch (e)
	                {
	                    try {
	                        /*Para explorer*/
	                        objetoAjax = new ActiveXObject('Microsoft.XMLHTTP');
	                    } catch (E) {
	                        objetoAjax = false;
	                        }
	                    }
	                if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
	                    objetoAjax = new XMLHttpRequest();
	                }
	                return objetoAjax;
	            }

	            $(document).ready(function()
	            {

	                $('#gh').on('change', function(event) 
	                {
	                    var zona = null;
	                        zona = $('option:selected', this).attr('valorZona');
	                        $('#zona').val(zona);
	                });

	                $('#buscar_asociado').on('click', function()
	                {   
	                    var ns_salida_lider = null;
	                        ns_salida_lider = $('#ns_salida_lider').val();
	                        
	                    
	                    if (ns_salida_lider > 0) 
	                    {
	                        $('.imagenPerfil').attr('src', 'dist/img/load_2019.gif');
	                        var ajax=creaAjax();

	                        ajax.open('GET', 'helper_herramientas.php?consulta=ASOCIADO&codigo='+ns_salida_lider, true);
	                        ajax.onreadystatechange=function() 
	                        { 
	                            if (ajax.readyState==1)
	                            {
	                              // Mientras carga ponemos un letrerito que dice Verificando...
	                              DestinoMsg.innerHTML='Verificando...';
	                            }
	                            if (ajax.readyState==4)
	                            {
	                                // Cuando ya terminó, ponemos el resultado
	                                var str = ajax.responseText;
	                                var n = str.split('&');
	                                    
	                                var nombre = n[1];
	                                var departamento = n[2];
	                                var puesto = n[3];
	                                var lider = n[4];
	                                var estatus = n[5];
	                               
	                              
	                                if(str == '*NO ENCONTRADO*')
	                                {
	                                    $('#nombre_lider_salida').val(null);
	                                    $('#ns_salida_lider').val(null);
	                                    $('.imagenPerfil').attr('src', 'dist/img/avatar.jpg');
	                                    $('#departamento').text('Departamento: ');
	                                    $('#puesto').text('Puesto: ');
	                                    $('#lider').text('Líder: ');
	                                    $('#estatus').text('Estatus: ');
	                                    alert('Asociado no encontrado...');
	                                }
	                                else
	                                {
	                                    $('#nombre_lider_salida').val(nombre);
	                                    $('.imagenPerfil').attr('src', '../col2/ch/perfils/'+ns_salida_lider+'.jpg');
	                                    $('#departamento').text('Departamento: '+departamento);
	                                    $('#puesto').text('Puesto: '+puesto);
	                                    $('#lider').text('Líder: '+lider);
	                                    $('#estatus').text('Estatus: '+estatus);
	                                    
	                                }         
	                              
	                            } 
	                        }
	                        ajax.send(null);
	                        return false;
	                    }
	                    else
	                    {
	                        return false;
	                    }
	                    
	                });


	                $('#ns_salida_lider').keypress(function(event)
	                {   
	                    if (event.which == 13) 
	                    {
	                        return false;
	                    }
	                    
	                });


	                $('#datetimepicker2').on('change', function() 
	                {
	                    var consulta = 'WK';
	                    var fecha_salida = null;
	                        fecha_salida = $('#fecha_salida').val();
	                    
	                    $.get('helper_herramientas.php', {consulta:consulta, fecha:fecha_salida} ,function(data)
	                    { 
	                        $('#wk_salida').val(data);
	                    });

	                    var tiempo_limite = $('#tiempo_limite').val();
	                    var day = $('#fechaActual').text();
	                    var diferencia =  Math.floor(( Date.parse(day) - Date.parse(fecha_salida) ) / (1000 * 60 * 60 * 24));
	                          
	                    var semanitas = (diferencia / 7);
	                    var desfase = 0.0; 
	                    if(tiempo_limite < semanitas)
	                    {
	                        desfase = (semanitas - tiempo_limite).toFixed(1);
	                    }

	                    $('#wk_desfase').val(desfase);
	                });

	                $('#datetimepicker3').on('change', function() 
	                {
	                    var consulta = 'WK';
	                    var fecha_salida = null;
	                        fecha_salida = $('#fecha_entrega').val();
	                    
	                    $.get('helper_herramientas.php', {consulta:consulta, fecha:fecha_salida} ,function(data)
	                    {
	                        
	                        $('#wk_entrega').val(data);
	                    });
	                });

	                $(function () 
	                {
	                    $('#datetimepicker1').datetimepicker({
	                        format: 'YYYY-MM-DD',
	                        pickTime: false,
	                        autoclose: true,

	                    });

	                    $('#datetimepicker2').datetimepicker({
	                        format: 'YYYY-MM-DD',
	                        pickTime: false,
	                        autoclose: true,

	                    });

	                    $('#datetimepicker3').datetimepicker({
	                        format: 'YYYY-MM-DD',
	                        pickTime: false,
	                        autoclose: true,

	                    });

	                    $('#datetimepicker4').datetimepicker({
	                        format: 'YYYY-MM-DD',
	                        pickTime: false,
	                        autoclose: true,

	                    });
	                });


	            }); // end ready
	        </script>";
		
    	}
    	else
    	{
    		$str="*NO ENCONTRADO*";
    	}
	}

	
}

else
{
	$str.="NO REQUEST";
}


echo $str;
?>
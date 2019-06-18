<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 9) ) // para zancos
{	
	//$mes = $_GET['mes'];
	$consulta = $_REQUEST['consulta'];
	
	if($consulta == "NUEVO")
	{
		$no_zanco = $_REQUEST['no_zanco'];
		$q = "SELECT zancos_bd.*, zancos_tamanos.tamano as tamano_descripcion, zancos_tamanos.limite_semana as limite_semana 
				FROM zancos_bd
				INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
				WHERE zancos_bd.no_zanco = $no_zanco";

		$bd = Zancos_bd::getAllByQuery($q);

    	if(count($bd) > 0) // ultimo movimiento de nuestro zanco
    	{
    		$q = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana, zancos_bd.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion,
				(SELECT zancos_movimientos.fecha_activacion_o_baja 
				 		FROM zancos_movimientos
				 		WHERE zancos_movimientos.tipo_movimiento = 1
				 		AND zancos_movimientos.no_zanco = m.no_zanco
				 ) AS f_activacion,
				 (SELECT zancos_movimientos.id_registro
				 		FROM zancos_movimientos
				 		WHERE zancos_movimientos.tipo_movimiento = 1
				 		AND zancos_movimientos.no_zanco = m.no_zanco

			  
				 ) AS id_reg_activacion

			FROM zancos_movimientos m
			INNER JOIN
			(
			    SELECT max(id_registro) reg, no_zanco
			    FROM zancos_movimientos
			    GROUP BY no_zanco
			) m2
			  ON m.no_zanco = m2.no_zanco
			  INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
			  INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
			  INNER JOIN zancos_bd ON m.no_zanco = zancos_bd.no_zanco
			  AND m.id_registro = m2.reg
			  AND m.no_zanco = $no_zanco
			  ORDER BY m.no_zanco DESC
			  LIMIT 1";
			
			$movimientos = Zancos_movimientos::getAllByQuery($q);
			$zancos_acciones = Zancos_acciones::getAllByOrden("accion", "ASC");
			$zancos_ghs = Zancos_ghs::getAllByOrden("gh", "ASC");
			//$zancos_lideres = Zancos_lideres::getAllByOrden("ns", "ASC");
			$zancos_problemas = Zancos_problemas::getAllByOrden("descripcion", "ASC");

			if(count($movimientos) > 0) // ultimo movimiento de nuestro zanco
    		{
    			if ($movimientos[0]->tipo_movimiento == 1) // PARA CUANDO ESTA EN ACTIVACION Y LO PODEMOS DISPONER O DAR DE BAJA
    			{
    				$q = "SELECT zancos_bd.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana
    					FROM zancos_bd
    						INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
    						WHERE zancos_bd.no_zanco = $no_zanco";
    			
	    			$zancos = Zancos_bd::getAllByQuery($q);

	    			// HEAD + REGISTRO

    					$movimiento_max = Zancos_movimientos::getAllLastInsert();

						if(count($movimiento_max) > 0)
						{
							$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;
						}

						$str.="<div class='form-group col-sm-12'>
                                    <label style='font-size: large'>No de registro: <b style='color: orangered;'>".$registro_autoincrementa."</b></label>
                                    <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='' autocomplete='' readonly='true'>
                                </div>";

                        $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
                                    <h6 style='color: #F3D93A;' id='departamento'></h6>
                                    <h6 style='color: #F3D93A;' id='puesto'></h6>
                                    <h6 style='color: #F3D93A;' id='estatus'></h6>
                                    <h6 style='color: #F3D93A;' id='lider'></h6>
                                </div>

                                <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";
                                $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                    
                                
                        $str.="</div>";

                        // FIN DEL HEAD + REGISTRO
	    			$str.="<div class='row'>
	    						<div class='form-group col-sm-4 hidden'>   
	                                <label >Tamaño</label>
	                                <input type='number' class='form-control' name='tamano' id='tamano' value='".$zancos[0]->tamano."' autocomplete='' required='required' readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>   
	                                <label >Tamaño</label>
	                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='".$zancos[0]->tamano_descripcion."' required='required' readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>   
	                                <label >Límite semanal</label>
	                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='".$zancos[0]->limite_semana."' required='required' readonly='true'>
	                            </div>   
	                        
	                            <div class='form-group col-sm-4'>
	                                <label >Tipo de movimiento</label>
	                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' >
	                                	<option value='' style='display:none;'>Seleccione</option>";
	                                
	                                    foreach ($zancos_acciones as $a) 
	                                    {
	                                    	if($a->id != 1)
	                                    	{
	                                    		$str.="<option value='".$a->id."'>".$a->accion."</option>";
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
	                                    
	                                        foreach ($zancos_ghs as $g) 
	                                        {
	                                            $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
	                                        } 
	                                   
	                              $str.="</select>
	                            </div>

	                            <div class='form-group col-sm-4'>
	                                <label >Zona</label>
	                                <input type='text' class='form-control' name='zona' id='zona' value=''  required='required' readonly='true'>
	                            </div>

	                            <div class='form-group'>
	                                <div class='col-sm-4'>
	                                    <label >Fecha activación / baja</label>
	                                    <div class='input-group date' id='datetimepicker1' style='pointer-events: none;'>
	                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' autocomplete='off' readonly='true'>
	                                        <span class='input-group-addon'>
	                                            <span class='glyphicon glyphicon-calendar'></span>
	                                        </span>
	                                    </div>
	                                </div>
	                            </div>
	                	</div>";

	                $str.="<div class='row'>
	                			<div class='form-group col-sm-4'>
	                                <label >Código asociado</label>
	                				<div class='input-group' style='margin-bottom: 0px;'>
		                                <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
		                                <span class='input-group-btn'>
		                                    <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
		                                </span>
		                            </div>
		                        </div>

		                        <div class='form-group col-sm-4'>
		                            <label >Nombre asociado</label>
		                            <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
		                        </div>


	                            <div class='form-group'>
	                            	<div class='col-sm-4'>
	                                	<label >Fecha salida</label>
	                                	<div class='input-group date' id='datetimepicker2' style='pointer-events-none;'>
	                                		<input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' readonly='true'>
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
	                            </div>

	                            <div class='form-group col-sm-4'>
	                                <label >Semanas desfase</label>
	                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
	                            </div>

	                            <div class='form-group'>
	                            	<div class='col-sm-4'>
	                                	<label >Fecha entrega</label>
	                                	<div class='input-group date' id='datetimepicker3' style='pointer-events: none;'>
	                                		<input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off' readonly='true'>
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
		                            	<div class='input-group date' id='datetimepicker4' style='pointer-events: none;'>
		                            		<input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off' readonly='true'>
		                            		<span class='input-group-addon'>
	                                            <span class='glyphicon glyphicon-calendar'></span>
	                                        </span>
		                            	</div>
		                            </div>
	                            </div>

		                        <div class='form-group col-sm-4'>
		                            <label >Problema</label>
		                            <select class='form-control' name='descripcion_problema' id='descripcion_problema' readonly='true' style='pointer-events: none;'>
		                                <option value='' style='display: none;' >Seleccione</option>";
		                                foreach ($zancos_problemas as $p) 
                                        {
                                            $str.="<option value='".$p->id."'>".$p->descripcion."</option>";  
                                        } 
		                          $str.="</select>
		                        </div>
	                	</div>";
    			}
    			else if($movimientos[0]->tipo_movimiento == 2) // PARA CUANDO EL ZANCO YA ESTA DADO DE BAJA
    			{
    				// HEAD + REGISTRO

				    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$movimientos[0]->ns_salida_lider;
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

					$str.="<div class='form-group col-sm-12'>
                                <label style='font-size: large'>No de registro: <b style='color: orange;'>".$movimientos[0]->id_registro."</b></label>
                                <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='".$movimientos[0]->id_registro."' autocomplete='' required='required' readonly='true'>
                            </div>";

                    $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                            <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
                                <h6 style='color: #F3D93A;' id='departamento'>".$a_departamento."</h6>
                                <h6 style='color: #F3D93A;' id='puesto'>".$a_puesto."</h6>
                                <h6 style='color: #F3D93A;' id='estatus'>".$a_estatus."</h6>
                                <h6 style='color: #F3D93A;' id='lider'>".$a_lider."</h6>
                            </div>

                            <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";
                            
                                if(isset($movimientos[0]->ns_salida_lider) > 0)
                                {
                                    
                                    $str.="<img  class='imagenPerfil img-circle' src='../col2/ch/perfils/".$movimientos[0]->ns_salida_lider.".jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                }
                                else
                                {
                                    $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                }
                            
                    $str.="</div>";

                    // FIN DEL HEAD + REGISTRO



	    			$str.="<div class='row'>
	    						<div class='form-group col-sm-4 hidden'>   
	                                <label >Tamaño</label>
	                                <input type='number' class='form-control' name='tamano' id='tamano' value='".$movimientos[0]->tamano."' autocomplete='' required='required' readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>   
	                                <label >Tamaño</label>
	                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='".$movimientos[0]->tamano_descripcion."' required='required' readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>   
	                                <label >Límite semanal</label>
	                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='".$movimientos[0]->limite_semana."' required='required' readonly='true'>
	                            </div>   
	                        
	                            <div class='form-group col-sm-4'>
	                                <label >Tipo de movimiento</label>
	                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
	                                
	                                    foreach ($zancos_acciones as $a) 
	                                    {
	                                    	if($a->id == 2)
	                                    	{
	                                    		$str.="<option value='".$a->id."'>".$a->accion."</option>";
	                                    	}
	                                        
	                                        
	                                    } 
	                               
	                           $str.="</select>
	                            </div>
	                    </div>";

	                $str.="<div class='row'>
		                			<div class='form-group col-sm-4'>
		                                <label >Invernadero</label>
		                                <select class='form-control' name='gh' id='gh' required='required'>
		                                    <option value='".$movimientos[0]->gh."' style='display: none;'>".$movimientos[0]->gh."</option>";

		                                        foreach ($zancos_ghs as $g) 
		                                        {
		                                            $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
		                                        } 
		                                   
		                              $str.="</select>
		                            </div>

		                            <div class='form-group col-sm-4'>
		                                <label >Zona</label>
		                                <input type='text' class='form-control' name='zona' id='zona' value='".$movimientos[0]->zona."'  required='required' readonly='true'>
		                            </div>

		                            <div class='form-group'>
		                                <div class='col-sm-4'>
		                                    <label >Fecha activación / baja</label>
		                                    <div class='input-group date' id='datetimepicker1' style='pointer-events: none;'>
		                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='".$movimientos[0]->fecha_activacion_o_baja."' autocomplete='off' readonly='true' required='required'>
		                                        <span class='input-group-addon'>
		                                            <span class='glyphicon glyphicon-calendar'></span>
		                                        </span>
		                                    </div>
		                                </div>
		                            </div>
		                	</div>";

	                $str.="<div class='row'>
	                			<div class='form-group col-sm-4'>
	                                <label >Código asociado</label>
	                				<div class='input-group' style='margin-bottom: 0px;'>
		                                <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='".$movimientos[0]->ns_salida_lider."' required='required'>
		                                <span class='input-group-btn'>
		                                    <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
		                                </span>
		                            </div>
		                        </div>

		                        <div class='form-group col-sm-4'>
		                            <label >Nombre asociado</label>
		                            <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='".$movimientos[0]->nombre_lider_salida."' autocomplete='' required readonly='true'>
		                        </div>


	                            <div class='form-group col-sm-4'>
	                                <label >Fecha salida</label>
	                                <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' readonly='true'>
	                            </div>
	                	</div>";

	                $str.="<div class='row'>
	                			<div class='form-group col-sm-4'>
	                                <label >Semana salida</label>
	                                <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='' autocomplete='' required readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>
	                                <label >Semanas desfase</label>
	                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
	                            </div>

	                            <div class='form-group col-sm-4'>
	                                <label >Fecha entrega</label>
	                                <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off' readonly='true'>
	                            </div>
	                	</div>";

	                $str.="<div class='row'>
		                		<div class='form-group col-sm-4'>
		                            <label >Semana entrega</label>
		                            <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='' autocomplete='' required readonly='true'>
		                        </div>

		                        <div class='form-group col-sm-4'>
		                            <label >Fecha servicio</label>
		                            <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off' readonly='true'>
		                            
	                            </div>

		                        <div class='form-group col-sm-4'>
		                            <label >Problema</label>
		                            <select class='form-control' name='descripcion_problema' id='descripcion_problema' readonly='true'>
		                                <option value='' style='display: none;' >Seleccione</option>
		                          </select>
		                        </div>
	                	</div>";
    			}
    			else if($movimientos[0]->tipo_movimiento == 3) // PARA CUANDO ESTA EN DISPOSICION
    			{
    				$q = "SELECT zancos_bd.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana
    					FROM zancos_bd
    						INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
    						WHERE zancos_bd.no_zanco = $no_zanco";
    			
		    			$zancos = Zancos_bd::getAllByQuery($q);
    				if($movimientos[0]->fecha_salida > 0  && $movimientos[0]->fecha_entrega > 0 && $movimientos[0]->fecha_servicio > 0 && $movimientos[0]->descripcion_problema > 0)
    				{
    					// HEAD + REGISTRO

    					$movimiento_max = Zancos_movimientos::getAllLastInsert();

						if(count($movimiento_max) > 0)
						{
							$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;
						}

						$str.="<div class='form-group col-sm-12'>
                                    <label style='font-size: large'>No de registro: <b style='color: orangered;'>".$registro_autoincrementa."</b></label>
                                    <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='' autocomplete='' readonly='true'>
                                </div>";

                        $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
                                    <h6 style='color: #F3D93A;' id='departamento'></h6>
                                    <h6 style='color: #F3D93A;' id='puesto'></h6>
                                    <h6 style='color: #F3D93A;' id='estatus'></h6>
                                    <h6 style='color: #F3D93A;' id='lider'></h6>
                                </div>

                                <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";
                                $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                    
                                
                        $str.="</div>";

                        // FIN DEL HEAD + REGISTRO
    					$str.="<div class='row'>
		    						<div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='number' class='form-control' name='tamano' id='tamano' value='".$zancos[0]->tamano."' autocomplete='' required='required' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Tamaño</label>
		                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='".$zancos[0]->tamano_descripcion."' required='required' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Límite semanal</label>
		                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='".$zancos[0]->limite_semana."' required='required' readonly='true'>
		                            </div>   
		                        
		                            <div class='form-group col-sm-4'>
		                                <label >Tipo de movimiento</label>
		                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' >
		                                	<option value='' style='display:none;'>Seleccione</option>";
		                                
		                                    foreach ($zancos_acciones as $a) 
		                                    {
		                                    	if($a->id != 1)
		                                    	{
		                                    		$str.="<option value='".$a->id."'>".$a->accion."</option>";
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
		                                    
		                                        foreach ($zancos_ghs as $g) 
		                                        {
		                                            $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
		                                        } 
		                                   
		                              $str.="</select>
		                            </div>

		                            <div class='form-group col-sm-4'>
		                                <label >Zona</label>
		                                <input type='text' class='form-control' name='zona' id='zona' value=''  required='required' readonly='true'>
		                            </div>

		                            <div class='form-group'>
		                                <div class='col-sm-4'>
		                                    <label >Fecha activación / baja</label>
		                                    <div class='input-group date' id='datetimepicker1' style='pointer-events: none;'>
		                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' autocomplete='off' readonly='true'>
		                                        <span class='input-group-addon'>
		                                            <span class='glyphicon glyphicon-calendar'></span>
		                                        </span>
		                                    </div>
		                                </div>
		                            </div>
		                	</div>";

		                $str.="<div class='row'>
		                			<div class='form-group col-sm-4'>
		                                <label >Código asociado</label>
		                				<div class='input-group' style='margin-bottom: 0px;'>
			                                <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
			                                <span class='input-group-btn'>
			                                    <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
			                                </span>
			                            </div>
			                        </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Nombre asociado</label>
			                            <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
			                        </div>


		                            <div class='form-group'>
		                            	<div class='col-sm-4'>
		                                	<label >Fecha salida</label>
		                                	<div class='input-group date' id='datetimepicker2' style='pointer-events-none;'>
		                                		<input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' readonly='true' required='required'>
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
		                            </div>

		                            <div class='form-group col-sm-4'>
		                                <label >Semanas desfase</label>
		                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
		                            </div>

		                            <div class='form-group'>
		                            	<div class='col-sm-4'>
		                                	<label >Fecha entrega</label>
		                                	<div class='input-group date' id='datetimepicker3' style='pointer-events: none;'>
		                                		<input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off' readonly='true'>
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
			                            	<div class='input-group date' id='datetimepicker4' style='pointer-events: none;'>
			                            		<input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off' readonly='true'>
			                            		<span class='input-group-addon'>
		                                            <span class='glyphicon glyphicon-calendar'></span>
		                                        </span>
			                            	</div>
			                            </div>
		                            </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Problema</label>
			                            <select class='form-control' name='descripcion_problema' id='descripcion_problema' readonly='true' style='pointer-events: none;'>
			                                <option value='' style='display: none;' >Seleccione</option>";
			                                foreach ($zancos_problemas as $p) 
	                                        {
	                                            $str.="<option value='".$p->id."'>".$p->descripcion."</option>";  
	                                        } 
			                          $str.="</select>
			                        </div>
		                	</div>";
    				}
					else
					{
						// HEAD + REGISTRO

					    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$movimientos[0]->ns_salida_lider;
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

						$str.="<div class='form-group col-sm-12'>
                                    <label style='font-size: large'>No de registro: <b style='color: orange;'>".$movimientos[0]->id_registro."</b></label>
                                    <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='".$movimientos[0]->id_registro."' autocomplete='' required='required' readonly='true'>
                                </div>";

                        $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
                                    <h6 style='color: #F3D93A;' id='departamento'>".$a_departamento."</h6>
                                    <h6 style='color: #F3D93A;' id='puesto'>".$a_puesto."</h6>
                                    <h6 style='color: #F3D93A;' id='estatus'>".$a_estatus."</h6>
                                    <h6 style='color: #F3D93A;' id='lider'>".$a_lider."</h6>
                                </div>

                                <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";
                                
                                    if(isset($movimientos[0]->ns_salida_lider) > 0)
                                    {
                                        
                                        $str.="<img  class='imagenPerfil img-circle' src='../col2/ch/perfils/".$movimientos[0]->ns_salida_lider.".jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                    }
                                    else
                                    {
                                        $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                    }
                                
                        $str.="</div>";

                        // FIN DEL HEAD + REGISTRO

		    			$str.="<div class='row'>
		    						<div class='form-group col-sm-4 hidden'>   
		                                <label >Tamaño</label>
		                                <input type='number' class='form-control' name='tamano' id='tamano' value='".$movimientos[0]->tamano."' autocomplete='' required='required' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Tamaño</label>
		                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='".$movimientos[0]->tamano_descripcion."' required='required' readonly='true'>
		                            </div>

		                            <div class='form-group col-sm-4'>   
		                                <label >Límite semanal</label>
		                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='".$movimientos[0]->limite_semana."' required='required' readonly='true'>
		                            </div>   
		                        
		                            <div class='form-group col-sm-4'>
		                                <label >Tipo de movimiento</label>
		                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
		                                	
		                                    foreach ($zancos_acciones as $a) 
		                                    {
		                                    	if($a->id == 3)
		                                    	{
		                                    		$str.="<option value='".$a->id."'>".$a->accion."</option>";
		                                    	}
		                                        
		                                        
		                                    } 
		                               
		                           $str.="</select>
		                            </div>
		                    </div>";

		                $str.="<div class='row'>
		                			<div class='form-group col-sm-4'>
		                                <label >Invernadero</label>
		                                <select class='form-control' name='gh' id='gh' required='required'>
		                                    <option value='".$movimientos[0]->gh."' style='display: none;'>".$movimientos[0]->gh."</option>";

		                                        foreach ($zancos_ghs as $g) 
		                                        {
		                                            $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
		                                        } 
		                                   
		                              $str.="</select>
		                            </div>

		                            <div class='form-group col-sm-4'>
		                                <label >Zona</label>
		                                <input type='text' class='form-control' name='zona' id='zona' value='".$movimientos[0]->zona."'  required='required' readonly='true'>
		                            </div>

		                            <div class='form-group'>
		                                <div class='col-sm-4'>
		                                    <label >Fecha activación / baja</label>
		                                    <div class='input-group date' id='datetimepicker1' style='pointer-events: none;'>
		                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' autocomplete='off' readonly='true'>
		                                        <span class='input-group-addon'>
		                                            <span class='glyphicon glyphicon-calendar'></span>
		                                        </span>
		                                    </div>
		                                </div>
		                            </div>
		                	</div>";

		                $f_salida = null;
                        $w_salida = null;

                        $f_entrega = null;
                        $w_entrega = null;

                        $f_servicio = null;

                        if($movimientos[0]->fecha_salida > 0)
                        {
                           $f_salida = $movimientos[0]->fecha_salida;
                           $w_salida = $movimientos[0]->wk_salida;
                        }

                        if($movimientos[0]->fecha_entrega > 0)
                        {
                           $f_entrega = $movimientos[0]->fecha_entrega;
                           $w_entrega = $movimientos[0]->wk_entrega;
                        }

                        if($movimientos[0]->fecha_servicio > 0)
                        {
                           $f_servicio = $movimientos[0]->fecha_servicio;
                        }

		                $str.="<div class='row'>
		                			<div class='form-group col-sm-4'>
		                                <label >Código asociado</label>
		                				<div class='input-group' style='margin-bottom: 0px;'>
			                                <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='".$movimientos[0]->ns_salida_lider."' required='required'>
			                                <span class='input-group-btn'>
			                                    <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
			                                </span>
			                            </div>
			                        </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Nombre asociado</label>
			                            <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='".$movimientos[0]->nombre_lider_salida."' autocomplete='' required readonly='true'>
			                        </div>


		                            <div class='form-group'>
		                            	<div class='col-sm-4'>
		                                	<label >Fecha salida</label>
		                                	<div class='input-group date' id='datetimepicker2' >
		                                		<input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='".$f_salida."' autocomplete='off' required='required'>
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

		                if($movimientos[0]->fecha_entrega > 0 && $movimientos[0]->fecha_salida > 0)
                        {

                            $str.="<div class='form-group col-sm-4'>
                                    <label >Semanas desfase</label>
                                    <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete=''  readonly='true'>
                                </div>";
                        }
                        else
                        {
                            // aquí sacamos el desfase
                            $fechaHoy = date_create(date("Y-m-d"));
                            $f_salida = date_create($movimientos[0]->fecha_salida);

                            $d_dias = date_diff($fechaHoy, $f_salida);
                            $d_dias = $d_dias->format('%a');
                            $semanas_limite = $movimientos[0]->limite_semana;
                            $semanas_convertidas = $d_dias / 7;
                            $semanas_convertidas = round($semanas_convertidas, 2);
                            
                            if($semanas_convertidas > $semanas_limite)
                            {
                                $diferencia_semanas = $semanas_convertidas - $semanas_limite;
                                

                                $str.="<div class='form-group col-sm-4'>
                                    <label >Semanas desfase</label>
                                    <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='".$diferencia_semanas."' autocomplete=''  readonly='true'>
                                </div>";   
                            }
                            else
                            {
                                $str.="<div class='form-group col-sm-4'>
                                    <label >Semanas desfase</label>
                                    <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete=''  readonly='true'>
                                </div>";
                            }
                            
                        }            
		                            

		                            $str.="<div class='form-group'>
		                            	<div class='col-sm-4'>
		                                	<label >Fecha entrega</label>
		                                	<div class='input-group date' id='datetimepicker3' >
		                                		<input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='".$f_entrega."' autocomplete='off' >
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
			                            <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='".$w_entrega."' autocomplete='' readonly='true'>
			                        </div>

			                        <div class='form-group'>
			                        	<div class='col-sm-4'>
			                            	<label >Fecha servicio</label>
			                            	<div class='input-group date' id='datetimepicker4' >
			                            		<input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='".$f_servicio."' autocomplete='off'>
			                            		<span class='input-group-addon'>
		                                            <span class='glyphicon glyphicon-calendar'></span>
		                                        </span>
			                            	</div>
			                            </div>
		                            </div>

			                        <div class='form-group col-sm-4'>
			                            <label >Problema</label>
			                            <select class='form-control' name='descripcion_problema' id='descripcion_problema' >";
			                                
			                                if($movimientos[0]->descripcion_problema <= 0)
			                                {
			                                	$str.="<option value='' style='display: none;' >Seleccione</option>";
			                                }

			                                
			                                foreach ($zancos_problemas as $p) 
	                                        {
	                                            if($movimientos[0]->descripcion_problema == $p->id )
                                                {
                                                    $str.="<option value='".$movimientos[0]->descripcion_problema."' style='display: none;' selected='selected'>$p->descripcion</option>";
                                                }
                                                            
                                                $str.="<option value='".$p->id."'>".$p->descripcion."</option>";
	                                        } 
			                          $str.="</select>
			                        </div>
		                	</div>";
					}
    				
    			}
    			
    		}
    		else
    		{
    			$q = "SELECT zancos_bd.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana
    					FROM zancos_bd
    						INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
    						WHERE zancos_bd.no_zanco = $no_zanco";
    			
    			$zancos = Zancos_bd::getAllByQuery($q);

    			// HEAD + REGISTRO

    					$movimiento_max = Zancos_movimientos::getAllLastInsert();

						if(count($movimiento_max) > 0)
						{
							$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;
						}

						$str.="<div class='form-group col-sm-12'>
                                    <label style='font-size: large'>No de registro: <b style='color: orangered;'>".$registro_autoincrementa."</b></label>
                                    <input type='number' class='form-control hidden' name='id_registro' id='id_registro' value='' autocomplete='' readonly='true'>
                                </div>";

                        $str.="<div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                <div style='color: white; float: left; text-align: left;' class='col-sm-8'>
                                    <h6 style='color: #F3D93A;' id='departamento'></h6>
                                    <h6 style='color: #F3D93A;' id='puesto'></h6>
                                    <h6 style='color: #F3D93A;' id='estatus'></h6>
                                    <h6 style='color: #F3D93A;' id='lider'></h6>
                                </div>

                                <label id='fechaActual' class='hidden'>".date("Y-m-d")."</label>";
                                $str.="<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                    
                                
                        $str.="</div>";

                        // FIN DEL HEAD + REGISTRO

    			$str.="<div class='row'>
    						<div class='form-group col-sm-4 hidden'>   
                                <label >Tamaño</label>
                                <input type='number' class='form-control' name='tamano' id='tamano' value='".$zancos[0]->tamano."' autocomplete='' required='required' readonly='true'>
                            </div>

                            <div class='form-group col-sm-4'>   
                                <label >Tamaño</label>
                                <input type='text' class='form-control' name='descripcion' id='descripcion' value='".$zancos[0]->tamano_descripcion."' required='required' readonly='true'>
                            </div>

                            <div class='form-group col-sm-4'>   
                                <label >Límite semanal</label>
                                <input type='number' class='form-control' name='tiempo_limite' id='tiempo_limite' value='".$zancos[0]->limite_semana."' required='required' readonly='true'>
                            </div>   
                        
                            <div class='form-group col-sm-4'>
                                <label >Tipo de movimiento</label>
                                <select class='form-control' name='tipo_movimiento' id='tipo_movimiento' required='required' readonly='true'>";
                                
                                    foreach ($zancos_acciones as $a) 
                                    {
                                    	if($a->id == 1)
                                    	{
                                    		$str.="<option value='".$a->id."'>".$a->accion."</option>";
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
                                    
                                        foreach ($zancos_ghs as $g) 
                                        {
                                            $str.="<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
                                        } 
                                   
                              $str.="</select>
                            </div>

                            <div class='form-group col-sm-4'>
                                <label >Zona</label>
                                <input type='text' class='form-control' name='zona' id='zona' value=''  required='required' readonly='true'>
                            </div>

                            <div class='form-group'>
                                <div class='col-sm-4'>
                                    <label >Fecha activación / baja</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' autocomplete='off' required='required'>
                                        <span class='input-group-addon'>
                                            <span class='glyphicon glyphicon-calendar'></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                	</div>";

                $str.="<div class='row'>
                			<div class='form-group col-sm-4'>
                                <label >Código asociado</label>
                				<div class='input-group' style='margin-bottom: 0px;'>
	                                <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
	                                <span class='input-group-btn'>
	                                    <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
	                                </span>
	                            </div>
	                        </div>

	                        <div class='form-group col-sm-4'>
	                            <label >Nombre asociado</label>
	                            <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
	                        </div>


                            <div class='form-group col-sm-4'>
                                <label >Fecha salida</label>
                                <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' readonly='true'>
                            </div>
                	</div>";

                $str.="<div class='row'>
                			<div class='form-group col-sm-4'>
                                <label >Semana salida</label>
                                <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='' autocomplete='' required readonly='true'>
                            </div>

                            <div class='form-group col-sm-4'>
                                <label >Semanas desfase</label>
                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
                            </div>

                            <div class='form-group col-sm-4'>
                                <label >Fecha entrega</label>
                                <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off' readonly='true'>
                            </div>
                	</div>";

                $str.="<div class='row'>
	                		<div class='form-group col-sm-4'>
	                            <label >Semana entrega</label>
	                            <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='' autocomplete='' required readonly='true'>
	                        </div>

	                        <div class='form-group col-sm-4'>
	                            <label >Fecha servicio</label>
	                            <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off' readonly='true'>
	                            
                            </div>

	                        <div class='form-group col-sm-4'>
	                            <label >Problema</label>
	                            <select class='form-control' name='descripcion_problema' id='descripcion_problema' readonly='true'>
	                                <option value='' style='display: none;' >Seleccione</option>
	                          </select>
	                        </div>
                	</div>";
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
						    
						    $('#tipo_movimiento').on('change', function()
						    {
						        var tipo_movimiento = null;
						            tipo_movimiento = $(this).val();

						            if(tipo_movimiento == 1) // activacion
						            {
						                $('#fecha_activacion_o_baja').attr('required', 'required');
						                $('#ns_salida_lider').attr('required', 'required');
						                $('#nombre_lider_salida').attr('required', 'required');

						                $('#fecha_salida').removeAttr('required');
						                $('#fecha_salida').attr('readonly', true);
						                $('#datetimepicker2').css('pointer-events','none');
						                $('#fecha_salida').val(null);


						                $('#wk_salida').removeAttr('required');
						                $('#wk_salida').val(null);


						                $('#desfase').removeAttr('required');
						                $('#desfase').val(null);


						                $('#fecha_entrega').removeAttr('required');
						                $('#fecha_entrega').attr('readonly', true);
						                $('#datetimepicker3').css('pointer-events','none');
						                $('#fecha_entrega').val(null);

						                $('#wk_entrega').removeAttr('required');
						                $('#wk_entrega').val(null);

						                $('#fecha_servicio').removeAttr('required');
						                $('#fecha_servicio').attr('readonly', true);
						                $('#datetimepicker4').css('pointer-events','none');
						                $('#fecha_servicio').val(null);


						                $('#descripcion_problema').removeAttr('required');
						                $('#descripcion_problema').val(null);
						                $('#descripcion_problema').attr('readonly', true);
						                $('#descripcion_problema').css('pointer-events','none');

						                
						            }
						            else if(tipo_movimiento == 2) // baja
						            {
						                
						                $('#fecha_activacion_o_baja').attr('required', 'required');
						                $('#fecha_activacion_o_baja').attr('readonly', false);
						                $('#datetimepicker1').css('pointer-events','auto');
						                $('#fecha_activacion_o_baja').val(null);

						                $('#ns_salida_lider').attr('required', 'required');
						                $('#nombre_lider_salida').attr('required', 'required');

						                $('#fecha_salida').removeAttr('required');
						                $('#fecha_salida').attr('readonly', true);
						                $('#datetimepicker2').css('pointer-events','none');
						                $('#fecha_salida').val(null);


						                $('#wk_salida').removeAttr('required');
						                $('#wk_salida').val(null);


						                $('#desfase').removeAttr('required');
						                $('#desfase').val(null);


						                $('#fecha_entrega').removeAttr('required');
						                $('#fecha_entrega').attr('readonly', true);
						                $('#datetimepicker3').css('pointer-events','none');
						                $('#fecha_entrega').val(null);

						                $('#wk_entrega').removeAttr('required');
						                $('#wk_entrega').val(null);

						                $('#fecha_servicio').removeAttr('required');
						                $('#fecha_servicio').attr('readonly', true);
						                $('#datetimepicker4').css('pointer-events','none');
						                $('#fecha_servicio').val(null);


						                $('#descripcion_problema').removeAttr('required');
						                $('#descripcion_problema').val(null);
						                $('#descripcion_problema').attr('readonly', true);
						                $('#descripcion_problema').css('pointer-events','none');
						            }
						            else if(tipo_movimiento == 3) // salida
						            {
						                $('#fecha_activacion_o_baja').removeAttr('required');
						                $('#fecha_activacion_o_baja').attr('readonly', true);
						                $('#datetimepicker1').css('pointer-events','none');
						                $('#fecha_activacion_o_baja').val(null);

						                $('#ns_salida_lider').attr('required', 'required');
						                $('#nombre_lider_salida').attr('required', 'required');

						                $('#fecha_salida').attr('required', 'required');
						                $('#fecha_salida').attr('readonly', false);
						                $('#datetimepicker2').css('pointer-events','auto');
						                $('#fecha_salida').val(null);


						                $('#wk_salida').removeAttr('required');
						                $('#wk_salida').val(null);


						                $('#desfase').removeAttr('required');
						                $('#desfase').val(null);


						                $('#fecha_entrega').removeAttr('required');
						                $('#fecha_entrega').attr('readonly', false);
						                $('#datetimepicker3').css('pointer-events','auto');
						                $('#fecha_entrega').val(null);

						                $('#wk_entrega').removeAttr('required');
						                $('#wk_entrega').val(null);

						                $('#fecha_servicio').removeAttr('required');
						                $('#fecha_servicio').attr('readonly', false);
						                $('#datetimepicker4').css('pointer-events','auto');
						                $('#fecha_servicio').val(null);


						                $('#descripcion_problema').removeAttr('required');
						                $('#descripcion_problema').val(null);
						                $('#descripcion_problema').attr('readonly', false);
						                $('#descripcion_problema').css('pointer-events','auto');

						            }
						    });

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

						            ajax.open('GET', 'helper_zancos.php?consulta=ASOCIADO&codigo='+ns_salida_lider, true);
						            ajax.onreadystatechange=function() 
						            { 
						                if (ajax.readyState==1)
						                {
						                  // Mientras carga ponemos un letrerito que dice 'Verificando...'
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
						        
						        $.get('helper_zancos.php', {consulta:consulta, fecha:fecha_salida} ,function(data)
						        {
						            
						            $('#wk_salida').val(data);
						        });

						        var tiempo_limite = $('#tiempo_limite').val();
						        var day = $('#fechaActual').text();
						        var diferencia =  Math.floor(( Date.parse(day) - Date.parse(fecha_salida) ) / (1000 * 60 * 60 * 24));
						            /*if(diferencia < 0)
						            {
						                diferencia = diferencia*(-1);
						            }*/  
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
						        
						        $.get('helper_zancos.php', {consulta:consulta, fecha:fecha_salida} ,function(data)
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
	elseif ($consulta == "EXISTE_ZANCO") 
	{
		$no_zanco = $_REQUEST['no_zanco'];

		$datos = Zancos_bd::buscaZanco($no_zanco);

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
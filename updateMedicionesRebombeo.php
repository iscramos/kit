<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$str = "";
	
	if($id > 0)
	{
		$medicion = Bd_rebombeo::getById($id);
		$q = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
											OR activo LIKE 'CO-COM%'
											OR activo LIKE 'CO-POZ%'
											AND organizacion = 'COL' ORDER BY activo ASC";

		$tipos = TipoMedicion_Rebombeo::getById($medicion->tipo);
											
		$activos = Disponibilidad_activos::getAllByQuery($q);

		$str.="<div class='form-group hidden'>
						<label >ID</label>
						
							<input type='number' class='form-control' id='id' name='id' value='".$medicion->id."' readonly>
						
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
						<label >Fecha de lectura</label>
						<input type='text' name='fechaLectura' id='fechaLectura' class='form-control input-sm' value='".date("d-m-Y H:i", strtotime($medicion->fechaLectura))."' readonly>        
					</div>
					<div class='col-md-4 col-xs-12'>
						<label >Tipo de medición</label>
						<input class='form-control input-sm' type='text' name='equipo' value='".$tipos->descripcion."' readonly>
									
							
					</div>	
					<div class='col-md-4 col-xs-12'>
						<label >Tipo</label>";
						
								foreach ($activos as $activo) 
								{	
									if($activo->activo == $medicion->equipo)
									{
										$str.="<input class='form-control input-sm' type='text' name='equipo' value='".$activo->descripcion."' readonly>;";
									}
								}
							
					$str.="</div>	
				</div>";

		$plusAtributo = "";
		if($medicion->tipo == 1)
		{
			$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
						<label >Voltaje L1 - L2</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l1_l2' name='voltaje_l1_l2' value='".$medicion->voltaje_l1_l2."' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Voltaje L2 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l2_l3' name='voltaje_l2_l3' value='".$medicion->voltaje_l2_l3."' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12'>
						<label >Voltaje L1 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l1_l3' name='voltaje_l1_l3' value='".$medicion->voltaje_l1_l3."' autocomplete='off' >
					</div>
				</div>";


		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L1</label>
							<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l1' name='amperaje_l1' value='".$medicion->amperaje_l1."' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L2</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l2' name='amperaje_l2' value='".$medicion->amperaje_l2."' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l3' name='amperaje_l3' value='".$medicion->amperaje_l3."' autocomplete='off' >
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
						<label >Voltaje L1 - L2</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l1_l2' name='voltaje_l1_l2' value='".$medicion->voltaje_l1_l2."' autocomplete='off' readonly>
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Voltaje L2 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l2_l3' name='voltaje_l2_l3' value='".$medicion->voltaje_l2_l3."' autocomplete='off' readonly>
					</div>
					<div class='col-md-4 col-xs-12'>
						<label >Voltaje L1 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l1_l3' name='voltaje_l1_l3' value='".$medicion->voltaje_l1_l3."' autocomplete='off' readonly>
					</div>
				</div>";


		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L1</label>
							<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l1' name='amperaje_l1' value='".$medicion->amperaje_l1."' autocomplete='off' readonly>
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L2</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l2' name='amperaje_l2' value='".$medicion->amperaje_l2."' autocomplete='off' readonly>
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Amperaje L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l3' name='amperaje_l3' value='".$medicion->amperaje_l3."' autocomplete='off' readonly>
					</div>
				</div>";
		}		
		

		if($medicion->tipo == 2)
		{
			$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-12'>
						<label >Nivel Estático</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_estatico' name='nivel_estatico' value='".$medicion->nivel_estatico."' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Nivel Dinámico</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_dinamico' name='nivel_dinamico' value='".$medicion->nivel_dinamico."' autocomplete='off' >
					</diV>
					<div class='col-md-4 col-xs-12'>
						<label>HP</label>
						<input type='number' step='0.01' class='form-control input-sm' id='hp' name='hp' value='".$medicion->hp."' autocomplete='off' readonly>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-12'>
						<label >Nivel Estático</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_estatico' name='nivel_estatico' value='".$medicion->nivel_estatico."' autocomplete='off' readonly>
					</div>
					<div class='col-md-4 col-xs-12'>
						<label>Nivel Dinámico</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_dinamico' name='nivel_dinamico' value='".$medicion->nivel_dinamico."' autocomplete='off' readonly>
					</diV>
					<div class='col-md-4 col-xs-12'>
						<label>HP</label>
						<input type='number' step='0.01' class='form-control input-sm' id='hp' name='hp' value='".$medicion->hp."' autocomplete='off' readonly>
					</div>
				</div>";
		}
				

		$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12'>
						<label >Voltaje nominal bajo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='volt_nomi_bajo' name='volt_nomi_bajo' value='".$medicion->volt_nomi_bajo."' autocomplete='off' readonly>
					</div>
					<div class='col-md-3 col-xs-12'>
						<label '>Voltaje nominal alto</label>
						<input type='number' step='0.01' class='form-control input-sm' id='volt_nomi_alto' name='volt_nomi_alto' value='".$medicion->volt_nomi_alto."' autocomplete='off' readonly>
					</diV>
					<div class='col-md-3 col-xs-12'>
						<label >Amperaje Máximo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amp_max' name='amp_max' value='".$medicion->amp_max."' autocomplete='off' readonly>
					</div>
					<div class='col-md-3 col-xs-12'>
						<label >Amperaje Mínimo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amp_min' name='amp_min' value='".$medicion->amp_min."' autocomplete='off' readonly>
					</div>
				</div>";

		if($medicion->tipo == 3)
		{
			$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12'>
						<label >M<sup>3</sup> consumidos</label>
						<input type='number' class='form-control input-sm' id='m_consumidos' name='m_consumidos' value='".$medicion->m_consumidos."' autocomplete='off'> 
					</div>
					<div class='col-md-3 col-xs-12'>
						<label >Caudal</label>
						<input type='number' step='0.01' class='form-control input-sm' id='caudal' name='caudal' value='".$medicion->caudal."' autocomplete='off' >
					</div>
				</div>";

			$atributo = "";
			if($medicion->reinicio == 1)
			{
				$atributo = "checked";
			}

			$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12'>
						<label >Reinicio de Medidor</label>
						<input type='checkbox' class='form-control' ".$atributo." id='reinicio' name='reinicio' > 
							
					</div>
					<div class='col-md-9 col-xs-12'>
						<label >Comentarios adicionales</label>
						<textarea class='form-control' rows='2' id='comentarios' name='comentarios' >".$medicion->comentarios."</textarea>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12'>
						<label >M<sup>3</sup> consumidos</label>
						<input type='number' class='form-control input-sm' id='m_consumidos' name='m_consumidos' value='".$medicion->m_consumidos."' autocomplete='off' readonly> 
					</div>
					<div class='col-md-3 col-xs-12'>
						<label >Caudal</label>
						<input type='number' step='0.01' class='form-control input-sm' id='caudal' name='caudal' value='".$medicion->caudal."' autocomplete='off' readonly>
					</div>
				</div>";

			$atributo = "";
			if($medicion->reinicio == 1)
			{
				$atributo = "checked";
			}
			
			$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12'>
						<label >Reinicio de Medidor</label>
						<input style='pointer-events:none;' type='checkbox' class='form-control' ".$atributo." id='reinicio' name='reinicio' readonly> 
							
					</div>
					<div class='col-md-9 col-xs-12'>
						<label >Comentarios adicionales</label>
						<textarea class='form-control' rows='2' id='comentarios' name='comentarios' readonly>".$medicion->comentarios."</textarea>
					</div>
				</div>";
		}

		

		
	}
	else
	{
		$q = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
											OR activo LIKE 'CO-COM%'
											OR activo LIKE 'CO-POZ%'
											AND organizacion = 'COL' ORDER BY activo ASC";

		$activos = Disponibilidad_activos::getAllByQuery($q);
		$tipos = tipoMedicion_rebombeo::getAllByOrden("descripcion", "ASC");

		$fechita = date("Y-m-d H:i");
		//echo $fechita;
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";

		
		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12'>
			            <div class='form-group'>
			            	<label >Fecha de lectura</label>
			                <div class='input-group date' id='datetimepicker1'>
			                    <input type='text' name='fechaLectura' id='fechaLectura' class='form-control input-sm' value='".$fechita."'>
			                    <span class='input-group-addon'>
			                        <span class='glyphicon glyphicon-calendar'></span>
			                    </span>
			                </div>
			            </div>
			        </div>
					<div class='col-md-4 col-xs-12'>
						<label >Tipo de medición</label>
						<select name='tipo' id='tipo' class='form-control input-sm' required>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($tipos as $tipo) 
								{
									$str.="<option value='".$tipo->id."'>".$tipo->descripcion."</option>";
								}
							$str.="</select>
					</div>
					<div class='col-md-4 col-xs-12  hidden visible'>
						<label >Equipo</label>
						<select name='equipo' id='equipo' class='form-control input-sm' required >
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($activos as $activo) 
								{
									
									
									
									$buscarBomba = "CO-BMU";
									$resultado = strpos($activo->activo, $buscarBomba);
									 
									if($resultado !== FALSE)
									{
									    $str.="<option value='".$activo->activo."' class='medidor voltaje modoActiva hidden' >".$activo->descripcion."</option>";
									}

									$buscarComedor = "CO-COM";
									$resultado = strpos($activo->activo, $buscarComedor);
									 
									if($resultado !== FALSE)
									{
									    $str.="<option value='".$activo->activo."' class='medidor modoActiva hidden' >".$activo->descripcion."</option>";
									}

									

									$buscarPozo = "CO-POZ";
									$resultado = strpos($activo->activo, $buscarPozo);
									 
									if($resultado !== FALSE)
									{
									    $str.="<option value='".$activo->activo."' class='nivel voltaje medidor modoActiva hidden' >".$activo->descripcion."</option>";
									}
								}
							$str.="</select>
					</div>	
						
				</div>";

		

		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label >Voltaje L1 - L2</label>
						<input type='number' step='0.01'  class='form-control input-sm' id='voltaje_l1_l2' name='voltaje_l1_l2' value='' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>Voltaje L2 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l2_l3' name='voltaje_l2_l3' value='' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label >Voltaje L1 - L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='voltaje_l1_l3' name='voltaje_l1_l3' value='' autocomplete='off' >
					</div>
				</div>";


		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>Amperaje L1</label>
							<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l1' name='amperaje_l1' value='' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>Amperaje L2</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l2' name='amperaje_l2' value='' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>Amperaje L3</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amperaje_l3' name='amperaje_l3' value='' autocomplete='off' >
					</div>
				</div>";

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label >Nivel Estático</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_estatico' name='nivel_estatico' value='' autocomplete='off' >
					</div>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>Nivel Dinámico</label>
						<input type='number' step='0.01' class='form-control input-sm' id='nivel_dinamico' name='nivel_dinamico' value='' autocomplete='off' >
					</diV>
					<div class='col-md-4 col-xs-12 hidden visible'>
						<label>HP</label>
						<input type='number' step='0.01' class='form-control input-sm' id='hp' name='hp' value='' autocomplete='off' >
					</div>
				</div>";		

		$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >Voltaje nominal bajo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='volt_nomi_bajo' name='volt_nomi_bajo' value='' autocomplete='off' >
					</div>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label '>Voltaje nominal alto</label>
						<input type='number' step='0.01' class='form-control input-sm' id='volt_nomi_alto' name='volt_nomi_alto' value='' autocomplete='off' >
					</diV>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >Amperaje Máximo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amp_max' name='amp_max' value='' autocomplete='off' >
					</div>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >Amperaje Mínimo</label>
						<input type='number' step='0.01' class='form-control input-sm' id='amp_min' name='amp_min' value='' autocomplete='off' >
					</div>
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >M<sup>3</sup> consumidos</label>
						<input type='number' class='form-control input-sm' id='m_consumidos' name='m_consumidos' value='' autocomplete='off'> 
					</div>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >Caudal</label>
						<input type='number' step='0.01' class='form-control input-sm' id='caudal' name='caudal' value='' autocomplete='off' >
					</div>
				</div>";
		$str.="<div class='form-group'>
					<div class='col-md-3 col-xs-12 hidden visible'>
						<label >Reinicio de Medidor</label>
						<input type='checkbox' class='form-control' id='reinicio' name='reinicio' > 
							
					</div>
					<div class='col-md-9 col-xs-12 hidden visible'>
						<label >Comentarios adicionales</label>
						<textarea class='form-control' rows='2' id='comentarios' name='comentarios' ></textarea>
					</div>
				</div>";
	}
}
else
{
	redirect_to('lib/logout.php');
}

echo $str;
?>

<script type="text/javascript">
	function creaAjax()
	{
		var objetoAjax=false;
		try 
		{
		    /*Para navegadores distintos a internet explorer*/
		    objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e)
		{
		    try 
		    {
		      /*Para explorer*/
		      objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
		    } catch (E) 
		    {
		      objetoAjax = false;
			}
		}
		if (!objetoAjax && typeof XMLHttpRequest!='undefined') 
		{
		    objetoAjax = new XMLHttpRequest();
		}
		return objetoAjax;
	}

	$("#equipo").on("change", function(){
    		var datoTipo = 0;
    		var datoEquipo = null;

    		datoTipo = $("#tipo").val();
    		equipo = $(this).val();

    		$("#reinicio").val(null);
    		$('#reinicio').css('pointer-events','auto');
    		$('#reinicio').prop('checked', false);
    		$("#comentarios").val(null);
    		$("#m_consumidos").val(null);
			$("#voltaje_l1_l2").val(null);
			$("#voltaje_l2_l3").val(null);
			$("#voltaje_l1_l3").val(null);
			$("#amperaje_l1").val(null);
			$("#amperaje_l2").val(null);
			$("#amperaje_l3").val(null);
			$("#caudal").val(null);
			$("#nivel_dinamico").val(null);
			$("#nivel_estatico").val(null);
			$("#hp").val(null);
			$("#volt_nomi_bajo").val(null);
			$("#volt_nomi_alto").val(null);
			$("#amp_max").val(null);
			$("#amp_min").val(null);

			

    		if (datoTipo == 1) // para voltaje y corriente
    		{
    			//console.log("hasta aqui");
    			var ajax = creaAjax();
			    //document.frmdatos.nocuentaId.value=idcuenta;

			    ajax.open("GET", "helper_equipo_rebombeo.php?equipo="+equipo, true);
			    ajax.onreadystatechange=function() 
			    { 
			      if (ajax.readyState==1)
			      {
			        // Mientras carga ponemos un letrerito que dice "Verificando..."
			        DestinoMsg.innerHTML='Verificando...';
			      }
			      if (ajax.readyState==4)
			      {
			        // Cuando ya terminó, ponemos el resultado
			        var str = ajax.responseText;
			        var n = str.split("&");
			        
			        var hp = n[0];
			        var v_bajo = n[1];
			        var v_alto = n[2];
			        var a_bajo = n[3];
			        var a_alto = n[4];

			        /*document.frmtipo.hp.value = hp;
			        document.frmtipo.volt_nomi_bajo.value = v_bajo;
			        document.frmtipo.volt_nomi_alto.value = v_alto;
			        document.frmtipo.amp_min.value = a_bajo;
			        document.frmtipo.amp_max.value = a_alto;*/

			        $("#hp").val(hp);
			        $("#volt_nomi_bajo").val(v_bajo);
	    			$("#volt_nomi_alto").val(v_alto);
	    			$("#amp_min").val(a_bajo);
	    			$("#amp_max").val(a_alto);
			      } 
			    }
			    ajax.send(null);
    		}
    		/*else if(tipo == 2) // para medidores
    		{

    		}*/
    	})

		$("#tipo").on("change", function()
    	{
    		var tipo = null;
    		tipo = $("#tipo").val();
    		//console.log("seleccion "+ tipo);
    			$("#reinicio").attr("readonly", "true");
    			$('#reinicio').css('pointer-events','none');
    			$('#reinicio').prop('checked', false);
    			$("#comentarios").attr("readonly", "true");
    			$("#m_consumidos").attr("readonly", "true");
    			$("#voltaje_l1_l2").attr("readonly", "true");
    			$("#voltaje_l2_l3").attr("readonly", "true");
    			$("#voltaje_l1_l3").attr("readonly", "true");
    			$("#amperaje_l1").attr("readonly", "true");
    			$("#amperaje_l2").attr("readonly", "true");
    			$("#amperaje_l3").attr("readonly", "true");
    			$("#caudal").attr("readonly", "true");
    			$("#nivel_dinamico").attr("readonly", "true");
    			$("#nivel_estatico").attr("readonly", "true");
    			$("#hp").attr("readonly", "true");
    			$("#volt_nomi_bajo").attr("readonly", "true");
    			$("#volt_nomi_alto").attr("readonly", "true");
    			$("#amp_max").attr("readonly", "true");
    			$("#amp_min").attr("readonly", "true");

    			$("#reinicio").val(null);
    			$("#comentarios").val(null);
    			$("#m_consumidos").val(null);
    			$("#voltaje_l1_l2").val(null);
    			$("#voltaje_l2_l3").val(null);
    			$("#voltaje_l1_l3").val(null);
    			$("#amperaje_l1").val(null);
    			$("#amperaje_l2").val(null);
    			$("#amperaje_l3").val(null);
    			$("#caudal").val(null);
    			$("#nivel_dinamico").val(null);
    			$("#nivel_estatico").val(null);
    			$("#hp").val(null);
    			$("#volt_nomi_bajo").val(null);
    			$("#volt_nomi_alto").val(null);
    			$("#amp_max").val(null);
    			$("#amp_min").val(null);

    		$(".visible").removeClass("hidden");

    		$(".modoActiva").addClass("hidden"); // para los options de los equipos al iniciar o en un cambio

    		if(tipo == 1) // voltaje y corriente
    		{	
    			$("#equipo option:first").prop('selected','selected');
    			$("#voltaje_l1_l2").removeAttr("readonly");
    			$("#voltaje_l2_l3").removeAttr("readonly");
    			$("#voltaje_l1_l3").removeAttr("readonly");
    			$("#amperaje_l1").removeAttr("readonly");
    			$("#amperaje_l2").removeAttr("readonly");
    			$("#amperaje_l3").removeAttr("readonly");

    			$(".voltaje").removeClass("hidden");
    			//$(".voltaje").removeClass("hidden");

    		}
    		else if(tipo == 2) // niveles
    		{
    			$("#equipo option:first").prop('selected','selected');
    			$("#nivel_dinamico").removeAttr("readonly");
    			$("#nivel_estatico").removeAttr("readonly");

    			$(".nivel").removeClass("hidden");
    			//$(".nivel").removeClass("hidden");
    		}
    		else if(tipo == 3) // medidores
    		{
    			$("#equipo option:first").prop('selected','selected');
    			$("#m_consumidos").removeAttr("readonly");
    			$("#caudal").removeAttr("readonly");
    			$("#reinicio").removeAttr("readonly");
    			$('#reinicio').css('pointer-events','auto');
    			$("#comentarios").removeAttr("readonly");

    			$(".medidor").removeClass("hidden");
    			//$(".medidor").removeClass("hidden");
    		}

    	})

	$(document).ready(function()
    {
    	
    	
        $(function () {
            $('#datetimepicker1').datetimepicker({
            	 format: 'YYYY-MM-DD HH:mm',
            	 /*autoclose: true,*/
            });
        });
        
    });
</script>


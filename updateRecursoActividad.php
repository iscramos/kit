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
		$act = Recursos_actividades::getById($id);
		

		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$act->id."' readonly> 
					</div>
				</div>";

		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Id actividad</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='id_actividad' name='id_actividad' value='".$act->id_actividad."' autocomplete='off' required>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Nombre</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='nombre' name='nombre' value='".$act->nombre."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Etapa</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='etapa' name='etapa' value='".$act->etapa."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Objetivo</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='objetivo' name='objetivo' value='".$act->objetivo."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>% Eficiencia</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='eficiencia_exponencial' name='eficiencia_exponencial' value='".$act->eficiencia_exponencial."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Pago de surco $</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='pago_surco' name='pago_surco' value='".$act->pago_surco."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo de jornal</label>
					<div class='col-xs-9 '>
						<select name='tipo_jornal' id='tipo_jornal' class='form-control input-sm' required>
							<option value='".$act->tipo_jornal."' style='display:none;'>".$act->tipo_jornal."</option>
							<option value='VARIABLE'>VARIABLE</option>
						</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo de pago</label>
					<div class='col-xs-9 '>
						<select name='tipo_pago' id='tipo_pago' class='form-control input-sm' required>
							<option value='".$act->tipo_pago."' style='display:none;'>".$act->tipo_pago."</option>
							<option value='EFICIENCIA'>EFICIENCIA</option>
							<option value='TIEMPO'>TIEMPO</option>
						</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Centro de costo</label>
					<div class='col-xs-9 '>
						<select name='centro_costo' id='centro_costo' class='form-control input-sm' required>
							<option value='".$act->centro_costo."' style='display:none;'>".$act->centro_costo."</option>
							<option value='PREPARACION DE SUELOS'>PREPARACION DE SUELOS</option>
						</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Factor $</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='factor' name='factor' value='".$act->factor."' autocomplete='off' >
					</div>
				</div>";


		
	}
	else
	{
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";

		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Id actividad</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='id_actividad' name='id_actividad' value='' autocomplete='off' required>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Nombre</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='nombre' name='nombre' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Etapa</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='etapa' name='etapa' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Objetivo</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='objetivo' name='objetivo' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>% Eficiencia</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='eficiencia_exponencial' name='eficiencia_exponencial' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Pago de surco $</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='pago_surco' name='pago_surco' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo de jornal</label>
					<div class='col-xs-9 '>
						<select name='tipo_jornal' id='tipo_jornal' class='form-control input-sm' required>
							<option value='' style='display:none;'>Seleccione</option>
							<option value='VARIABLE'>VARIABLE</option>
						</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo de pago</label>
					<div class='col-xs-9 '>
						<select name='tipo_pago' id='tipo_pago' class='form-control input-sm' required>
							<option value='' style='display:none;'>Seleccione</option>
							<option value='EFICIENCIA'>EFICIENCIA</option>
							<option value='TIEMPO'>TIEMPO</option>
						</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Centro de costo</label>
					<div class='col-xs-9 '>
						<select name='centro_costo' id='centro_costo' class='form-control input-sm' required>
							<option value='' style='display:none;'>Seleccione</option>
							<option value='PREPARACION DE SUELOS'>PREPARACION DE SUELOS</option>
						</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Factor $</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='factor' name='factor' value='' autocomplete='off' >
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

	


	$(document).ready(function()
    {
    	
    	$("#metros_lineales_estandar").on("keyup", function(){
    		var metros_lineales_estandar = null;
    		var metros_lineales_reales = null;
    		var surco_real = 0;

    			metros_lineales_estandar = $(this).val();
    			metros_lineales_reales = $("#metros_lineales_reales").val();
    			///console.log(metros_lineales_estandar);
    			//console.log(metros_lineales_reales);
    			surco_real = parseFloat(metros_lineales_estandar) / parseFloat(metros_lineales_reales);

    			$("#surco_real").val(surco_real);
    	})

    	$("#metros_lineales_reales").on("keyup", function(){
    		var metros_lineales_estandar = null;
    		var metros_lineales_reales = null;
    		var surco_real = 0;

    			metros_lineales_reales = $(this).val();
    			metros_lineales_estandar = $("#metros_lineales_estandar").val();
    			//console.log(metros_lineales_estandar);
    			//console.log(metros_lineales_reales);
    			surco_real = parseFloat(metros_lineales_estandar) / parseFloat(metros_lineales_reales);

    			$("#surco_real").val(surco_real);
    	})
      
        
    });
</script>


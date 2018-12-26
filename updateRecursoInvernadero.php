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
		$inv = Recursos_invernaderos::getById($id);
		

		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$inv->id."' readonly> 
					</div>
				</div>";

		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Invernadero</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='invernadero' name='invernadero' value='".$inv->invernadero."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Zona</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='zona' name='zona' value='".$inv->zona."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Surcos</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='surcos' name='surcos' value='".$inv->surcos."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Metros estándar</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='metros_lineales_estandar' name='metros_lineales_estandar' value='".$inv->metros_lineales_estandar."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Metros reales</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='metros_lineales_reales' name='metros_lineales_reales' value='".$inv->metros_lineales_reales."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Surco real</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='surco_real' name='surco_real' value='".$inv->surco_real."' autocomplete='off' required readonly>
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
					<label class='col-xs-3 control-label'>Invernadero</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='invernadero' name='invernadero' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Zona</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='zona' name='zona' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Surcos</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='surcos' name='surcos' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Metros estándar</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='metros_lineales_estandar' name='metros_lineales_estandar' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Metros reales</label>
					<div class='col-xs-9 '>
						<input type='number' step='0.01' class='form-control input-sm' id='metros_lineales_reales' name='metros_lineales_reales' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Surco real</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='surco_real' name='surco_real' value='' autocomplete='off' required readonly>
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


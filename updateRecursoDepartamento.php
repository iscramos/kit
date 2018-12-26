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
		$departamento = Recursos_departamentos::getById($id);
		

		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$departamento->id."' readonly> 
					</div>
				</div>";

		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Departamento</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='departamento' name='departamento' value='".$departamento->departamento."' autocomplete='off' required>
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
					<label class='col-xs-3 control-label'>Departamento</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='departamento' name='departamento' value='' autocomplete='off' required>
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
    	
    	
       
        
    });
</script>


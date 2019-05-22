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
		$tamanos = Zancos_tamanos::getById($id);

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$tamanos->id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tamaño</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='tamano' name='tamano' value='".$tamanos->tamano."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Límite semanal</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='limite_semana' name='limite_semana' value='".$tamanos->limite_semana."' autocomplete='off' required='required'>
						</div>
				</div>";
	}
	else
	{
		

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tamaño</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='tamano' name='tamano' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Límite semanal</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='limite_semana' name='limite_semana' value='' autocomplete='off' required='required'>
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
	$('.password').focus(function () 
    {
       $('.password').attr('type', 'text'); 
    });
</script>
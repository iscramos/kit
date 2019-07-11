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
		$udm = Herramientas_udm::getById($id);

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$udm->id."' readonly >
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>UDM</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='udm' name='udm' value='".$udm->udm."' autocomplete='off' required='required' readonly>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Descripción</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".$udm->descripcion."' autocomplete='off' required='required'>
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
						<label class='col-sm-4 control-label'>UDM</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='udm' name='udm' value='' autocomplete='off' required='required' onkeyup='javascript:this.value=this.value.toUpperCase();'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Descripción</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='' autocomplete='off' required='required'>
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
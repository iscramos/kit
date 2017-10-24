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
		/*$user = Usuarios::getById($id);
		$description_roles = Description_roles::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".sanitize_output($user->id)."' readonly>
						</div>
				</div>";*/

		
	}
	else
	{

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Equipo</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='nombre_equipo' name='nombre_equipo' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tipo</label>
						<div class='col-sm-8'>
							<select class='form-control' id='familia' name='familia' required>";
								$str.="<option value='' style='display:none;'>Seleccione una familia</option>";
								$str.="<option value='TRACTOR'>TRACTOR</option>";
								$str.="<option value='EMBARQUE'>EMBARQUE</option>";
								$str.="<option value='FUMIGACION'>FUMIGACION</option>";
								$str.="<option value='REMOLQUES'>REMOLQUES</option>";
								$str.="<option value='RIEGO'>RIEGO</option>";
								$str.="<option value='ELECTRICA'>ELECTRICA</option>";
							$str.="</select>
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
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
		$bd = Zancos_bd::getById($id);

		$tamanos = Zancos_tamanos::getAllByOrden("tamano", "ASC");

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$bd->id."' readonly>
						</div>
				</div>";

		if($bd->no_zanco == 0)
		{
			$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>No zanco</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='no_zanco' name='no_zanco' value='".$bd->no_zanco."' autocomplete='off' required='required' >
						</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>No zanco</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='no_zanco' name='no_zanco' value='".$bd->no_zanco."' autocomplete='off' required='required' readonly>
						</div>
				</div>";
		}
		

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tamaño</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='tamano' id='tamano' required='required' readonly>";
								foreach ($tamanos as $t) 
								{
									if($t->id == $bd->tamano)
									{
										$str.="<option value='".$t->id."' style='display:none;' selected>".$t->tamano."</option>";	
									}
									/*$str.="<option value='".$t->id."' >".$t->tamano."</option>";*/
								}
							$str.="</select>
						</div>
				</div>";
		/*$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tamaño</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='tamano' id='tamano' required='required'>
								<option value='' style='display:none;'>Seleccione un tamaño</option>";
								foreach ($tamanos as $t) 
								{
									if($t->id == $bd->tamano)
									{
										$str.="<option value='".$t->id."' style='display:none;' selected>".$t->tamano."</option>";	
									}
									$str.="<option value='".$t->id."' >".$t->tamano."</option>";
								}
							$str.="</select>
						</div>
				</div>";*/
	}
	else
	{
		
		$tamanos = Zancos_tamanos::getAllByOrden("tamano", "ASC");

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='' readonly>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<p style='color: red;'>* Colocar 0, para stock.</p>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>No zanco </label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='no_zanco' name='no_zanco' value='' autocomplete='off' required='required'>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tamaño</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='tamano' id='tamano' required='required'>
								<option value='' style='display:none;'>Seleccione un tamaño</option>";
								foreach ($tamanos as $t) 
								{
									$str.="<option value='".$t->id."' >".$t->tamano."</option>";
								}
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


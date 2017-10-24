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
		$ideal = Mpideales::getById($id);
		$activos_equipos = Activos_equipos::getAllOrderASC();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".$ideal->id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Equipo</label>
						<div class='col-sm-8'>
							<select class='form-control' id='id_activo_equipo' name='id_activo_equipo' required>";
								foreach ($activos_equipos as $activo) 
								{
									if($activo->id == $ideal->id_activo_equipo)
									{
										$str.="<option value='".$activo->id."' style='display:none;' selected='selected'>".$activo->nombre_equipo."</option>";
									}
									$str.="<option value='".$activo->id."'>".$activo->nombre_equipo." (".$activo->familia.") </option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>A (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='A' name='A' value='".$ideal->A."' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>B (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='B' name='B' value='".$ideal->B."' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>C (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='C' name='C' value='".$ideal->C."' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>D (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='D' name='D' value='".$ideal->D."' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>E (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='E' name='E' value='".$ideal->E."' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>F (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='F' name='F' value='".$ideal->F."' autocomplete='off' >
						</div>
				</div>";

		
	}
	else
	{
		$activos_equipos = Activos_equipos::getAllOrderASC();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Equipo</label>
						<div class='col-sm-8'>
							<select class='form-control' id='id_activo_equipo' name='id_activo_equipo' required>";
								$str.="<option value='' style='display:none;'>Seleccione un equipo</option>";
								foreach ($activos_equipos as $activo) 
								{
									$str.="<option value='".$activo->id."'>".$activo->nombre_equipo." (".$activo->familia.") </option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>A (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='A' name='A' value='' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>B (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='B' name='B' value='' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>C (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='C' name='C' value='' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>D (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='D' name='D' value='' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>E (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='E' name='E' value='' autocomplete='off' >
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>F (horas)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='F' name='F' value='' autocomplete='off' >
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
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
		
		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Fecha de medición</label>
						<div class='col-sm-8'>
							
				                <div class='input-group date' id='datetimepicker1'>
				                    <input type='text' name='fecha' id='fecha' class='form-control' required>
				                    <span class='input-group-addon'>
				                        <span class='glyphicon glyphicon-calendar'></span>
				                    </span>
				                </div>
				            
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Temperatura (vacia)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='temp_vacia' name='temp_vacia' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Temperatura con tomates</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='temp_con_tomate' name='temp_con_tomate' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Humedad relativa (vacia)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='hr_vacia' name='hr_vacia' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Humedad relativa (con tomate)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='hr_con_tomate' name='hr_con_tomate' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Temperatura del tomate(entrada)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='temp_tomate_entrada' name='temp_tomate_entrada' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Temperatura del tomate (salida)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='temp_tomate_salida' name='temp_tomate_salida' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Temperatura exterior</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='temp_externa' name='temp_externa' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Número de tarimas</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='num_tarimas' name='num_tarimas' value='' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>¿Puerta cerrada?</label>
						<div class='col-sm-8'>
							<select name='puerta_cerrada' id='puerta_cerrada' class='form-control' required>
								<option value='' style='display:none;'>Seleccione una opción</option>
								<option value='1' >Sí</option>
								<option value='2' >No</option>
							</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>¿Lona bien ubicada?</label>
						<div class='col-sm-8'>
							<select name='lona_bien_ubicada' id='lona_bien_ubicada' class='form-control' required>
								<option value='' style='display:none;'>Seleccione una opción</option>
								<option value='1' >Sí</option>
								<option value='2' >No</option>
							</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>¿Equipo 7.5 encendido?</label>
						<div class='col-sm-8'>
							<select name='e_75_encendido' id='e_75_encendido' class='form-control' required>
								<option value='' style='display:none;'>Seleccione una opción</option>
								<option value='1' >Sí</option>
								<option value='2' >No</option>
							</select>
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
	
	    $(function ()
		{
		    $('#datetimepicker1').datetimepicker();
		});
	
</script>
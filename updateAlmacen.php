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
		$material = Almacen_inventario::getById($id);
		//$activos_equipos = Activos_equipos::getAllOrderASC();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".$material->id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Código</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control' id='codigo' name='codigo' value='".$material->codigo."' readonly >
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Descripción</label>
						<div class='col-sm-10'>
							<input type='text' class='form-control' id='descripcion' name='descripcion' value='".sanitize_output($material->descripcion)."' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Unidad</label>
						<div class='col-sm-4'>
							<select class='form-control' id='unidad' name='unidad' required>
								<option value='".$material->unidad."' style='display:none;' selected>".$material->unidad."</option>
								<option value='KG' >KG</option>
								<option value='MTS' >MTS</option>
								<option value='PZA' >PZA</option>
								<option value='ROLLO' >ROLLO</option>
								<option value='TAMBO' >TAMBO</option>
							</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Cantidad mínima</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control' id='cantidad_minima' name='cantidad_minima' value='".$material->cantidad_minima."' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Cantidad máxima</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control' id='cantidad_maxima' name='cantidad_maxima' value='".$material->cantidad_maxima."' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Stock</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control' id='stock' name='stock' value='".$material->stock."' autocomplete='off' >
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Precio unitario</label>
						<div class='col-sm-4'>
							<input type='text' class='form-control' id='precio_unitario' name='precio_unitario' value='".$material->precio_unitario."' autocomplete='off' required>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-2 control-label'>Estatus</label>
						<div class='col-sm-4'>
							<select class='form-control' id='estatus' name='estatus' required>";
							if($material->estatus == 1)
							{
								$str.="<option value='".$material->estatus."' style='display:none;' selected>ACTIVO</option>";
							}
							else
							{
								$str.="<option value='".$material->estatus."' style='display:none;' selected>NO ACTIVO</option>";
							}

							

								$str.="<option value='1' >ACTIVO</option>";
								$str.="<option value='0' >NO ACTIVO</option>";
							$str.="</select>
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
<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$id_categoria = $_GET["id_categoria"];
	$id_almacen = $_GET["id_almacen"];
	$str = "";
	
	if($id > 0)
	{
		$herramientas = Herramientas_herramientas::getById($id);
		//$description_roles = Description_roles::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".sanitize_output($id)."' readonly>
							<input type='number' class='form-control' id='id_categoria' name='id_categoria' value='".sanitize_output($id_categoria)."' readonly>
							<input type='number' class='form-control' id='id_almacen' name='id_almacen' value='".sanitize_output($id_almacen)."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group has-success'>
						<label class='col-sm-4 control-label'>Clave</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='clave' name='clave' value='".sanitize_output($herramientas->clave)."' autocomplete='off' required='required'>
							<span id='helpBlock2' class='help-block'>Ejemplo: Código de barras... 
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Descripción</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='descripcion' name='descripcion' value='".sanitize_output($herramientas->descripcion)."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Precio unitario ($)</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='precio_unitario' name='precio_unitario' value='".$herramientas->precio_unitario."' autocomplete='off' required='required'>
						</div>
				</div>";
	}
	else
	{

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".$id."' readonly>
							<input type='number' class='form-control' id='id_categoria' name='id_categoria' value='".$id_categoria."' readonly>
							<input type='number' class='form-control' id='id_almacen' name='id_almacen' value='".$id_almacen."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group has-success'>
						<label class='col-sm-4 control-label'>Clave</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='clave' name='clave' value='' autocomplete='off' required='required'>
							<span id='helpBlock2' class='help-block'>Ejemplo: Código de barras... 
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Descripción</label>
						<div class='col-sm-8 '>
							
							<input type='text' class='form-control' id='descripcion' name='descripcion' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Precio unitario ($)</label>
						<div class='col-sm-8'>
							
							<input type='text' class='form-control' id='precio_unitario' name='precio_unitario' value='' autocomplete='off' required='required'>
						</div>
				</div>";


		/*$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Almacén</label>
						<div class='col-sm-8'>
							<select class='form-control' name='id_almacen' id='id_almacen' required='required'>
								<option value='' style='display:none;'>Seleccione un Almacén</option>";
								foreach ($herramientas_almacenes as $almacen) 
								{
									$str.="<option value='".$almacen->id."'>".$almacen->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";*/
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
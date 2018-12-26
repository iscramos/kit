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
		$categorias = Herramientas_categorias::getById($id);
		//$description_roles = Description_roles::getAll();

		$herramientas_almacenes = Herramientas_almacenes::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Almacén</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='id_almacen' id='id_almacen' required='required'>";
								
								foreach ($herramientas_almacenes as $almacen) 
								{
									if($almacen->id == $categorias->id_almacen)
									{
										$str.="<option value='".$almacen->id."' style='display:none;' selected='selected'>".$almacen->descripcion."</option>";
									}
									$str.="<option value='".$almacen->id."'>".$almacen->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Categoría</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='categoria' name='categoria' value='".$categorias->categoria."' autocomplete='off' required='required'>
						</div>
				</div>";
	}
	else
	{
		$herramientas_almacenes = Herramientas_almacenes::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Almacén</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='id_almacen' id='id_almacen' required='required'>
								<option value='' style='display:none;'>Seleccione un Almacén</option>";
								foreach ($herramientas_almacenes as $almacen) 
								{
									$str.="<option value='".$almacen->id."'>".$almacen->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Categoría</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='categoria' name='categoria' value='' autocomplete='off' required='required'>
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
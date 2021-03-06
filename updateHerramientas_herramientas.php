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
		$almacenes = Herramientas_almacenes::getById($herramientas->id_almacen);
		$categorias = Herramientas_categorias::getById($herramientas->id_categoria);
		$udm = Herramientas_udm::getAllByOrden("descripcion", "ASC");


		$proveedores = Herramientas_proveedores::getAll();
		//$description_roles = Description_roles::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 col-xs-4 control-label'>ID</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".sanitize_output($herramientas->id)."' readonly>
							<input type='number' class='form-control input-sm' id='id_categoria' name='id_categoria' value='".sanitize_output($herramientas->id_categoria)."' readonly>
							<input type='number' class='form-control input-sm' id='id_almacen' name='id_almacen' value='".sanitize_output($herramientas->id_almacen)."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Imagen</label>
						<div class='col-sm-8 col-xs-8 text-right'>
							<input name='archivo' id='archivo' class='form-control hidden' value='".$herramientas->archivo."'>
							<img class='img-thumbnail' src='".$contentRead.$herramientas->archivo."' height='120px' width='180px'>
						</div>
				</div>";
		$str.="<div class='form-group has-success'>
						<label class='col-sm-4 col-xs-4 control-label'>Clave</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='text' class='form-control input-sm' id='clave' name='clave' value='".sanitize_output($herramientas->clave)."' autocomplete='off' readonly required='required'>
							<span id='helpBlock2' class='help-block'>Ejemplo: Código de barras... 
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Almacén</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".sanitize_output($almacenes->descripcion)."' readonly>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Categoría</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".sanitize_output($categorias->categoria)."' readonly>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Marca</label>
						<div class='col-sm-8 col-xs-8'>
						<select class='form-control' name='id_marca' id='id_marca'>";
						foreach ($proveedores as $proveedor) 
						{
							if($proveedor->id == $herramientas->id_marca)
							{
								$str.="<option value='".$proveedor->id."' selected>".$proveedor->descripcion."</option>";
							}
							$str.="<option value='".$proveedor->id."'>".$proveedor->descripcion."</option>";
						}
						$str.="</select>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Descripción</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='".sanitize_output($herramientas->descripcion)."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Precio unit ($)</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='number' step='0.01'  class='form-control input-sm' id='precio_unitario' name='precio_unitario' value='".$herramientas->precio_unitario."' autocomplete='off' required='required'>
						</div>
				</div>";

		$atributo = "";

		if($herramientas->activaStock > 0)
		{
			$atributo = "checked ";
		}

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Unidad de medida</label>
						<div class='col-sm-8 col-xs-8'>
							<select class='form-control input-sm' name='id_udm' id='id_udm' required='required'>";
								foreach ($udm as $u) 
								{
									if($u->id == $herramientas->id_udm)
									{
										$str.="<option value='".$u->id."' selected>".$u->descripcion."</option>";
									}
									$str.="<option value='".$u->id."'>".$u->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Stock</label>
						<div class='col-sm-8 col-xs-8'>
							<input id='stock' ".$atributo." type='checkbox' name='stock'>
						</div>
				</div>";

	}
	else
	{
		$almacenes = Herramientas_almacenes::getAllByOrden("descripcion", "ASC");
		$categorias = Herramientas_categorias::getAllByOrden("categoria", "ASC");
		$proveedores = Herramientas_proveedores::getAllByOrden("descripcion", "ASC");
		$udm = Herramientas_udm::getAllByOrden("descripcion", "ASC");

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 col-xs-4 control-label'>ID</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='' readonly>
							
						</div>
				</div>";

		$str.="<div class='form-group has-success'>
						<label class='col-sm-4 col-xs-4 control-label'>Clave</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='text' class='form-control input-sm' id='clave' name='clave' value='' autocomplete='off' required='required'>
							<span id='helpBlock2' class='help-block'>Ejemplo: Código de barras... 
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Descripción</label>
						<div class='col-sm-8 col-xs-8 '>
							
							<input type='text' class='form-control input-sm' id='descripcion' name='descripcion' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Precio unit ($)</label>
						<div class='col-sm-8 col-xs-8'>
							
							<input type='number' step='0.01' class='form-control input-sm' id='precio_unitario' name='precio_unitario' value='' autocomplete='off' required='required'>
						</div>
				</div>";

		$str.="<div class='form-group'>
                            <label class='col-sm-4 col-xs-4 control-label' >Imagen de carga</label>
                            <div class='col-sm-8 col-xs-8'>  
                                <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                                <font size='1' color='gray'>(Archivos soportados: JPG, PNG)</font>
                                <p><font size='1' color='red'>Tama&ntilde;o m&aacute;ximo: 5 MB.</font></p>
                            </div>
                        </div>
                        <div class='form-group hidden' id='mensaje'>
                            <label class='col-sm-4 col-xs-4 control-label' ></label>
                            <div class='col-sm-8 col-xs-8 alert alert-danger' role='alert'>
                                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                <span id='ext'></span>
                                <span id='tam'></span>
                            </div>
                        </div>";

        $str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Marca</label>
						<div class='col-sm-8 col-xs-8'>
							<select class='form-control input-sm' name='id_marca' id='id_marca' required='required'>
								<option value='' style='display:none;'>Seleccione una marca</option>";
								foreach ($proveedores as $proveedor) 
								{
									$str.="<option value='".$proveedor->id."'>".$proveedor->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Almacén</label>
						<div class='col-sm-8 col-xs-8'>
							<select class='form-control input-sm' name='id_almacen' id='id_almacen' required='required'>
								<option value='' style='display:none;'>Seleccione un almacén</option>";
								foreach ($almacenes as $almacen) 
								{
									$str.="<option value='".$almacen->id."'>".$almacen->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Categoría</label>
						<div class='col-sm-8 col-xs-8'>
							<select class='form-control input-sm' name='id_categoria' id='id_categoria' required='required'>
								<option value='' style='display:none;'>Seleccione una categoría</option>";
								foreach ($categorias as $categoria) 
								{
									$str.="<option value='".$categoria->id."'>".$categoria->categoria."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Unidad de medida</label>
						<div class='col-sm-8 col-xs-8'>
							<select class='form-control input-sm' name='id_udm' id='id_udm' required='required'>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($udm as $u) 
								{
									$str.="<option value='".$u->id."'>".$u->descripcion."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 col-xs-4 control-label'>Stock</label>
						<div class='col-sm-8 col-xs-8 '>
							<input id='stock' type='checkbox' name='stock'>
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
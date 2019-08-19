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
		$categorias = Herramientas_entradas::getById($id);

		/*$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$categorias->id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Categoría</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='categoria' name='categoria' value='".$categorias->categoria."' autocomplete='off' required='required'>
						</div>
				</div>";*/
	}
	else
	{
		

		/*$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
                        <label class='col-sm-4 control-label'>CLAVE</label>
                        <div class='col-sm-8'>
                            
                            <input type='text' class='typeahead form-control input-sm' data-provide='typeahead' id='clave' name='clave' value='' autocomplete='off' required='required'>
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


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
		$ghs = Zancos_ghs::getById($id);

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$ghs->id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Gh</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='gh' name='gh' value='".$ghs->gh."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Zona</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='zona' name='zona' value='".$ghs->zona."' autocomplete='off' required='required'>
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
						<label class='col-sm-4 control-label'>Gh</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='gh' name='gh' value='' autocomplete='off' required='required'>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Zona</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='zona' name='zona' value='' autocomplete='off' required='required'>
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


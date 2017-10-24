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
		$user = Usuarios::getById($id);
		$description_roles = Description_roles::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".sanitize_output($user->id)."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Nombre</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='name' name='name' value='".sanitize_output($user->name)."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Usuario</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='email' name='email' value='".sanitize_output($user->email)."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Password</label>
						<div class='col-sm-8'>
							<input type='password' class='form-control password' id='password' name='password' value='".sanitize_output(base64_decode($user->password))."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tipo</label>
						<div class='col-sm-8'>
							<select class='form-control' id='type' name='type' required>";
							foreach ($description_roles as $role) 
							{
								if ($role->id == $user->type) 
								{
									$str.="<option value='".$role->id."' style='display:none;' selected='selected'>".$role->description."</option>";
								}
								$str.="<option value='".$role->id."'>".$role->description."</option>";
								
							}
							$str.="</select>
						</div>
				</div>";
	}
	else
	{
		$description_roles = Description_roles::getAll();

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Nombre</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='name' name='name' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Usuario</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control' id='email' name='email' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Password</label>
						<div class='col-sm-8'>
							<input type='password' class='form-control password' id='password' name='password' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Tipo</label>
						<div class='col-sm-8'>
							<select class='form-control' id='type' name='type' required>
								<option value='' style='display:none;'>Seleccione un tipo de usuario</option>";
								foreach ($description_roles as $role) 
								{
									$str.="<option value='".$role->id."'>".$role->description."</option>";
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

<script type="text/javascript">
	$('.password').focus(function () 
    {
       $('.password').attr('type', 'text'); 
    });
</script>
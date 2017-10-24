<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$name = NULL;
$created = NULL;
$updated = NULL;
$email = NULL;
$password = NULL;
$type = NULL;

/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$name = $_POST["name"];
		//$created = date('Y/m/d H:i:s');
		$updated = date('Y/m/d H:i:s');
		$email = $_POST["email"];
		$password = base64_encode($_POST["password"]);
		$type = $_POST["type"];

		// new object
		$user = new Usuarios();
		$user->id = $id;
		$user->name = $name;
		//$user->created = $created;
		$user->updated = $updated;
		$user->email = $email;
		$user->password = $password;
		$user->type = $type;
		$user->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		$name = $_POST["name"];
		$created = date('Y/m/d H:i:s');
		$updated = date('Y/m/d H:i:s');
		$email = $_POST["email"];
		$password = base64_encode($_POST["password"]);
		$type = $_POST["type"];

		// new object
		$user = new Usuarios();
		$user->name = $name;
		$user->created = $created;
		$user->updated = $updated;
		$user->email = $email;
		$user->password = $password;
		$user->type = $type;
		$user->save();
	}
}

redirect_to('indexUsers.php');

?>
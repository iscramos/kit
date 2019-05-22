<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 3 || $_SESSION["type"] == 4 || $_SESSION["type"] == 5 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7 || $_SESSION["type"] == 8 || $_SESSION["type"] == 9) // para administrador, embarque
{
	// Include page view
	require_once(VIEW_PATH.'index.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}


function vistas($vUsuario, $vId, $vCorreo, $cicloEscolar)
{
	$laip = $_SERVER['REMOTE_ADDR'];
	$perfil = "";
	if($perfil=="")
	{
	  if(!(strpos($laip, "148.213.")===FALSE))
	   $perfil="ucol";
	  else
	   $perfil="externo";
	}
	
	if(strpos($laip, "216.129.")===FALSE && strpos($laip, "66.249.")===FALSE) //<-- para evitar registrar las visitas de los robots de google
	{  
		$estadistica = new Estadisticas();
		$estadistica->accion = "entrada";
		$estadistica->fecha = date('Y-m-d H:i:s');
		$estadistica->usuario = $vUsuario;
		$estadistica->idUsuario = $vId;
		$estadistica->correo = $vCorreo;
		$estadistica->ip = $laip;
		$estadistica->perfil = $perfil;
		$estadistica->cicloEscolar = $cicloEscolar;
		$estadistica->save();
	}
}
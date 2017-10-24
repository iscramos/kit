<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

  if( isset($_REQUEST["ano"]) ) 
  {
    $ano = $_REQUEST["ano"];

    traer_historicos($ano); // mandando llamar los históricos por año
  }
  else
  {

    echo "<link href='".$url."vendor/bootstrap/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<div class='col-md-3'></div>";
    echo "<div style='text-align:center; background:#F3D93A;' class='col-md-6'>
            <img src='".$url."dist/img/naturesweet_picture.png'>
            <hr>
            <h4>SOLICITUD NO VÁLIDA, ¿TE HAS PERDIDO?</h4>
          </div>";
    echo "<div class='col-md-3'></div>";
    
    die();
  }

  function traer_historicos($ano) 
  {
    $historico = Mp_mc_historicos::getAllAno($ano);

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($historico, JSON_FORCE_OBJECT);
  }
?>
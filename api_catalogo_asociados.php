<?php

require_once('includes/config.inc.php');
//require_once('includes/inc.session.php');

  if( isset($_REQUEST["asociado"]) ) 
  {
    $asociado = $_REQUEST["asociado"];

    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$asociado;
    $json_asociado = file_get_contents($direccion0);
    $asociadoData = json_decode($json_asociado, true);

    if(count($asociadoData) > 0)
    {
        echo $asociadoData[0]['codigo']."&".$asociadoData[0]['nombre'];
    }
    else
    {
      echo "*NO ENCONTRADO*";
    }

    
    
  }
  else
  {
    echo "*NO ENCONTRADO*";
  }

?>
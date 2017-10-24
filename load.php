<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');



//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";
if( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
	

        $nombre = $_FILES['archivo']['name'];
        $lider = $_REQUEST['lider']; 
        //echo $lider;
      
        $destino = $content; 
      
        $tamano = intval($_FILES['archivo']['size']); 
        
        if($tamano < 10485760)
        {

            if (copy($_FILES['archivo']['tmp_name'],"".$destino.'/'.$nombre))
            {
                $archivo = $nombre;
                redirect_to('indexMonitoreo.php?lider='.$lider.'&actualizado=@');   
            }
            else
            {
                die("Error al subir el archivo");
            }
            
        } 
        else
        {
            die('No se pudo subir el archivo '.$_FILES['archivo']['name'].' Verifique que el archivo no esté abierto y que no exceda el tamaño máximo permitido.');
        }
}
else
{
	echo "NO DATA";
}


//echo $str;
?>
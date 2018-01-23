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
        //echo $lider;
      
        $destino = $content; 
      
        $tamano = intval($_FILES['archivo']['size']); 
        
        if($tamano < 10485760)
        {

            if (copy($_FILES['archivo']['tmp_name'],"".$destino.'/'.$nombre))
            {
                $archivo = $nombre;
                // para la conversion a json

                require_once 'PHPExcel/Classes/PHPExcel.php';
                $archivo = $contentRead."activos.xlsx";
                //echo $archivo;
                $inputFileType = PHPExcel_IOFactory::identify($archivo);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($archivo);
                $sheet = $objPHPExcel->getSheet(0); 
                $highestRow = $sheet->getHighestRow(); 
                $highestColumn = $sheet->getHighestColumn();

                $contenedor[] = array();
                    
                $i = 0;
                $anoActual = date("Y");

                for ($row = 2; $row <= $highestRow; $row++)
                {  
                    $equipo = $sheet->getCell("A".$row)->getValue();
                    $descripcion = $sheet->getCell("B".$row)->getValue();
                    $responsable = $sheet->getCell("C".$row)->getValue();

                   

                    $contenedor[$i] = array(
                                        "equipo"=>$equipo,
                                        "descripcion"=>$descripcion,
                                        "responsable"=>$responsable);
                    $i++;
                    
                }

                //echo json_encode($contenedor);
                /*echo "<pre>";
                print_r($contenedor);
                echo "</pre>";*/

                header('Content-type: application/json; charset=utf-8');
                //echo json_encode($contenedor, JSON_FORCE_OBJECT);

                //Creamos el JSON
                $json_string = json_encode($contenedor);
                $file = $content.'/activos.json';
                file_put_contents($file, $json_string);

                redirect_to('indexAsignadosEquipos.php?actualizado=@');   
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
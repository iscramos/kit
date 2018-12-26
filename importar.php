<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';


//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";
function leo_sanitize($variable)
{
    $regresa = $variable;
    
    $regresa = str_replace("'", "&#39;", $regresa);
    $regresa = str_replace("%", "&#37;", $regresa);
    $regresa = str_replace("?", "&#63;", $regresa);
    $regresa = str_replace('"', "&#34;", $regresa);
    $regresa = str_replace("<", "&lt;", $regresa);
    $regresa = str_replace(">", "&gt;", $regresa);

    return $regresa;
}



if( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $query = "";
    $archivo1 = $_FILES["archivo"]["tmp_name"];
    $tamanio1 = $_FILES["archivo"]["size"];
    $tipo1 = $_FILES["archivo"]["type"];
    $nombre_archivo = "ordenes.xlsx";
    $destino = $content;
    $archivo = $contentRead.$nombre_archivo; 
    //echo $archivo;

    move_uploaded_file($archivo1, "".$destino.'/'.$nombre_archivo);
    
    $objPHPExcel = PHPExcel_IOFactory::load("./".$archivo);
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        $worksheetTitle = $worksheet->getTitle();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;
        if ($worksheetTitle == "Sheet1") {
            for ($row = 2; $row <= $highestRow; $row++) {
                $valores = "(null";
                for ($col = 0; $col <= 17; $col++) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $valor = "";
                    $valor = $cell->getCalculatedValue();
                    //$valor = PHPExcel_Cell_DataType::dataTypeForValue($val);
                    if ($col == 0) {
                        if ($valor != "") {
                            $valor = PHPExcel_Shared_Date::ExcelToPHP($valor);
                            $valor = gmdate("Y-m-d", $valor);
                        } else {
                            $valor = "0000-00-00";
                        }
                    }
                    
                    if (($col == 8) || ($col == 9)) {
                        $valor = PHPExcel_Shared_Date::ExcelToPHP($valor);
                        $valor = gmdate("Y-m-d", $valor);
                    }
                    if (($col >= 13) && ($col <= 15)) {
                        if ($valor != "") {
                            $valor = PHPExcel_Shared_Date::ExcelToPHP($valor);
                            $valor = gmdate("Y-m-d H:i:s", $valor);
                        } else {
                            $valor = "0000-00-00 00:00:00";
                        }
                    }
                    $valores .= ", '$valor'";
                }
                $valores .= ")";
                //echo $valores . " <br>";

                if ($query != "") {
                    $query .= ", ";
                }
                $query .= $valores;
            }
        }
    }

    
   //echo $query;
    //die("Hay hay");

    
    // Execute database query
    $disponibilidad_trunca = new Ordenesots();   
    $disponibilidad_trunca->truncate();    

    $disponibilidad_inserta = new Ordenesots();
    $disponibilidad_inserta->q = $query;
    $disponibilidad_inserta->inserta_dura();


    /*mysqli_query($conMyBD, "insert into data values $query");
    echo mysqli_error($conMyBD);*/

    redirect_to('indexDisponibilidad.php?actualizado=@'); 

}
else
{
    echo "NO DATA";
}


//echo $str;
?>
<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';


//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";

if( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $query = "";
    $archivo1 = $_FILES["archivo"]["tmp_name"];
    $tamanio1 = $_FILES["archivo"]["size"];
    $tipo1 = $_FILES["archivo"]["type"];
    $nombre_archivo = "data.xlsx";

    move_uploaded_file($archivo1, $nombre_archivo);
    
    $objPHPExcel = PHPExcel_IOFactory::load("./" . $nombre_archivo);
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        $worksheetTitle = $worksheet->getTitle();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;
        if ($worksheetTitle == "Sheet1") {
            for ($row = 2; $row <= $highestRow; $row++) {
                $valores = "(null";
                for ($col = 0; $col <= 19; $col++) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $valor = $cell->getCalculatedValue();
                    if (($col == 8) || ($col == 9)) {
                        $valor = PHPExcel_Shared_Date::ExcelToPHP($valor);
                        $valor = gmdate("Y-m-d", $valor);
                    }
                    if (($col >= 12) && ($col <= 14)) {
                        if ($valor != "") {
                            $valor = PHPExcel_Shared_Date::ExcelToPHP($valor);
                            $valor = gmdate("Y-m-d H:i:s", $valor);
                        } else {
                            $valor = "1999-01-01 06:05:20";
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
    // Execute database query
    $disponibilidad_trunca = new Disponibilidad_data();   
    $disponibilidad_trunca->truncate();    

    $disponibilidad_inserta = new Disponibilidad_data();
    $disponibilidad_inserta->q = $query;
    $disponibilidad_inserta->inserta_dura();

    // Para dejar un rastro de la acción
    $fechita = gmdate("Y-m-d H:i:s");
    $tablita = "Disponibilidad_logs";
    $accion = "UPDATE";
    
    $log = new Disponibilidad_logs();
    $log->fecha = $fechita;
    $log->tabla = $tablita;
    $log->accion = $accion;
    
    $log->save();
    /*mysqli_query($conMyBD, "insert into data values $query");
    echo mysqli_error($conMyBD);*/

    redirect_to('indexDisponibilidadData.php?actualizado=@'); 

}
else
{
	echo "NO DATA";
}


//echo $str;
?>
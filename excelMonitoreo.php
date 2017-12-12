<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

require_once 'PHPExcel/Classes/PHPExcel.php';

if(isset($_REQUEST["semanaActual"]))
{
    $archivo = $contentRead."monitoreo.xlsx";
    //echo $archivo;
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    $contenedor[] = array();
        
    $i = 0;
    $semanaActual = $_REQUEST["semanaActual"];
    $anoActual = date("Y");

    for ($row = 2; $row <= $highestRow; $row++)
    {  
        $anoProgramada = $sheet->getCell("J".$row)->getValue();
        $anoProgramada = \PHPExcel_Style_NumberFormat::toFormattedString($anoProgramada, 'YYYY');

        $tipoMantenmiento = $tipo = $sheet->getCell("E".$row)->getValue();


        if( ($sheet->getCell("Q".$row)->getValue() == $semanaActual) && ($anoActual == $anoProgramada) )
        {

        
            $fecha_original_vencimiento_mp = $sheet->getCell("A".$row)->getCalculatedValue();
            $fecha_original_vencimiento_mp = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_original_vencimiento_mp, 'YYYY-MM-DD HH:MM:SS');
            $orden_trabajo = $sheet->getCell("B".$row)->getValue();
            $descripcion = $sheet->getCell("C".$row)->getValue();
            $equipo = $sheet->getCell("D".$row)->getValue();
            $tipo = $sheet->getCell("E".$row)->getValue();
            $estado = $sheet->getCell("F".$row)->getValue();
            $clase = $sheet->getCell("G".$row)->getValue();
            $departamento = $sheet->getCell("H".$row)->getValue();

            $fecha_inicio_programada = $sheet->getCell("I".$row)->getValue();
            $fecha_inicio_programada = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_inicio_programada, 'YYYY-MM-DD HH:MM:SS');

            $fecha_finalizacion_programada = $sheet->getCell("J".$row)->getValue();
            $fecha_finalizacion_programada = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_finalizacion_programada, 'YYYY-MM-DD HH:MM:SS');

            $solicitado = $sheet->getCell("K".$row)->getValue();
            $responsable = $sheet->getCell("L".$row)->getValue();
            $tecnico = $sheet->getCell("M".$row)->getValue();

            $fecha_informe = $sheet->getCell("N".$row)->getValue();
            $fecha_informe = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_informe, 'YYYY-MM-DD HH:MM:SS');
            
            $fecha_inicio = $sheet->getCell("O".$row)->getValue();
            $fecha_inicio = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_inicio, 'YYYY-MM-DD HH:MM:SS');
            
            $fecha_finalizacion = $sheet->getCell("P".$row)->getValue();
            $fecha_finalizacion = \PHPExcel_Style_NumberFormat::toFormattedString($fecha_finalizacion, 'YYYY-MM-DD HH:MM:SS');

            $semana = $sheet->getCell("Q".$row)->getValue();
            $motivo = $sheet->getCell("R".$row)->getValue();
            $horasEstimadas = $sheet->getCell("S".$row)->getValue();

           

            $contenedor[$i] = array("fecha_original_vencimiento_mp"=>$fecha_original_vencimiento_mp, 
                                "orden_trabajo"=>$orden_trabajo,
                                "descripcion"=>$descripcion,
                                "equipo"=>$equipo,
                                "tipo"=>$tipo,
                                "estado"=>$estado,
                                "clase"=>$clase,
                                "departamento"=>$departamento,
                                "fecha_inicio_programada"=>$fecha_inicio_programada,
                                "fecha_finalizacion_programada"=>$fecha_finalizacion_programada,
                                "solicitado"=>$solicitado,
                                "responsable"=>$responsable,
                                "tecnico"=>$tecnico,
                                "fecha_informe"=>$fecha_informe,
                                "fecha_inicio"=>$fecha_inicio,
                                "fecha_finalizacion"=>$fecha_finalizacion,
                                "semana"=>$semana,
                                "motivo"=>$motivo,
                                "horasEstimadas"=>$horasEstimadas);
            $i++;
        }
    }

    //echo json_encode($contenedor);
    /*echo "<pre>";
    print_r($contenedor);
    echo "</pre>";*/

    header('Content-type: application/json; charset=utf-8');
    echo json_encode($contenedor, JSON_FORCE_OBJECT);

    //Creamos el JSON
    $json_string = json_encode($contenedor);
    $file = $content.'/monitoreo.json';
    file_put_contents($file, $json_string);
}
else
{
    redirect_to('index.php');
}


?>
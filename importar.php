<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

require_once 'PHPExcel/Classes/PHPExcel.php';


//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";
if( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
	 
    extract($_POST);
    $vaciar = new Ordenesots();
    $vaciar->tablita = "ordenesots";
    $vaciar->truncate();    
    
    //cargamos el archivo al servidor con el mismo nombre
    //solo le agregue el sufijo bak_ 
    $nombre = $_FILES['archivo']['name'];
    $nombre = "ordenes.xlsx";
 
    $destino = $content; 
      
    $tamano = intval($_FILES['archivo']['size']); 
    
    if($tamano < 10485760)
    {

        if (copy($_FILES['archivo']['tmp_name'],"".$destino.'/'.$nombre))
        {
            echo "Archivo Cargado Con Éxito";  
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

    $archivo = $contentRead.$nombre;
    //echo $archivo;
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    $contenedor[] = array();
        
    $i = 0;

    for ($row = 2; $row <= $highestRow; $row++)
    {  
        $anoProgramada = $sheet->getCell("J".$row)->getValue();
        $anoProgramada = \PHPExcel_Style_NumberFormat::toFormattedString($anoProgramada, 'YYYY');

        $tipoMantenmiento = $tipo = $sheet->getCell("E".$row)->getValue();

        
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
                            "motivo"=>$motivo);
        $i++;
    }

    
    
  
    foreach ($contenedor as $registro) 
    {
        $fecha_original_vencimiento_mp = NULL;
        $orden_trabajo = NULL;
        $descripcion = NULL;
        $equipo = NULL;
        $tipo = NULL;
        $estado = NULL;
        $clase = NULL;
        $departamento = NULL;
        $fecha_inicio_programada = NULL;
        $fecha_finalizacion_programada = NULL;
        $solicitado = NULL;
        $responsable = NULL;
        $tecnico = NULL;
        $fecha_informe = NULL;
        $fecha_inicio = NULL;
        $fecha_finalizacion = NULL;
        $semana = NULL;
        $motivo = NULL;

        $fecha_original_vencimiento_mp = $registro['fecha_original_vencimiento_mp']; 
        $orden_trabajo = $registro['orden_trabajo']; 
        $descripcion = $registro['descripcion'];
        $equipo = $registro['equipo']; 
        $tipo = $registro['tipo'];
        $estado = $registro['estado'];
        $clase = $registro['clase'];
        $departamento = $registro['departamento'];
        $fecha_inicio_programada = $registro['fecha_inicio_programada'];
        $fecha_finalizacion_programada = $registro['fecha_finalizacion_programada'];
        $solicitado = $registro['solicitado'];
        $responsable = $registro['responsable'];
        $tecnico = $registro['tecnico'];
        $fecha_informe = $registro['fecha_informe'];
        $fecha_inicio = $registro['fecha_inicio'];
        $fecha_finalizacion = $registro['fecha_finalizacion'];  
        $semana = $registro['semana'];
        $motivo = $registro['motivo'];

        $orden = new Ordenesots();

        $orden->fecha_original_vencimiento_mp = $fecha_original_vencimiento_mp;
        $orden->orden_trabajo = $orden_trabajo;
        $orden->descripcion = $descripcion;
        $orden->equipo = $equipo;
        $orden->tipo = $tipo;
        $orden->estado = $estado;
        $orden->clase = $clase;
        $orden->departamento = $departamento;
        $orden->fecha_inicio_programada = $fecha_inicio_programada;
        $orden->fecha_finalizacion_programada = $fecha_finalizacion_programada;
        $orden->solicitado = $solicitado;
        $orden->responsable = $responsable;
        $orden->tecnico = $tecnico;
        $orden->fecha_informe = $fecha_informe;
        $orden->fecha_inicio = $fecha_inicio;
        $orden->fecha_finalizacion = $fecha_finalizacion;
        $orden->semana = $semana;
        $orden->motivo = $motivo;

        $orden->save();
    }

    redirect_to('indexDisponibilidad.php?actualizado=@');                   
            
}
else
{
	echo "NO DATA";
}


//echo $str;
?>
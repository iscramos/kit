<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if( ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$fechaInicio = $_GET['fechaInicio'];
	$fechaFinalizacion = $_GET['fechaFinalizacion'];
	$lider = $_GET['lider'];
	$tipo = $_GET['tipo'];

	$adicional = "";
	if ($tipo == "totalMP") 
	{
		$adicional = " AND ordenesots.tipo='Mant. preventivo' 
		AND (ordenesots.estado = 'Cerrado sin ejecutar'
		 	OR ordenesots.estado = 'Cierre Lider Mtto'
		 	OR ordenesots.estado = 'Ejecutado'
		 	OR ordenesots.estado = 'Espera de equipo'
		 	OR ordenesots.estado = 'Espera de refacciones'
		 	OR ordenesots.estado = 'Programada' 
		 	OR ordenesots.estado = 'Terminado' )";
	}
	elseif ($tipo == "terminadoMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado='Terminado' ";
		$adicional = "AND ordenesots.tipo='Mant. preventivo'
		 AND (ordenesots.estado='Terminado'
		 OR ordenesots.estado = 'Cerrado sin ejecutar')";
	}
	elseif ($tipo == "pendienteMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado <> 'Terminado' ";
		$adicional = "AND ordenesots.tipo='Mant. preventivo'
		 AND (ordenesots.estado = 'Programada' 
		 		OR ordenesots.estado = 'Cierre Lider Mtto'
		 		OR ordenesots.estado = 'Ejecutado'
		 		OR ordenesots.estado = 'Espera de equipo'
		 		OR ordenesots.estado = 'Espera de refacciones')
		 AND  ordenesots.estado <> 'Cancelado'";
		
	}
	elseif ($tipo == "otrosMP") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (ordenesots.tipo='Mant. preventivo')
		 AND (ordenesots.estado = 'Cancelado'
		 		OR ordenesots.estado = 'Rechazado'
		 		OR ordenesots.estado = 'Solic. de trabajo') ";

	}


	elseif ($tipo == "totalMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR  tipo='Correctivo planeado')";*/
		$adicional = " AND (ordenesots.tipo='Correctivo planeado' OR ordenesots.tipo='Correctivo de emergencia')
		 AND (ordenesots.estado = 'Cerrado sin ejecutar'
		 	OR ordenesots.estado = 'Cierre Lider Mtto'
		 	OR ordenesots.estado = 'Ejecutado'
		 	OR ordenesots.estado = 'Espera de equipo'
		 	OR ordenesots.estado = 'Espera de refacciones'
		 	OR ordenesots.estado = 'Programada' 
		 	OR ordenesots.estado = 'Terminado' )";
	}
	elseif ($tipo == "terminadoMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado='Terminado' ";*/
		$adicional = " AND (ordenesots.tipo='Correctivo planeado' OR ordenesots.tipo='Correctivo de emergencia')
		 AND (ordenesots.estado = 'Terminado'
		 	OR ordenesots.estado = 'Cerrado sin ejecutar') ";
	}
	elseif ($tipo == "pendienteMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (ordenesots.tipo='Correctivo planeado' OR ordenesots.tipo='Correctivo de emergencia')
		 AND (ordenesots.estado = 'Programada' 
		 		OR ordenesots.estado = 'Cierre Lider Mtto'
		 		OR ordenesots.estado = 'Ejecutado'
		 		OR ordenesots.estado = 'Espera de equipo'
		 		OR ordenesots.estado = 'Espera de refacciones')
		 AND  ordenesots.estado <> 'Cancelado' ";
	}
	elseif ($tipo == "otrosMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (ordenesots.tipo='Correctivo planeado' OR ordenesots.tipo='Correctivo de emergencia')
		 AND (ordenesots.estado = 'Cancelado'
		 		OR ordenesots.estado = 'Rechazado'
		 		OR ordenesots.estado = 'Solic. de trabajo') ";

	}

	$consulta = "";
 	/*$consulta = "SELECT * FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 $adicional
		 AND responsable=$lider";*/

	$consulta = "SELECT ordenesots.*, activos_equipos.nombre_equipo  
 				FROM ordenesots
 				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
 				WHERE
		 ( ordenesots.fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 $adicional
		 AND ordenesots.responsable=$lider";

		 //echo $consulta;

	$ordenes = Ordenesots::getAllConsulta($consulta);
		 

	$str.="<table class='table table-bordered table-hover pagina' style='font-size: 11px;'>
			<thead class='bg-primary'>";
			$str.="<tr >";
				$str.="<th >OT</th>
						<th>DESCRIPCIÓN</th>
						<th>EQUIPO</th>
						<th>CLASE</th>
						<!--th>DEPARTAMENTO</th-->";

						/*if($tipo == "pendienteMP" || $tipo == "pendienteMC")
						{
							$str.="<th>ESTADO</th>";
						}*/
						$str.="<th>ESTADO</th>";
						$str.="<th>PROGRAMADA</th>
						<th>FINALIZADA</th>
						<th>MOTIVO</th>";
			$str.="</tr>
			</thead>
			</tbody>";

			foreach ($ordenes as $orden) 
			{
				$str.="<tr>";
					$str.="<th >".$orden->orden_trabajo."</th>";
					$str.="<td >".utf8_encode($orden->descripcion)."</td>";
					$str.="<td >".$orden->equipo."</td>";
					$str.="<td >".$orden->clase."</td>";
					//$str.="<td >".$orden->departamento."</td>";
					
					/*if($tipo == "pendienteMP" || $tipo == "pendienteMC")
					{
						$str.="<td >".$orden->estado."</td>";
					}*/
					$str.="<td >".$orden->estado."</td>";

					$str.="<td >".$orden->fecha_inicio_programada."</td>";
					$str.="<td >".$orden->fecha_finalizacion."</td>";
					$str.="<td >".$orden->motivo."</td>";
				$str.="</tr>";
			}
	$str.="</tbody>
			</table>";

		

}
else
{
	$str.="NO DATA";
}


echo $str;


?>

<script type="text/javascript">
	$('.pagina').DataTable({
                responsive: true,
                "language":{
                    "oPaginate": {
                        "sNext" : "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "search": "Buscar ",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                    "lengthMenu": "_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)"
                }
            });
</script>


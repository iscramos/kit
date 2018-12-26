<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if( ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7 || $_SESSION["type"] == 4)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$fechaInicio = $_GET['fechaInicio'];
	$fechaFinalizacion = $_GET['fechaFinalizacion'];
	$tipo = $_GET['tipo'];

	$adicional = "";
	if ($tipo == "totalMP") 
	{
		$adicional = " AND disponibilidad_data.tipo = 'Mant. preventivo' 
		AND (disponibilidad_data.estado = 'Cierre Lider Mtto'
		 	OR disponibilidad_data.estado = 'Ejecutado'
		 	OR disponibilidad_data.estado = 'Espera de equipo'
		 	OR disponibilidad_data.estado = 'Espera de refacciones'
		 	OR disponibilidad_data.estado = 'Abierta'
		 	OR disponibilidad_data.estado = 'Falta de mano de obra'
		 	OR disponibilidad_data.estado = 'Condiciones ambientales'
		 	OR disponibilidad_data.estado = 'Programada' 
		 	OR disponibilidad_data.estado = 'Terminado' )";
	}
	elseif ($tipo == "terminadoMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado='Terminado' ";
		$adicional = "AND disponibilidad_data.tipo = 'Mant. preventivo'
		 AND (disponibilidad_data.estado = 'Terminado')";
	}
	elseif ($tipo == "pendienteMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado <> 'Terminado' ";
		$adicional = " AND disponibilidad_data.tipo='Mant. preventivo'
		 AND (disponibilidad_data.estado = 'Programada' 
		 		OR disponibilidad_data.estado = 'Cierre Lider Mtto'
		 		OR disponibilidad_data.estado = 'Ejecutado'
		 		OR disponibilidad_data.estado = 'Espera de equipo'
		 		OR disponibilidad_data.estado = 'Espera de refacciones'
		 		OR disponibilidad_data.estado = 'Falta de mano de obra'
		 		OR disponibilidad_data.estado = 'Condiciones ambientales'
		 		OR disponibilidad_data.estado = 'Solic. de trabajo'
		 		OR disponibilidad_data.estado = 'Abierta')";
		
	}
	elseif ($tipo == "otrosMP") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (disponibilidad_data.tipo='Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cancelado'
		 		OR disponibilidad_data.estado = 'Rechazado'
		 		OR disponibilidad_data.estado = 'Cerrado sin ejecutar') ";

	}


	elseif ($tipo == "totalMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR  tipo='Correctivo planeado')";*/
		$adicional = " AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cierre Lider Mtto'
		 	OR disponibilidad_data.estado = 'Ejecutado'
		 	OR disponibilidad_data.estado = 'Espera de equipo'
		 	OR disponibilidad_data.estado = 'Espera de refacciones'
		 	OR disponibilidad_data.estado = 'Falta  de mano de obra'
		 	OR disponibilidad_data.estado = 'Condiciones ambientales'
		 	OR disponibilidad_data.estado = 'Programada' 
		 	OR disponibilidad_data.estado = 'Terminado'
		 	OR disponibilidad_data.estado = 'Solic. de trabajo'
		 	OR disponibilidad_data.estado = 'Abierta' )";
	}
	elseif ($tipo == "terminadoMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado='Terminado' ";*/
		$adicional = " AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Terminado') ";
	}
	elseif ($tipo == "pendienteMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Programada' 
		 		OR disponibilidad_data.estado = 'Cierre Lider Mtto'
		 		OR disponibilidad_data.estado = 'Ejecutado'
		 		OR disponibilidad_data.estado = 'Espera de equipo'
		 		OR disponibilidad_data.estado = 'Espera de refacciones'
		 		OR disponibilidad_data.estado = 'Falta de mano de obra'
		 		OR disponibilidad_data.estado = 'Condiciones ambientales'
		 		OR disponibilidad_data.estado = 'Solic. de trabajo'
		 		OR disponibilidad_data.estado = 'Abierta')";
	}
	elseif ($tipo == "otrosMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cancelado'
		 		OR disponibilidad_data.estado = 'Rechazado'
		 		OR disponibilidad_data.estado = 'Cerrado sin ejecutar') ";

	}

	$consulta = "";
 	$consulta = "SELECT disponibilidad_data.*  
 				FROM disponibilidad_data
 				INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
 				WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 $adicional";

		 //echo $consulta;

	$ordenes = Disponibilidad_data::getAllByQuery($consulta);
		 

	$str.="<table class='table table-bordered table-condensed table-hover dataTables_wrapper jambo_table bulk_action pagina' style='font-size: 11px;'>
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
						$str.="<th>LIMITE</th>
						<th>CIERRE</th>
						<th>MOTIVO</th>
						<th>LIDER</th>";
			$str.="</tr>
			</thead>
			</tbody>";

			foreach ($ordenes as $orden) 
			{
				$fecha_fin_tecnico = "";
				if($orden->fecha_finalizacion != null)
				{
					$fecha_fin_tecnico = date("d-M", strtotime($orden->fecha_finalizacion));
				}

				$str.="<tr>";
					$str.="<th >".$orden->ot."</th>";
					$str.="<td >".utf8_encode($orden->descripcion)."</td>";
					$str.="<td >".$orden->equipo."</td>";
					$str.="<td >".$orden->clase."</td>";
					//$str.="<td >".$orden->departamento."</td>";
					
					/*if($tipo == "pendienteMP" || $tipo == "pendienteMC")
					{
						$str.="<td >".$orden->estado."</td>";
					}*/
					$str.="<td >".$orden->estado."</td>";
					
					$str.="<td class='bg-success'>".date("d-M", strtotime($orden->fecha_finalizacion_programada))."</td>";
					$str.="<td >".$fecha_fin_tecnico."</td>";
					$str.="<td >".$orden->motivo."</td>";
					$str.="<td >".$orden->responsable."</td>";
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


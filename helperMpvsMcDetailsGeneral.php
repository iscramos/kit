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
		$adicional = " AND tipo='Mant. preventivo'
				AND (estado = 'Cierre Lider Mtto'
					 	OR estado = 'Ejecutado'
					 	OR estado = 'Espera de equipo'
					 	OR estado = 'Espera de refacciones'
					 	OR estado = 'Abierta'
					 	OR estado = 'Falta de mano de obra'
					 	OR estado = 'Programada' 
					 	OR estado = 'Terminado' )";
	}
	elseif ($tipo == "terminadoMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado='Terminado' ";
		$adicional = " AND tipo='Mant. preventivo'
		 AND (estado='Terminado')";
	}
	elseif ($tipo == "pendienteMP") 
	{
		//$adicional = " AND tipo='Mant. preventivo' AND estado <> 'Terminado' ";
		$adicional = " AND tipo='Mant. preventivo'
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto'
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Solic. de trabajo'
		 		OR estado = 'Abierta')";
		
	}
	elseif ($tipo == "otrosMP") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (tipo='Mant. preventivo')
		 AND (estado = 'Cancelado'
		 		OR estado = 'Rechazado'
		 		OR estado = 'Cerrado sin ejecutar')";

	}


	elseif ($tipo == "totalMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR  tipo='Correctivo planeado')";*/
		$adicional = " AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cierre Lider Mtto'
		 	OR estado = 'Ejecutado'
		 	OR estado = 'Espera de equipo'
		 	OR estado = 'Espera de refacciones'
		 	OR estado = 'Falta  de mano de obra'
		 	OR estado = 'Programada' 
		 	OR estado = 'Terminado'
		 	OR estado = 'Solic. de trabajo'
		 	OR estado = 'Abierta' )";
	}
	elseif ($tipo == "terminadoMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado='Terminado' ";*/
		$adicional = " AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Terminado') ";
	}
	elseif ($tipo == "pendienteMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto'
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Solic. de trabajo'
		 		OR estado = 'Abierta') ";
	}
	elseif ($tipo == "otrosMC") 
	{
		/*$adicional = " AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND estado <> 'Terminado' ";*/
		$adicional = " AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cancelado'
		 		OR estado = 'Rechazado'
		 		OR estado = 'Cerrado sin ejecutar') ";

	}

	$consulta = "";
 	$consulta = "SELECT * FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 $adicional ORDER BY responsable ASC";

		 //echo $consulta;

	$ordenes = Ordenesots::getAllConsulta($consulta);
		 

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
						<th>Líder</th>";
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


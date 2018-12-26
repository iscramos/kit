<?php
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$pdf = "";

if(isset($_REQUEST["parametro"]))
{

	$parametro = $_REQUEST['parametro'];
	
	if($parametro == "SEGREGACION")
	{
		if(isset($_REQUEST['departamento']) && isset($_REQUEST['semana']) && isset($_REQUEST['fecha']) && isset($_REQUEST['captura']) && isset($_REQUEST['lider']) && isset($_REQUEST['ano']) )
		{
			$departamento = $_REQUEST["departamento"];
			$semana = $_REQUEST["semana"];
			$fecha = date("d/m/Y", strtotime($_REQUEST["fecha"]));
			$captura = $_REQUEST["captura"];
			$lider = $_REQUEST["lider"];
			$ano = $_REQUEST["ano"];

			$semanaActual = "0";
			$inicio = "";
			$fin = "";
			$nombreResponsable = "";
			

			$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
		    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);
		    $inicio = $min_calendario[0]->dia;
		   	$fin = $max_calendario[0]->dia;

			$pdf.="<table style='text-align:center;' border='0'>
				      	<tr>
				          <th width='900' colspan='6' style='font-size:16px;'><i>NATURESWEET PLANTA COLIMA</i></th>
				        </tr>
				        <tr>
				          <th width='100'><img style='width:70; ' src='".$url."dist/img/naturesweet_picture.png'></th> 
				          <th width='700' colspan='4'  style='font-size:11px;'>CONTROL DE ACTIVIDADES POR ZONA DE MANTENIMIENTO CORRECTIVO</th>
				          <td width='100'><img style='width:100; ' src='".$url."dist/img/autoliberado.png'></td>
				        </tr>
				        <tr>
				          <th width='100'></th> 
				          <th width='150'>DEPARTAMENTO: </th>
				          <td width='550' colspan='3' ><u>".$departamento."</u></td>
				          <td width='100'></td>
				        </tr>
				        <tr>
				          <th width='100'></th> 
				          <th width='150' >SEMANA: </th>
				          <td width='200' ><u>".$semana."</u></td>
				          <th width='150'>FECHA: </th>
				          <td width='200' ><u>".$fecha."</u></td>
				          <td width='100'></td>
				        </tr>
			      	</table>";
			$pdf.="<br>";
			if($lider == 41185)
			{
				$departamento = "MECANICO Y SOLDADURA";
				$nombreResponsable = "ORFANEL RENDON RAMIREZ";
			}
			if($lider == 239)
			{
				$departamento = "HIDROELECTRICO";
				$nombreResponsable = "ORFANEL RENDON RAMIREZ";
			}

			$consulta = "SELECT disponibilidad_data.*, disponibilidad_activos.activo, disponibilidad_activos.zona_segregacion
							 FROM disponibilidad_data
							 INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
							WHERE disponibilidad_data.fecha_finalizacion_programada 
							BETWEEN '$inicio' 
								AND '$fin'
								AND disponibilidad_data.responsable = $lider
								AND disponibilidad_data.tipo <> 'Mant. preventivo'
								AND (disponibilidad_data.estado = 'Ejecutado'
									OR disponibilidad_data.estado = 'Terminado')
							ORDER BY disponibilidad_data.ot DESC";

							//echo $consulta."<br>";

			$ordenes = Disponibilidad_data::getAllByQuery($consulta);

			//print_r($segregaciones);
			
			
				
				$pdf.="<table class='table' style='width:900; font-size:14px; text-align:center; border-collapse:collapse;' border='1'>";
					$pdf.="<thead>";
						$pdf.="<tr>
				          		<td width='900' colspan='9' style='font-size:11px;'>HORAS TRABAJADAS</td>
				        	</tr>";
						$pdf.="<tr >";
							$pdf.="<th style='width:100; height:30; background-color:#465467; color:white;'>ZONAS</th> 
									<th style='width:100; background-color:#465467; color:white;'>DOMINGO</th>  
									<th style='width:100; background-color:#465467; color:white;'>LUNES</th> 
									<th style='width:100; background-color:#465467; color:white;'>MARTES</th> 
									<th style='width:100; background-color:#465467; color:white;'>MIERCOLES</th> 
									<th style='width:100; background-color:#465467; color:white;'>JUEVES</th> 
									<th style='width:100; background-color:#465467; color:white;'>VIERNES</th> 
									<th style='width:100; background-color:#465467; color:white;'>SABADO</th> 
									<th style='width:100; background-color:#465467; color:white;'>TOTAL</th>";
						$pdf.="</tr>";
					$pdf.="</thead>";
					$pdf.="<tbody>";

						$dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
						//$nombreDiaHoy = $dias[date('w', pdftotime($diaHoy))];

						$sumaZonaNorte = 0;
						$sumaZonaSur = 0;
						$sumatotal = 0;
						foreach ($zonas_norte as $norte) 
						{
							$dom = 0;
							$lun = 0;
							$mar = 0;
							$mie = 0;
							$jue = 0;
							$vie = 0;
							$sab = 0;

							foreach ($ordenes as $ot) 
							{
								if($norte == $ot->zona_segregacion)
								{
									$diaCompara = $dias[date('w', strtotime($ot->fecha_finalizacion_programada))];
									if($norte == "AREAS COMUNES" && $ot->horas_estimadas > 0)
									{
										
										if($diaCompara == "DOMINGO")
										{
											$dom = $dom + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "LUNES")
										{
											$lun = $lun + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "MARTES")
										{
											$mar = $mar + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "MIERCOLES")
										{
											$mie = $mie + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "JUEVES")
										{
											$jue = $jue + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "VIERNES")
										{
											$vie = $vie + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "SABADO")
										{
											$sab = $sab + ($ot->horas_estimadas / 2 );
										}
									}
									else
									{
										if($diaCompara == "DOMINGO")
										{
											$dom = $dom + $ot->horas_estimadas;
										}
										if($diaCompara == "LUNES")
										{
											$lun = $lun + $ot->horas_estimadas;
										}
										if($diaCompara == "MARTES")
										{
											$mar = $mar + $ot->horas_estimadas;
										}
										if($diaCompara == "MIERCOLES")
										{
											$mie = $mie + $ot->horas_estimadas;
										}
										if($diaCompara == "JUEVES")
										{
											$jue = $jue + $ot->horas_estimadas;
										}
										if($diaCompara == "VIERNES")
										{
											$vie = $vie + $ot->horas_estimadas;
										}
										if($diaCompara == "SABADO")
										{
											$sab = $sab + $ot->horas_estimadas;
										}
									}
								}
							}
							$subtotalZona = $dom + $lun + $mar + $mie + $jue + $vie + $sab;
							$sumaZonaNorte = $sumaZonaNorte + $subtotalZona;
							$pdf.="<tr>";
								$pdf.="<td>".$norte."</td> <td>".$dom."</td> <td>".$lun."</td> <td>".$mar."</td> <td>".$mie."</td> <td>".$jue."</td> <td>".$vie."</td> <td>".$sab."</td> <td>".$subtotalZona."</td>";
							$pdf.="</tr>";
						}
						$pdf.="<tr style='background-color:#DDF1D7;'>";
								$pdf.="<td colspan='8' style='text-align:right;'><b>SUMA ZONA NORTE</b></td>  <td><b>".$sumaZonaNorte."</b></td>";
						$pdf.="</tr>";
						foreach ($zonas_sur as $sur) 
						{
							$dom = 0;
							$lun = 0;
							$mar = 0;
							$mie = 0;
							$jue = 0;
							$vie = 0;
							$sab = 0;

							foreach ($ordenes as $ot) 
							{
								if($sur == $ot->zona_segregacion)
								{
									$diaCompara = $dias[date('w', strtotime($ot->fecha_finalizacion_programada))];
									if($sur == "AREAS COMUNES" && $ot->horas_estimadas > 0)
									{
										if($diaCompara == "DOMINGO")
										{
											$dom = $dom + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "LUNES")
										{
											$lun = $lun + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "MARTES")
										{
											$mar = $mar + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "MIERCOLES")
										{
											$mie = $mie + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "JUEVES")
										{
											$jue = $jue + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "VIERNES")
										{
											$vie = $vie + ($ot->horas_estimadas / 2 );
										}
										if($diaCompara == "SABADO")
										{
											$sab = $sab + ($ot->horas_estimadas / 2 );
										}
									}
									else
									{
										if($diaCompara == "DOMINGO")
										{
											$dom = $dom + $ot->horas_estimadas;
										}
										if($diaCompara == "LUNES")
										{
											$lun = $lun + $ot->horas_estimadas;
										}
										if($diaCompara == "MARTES")
										{
											$mar = $mar + $ot->horas_estimadas;
										}
										if($diaCompara == "MIERCOLES")
										{
											$mie = $mie + $ot->horas_estimadas;
										}
										if($diaCompara == "JUEVES")
										{
											$jue = $jue + $ot->horas_estimadas;
										}
										if($diaCompara == "VIERNES")
										{
											$vie = $vie + $ot->horas_estimadas;
										}
										if($diaCompara == "SABADO")
										{
											$sab = $sab + $ot->horas_estimadas;
										}
									}
								}
							}
							$subtotalZona = $dom + $lun + $mar + $mie + $jue + $vie + $sab;
							$sumaZonaSur = $sumaZonaSur + $subtotalZona;
							$pdf.="<tr >";
								$pdf.="<td>".$sur."</td> <td>".$dom."</td> <td>".$lun."</td> <td>".$mar."</td> <td>".$mie."</td> <td>".$jue."</td> <td>".$vie."</td> <td>".$sab."</td> <td>".$subtotalZona."</td>";
							$pdf.="</tr>";
						}
						$pdf.="<tr style='background-color:#DDF1D7;'>";
								$pdf.="<td colspan='8' style='text-align:right;'><b>SUMA ZONA SUR</b></td>  <td><b>".$sumaZonaSur."</b></td>";
						$pdf.="</tr>";

						$sumatotal = $sumaZonaNorte + $sumaZonaSur;
						$pdf.="<tr style='background-color:#DDF1D7;'>";
								$pdf.="<td colspan='8' style='text-align:right;'><b>SUMA ZONAS</b></td>  <td><b>".$sumatotal."</b></td>";
						$pdf.="</tr>";
					$pdf.="</tbody>";
				$pdf.="</table>";


				$pdf.="<br><br><br>
						<table style='text-align:center; font-size:11;' border='0'>
				      	<tr>
				          <th width='900' colspan='5' style='font-size:16px;'></th>
				        </tr>
				        <tr>
				          <td width='200'></td> 
				          <th width='200'>______________________________</th>
				          <th width='100'></th>
				          <th width='200'>______________________________</th>
				          <td width='200'></td>
				        </tr>
				        <tr>
				          <td width='200'></td> 
				          <th width='200'>Capturó</th>
				          <th width='100'></th>
				          <th width='200'>Validó</th>
				          <td width='200'></td>
				        </tr>
				        <tr>
				          <td width='200'></td> 
				          <th width='200'>".$captura."</th>
				          <th width='100'></th>
				          <th width='200'>".$nombreResponsable."</th>
				          <td width='200'></td>
				        </tr>
			      	</table>";

			require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
			ob_start();
			$contentFinal="<page backtop='15mm' backbottom='15mm' backleft='20mm' backright='20mm'>
			  <page_header > 

			  </page_header> 
			  <page_footer>  
			        <!--table  >
			          <tr >
			              P&aacute;gina [[page_cu]]/[[page_nb]]
			            
			          </tr>
			        </table--> 

			       
			  </page_footer>".$pdf."</page>";


				  /*echo $contentFinal;
				  die();*/

				try
				{

				    $content = ob_get_clean(); 
				    $html2pdf = new HTML2PDF('L', 'A4', 'fr');
				    $html2pdf->pdf->SetDisplayMode('fullpage');
				    $html2pdf->writeHTML($contentFinal, isset($_GET['vuehtml']));
				    $html2pdf->Output($parametro.".pdf","false"); 
				}
				catch(HTML2PDF_exception $e) 
				{
				    echo $e;
				    exit;
				}
		}
		else
		{
			$pdf.="NO DATA";
		}
	}
}		
else
{
	echo "NO DATA";
}




?>
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
	if($parametro == "SISPA")
		{
			
			if(isset($_REQUEST['semana']) && isset($_REQUEST['fecha']) && isset($_REQUEST['realizo']) && isset($_REQUEST['supervisor']) && isset($_REQUEST['ano']) && isset($_REQUEST['observacion']) )
			{
				$semana = $_REQUEST["semana"];
				$fecha = date("d/m/Y", strtotime($_REQUEST["fecha"]));
				$realizo = $_REQUEST["realizo"];
				$supervisor = $_REQUEST["supervisor"];
				$ano = $_REQUEST["ano"];
				$observacion = $_REQUEST["observacion"];

				$inicio = "";
				$fin = "";
				

				$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
			    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);
			    $fechasDias = Disponibilidad_calendarios::getDaysBySemanaAno($semana, $ano);
			    $inicio = $min_calendario[0]->dia;
			   	$fin = $max_calendario[0]->dia;

			   	$consulta = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
											OR activo LIKE 'CO-COM%'
											OR activo LIKE 'CO-POZ%'
											AND organizacion = 'COL' ORDER BY activo ASC";
				$equipos = Disponibilidad_activos::getAllByQuery($consulta);

				$pdf.="<table style=' border-collapse:collapse;' border='0'>
					      	<tr>
					          <th width='900' colspan='9' style='font-size:12px; text-align:center;'>NatureSweet Invernaderos S. de R.L. de C.V.</th>
					        </tr>
					        <tr>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					        	<th width='100' style='text-align:right;'> </th>
					          	<th width='100' style='text-align:right; font-size:12px;'>FECHA: </th>
					          	<td width='100' style='font-size:12px; text-align:right; border-bottom:1 solid black;'>".$fecha."</td>
					        </tr>
					       	<tr>
					          <td width='400' colspan='4' style='text-align:center; font-size:12px;'>Planta Colima </td>
					          <td width='200' colspan='2' style='font-size:12px; text-align:left;'><b>SAC-FO-GM-048</b></td>
					          <td width='100' style='text-align:center;'></td>
					          <td width='100' style='text-align:center;'></td>
					          <td width='100' style='text-align:center;'></td>
					        </tr>
					        <tr>
					        	<td width='100' style='text-align:center;'></td>
					        	<td width='100' style='text-align:center;'></td>
					          <td width='100'  style='text-align:center;'></td>
					          <td width='100' style='text-align:center;'></td>
					          <td width='100' style='text-align:center; font-size:12px;'>Ver. 2</td>
					          <td width='100' style='text-align:center;'></td>
					          <td width='100' style='text-align:center;'></td>
					          <td width='100' style='text-align:right; font-size:12px;'><b> SEMANA: </b></td>
					          <td width='100' style='font-size:12px; text-align:right; border-bottom:1 solid black;'>".$semana."</td>
					        </tr>
					        <tr>
					          <td width='100'><img style='width:120;' src='".$url."dist/img/naturesweet_picture.png'></td> 
					          <td width='700' colspan='7'  style='font-size:14px; text-align:center;'>FORMATO DE TOMA DE LECTURAS DEL CONSUMO DE AGUA EN LA PLANTA</td>
					          <td width='100'> </td>
					        </tr>
				      	</table>";
				$pdf.="<br>";

				$consulta = "SELECT * 
						FROM bd_rebombeo 
							WHERE tipo = 3
								AND ( DATE(fechaLectura) BETWEEN '".$inicio."' AND '".$fin."')";

				$mediciones = Disponibilidad_data::getAllByQuery($consulta);

				//print_r($segregaciones);
				
				
					
			$pdf.="<table style='font-size:12px; border-collapse:collapse;'  border='1'>";
				$pdf.="<thead>";
				$pdf.="<tr>";
							$pdf.="<td width='200'  colspan='2'  rowspan='2' style='text-align:right;'>FECHA </td>
					          <td width='700' colspan='7' style='font-size:12px; text-align:center;'><b>TOMA DE LECTURAS</b></td>";
					$pdf.="</tr>";
					$pdf.="<tr>";
					foreach ($fechasDias as $fechas) 
					{
						$pdf.="<td width='100' style='text-align:center;'>".date("d-m-Y", strtotime($fechas->dia))."</td>";
					}
					$pdf.="</tr>";
					$pdf.="<tr>";
						$pdf.="<th width='145' height='30' style='text-align:center; background: #D4D4D4;'>UBICACION</th> 
								<th width='55' height='30' style='text-align:center; background: #D4D4D4;'>MEDIDOR</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>DOMINGO</th>  
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>LUNES</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>MARTES</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>MIERCOLES</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>JUEVES</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>VIERNES</th> 
								<th width='100' height='30' style='text-align:center; background: #D4D4D4;'>SABADO</th> ";
					$pdf.="</tr>";
				$pdf.="</thead>";
				$pdf.="<tbody>";

					$dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
					//$nombreDiaHoy = $dias[date('w', strtotime($diaHoy))];

					$sumaZonaNorte = 0;
					$sumaZonaSur = 0;
					$sumatotal = 0;
					foreach ($equipos as $equipo) 
					{
						$dom = 0;
						$lun = 0;
						$mar = 0;
						$mie = 0;
						$jue = 0;
						$vie = 0;
						$sab = 0;

						foreach ($mediciones as $medicion) 
						{
							if($equipo->activo == $medicion->equipo)
							{	
								$diaCompara = $dias[date('w', strtotime($medicion->fechaLectura))];

								//echo $diaCompara;
								
								if($diaCompara == "DOMINGO")
								{
									$dom = $dom + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "LUNES")
								{
									$lun = $lun + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "MARTES")
								{
									$mar = $mar + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "MIERCOLES")
								{
									$mie = $mie + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "JUEVES")
								{
									$jue = $jue + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "VIERNES")
								{
									$vie = $vie + ($medicion->m_consumidos * 10 );
								}
								if($diaCompara == "SABADO")
								{
									$sab = $sab + ($medicion->m_consumidos * 10 );
								}
							}
							
						}
						
						$pdf.="<tr>";
							$pdf.="<td width='145' style='text-align:left; font-size:9px;'>".$equipo->descripcion."</td> 
									<td width='55' style='text-align:left; font-size:9px;'>".$equipo->medidor."</td> 
									<td width='100' style='text-align:right; '>".$dom."</td> 
									<td width='100' style='text-align:right; '>".$lun."</td> 
									<td width='100' style='text-align:right; '>".$mar."</td> 
									<td width='100' style='text-align:right; '>".$mie."</td> 
									<td width='100' style='text-align:right; '>".$jue."</td> 
									<td width='100' style='text-align:right; '>".$vie."</td> 
									<td width='100' style='text-align:right; '>".$sab."</td>";
						$pdf.="</tr>";
					}
					
					
					
				$pdf.="</tbody>";
			$pdf.="</table>";

					$pdf.="<br>
							<table style='text-align:center; font-size:12; ' border='0'>
							<tr>
					      		<td colspan='9' width='900' style='text-align:center;'><b>OBSERVACIONES</b></td>
					      	</tr>
							<tr >
					      		<td colspan='9' width='900' style='border:1 solid black; text-align:justity;'>".$observacion."</td>
					      	</tr>
					      	<tr>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      		<td width='100'><br><br></td>
					      	</tr>
					        <tr>
					          <td width='200' colspan='2'></td> 
					          <td width='200' colspan='2'>______________________________</td>
					          <td width='100' ></td>
					          <td width='200' colspan='2'>______________________________</td>
					          <td width='200' colspan='2'></td> 
					        </tr>
					        <tr>
					          <td width='200' colspan='2'></td> 
					          <td width='200' colspan='2'>Realizó</td>
					          <td width='100' ></td>
					          <td width='200' colspan='2'>Supervisor</td>
					          <td width='200' colspan='2'></td> 
					        </tr>
					        <tr>
					          <td width='200' colspan='2'></td> 
					          <td width='200' colspan='2'><b>".$realizo."</b></td>
					          <td width='100' ></td>
					          <td width='200' colspan='2'><b>".$supervisor."</b></td>
					          <td width='200' colspan='2'></td>
					        </tr>
				      	</table>";

				require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
				ob_start();
				$contentFinal="<page backtop='15mm' backbottom='15mm' backleft='20mm' backright='20mm'>
				  <page_header > 

				  </page_header> 
				  <page_footer>  
				        <table  >
				          <tr >
				              <td>P&aacute;gina [[page_cu]]/[[page_nb]]</td>
				            
				          </tr>
				        </table> 

				       
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
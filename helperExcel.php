<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');



//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";
if( isset($_REQUEST["parametro"]) ) 
{
	$parametro = $_REQUEST["parametro"];
	if ($parametro == "MEDICIONES_CAMARA") 
	{
		//Inicio de la instancia para la exportación en Excel
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$parametro.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "<table border='1'> ";
		echo "<tr >
				<td colspan='2'><img src='".$url."dist/img/naturesweet_picture.png"."' width='10%' height='10%'></td>

				<td colspan='9'><br><h2>REPORTE DE MEDICIONES DE CAMARA FRIA</h2><br><br></td>
			</tr>";

		echo "<tr> ";
            echo "<th>FECHA</th>";
            echo "<th>T. CAM (VACIA)</th>";
            echo "<th>T. CAM (CON TOMATE)</th>";
            echo "<th>HR. CAM (VACIA)</th>";
            echo "<th>HR. CAM (CON TOMATE)</th>";
            echo "<th>T. TOMATE (ENTRADA)</th>";
            echo "<th>T. TOMATE (SALIDA)</th>";
            echo "<th>NUM TARIMAS</th>";
            echo "<th>PUERTA CERRADA</th>";
            echo "<th>LONA B. UBICADA</th>";
            echo "<th>EQUIPO 7.5 ENCENDIDO</th>";
		echo "</tr> ";

		$camaras = Mediciones_camara_fria::getAll();
		foreach ($camaras as $camara) 
		{
			echo "<tr >";
                echo "<td>".date("d-M-Y H:m:s", strtotime($camara->fecha_medicion))."</td>";
                echo "<td>".$camara->temp_vacia."</td>";
                echo "<td>".$camara->temp_con_tomate."</td>";
                echo "<td>".$camara->hr_vacia."</td>";
                echo "<td>".$camara->hr_con_tomate."</td>";
                echo "<td>".$camara->temp_tomate_entrada."</td>";
                echo "<td>".$camara->temp_tomate_salida."</td>";
                echo "<td>".$camara->num_tarimas."</td>";

                if($camara->puerta_cerrada == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->puerta_cerrada == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

                if($camara->lona_bien_ubicada == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->lona_bien_ubicada == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

                if($camara->e_75_encendido == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->e_75_encendido == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

               
                echo "</td>";
            echo "</tr>";
		}

		echo "</table> ";

	}
    if ($parametro == "MEDICIONES_REBOMBEO") 
    {
        $fecha = '2018-12-30';
        //Inicio de la instancia para la exportación en Excel
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=".$parametro.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1' > ";
        echo "<tr >
                <td colspan='2'><img src='".$url."dist/img/naturesweet_picture.png"."' width='10%' ></td>

                <td colspan='18' style='text-align: center;'><br><h2>REPORTE DE MEDICIONES DE REBOMBEO</h2><h3> AL ".date("d/m/Y")."</h3></td>
            </tr>";

        echo "<tr style='font-size: 12px'> ";
            echo "<th>ACTIVO EAM</th>";
            echo "<th>DESCRIPCION DEL EQUIPO</th>";
            echo "<th>MEDICION</th>";
            echo "<th>FECHA / HORA</th>";
            echo "<th>SEMANA</th>";
            echo "<th>VOLT <BR> L1 - L2</th>";
            echo "<th>VOLT <BR> L2 - L3</th>";
            echo "<th>VOLT <BR> L1 - L3</th>";
            echo "<th>AMP <BR> L1</th>";
            echo "<th>AMP <BR> L2</th>";
            echo "<th>AMP <BR> L3</th>";
            echo "<th>CAUDAL</th>";
            echo "<th>M<SUP>3</SUP> X 10 <BR> CONSUMIDOS</th>";
            echo "<th>NIVEL <BR> ESTATICO</th>";
            echo "<th>NIVEL <BR> DINAMICO</th>";
            echo "<th>HP</th>";
            echo "<th>VOLTAJE NOMINAL <BR> BAJO</th>";
            echo "<th>VOLTAJE NOMINAL <BR> ALTO</th>";
            echo "<th>AMPERAJE <BR> MAXIMO</th>";
            echo "<th>AMPERAJE <BR> MINIMO</th>";
        echo "</tr> ";

        $consulta = "SELECT bd_rebombeo.*, disponibilidad_activos.descripcion, tipoMedicion_rebombeo.descripcion as tipoM
                    FROM bd_rebombeo
                    INNER JOIN disponibilidad_activos ON bd_rebombeo.equipo = disponibilidad_activos.activo
                    INNER JOIN tipoMedicion_rebombeo ON bd_rebombeo.tipo = tipoMedicion_rebombeo.id
                    WHERE disponibilidad_activos.organizacion = 'COL'
                    AND DATE_FORMAT(bd_rebombeo.fechaLectura, '%Y-%m-%d') >= '$fecha'
                    ORDER BY bd_rebombeo.fechaLectura DESC";

        $mediciones = Bd_rebombeo::getAllByQuery($consulta);

        foreach ($mediciones as $medicion) 
        {
            $colorVoltaje_l1_l2 = "";
            $colorVoltaje_l2_l3 = "";
            $colorVoltaje_l1_l3 = "";
            $colorAmperaje_l1 = "";
            $colorAmperaje_l2 = "";
            $colorAmperaje_l3 = "";

            $dia = date("Y-m-d", strtotime($medicion->fechaLectura));
            $semanas = Disponibilidad_calendarios::getByDia($dia);
            //print_r($semanas);

            $s = $semanas[0]->semana;
            
            if($medicion->voltaje_l1_l2 < $medicion->volt_nomi_bajo || $medicion->voltaje_l1_l2 > $medicion->volt_nomi_alto)
            {
                $colorVoltaje_l1_l2 = "#D55551";
            }
            else
            {
                $colorVoltaje_l1_l2 = "#59BA5F";
            }

            if($medicion->voltaje_l2_l3 < $medicion->volt_nomi_bajo || $medicion->voltaje_l2_l3 > $medicion->volt_nomi_alto)
            {
                $colorVoltaje_l2_l3 = "#D55551";
            }
            else
            {
                $colorVoltaje_l2_l3 = "#59BA5F";
            }

            if($medicion->voltaje_l1_l3 < $medicion->volt_nomi_bajo || $medicion->voltaje_l1_l3 > $medicion->volt_nomi_alto)
            {
                $colorVoltaje_l1_l3 = "#D55551";
            }
            else
            {
                $colorVoltaje_l1_l3 = "#59BA5F";
            }

            // para el amperaje
            if($medicion->amperaje_l1 < $medicion->amp_min || $medicion->amperaje_l1 > $medicion->amp_max)
            {
                $colorAmperaje_l1 = "#D55551";
            }
            else
            {
                $colorAmperaje_l1 = "#59BA5F";
            }

            if($medicion->amperaje_l2 < $medicion->amp_min || $medicion->amperaje_l2 > $medicion->amp_max)
            {
                $colorAmperaje_l2 = "#D55551";
            }
            else
            {
                $colorAmperaje_l2 = "#59BA5F";
            }

            if($medicion->amperaje_l3 < $medicion->amp_min || $medicion->amperaje_l3 > $medicion->amp_max)
            {
                $colorAmperaje_l3 = "#D55551";
            }
            else
            {
                $colorAmperaje_l3 = "#59BA5F";
            }

            echo "<tr style='font-size: 12px'>";
                echo "<td>".$medicion->equipo."</td>";
                echo "<td>".$medicion->descripcion."</td>";
                echo "<td>".$medicion->tipoM."</td>";
                echo "<td>".date("d-m-Y H:i", strtotime($medicion->fechaLectura))."</td>";
                echo "<td>".$s."</td>";
                if($medicion->tipo == 1)
                {


                    echo "<td style='color:white; background-color: ".$colorVoltaje_l1_l2."'>".$medicion->voltaje_l1_l2."</td>";
                    echo "<td style='color:white; background-color: ".$colorVoltaje_l2_l3."'>".$medicion->voltaje_l2_l3."</td>";
                    echo "<td style='color:white; background-color: ".$colorVoltaje_l1_l3."'>".$medicion->voltaje_l1_l3."</td>";
                    echo "<td style='color:white; background-color: ".$colorAmperaje_l1."'>".$medicion->amperaje_l1."</td>";
                    echo "<td style='color:white; background-color: ".$colorAmperaje_l2."'>".$medicion->amperaje_l2."</td>";
                    echo "<td style='color:white; background-color: ".$colorAmperaje_l3."'>".$medicion->amperaje_l3."</td>";
                }
                else
                {
                    echo "<td style='text-align: center;' > - </td>";
                    echo "<td style='text-align: center;' > - </td>";
                    echo "<td style='text-align: center;' > - </td>";
                    echo "<td style='text-align: center;' > - </td>";
                    echo "<td style='text-align: center;' > - </td>";
                    echo "<td style='text-align: center;' > - </td>"; 
                }

                echo "<td>".$medicion->caudal."</td>";
                if($medicion->m_consumidos != "")
                {
                    if($medicion->equipo != "CO-BMU-009")
                    {
                        echo "<td>".($medicion->m_consumidos * 10)."</td>";
                    }
                    else
                    {
                        echo "<td>".($medicion->m_consumidos)."</td>";
                    }
                    
                }
                else
                {
                   echo "<td>".$medicion->m_consumidos."</td>"; 
                }
                                                        
                echo "<td style='background-color:#f8f0d8'>".$medicion->nivel_estatico."</td>";
                echo "<td style='background-color:#dff0d8'>".$medicion->nivel_dinamico."</td>";
                echo "<td>".$medicion->hp."</td>";
                echo "<td style='background-color:#f8f0d8'>".$medicion->volt_nomi_bajo."</td>";
                echo "<td style='background-color:#dff0d8'>".$medicion->volt_nomi_alto."</td>";
                echo "<td style='background-color:#dff0d8'>".$medicion->amp_max."</td>";
                echo "<td style='background-color:#f8f0d8'>".$medicion->amp_min."</td>";
            echo "</tr>";
        }

        echo "</table> ";

    }
    elseif($parametro == "INVENTARIO_MATERIALES")
    {
        //Inicio de la instancia para la exportación en Excel
        //header('Content-type: application/vnd.ms-excel');
        header('application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        header("Content-Disposition: attachment; filename=".$parametro.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'> ";
        echo "<tr >
                <td colspan='6'><img src='".$url."dist/img/naturesweet_picture.png"."' width='10%' height='10%'></td>
                <td><br>Fecha de impresi&oacute;n<br><br></td>
                <td><br>".date("d/m/Y")."<br><br></td>
            </tr>";
        echo "<tr >
                <td colspan='8' style='text-align:center;'><br><h2>INVENTARIO DE MATERIALES</h2><br><br></td>
            </tr>";

        echo "<tr> ";
            echo "<th>CODIGO</th>";
            echo "<th>DESCRIPCION</th>";
            echo "<th>CLASE</th>";
            echo "<th>MINIMO</th>";
            echo "<th>MAXIMO</th>";
            echo "<th>STOCK</th>";
            echo "<th>ESTATUS</th>";
            echo "<th>% DISPONIBILIDAD</th>";
        echo "</tr> ";

        $almacen = Almacen_inventario::getAll();
        foreach ($almacen as $a) 
        {
            echo "<tr>";
                //echo "<th width='5px' class='spec'>$i</th>";
                echo "<td>".$a->codigo."</td>";
                echo "<td>".utf8_encode($a->descripcion)."</td>";
                echo "<td>".$a->clase."</td>";
                echo "<td>".$a->cantidad_minima."</td>";
                echo "<td>".$a->cantidad_maxima."</td>";

                if($a->stock > $a->cantidad_maxima)
                {
                    echo "<td style='text-align:right; background:#337ab7; color:white;'>".$a->stock."</td>";
                }
                elseif($a->stock >= $a->cantidad_minima && $a->stock <= $a->cantidad_maxima)
                {
                    echo "<td style='text-align:right; background:#5cb85c; color:white;'>".$a->stock."</td>";
                }
                elseif($a->stock < $a->cantidad_minima)
                {
                    if($a->stock <= 2)
                    {
                        echo "<td style='text-align:right; background:#d9534f; color:white;'>".$a->stock."</td>";
                    }
                    else
                    {
                        echo "<td style='text-align:right; background:#f0ad4e; color:white;'>".$a->stock."</td>";
                    }
                    
                }
                
                

                if($a->estatus ==  1)
                {
                    echo "<td style='text-align:center;'>A</td>";
                }
                else
                {
                    echo "<td style='text-align:center;'>NA</td>";
                }

                $porcentajeDisponible = (100 * $a->stock) / $a->cantidad_maxima; 
                $porcentajeDisponible = round($porcentajeDisponible, 1);

               
                echo "<td>".$porcentajeDisponible."</td>";
                               
            echo "</tr>";
        }

        echo "</table>";

        
    } 
    elseif ($parametro == "semanal") 
    {
        $semana = $_REQUEST['semana'];
        $ano = date("Y");
        //Inicio de la instancia para la exportación en Excel
        //header('Content-type: application/vnd.ms-excel');
        header('application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        header("Content-Disposition: attachment; filename=Preparacion Captura ".$semana.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='0'> ";

        echo "<tr style='background-color:#AED6F1; height:40px;'> ";
            echo "<td>Codigo</td>";
            echo "<td>Nombre</td>";
            echo "<td>Semana</td>";
            echo "<td># de <br> actividad</td>";
            echo "<td>Actividad</td>";
            echo "<td>Pago por</td>";
            echo "<td>Pago <br> especial</td>";
            echo "<td>Fecha</td>";
            echo "<td>Surcos o <br> Cajas</td>";
            echo "<td>Tiempo</td>";
            echo "<td>Inv</td>";
            echo "<td>Zona</td>";
            echo "<td>Surcos <br> reales</td>";
            echo "<td>Surcos por <br> hora</td>";
            echo "<td>Objetivo por <br> hora</td>";
            echo "<td>Eficiencia</td>";
            echo "<td>Precio por <br>actividad</td>";
            echo "<td>Subpago</td>";
            echo "<td>Lider</td>";
            echo "<td>Tiempo <br>muerto</td>";
            echo "<td>Observacion</td>";

        echo "</tr> ";

        $consulta = "SELECT * FROM recursos_bonos_semanal
                        WHERE semana = $semana
                            AND (YEAR(fecha) = $ano)
                        ORDER BY fecha DESC";
        //ECHO $consulta;
        $bonos = Recursos_bonos_semanal::getAllByQuery($consulta);
        foreach ($bonos as $b) 
        {
            $nombre_lider = "-";
            $q = "SELECT nombre FROM recursos_asociados
                    WHERE codigo = $b->lider
                    LIMIT 1";
            $lideres = Recursos_asociados::getAllByQuery($q);
            if(!empty($lideres))
            {
                $nombre_lider = $lideres[0]->nombre;
            }

            /*$ano = date("Y", strtotime($b->fecha));
            $anoActual = date("Y");*/

           
            echo "<tr>";
                
                echo "<td>".$b->codigo."</td>";
                echo "<td style='background-color:#DAF7A6; '>".utf8_encode($b->nombre)."</td>";
                echo "<td style=' text-align:center;'>".$b->semana."</td>";
                echo "<td style=' text-align:center;'>".$b->id_actividad."</td>";
                echo "<td style='background-color:#DAF7A6; '>".utf8_encode($b->nombre_actividad)."</td>";
                echo "<td style='background-color:#DAF7A6; '>".$b->pago_por."</td>";
                
                if($b->pago_especial == 0)
                {
                    echo "<td style='text-align:center;'> - </td>";
                }
                else
                {
                    echo "<td>".$b->pago_especial."</td>";
                }
                echo "<td>".date("d/m/Y", strtotime($b->fecha))."</td>";
                echo "<td>".$b->surcos_cajas."</td>";
                echo "<td>".$b->tiempo."</td>";
                echo "<td>".$b->gh."</td>";
                echo "<td style='background-color:#DAF7A6; text-align:center;'>".$b->zona."</td>";
                echo "<td style='background-color:#DAF7A6; text-align:center;'>".$b->surcos_reales."</td>";

                echo "<td style='background-color:#DAF7A6; text-align:center;'>".$b->surcos_hora."</td>";
                echo "<td style='background-color:#DAF7A6; text-align:center;'>".$b->objetivo_hora."</td>";
                if($b->pago_por == "EFICIENCIA")
                {
                    echo "<td style='background-color:#DAF7A6; text-align:center;'>".$b->eficiencia." %</td>";
                }
                else
                {
                    echo "<td style='background-color:red; text-align:center;'> - </td>";
                }
                
                echo "<td style='background-color:#DAF7A6; text-align:right;'>$ ".$b->precio_actividad."</td>";
                echo "<td style='background-color:#DAF7A6; text-align:right;'>$ ".$b->subpago."</td>";
                echo "<td style='background-color:#DAF7A6; text-align:center;'>".$nombre_lider."</td>";

                if($b->tiempo_muerto == 0)
                {
                    echo "<td style='text-align:center;'> - </td>";
                }
                else
                {
                    echo "<td>".$b->tiempo_muerto."</td>";
                }
                
                echo "<td>".utf8_encode($b->observacion)."</td>";
                               
            echo "</tr>";
        }

        echo "</table>" ;
    }  
}
else
{
	echo "NO DATA";
}


//echo $str;
?>
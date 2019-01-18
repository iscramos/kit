<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$str = "";
	
	if($id > 0)
	{
		$plan = Planner::getById($id);

		//print_r($activos_equipos);
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$plan->id."' readonly> 
					</div>
				</div>";	

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Fecha de realización</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name='fecha_realizacion' id='fecha_realizacion' class='form-control input-sm' value='".$plan->fecha_realizacion."' required autocomplete='off'>
		                    <span class='input-group-addon'>
		                        <span class='glyphicon glyphicon-calendar'></span>
		                    </span>
			            </div>
					</div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Equipo</label>
						<select class='form-control input-sm' id='equipo' name='equipo' required readonly>
							<option value='".$plan->equipo."' style='display:none;'>".$plan->equipo."</option>
						</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-6  '>
						<label >Frecuencia</label>
						<select class='form-control input-sm' id='frecuencia' name='frecuencia' required readonly>
							<option value='".$plan->frecuencia."' style='display:none;'>".$plan->frecuencia."</option>
						</select>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Inició (hr)</label>
		                 <input type='time' name='hora_inicio' id='hora_inicio' class='form-control input-sm' value='".$plan->hora_inicio."' required autocomplete='off'>
			            
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Terminó (hr)</label>
		                 <input type='time' name='hora_fin' id='hora_fin' class='form-control input-sm' value='".$plan->hora_fin."' required autocomplete='off'>
			            
					</div>
					
				</div>";


		
	}
	else
	{
		
		
		$query = "SELECT * FROM disponibilidad_activos
				WHERE criticidad = 'Alta'
				AND activo LIKE 'CO-TRC-%'
				OR activo LIKE 'CO-PRH-%'
				OR activo LIKE 'CO-TOL-%'
				OR activo LIKE 'CO-MOA-%'
				ORDER BY activo ASC"; 

		$activos_equipos = Disponibilidad_activos::getAllByQuery($query);

		//print_r($activos_equipos);
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";	

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Fecha de realización</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name='fecha_realizacion' id='fecha_realizacion' class='form-control input-sm' value='' required autocomplete='off'>
		                    <span class='input-group-addon'>
		                        <span class='glyphicon glyphicon-calendar'></span>
		                    </span>
			            </div>
					</div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Equipo</label>
						<select class='form-control input-sm' id='equipo' name='equipo' required>
							<option value='' style='display:none;'>Seleccione</option>";
						foreach ($activos_equipos as $activo) 
						{
							$str.="<option value='".$activo->activo."'>".$activo->activo." [".utf8_encode($activo->descripcion)."] </option>";
						}
						$str.="</select>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-6  '>
						<label >Frecuencia</label>
						<select class='form-control input-sm' id='frecuencia' name='frecuencia' required>
							<option value='' style='display:none;'>Seleccione</option>
							<option value='S'>S</option>
							<option value='A'>A</option>
							<option value='B'>B</option>
							<option value='C'>C</option>
							<option value='D'>D</option>
							<option value='E'>E</option>
							<option value='F'>F</option>
						</select>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Inició (hr)</label>
		                 <input type='time' name='hora_inicio' id='hora_inicio' class='form-control input-sm' value='' required autocomplete='off'>
			            
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Terminó (hr)</label>
		                 <input type='time' name='hora_fin' id='hora_fin' class='form-control input-sm' value='' required autocomplete='off'>
			            
					</div>
					
				</div>";
		

		
	}
}
else
{
	redirect_to('lib/logout.php');
}

echo $str;
?>

<script type="text/javascript">
	function creaAjax()
	{
		var objetoAjax=false;
		try 
		{
		    /*Para navegadores distintos a internet explorer*/
		    objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e)
		{
		    try 
		    {
		      /*Para explorer*/
		      objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
		    } catch (E) 
		    {
		      objetoAjax = false;
			}
		}
		if (!objetoAjax && typeof XMLHttpRequest!='undefined') 
		{
		    objetoAjax = new XMLHttpRequest();
		}
		return objetoAjax;
	}



	$(document).ready(function()
    {
    	
    	$('#datetimepicker1').datetimepicker({
        	 format: 'YYYY-MM-DD',
        	 pickTime: false,
        	 autoclose: true,
        	 
        });
        
    });






</script>


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
		$bonos = Recursos_bonos_apoyos::getById($id);
		

		$fechita = date("Y-m-d");
		//echo $fechita;
		$semanaActual = Disponibilidad_calendarios::getByDia($fechita);
		//$semanas = Disponibilidad_semanas::getAllByOrden("semana", "ASC");
		$semanaHoy = $semanaActual[0]->semana;
		$invernaderos = Recursos_invernaderos::getAllByOrden("invernadero", "ASC");
		//print_r($semana);

		/*$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$bonos->id."' readonly> 
					</div>
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-12 col-xs-12  '>
						<p class='pull-right'><b class='text-danger'># id: </b> [ ".$bonos->id." ] <b>  Fecha: </b> [ ".date("d-m-Y", strtotime($bonos->fecha))." ] <b>WK: </b> [ ".$bonos->semana." ]</p>
					</div>
					
				</div>";

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Supervisor</label>
						<p >".$bonos->codigo_supervisor."</p>
		            </div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Nombre</label>
						<p >".$bonos->nombre_supervisor."</p>
					</div>
				</div>";
		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Asociado</label>
		                <p >".$bonos->codigo."</p>
		            </div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Nombre</label>
						<p >".$bonos->nombre."</p>
					</div>
				</div>";


		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-4  '>
						<label ># Actividad</label>
						<p >".$bonos->id_actividad."</p>
					</div>
					<div class='col-md-8 col-xs-8  '>
						<label >Descripción</label>
						<p >".$bonos->nombre_actividad."</p>
					</div>
					<div class='col-md-3 col-xs-4 hidden '>
						<label >Pago por</label>
						<input type='text' class='form-control input-sm' name='pago_por' id='pago_por' value='".$bonos->pago_por."' required readonly>
					</div>
				</div>";


		$str.="<div class='form-group hidden'>
					<div class='col-md-4 col-xs-4  '>
						<label >Objetivo </label>
						<input type='number' class='form-control input-sm' name='objetivo_hora' id='objetivo_hora' value='".$bonos->objetivo_hora."' required readonly>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Actividad $</label>
						<input type='number' class='form-control input-sm' name='precio_actividad' id='precio_actividad' value='".$bonos->precio_actividad."' required readonly>
					</div>
					
				</div>";
				
		$str.="<div class='form-group '>
					

					<div class='col-md-4 col-xs-4  '>
						<label >Surcos o cajas</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_cajas' id='surcos_cajas' value='".$bonos->surcos_cajas."'  required autocomplete='off'>
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Invernadero</label>
						<select class='form-control input-sm' name='gh' id='gh' required>
							<option value='' >Seleccione</option>";
							foreach ($invernaderos as $gh) 
							{
								if($bonos->gh == $gh->invernadero)
								{
									$str.="<option value='".$gh->invernadero."' selected>".$gh->invernadero."</option>";
								}
								$str.="<option value='".$gh->invernadero."'>".$gh->invernadero."</option>";
							}
						$str.="</select>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Pago especial $</label>
						<input type='number' step='0.01' class='form-control input-sm' name='pago_especial' id='pago_especial' value='".$bonos->pago_especial."'  autocomplete='off'>
					</div>
					
				</div>";

		$str.="<div class='form-group hidden'>
					
					
					<div class='col-md-4 col-xs-4  '>
						<label >Surcos reales</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_reales' id='surcos_reales' value='".$bonos->surcos_reales."' readonly required>
					</div>
				</div>";

		$str.="<div class='form-group'>
					
					
					<div class='col-md-4 col-xs-4  '>
						<label >Inició (hr)</label>
		                 <input type='time' name='hora_inicio' id='hora_inicio' class='form-control input-sm' value='".$bonos->hora_inicio."' required autocomplete='off'>
			            
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Terminó (hr)</label>
		                 <input type='time' name='hora_fin' id='hora_fin' class='form-control input-sm' value='".$bonos->hora_fin."' required autocomplete='off'>
			            
					</div>

					<div class='col-md-4 col-xs-4  hidden'>
						<label >Tiempo (hr)</label>
		                 <input type='text' name='tiempo' id='tiempo' class='form-control input-sm' value='".$bonos->tiempo."' required autocomplete='off'>
			            
					</div>

					<div class='col-md-4 col-xs-4  '>
						<label >Subpago $</label>
						<input type='number' step='0.01' class='form-control input-sm' name='subpago' id='subpago' value='".$bonos->subpago."' readonly required>
					</div>
					<div class='col-md-4 col-xs-4  hidden'>
						<label >Surcos / hrs</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_hora' id='surcos_hora' value='".$bonos->surcos_hora."' readonly required>
					</div>
					<div class='col-md-4 col-xs-4  hidden' >
						<label >% Eficiencia</label>
						<input type='number' step='0.01' class='form-control input-sm' name='eficiencia' id='eficiencia' value='".$bonos->eficiencia."'  required readonly>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-6 col-xs-6  hidden'>
						<label >Tiempo muerto</label>
						<input type='number' step='0.01' class='form-control input-sm' name='tiempo_muerto' id='tiempo_muerto' value='".$bonos->tiempo_muerto."'   autocomplete='off'>
					</div>
					<div class='col-md-12 col-xs-12  '>
						<label >Observaciones</label>
						<input type='text' class='form-control input-sm' name='observacion' id='observacion' value='".$bonos->observacion."'   autocomplete='off'>
					</div>
				</div>";*/


		
	}
	else
	{
		$fechita = date("Y-m-d");
		//echo $fechita;
		$semanaActual = Disponibilidad_calendarios::getByDia($fechita);
		//$semanas = Disponibilidad_semanas::getAllByOrden("semana", "ASC");
		$semanaHoy = $semanaActual[0]->semana;
		$invernaderos = Recursos_invernaderos::getAllByOrden("invernadero", "ASC");
		//print_r($semana);

		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-12 col-xs-12  '>
						<p class='pull-right'><b>Fecha: </b> [ ".date("d-m-Y", strtotime($fechita))." ] <b>WK: </b> [ ".$semanaHoy." ] </p>
					</div>
					
				</div>";

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Supervisor</label>
		                <div class='input-group'>
		                    <input type='number' class='form-control input-sm' name='codigo_supervisor' id='codigo_supervisor' value='' required autocomplete='off'>
		                    <span class='input-group-btn '>
		                          <button class='btn btn-success btn-sm' id='buscar_supervisor'>Buscar</button>
		                    </span> 
		                </div>
		            </div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Nombre</label>
						<input type='text' class='form-control input-sm' name='nombre_supervisor' id='nombre_supervisor' value='' required readonly>
					</div>
				</div>";
		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >Asociado</label>
		                <div class='input-group'>
		                    <input type='number' class='form-control input-sm' name='codigo' id='codigo' value='' required autocomplete='off'>
		                    <span class='input-group-btn '>
		                          <button class='btn btn-success btn-sm' id='buscar'>Buscar</button>
		                    </span> 
		                </div>
		            </div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Nombre</label>
						<input type='text' class='form-control input-sm' name='nombre' id='nombre' value='' required readonly>
					</div>
				</div>";

		
		$str.="<div class='form-group hidden'>
					<div class='col-md-4 col-xs-6  '>
						<label >Fecha</label>
		                <input type='text' name='fecha' id='fecha' class='form-control input-sm' value='".$fechita."' required readonly>
					</div>
					<div class='col-md-2 col-xs-2  '>
						<label >Sem</label>
						<input type='number' class='form-control input-sm' name='semana' id='semana' value='".$semanaHoy."' required readonly>
					</div>
					<div class='col-md-3 col-xs-2  '>
						<label >Líder</label>
						<input type='number' class='form-control input-sm' name='lider' id='lider' value='' required readonly>
					</div>

					<div class='col-md-3 col-xs-2  '>
						<label >Zona</label>
						<input type='text' class='form-control input-sm' name='zona' id='zona' value='' required readonly>
					</div>
					
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-4 col-xs-4  '>
						<label ># Actividad</label>
						<input type='number' class='form-control input-sm' name='id_actividad' id='id_actividad' value='' required autocomplete='off'>
					</div>
					<div class='col-md-8 col-xs-8  '>
						<label >Descripción</label>
						<input type='text' class='form-control input-sm' name='nombre_actividad' id='nombre_actividad' value='' required readonly>
					</div>
					<div class='col-md-3 col-xs-4  hidden'>
						<label >Pago por</label>
						<input type='text' class='form-control input-sm' name='pago_por' id='pago_por' value='' required readonly>
					</div>
				</div>";


		$str.="<div class='form-group hidden'>
					<div class='col-md-4 col-xs-4  '>
						<label >Objetivo </label>
						<input type='number' class='form-control input-sm' name='objetivo_hora' id='objetivo_hora' value='' required readonly>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Actividad $</label>
						<input type='number' class='form-control input-sm' name='precio_actividad' id='precio_actividad' value='' required readonly>
					</div>
					
				</div>";
				
		$str.="<div class='form-group '>
					

					<div class='col-md-4 col-xs-4  '>
						<label >Surcos o cajas</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_cajas' id='surcos_cajas' value=''   autocomplete='off'>
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Inició (hr)</label>
		                 <input type='time' name='hora_inicio' id='hora_inicio' class='form-control input-sm' value='' required autocomplete='off'>
			            
					</div>
					
					<div class='col-md-4 col-xs-4  '>
						<label >Terminó (hr)</label>
		                 <input type='time' name='hora_fin' id='hora_fin' class='form-control input-sm' value='' required autocomplete='off'>
			            
					</div>

					<div class='col-md-4 col-xs-4  hidden'>
						<label >Tiempo (hr)</label>
		                 <input type='text' name='tiempo' id='tiempo' class='form-control input-sm' value='' required autocomplete='off'>
			            
					</div>
					
				</div>";

		$str.="<div class='form-group hidden'>
					
					
					<div class='col-md-4 col-xs-4  '>
						<label >Surcos reales</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_reales' id='surcos_reales' value='' readonly required>
					</div>
				</div>";

		$str.="<div class='form-group'>

					<div class='col-md-4 col-xs-4  '>
						<label >Invernadero</label>
						<select class='form-control input-sm' name='gh' id='gh' required>
							<option value='' style='display:none;'>Seleccione</option>";
							foreach ($invernaderos as $gh) 
							{
								$str.="<option value='".$gh->invernadero."'>".$gh->invernadero."</option>";
							}
						$str.="</select>
					</div>
					<div class='col-md-4 col-xs-4  '>
						<label >Pago especial $</label>
						<input type='number' step='0.01' class='form-control input-sm' name='pago_especial' id='pago_especial' value=''  autocomplete='off'>
					</div>

					<div class='col-md-4 col-xs-4  '>
						<label >Subpago $</label>
						<input type='number' step='0.01' class='form-control input-sm' name='subpago' id='subpago' value='' readonly required>
					</div>
					<div class='col-md-4 col-xs-4  hidden'>
						<label >Surcos / hrs</label>
						<input type='number' step='0.01' class='form-control input-sm' name='surcos_hora' id='surcos_hora' value='' readonly required>
					</div>
					<div class='col-md-4 col-xs-4  hidden' >
						<label >% Eficiencia</label>
						<input type='number' step='0.01' class='form-control input-sm' name='eficiencia' id='eficiencia' value=''  required readonly>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<div class='col-md-6 col-xs-6  hidden'>
						<label >Tiempo muerto</label>
						<input type='number' step='0.01' class='form-control input-sm' name='tiempo_muerto' id='tiempo_muerto' value=''   autocomplete='off'>
					</div>
					<div class='col-md-12 col-xs-12  '>
						<label >Observaciones</label>
						<input type='text' class='form-control input-sm' name='observacion' id='observacion' value=''   autocomplete='off'>
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

	
	$("#buscar").on("click", function()
	{	
		var codigo = null;
    		codigo = $("#codigo").val();
    	if(codigo > 0)
    	{	
			var ajax=creaAjax();

			ajax.open("GET", "helper_recursos.php?consulta=ASOCIADO&codigo="+codigo, true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				  // Mientras carga ponemos un letrerito que dice "Verificando..."
				  DestinoMsg.innerHTML='Verificando...';
				}
				if (ajax.readyState==4)
				{
				  	// Cuando ya terminó, ponemos el resultado
			        var str = ajax.responseText;
				    var n = str.split("&");
				        
				    var nombre = n[0];
				    var lider = n[1];
				    var zona = n[2];
				   
				  
				  	if(str == '*NO ENCONTRADO*')
				  	{
					  	alert("NO ENCONTRADO, REVISAR EL CATALOGO...");
					  	$("#nombre").val(null);
					  	$("#lider").val(null);
					  	$("#zona").val(null);
					  	$("#codigo").val(null);
				  	}
					else
					{
					  	$("#nombre").val(nombre);
					  	$("#lider").val(lider);
					  	$("#zona").val(zona);
					  	
					} 		  
				  
				} 
			}
			ajax.send(null);
			return false;
		}
		else
		{
			return false;
		}
	})

	$("#buscar_supervisor").on("click", function()
	{	
		var codigo_supervisor = null;
    		codigo_supervisor = $("#codigo_supervisor").val();
    	if(codigo_supervisor > 0)
    	{	
			var ajax=creaAjax();

			ajax.open("GET", "helper_recursos.php?consulta=ASOCIADO&codigo="+codigo_supervisor, true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				  // Mientras carga ponemos un letrerito que dice "Verificando..."
				  DestinoMsg.innerHTML='Verificando...';
				}
				if (ajax.readyState==4)
				{
				  	// Cuando ya terminó, ponemos el resultado
			        var str = ajax.responseText;
				    var n = str.split("&");
				        
				    var nombre_supervisor = n[0];
				   
				  
				  	if(str == '*NO ENCONTRADO*')
				  	{
					  	alert("NO ENCONTRADO, REVISAR EL CATALOGO...");
					  	$("#nombre_supervisor").val(null);
					  	$("#codigo_supervisor").val(null);
				  	}
					else
					{
					  	$("#nombre_supervisor").val(nombre_supervisor);
					  	
					} 		  
				  
				} 
			}
			ajax.send(null);
			return false;
		}
		else
		{
			return false;
		}
	})

	/*$("#datetimepicker1").on("dp.change", function (e) 
	{
		var fecha = e.date.format('YYYY-MM-DD');
		var ajax = creaAjax();

			ajax.open("GET", "helper_recursos.php?consulta=SEMANA&fecha="+fecha, true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				  // Mientras carga ponemos un letrerito que dice "Verificando..."
				  DestinoMsg.innerHTML='Verificando...';
				}
				if (ajax.readyState==4)
				{
				  	// Cuando ya terminó, ponemos el resultado
			        var str = ajax.responseText;
				    var n = str.split("&");
				        
				    var semana = n[0];
				    var lider = n[1];
				  
				  	if(str == '*NO ENCONTRADO*')
				  	{
					  	alert("ESTA FECHA NO EXISTE...");
					  	$("#semana").val(null);
				  	}
					else
					{
					  	$("#semana").val(semana);
					} 		  
				  
				} 
			}
			ajax.send(null);
	});*/

	$("#id_actividad").on("keyup", function()
	{
    		var id_actividad = null;

    			id_actividad = $(this).val();
    		if(id_actividad > 0)
    		{


    			var ajax = creaAjax();
    			ajax.open("GET", "helper_recursos.php?consulta=ACTIVIDAD&id_actividad="+id_actividad, true);
				ajax.onreadystatechange=function() 
				{ 
					if (ajax.readyState==1)
					{
					  // Mientras carga ponemos un letrerito que dice "Verificando..."
					  DestinoMsg.innerHTML='Verificando...';
					}
					if (ajax.readyState==4)
					{
					  	// Cuando ya terminó, ponemos el resultado
				        var str = ajax.responseText;
					    var n = str.split("&");
					        
					    var nombre_actividad = n[0];
					    var pago_por = n[1];
					    var objetivo_hora = n[2];
					    var precio_actividad = n[3];
					    	precio_actividad = parseFloat(precio_actividad).toFixed(2);
					  
					  	if(str == '*NO ENCONTRADO*')
					  	{
						  	alert("ESTA ACTIVIDAD NO EXISTE...");
						  	$("#nombre_actividad").val(null);
						  	$("#pago_por").val(null);
						  	$("#objetivo_hora").val(null);
						  	$("#precio_actividad").val(null);
					  	}
						else
						{
						  	$("#nombre_actividad").val(nombre_actividad);
						  	$("#pago_por").val(pago_por);
						  	$("#objetivo_hora").val(objetivo_hora);
						  	$("#precio_actividad").val(precio_actividad);

						  	if(pago_por == "EFICIENCIA")
						  	{
						  		
						  		$("#surcos_cajas").attr("required", "required");
						  		$("#surcos_cajas").removeAttr("readonly");
						  		$("#surcos_cajas").val(null);
						  		
						  		$("#hora_inicio").val(null);
						  		$("#hora_fin").val(null);
						  		$("#hora_inicio").attr("readonly", "true");
						  		$("#hora_inicio").removeAttr("required");
						  		$("#hora_fin").attr("readonly", "true");
						  		$("#hora_fin").removeAttr("required");

						  		$("#tiempo").val(null);
						  		$("#tiempo").removeAttr("required");
						  		$("#tiempo").attr("readonly", "true");
						  	}
						  	else if(pago_por == "TIEMPO")
						  	{
						  		$("#surcos_cajas").attr("readonly", "true");
						  		$("#surcos_cajas").removeAttr("required");
						  		$("#surcos_cajas").val(null);
						  		
						  		$("#hora_inicio").val(null);
						  		$("#hora_fin").val(null);
						  		$("#hora_inicio").attr("required", "required");
						  		$("#hora_inicio").removeAttr("readonly");
						  		$("#hora_fin").attr("required", "required");
						  		$("#hora_fin").removeAttr("readonly");

						  		$("#tiempo").val(tiempo);
						  		$("#tiempo").attr("required", "required");
						  		$("#tiempo").removeAttr("readonly");
						  	}
						} 		  
					  
					} 
				}
				ajax.send(null);
			}
			else
			{
				return false;
			}
    	})

		/*$("#surcos_cajas").on("keyup", function(){

		});*/

		$("#gh").on("change", function()
		{
	    		var invernadero = null;
	    		var surcos_cajas = null;

	    			invernadero = $(this).val();
	    			surcos_cajas = $("#surcos_cajas").val();
	    			//$("#tiempo").val(null);
	    			//$("#hora_inicio").val(null);
	    			//$("#hora_fin").val(null);
	    			$("#surcos_hora").val(null);
	    			$("#eficiencia").val(null);
	    			$("#subpago").val(null);

	    			var pago_por = $("#pago_por").val();

	    			var tiempo = null;
	    			var surcos_cajas = null;
		    		var surcos_reales = null;
		    		var objetivo_hora = null;
		    		var precio_actividad = null;

					tiempo = $("#tiempo").val();
					surcos_cajas = $("#surcos_cajas").val();
	    			//surcos_reales = $("#surcos_reales").val();
	    			objetivo_hora = $("#objetivo_hora").val();
	    			precio_actividad = $("#precio_actividad").val();
	    		
	    		if(surcos_cajas > 0 || tiempo > 0)
	    		{

	    			var ajax = creaAjax();
	    			ajax.open("GET", "helper_recursos.php?consulta=INVERNADERO&invernadero="+invernadero, true);
					ajax.onreadystatechange=function() 
					{ 
						if (ajax.readyState==1)
						{
						  // Mientras carga ponemos un letrerito que dice "Verificando..."
						  DestinoMsg.innerHTML='Verificando...';
						}
						if (ajax.readyState==4)
						{
						  	// Cuando ya terminó, ponemos el resultado
					        var str = ajax.responseText;
						    var n = str.split("&");
						        
						    var surcos_reales = n[0];
						    var conversion = parseFloat(surcos_reales) * parseFloat(surcos_cajas);
						    	conversion = conversion.toFixed(2)
							  	$("#surcos_reales").val(conversion);

							/* --- llenando variables --- */
							var surcos_hora = parseFloat(surcos_reales) / parseFloat(tiempo);
				    			surcos_hora = surcos_hora.toFixed(2);
				    			$("#surcos_hora").val(surcos_hora);

				    			var eficiencia = parseFloat(surcos_hora) / parseFloat(objetivo_hora);
				    				eficiencia = eficiencia.toFixed(2)
				    			$("#eficiencia").val(eficiencia);

				    		/* --- llenando variables --- */

							if(pago_por == "EFICIENCIA")
							{
								var subpago = (parseFloat(surcos_reales) * parseFloat(surcos_cajas) ) * parseFloat(precio_actividad);
								//alert(surcos_reales + " --- " + surcos_cajas+ " ::: "+ precio_actividad);
			    					if(eficiencia >=1)
			    					{
			    						subpago = parseFloat(subpago * 1);
			    					}
			    					subpago = subpago.toFixed(2);

			    				$("#subpago").val(subpago);
							}
							else if(pago_por == "TIEMPO")
							{	
			    				var subpago = parseFloat(tiempo) * parseFloat(precio_actividad);
			    				
			    					if(eficiencia >=1)
			    					{
			    						subpago = parseFloat(subpago * 1);
			    					}
			    					subpago = subpago.toFixed(2);

			    				$("#subpago").val(subpago);
							}						  
						} 
					}
					ajax.send(null);
				}
				else
				{
					alert("CAPTURA EL CAMPO 'SURCOS O CAJAS' O LA HORA DE INICIO, FIN; SEGUN CORRESPONDA... ")
				}
				
	    	})


		$("#hora_inicio").on("change", function()
		{	
			$("#hora_fin").val(null);
			$("#surcos_hora").val(null);
			$("#eficiencia").val(null);
			$("#subpago").val(null);

			$("#tiempo").val(null);	
			$("#gh option:first").prop('selected','selected');
					
	    })


	    $("#hora_fin").on("change", function()
		{
				
					
					/*console.log(diff_in_min + ' min');
					console.log(hours_converted + ' horas');*/
					$("#surcos_hora").val(null);
					$("#eficiencia").val(null);
					$("#subpago").val(null);
					
					$("#tiempo").val(null);
					$("#gh option:first").prop('selected','selected');

	    		

					var day = '1/1/1970 '; // 1st January 1970
					var start = $("#hora_inicio").val(); //eg "09:20 PM"
					var end = $("#hora_fin").val(); //eg "10:00 PM"
					var diff_in_min = ( Date.parse(day + end) - Date.parse(day + start) ) / 1000 / 60;
					var hours_converted = diff_in_min / 60;

	    			$("#tiempo").val(hours_converted);

		    		
	    })




	    $("#surcos_cajas").on("keyup", function(){
	    	$("#gh option:first").prop('selected','selected');
	    })


	$(document).ready(function()
    {
    	

    	

    	$("#metros_lineales_reales").on("keyup", function(){
    		var metros_lineales_estandar = null;
    		var metros_lineales_reales = null;
    		var surco_real = 0;

    			metros_lineales_reales = $(this).val();
    			metros_lineales_estandar = $("#metros_lineales_estandar").val();
    			//console.log(metros_lineales_estandar);
    			//console.log(metros_lineales_reales);
    			surco_real = parseFloat(metros_lineales_estandar) / parseFloat(metros_lineales_reales);

    			$("#surco_real").val(surco_real);
    	})

    	

        $('#datetimepicker1').datetimepicker({
        	 format: 'HH:mm:ss',
        	 pickDate: false,
        	 pickTime: true,
        	 //format: 'LT',
        	 //autoclose: true,
        	 
        });

        $('#datetimepicker2').datetimepicker({
        	 format: 'HH:mm:ss',
        	 pickDate: false,
        	 pickTime: true,
        	 //pick12HourFormat: false,
        	 //format: 'LT',
        	 //autoclose: true,
        	 
        });


       
      
        
    });






</script>


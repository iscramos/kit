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
		$asociado = Recursos_asociados::getById($id);
		$q = "SELECT * FROM recursos_asociados 
						WHERE rango = 'LIDER'
						AND activo = 1 ORDER BY nombre ASC";

		$lideres = Recursos_asociados::getAllByQuery($q);
		$departamentos = Recursos_departamentos::getAllByOrden("departamento", "ASC");
		$puestos = Recursos_puestos::getAllByOrden("puesto", "ASC");

		$fechita = date("Y-m-d H:i");
		//echo $fechita;
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='".$asociado->id."' readonly> 
					</div>
				</div>";

		if($asociado->tipo == "NS")
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo1' value='NS' required checked> NS 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo2' value='SPYGA' required> SPYGA 
						</label>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo1' value='NS' required> NS 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo2' value='SPYGA' required checked> SPYGA 
						</label>
					</div>
				</div>";
		}

		if ($asociado->rango == "LIDER") 
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Rango</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango1' value='LIDER' required checked> LIDER 
						</label>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango2' value='T BASE' required> T BASE 
						</label>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Rango</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango1' value='LIDER' required> LIDER 
						</label>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango2' value='T BASE' required checked> T BASE 
						</label>
					</div>
				</div>";
		}

		


		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Código</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='codigo' name='codigo' value='".$asociado->codigo."' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Nombre</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='nombre' name='nombre' value='".$asociado->nombre."' autocomplete='off' required>
					</div>
				</div>";
		
		if ($asociado->sexo == "H") 
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Sexo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo1' value='H' required checked> H 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo2' value='M' required> M 
						</label>
					</div>
				</div>";

		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Sexo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo1' value='H' required> H 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo2' value='M' required checked> M 
						</label>
					</div>
				</div>";

		}
		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Departamento</label>
					<div class='col-xs-9 '>
						<select name='departamento' id='departamento' class='form-control input-sm' required>";
								foreach ($departamentos as $depa) 
								{
									if($depa->id == $asociado->departamento)
									{
										$str.="<option value='".$depa->id."' selected>".$depa->departamento."</option>";
									}
									else
									{
										$str.="<option value='".$depa->id."'>".$depa->departamento."</option>";	
									}
									
								}
							$str.="</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Puesto</label>
					<div class='col-xs-9 '>
						<select name='puesto' id='puesto' class='form-control input-sm' required>";
								foreach ($puestos as $puesto) 
								{
									if($depa->id == $asociado->departamento)
									{
										$str.="<option value='".$puesto->id."' selected>".$puesto->puesto."</option>";
									}
									else
									{
										$str.="<option value='".$puesto->id."'>".$puesto->puesto."</option>";
									}
								}
							$str.="</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Fec de nacimiento</label>
					<div class='col-xs-9 '>
						<div class='input-group date' id='datetimepicker1'>
			                    <input type='text' name='f_nacimiento' id='f_nacimiento' class='form-control input-sm' value='".$asociado->f_nacimiento."'>
			                    <span class='input-group-addon'>
			                        <span class='glyphicon glyphicon-calendar'></span>
			                    </span>
			                </div>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Fec de ingreso</label>
					<div class='col-xs-9 '>
						<div class='input-group date' id='datetimepicker2'>
			                    <input type='text' name='f_ingreso' id='f_ingreso' class='form-control input-sm' value='".$asociado->f_ingreso."'>
			                    <span class='input-group-addon'>
			                        <span class='glyphicon glyphicon-calendar'></span>
			                    </span>
			                </div>
					</div>
				</div>";

		if($asociado->activo == 1)
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Activo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo1' value='1' required checked> SI 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo2' value='0' required> NO 
						</label>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Activo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo1' value='1' required> SI 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo2' value='0' required checked> NO 
						</label>
					</div>
				</div>";
		}
		

		if($asociado->rango == "LIDER")
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Líder</label>
					<div class='col-xs-9 '>
						<select name='lider' id='lider' class='form-control input-sm' >
								<option value='' >Seleccione</option>";
								foreach ($lideres as $lider) 
								{
									if($lider->codigo == $asociado->lider)
									{

										$str.="<option value='".$lider->codigo."' selected>".$lider->nombre."</option>";
									}
									else
									{
										$str.="<option value='".$lider->codigo."'>".$lider->nombre."</option>";
									}
									
								}
							$str.="</select>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Líder</label>
					<div class='col-xs-9 '>
						<select name='lider' id='lider' class='form-control input-sm' required>
								<option value='' >Seleccione</option>";
								foreach ($lideres as $lider) 
								{
									if($lider->codigo == $asociado->lider)
									{

										$str.="<option value='".$lider->codigo."' selected>".$lider->nombre."</option>";
									}
									else
									{
										$str.="<option value='".$lider->codigo."'>".$lider->nombre."</option>";
									}
									
								}
							$str.="</select>
					</div>
				</div>";
		}
		
		if($asociado->rango == "LIDER")
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Zona</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='zona' name='zona' value='".$asociado->zona."'  required>
					</div>
				</div>";
		}
		else
		{
			$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Zona</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='zona' name='zona' value='".$asociado->zona."' readonly='true' required>
					</div>
				</div>";
		}


		

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>GH</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='gh' name='gh' value='".$asociado->gh."' >
					</div>
				</div>";


		
	}
	else
	{
		$q = "SELECT * FROM recursos_asociados 
						WHERE rango = 'LIDER'
						AND activo = 1 ORDER BY nombre ASC";

		$lideres = Recursos_asociados::getAllByQuery($q);
		$departamentos = Recursos_departamentos::getAllByOrden("departamento", "ASC");
		$puestos = Recursos_puestos::getAllByOrden("puesto", "ASC");

		$fechita = date("Y-m-d H:i");
		//echo $fechita;
		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Tipo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo1' value='NS' required> NS 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='tipo' id='tipo2' value='SPYGA' required> SPYGA 
						</label>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Rango</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango1' value='LIDER' required> LIDER 
						</label>
						<label class'radio-inline'>
						  <input type='radio' class='rango' name='rango' id='rango2' value='T BASE' required> T BASE 
						</label>
					</div>
				</div>";


		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Código</label>
					<div class='col-xs-9 '>
						<input type='number'  class='form-control input-sm' id='codigo' name='codigo' value='' autocomplete='off' required>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Nombre</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='nombre' name='nombre' value='' autocomplete='off' required>
					</div>
				</div>";
		
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Sexo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo1' value='H' required> H 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='sexo' id='sexo2' value='M' required> M 
						</label>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Departamento</label>
					<div class='col-xs-9 '>
						<select name='departamento' id='departamento' class='form-control input-sm' required>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($departamentos as $depa) 
								{
									$str.="<option value='".$depa->id."'>".$depa->departamento."</option>";
								}
							$str.="</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Puesto</label>
					<div class='col-xs-9 '>
						<select name='puesto' id='puesto' class='form-control input-sm' required>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($puestos as $puesto) 
								{
									$str.="<option value='".$puesto->id."'>".$puesto->puesto."</option>";
								}
							$str.="</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Fec de nacimiento</label>
					<div class='col-xs-9 '>
						<div class='input-group date' id='datetimepicker1'>
			                    <input type='text' name='f_nacimiento' id='f_nacimiento' class='form-control input-sm' value=''>
			                    <span class='input-group-addon'>
			                        <span class='glyphicon glyphicon-calendar'></span>
			                    </span>
			                </div>
					</div>
				</div>";
		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Fec de ingreso</label>
					<div class='col-xs-9 '>
						<div class='input-group date' id='datetimepicker2'>
			                    <input type='text' name='f_ingreso' id='f_ingreso' class='form-control input-sm' value=''>
			                    <span class='input-group-addon'>
			                        <span class='glyphicon glyphicon-calendar'></span>
			                    </span>
			                </div>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Activo</label>
					<div class='col-xs-9 '>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo1' value='1' required> SI 
						</label>
						<label class'radio-inline'>
						  <input type='radio' name='activo' id='activo2' value='0' required> NO 
						</label>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Líder</label>
					<div class='col-xs-9 '>
						<select name='lider' id='lider' class='form-control input-sm' required>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($lideres as $lider) 
								{
									$str.="<option value='".$lider->codigo."'>".$lider->nombre."</option>";
								}
							$str.="</select>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>Zona</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='zona' name='zona' value='' readonly='true' required>
					</div>
				</div>";

		$str.="<div class='form-group'>
					<label class='col-xs-3 control-label'>GH</label>
					<div class='col-xs-9 '>
						<input type='text'  class='form-control input-sm' id='gh' name='gh' value='' >
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

	$("#lider").on("change", function(){
    		
    		var lider = null;

    		lider = $(this).val();
    		if(lider > 0)
    		{
    			//console.log("hasta aqui");
				var ajax = creaAjax();
			    //document.frmdatos.nocuentaId.value=idcuenta;

			    ajax.open("GET", "helper_recursos.php?consulta=ZONA&lider="+lider, true);
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
			        
			        var zona = n[0];

			        /*document.frmtipo.hp.value = hp;
			        document.frmtipo.volt_nomi_bajo.value = v_bajo;
			        document.frmtipo.volt_nomi_alto.value = v_alto;
			        document.frmtipo.amp_min.value = a_bajo;
			        document.frmtipo.amp_max.value = a_alto;*/

			        $("#zona").val(zona);
			      } 
			    }
			    ajax.send(null);
    		}
    		else
    		{
    			$("#zona").val(null);
    		}
    		
			
    		
    	})

	$(".rango").on("change", function(){
		rango = null;
		rango = $(this).val();

		$("#lider option:first").prop('selected','selected');
		$("#zona").val(null);

		if (rango == "LIDER")
		{
			$("#lider").removeAttr("required");
			$("#zona").attr("required");
			$("#zona").removeAttr("readonly");
		}
		else
		{
			$("#lider").attr("required", "required");
			$("#zona").attr("required", "required");
			$("#zona").attr("readonly", "true");
		}
	})


	$(document).ready(function()
    {
    	
    	
        $(function () {
            $('#datetimepicker1').datetimepicker({
            	 format: 'YYYY-MM-DD',
            	 viewMode: 'years',
            	 picktime: false,
            	 /*autoclose: true,*/
            });
        });
        $(function () {
            $('#datetimepicker2').datetimepicker({
            	 format: 'YYYY-MM-DD',
            	 viewMode: 'years',
            	 picktime: false,
            	 /*autoclose: true,*/
            });
        });
        
    });
</script>


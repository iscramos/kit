<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$id_herramienta = $_GET["id_herramienta"];
	$str = "";
	
	if($id > 0)
	{
		
		$prestamo = Herramientas_prestamos::getById($id);
		$herramienta = Herramientas_herramientas::getById($prestamo->id_herramienta);
		//print_r($herramienta);
		//echo $id_herramienta;
		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 col-xs-4 control-label'>ID</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$id."' readonly>
							<input type='number' class='form-control input-sm' id='id_herramienta' name='id_herramienta' value='".$herramienta->id."' readonly>
						</div>
				</div>";

		$str.="<div class='row'>
			  <div class='col-sm-12 col-xs-12'>
			    <div class='thumbnail' style='height:auto !important;'>
			      <img class='text-center' src='".$contentRead.$herramienta->archivo."' height='120px' width='180px'>
			      <div class='caption bg-primary' >
			        <h4> Clave: ".$herramienta->clave."</h4>
			        <p> Descripción: ".$herramienta->descripcion."</p>
			      </div>
			    </div>
			  </div>
			</div>";
		

		

		$str.="<div class='form-group'>
					
					<div class='col-md-3 col-xs-3  '>
						<label >Código</label>
		                <input type='number' class='form-control input-sm' name='noAsociado' id='noAsociado' value='".$prestamo->noAsociado."' required readonly>
		                
		            </div>
		            <div class='col-md-9 col-xs-9  '>
						<label >Nombre</label>
						<input type='text' class='form-control input-sm' name='nombre' id='nombre' value='".$prestamo->nombre."' required readonly>
					</div>
				</div>";
		$str.="<div class='form-group'>
						<div class='col-md-6 col-xs-6  '>
						<label >Fecha de préstamo</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name='fecha_prestamo' id='fecha_prestamo' class='form-control input-sm' value='".$prestamo->fecha_prestamo."' required autocomplete='off'>
		                    <span class='input-group-addon'>
		                        <span class='glyphicon glyphicon-calendar'></span>
		                    </span>
			            </div>
					</div>
						<div class='col-md-6 col-xs-6  hidden'>
							<label >Estatus</label>
				            <input type='number' name='estatus' id='estatus' class='form-control input-sm' value='2' required readonly> 
						</div>

					<div class='col-md-6 col-xs-6  '>
						<label >Fecha de devolución</label>
						<div class='input-group date' id='datetimepicker2'>
		                    <input type='text' name='fecha_regreso' id='fecha_regreso' class='form-control input-sm' value='' required autocomplete='off'>
		                    <span class='input-group-addon'>
		                        <span class='glyphicon glyphicon-calendar'></span>
		                    </span>
			            </div>
					</div>
				</div>";
		$str.="<div class='form-group'>
						
						<div class='col-md-12 col-xs-12  '>
							<label >Observación</label>
				            <input type='text' name='observacion' id='observacion' class='form-control input-sm' value='' autocomplete='off' > 
						</div>
				</div>";
	}
	else
	{
		$herramienta = Herramientas_herramientas::getById($id_herramienta);
		//print_r($herramienta);
		//echo $id_herramienta;
		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 col-xs-4 control-label'>ID</label>
						<div class='col-sm-8 col-xs-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='".$id."' readonly>
							<input type='number' class='form-control input-sm' id='id_herramienta' name='id_herramienta' value='".$id_herramienta."' readonly>
							<input type='number' class='form-control input-sm' id='id_almacen' name='id_almacen' value='".$herramienta->id_almacen."' readonly>
							<input type='number' class='form-control input-sm' id='id_categoria' name='id_categoria' value='".$herramienta->id_categoria."' readonly>
						</div>
				</div>";

		$str.="<div class='row'>
			  <div class='col-sm-12 col-xs-12'>
			    <div class='thumbnail' style='height:auto !important;'>
			      <img class='text-center' src='".$contentRead.$herramienta->archivo."' height='120px' width='180px'>
			      <div class='caption bg-primary' >
			        <h4> Clave: ".$herramienta->clave."</h4>
			        <p> Descripción: ".$herramienta->descripcion."</p>
			      </div>
			    </div>
			  </div>
			</div>";
		

		

		$str.="<div class='form-group'>
					
					<div class='col-md-5 col-xs-6  '>
						<label >Código</label>
		                <div class='input-group'>
		                    <input type='number' class='form-control input-sm' name='noAsociado' id='noAsociado' value='' required autocomplete='off'>
		                    <span class='input-group-btn '>
		                          <button class='btn btn-success btn-sm' id='buscar'>Buscar</button>
		                    </span> 
		                </div>
		            </div>
		            <div class='col-md-7 col-xs-6  '>
						<label >Nombre</label>
						<input type='text' class='form-control input-sm' name='nombre' id='nombre' value='' required readonly>
					</div>
				</div>";
		$str.="<div class='form-group'>
						<div class='col-md-6 col-xs-6  '>
						<label >Fecha de préstamo</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name='fecha_prestamo' id='fecha_prestamo' class='form-control input-sm' value='' required autocomplete='off'>
		                    <span class='input-group-addon'>
		                        <span class='glyphicon glyphicon-calendar'></span>
		                    </span>
			            </div>
					</div>
						<div class='col-md-6 col-xs-6  hidden'>
							<label >Estatus</label>
				            <input type='number' name='estatus' id='estatus' class='form-control input-sm' value='1' required readonly> 
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
		var noAsociado = null;
    		noAsociado = $("#noAsociado").val();
    	if(noAsociado > 0)
    	{	
			var ajax=creaAjax();

			ajax.open("GET", "helper_recursos.php?consulta=ASOCIADO&codigo="+noAsociado, true);
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
				   
				  
				  	if(str == '*NO ENCONTRADO*')
				  	{
					  	alert("NO ENCONTRADO, REVISAR EL CATALOGO...");
					  	$("#nombre").val(null);
					  	$("#noAsociado").val(null);
				  	}
					else
					{
					  	$("#nombre").val(nombre);
					  	
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

	$(document).ready(function()
    {
    	

        $('#datetimepicker1').datetimepicker({
        	 format: 'YYYY-MM-DD HH:mm:ss',
        	 pickTime: true,
        	 autoclose: true,
        	 
        });

        $('#datetimepicker2').datetimepicker({
        	 format: 'YYYY-MM-DD HH:mm:ss',
        	 pickTime: true,
        	 autoclose: true,
        	 
        });
        
    });
	
</script>
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
		$lideres = Zancos_lideres::getById($id);
		
		
	}
	else
	{
		

		$str.="<div class='form-group hidden'>
					<div class='col-md-12'>
						<label >ID</label>
						<input type='number' class='form-control' id='id' name='id' value='' readonly> 
					</div>
				</div>";

		$str.="<div class='form-group'>
					
					<div class='col-md-4 col-xs-6  '>
						<label >NS</label>
		                <div class='input-group'>
		                    <input type='number' class='form-control input-sm' name='ns' id='ns' value='' required autocomplete='off'>
		                    <span class='input-group-btn '>
		                          <button class='btn btn-success btn-sm' id='buscar_lider'>Buscar</button>
		                    </span> 
		                </div>
		            </div>
		            <div class='col-md-8 col-xs-6  '>
						<label >Nombre</label>
						<input type='text' class='form-control input-sm' name='nombre' id='nombre' value='' required readonly>
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

	
	$("#buscar_lider").on("click", function()
	{	
		var codigo = null;
    		codigo = $("#ns").val();
    	if(codigo > 0)
    	{	
			var ajax=creaAjax();

			ajax.open("GET", "api_catalogo_asociados.php?asociado="+codigo, true);
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
				        
				    var ns = n[0];
				    var nombre = n[1];
				   
				  
				  	if(str == '*NO ENCONTRADO*')
				  	{
					  	alert("NO ENCONTRADO, REVISAR EL CATALOGO...");
					  	$("#ns").val(null);
					  	$("#nombre").val(null);
				  	}
					else
					{
					  	$("#ns").val(ns);
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
    	

    	
        
    });






</script>


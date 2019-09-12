 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Búsqueda (asociado)...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            
                            <div class="x_content">


                                <!-- aqui va el contenido -->
                               <form class="col-sm-12" name="frmtipo" id="divdestino" >

                                    <div class="row">        
                                        <div class="form-group col-sm-offset-4 col-sm-4">
                                            <label ></label>
                                            <div class="input-group " style="margin-bottom: 0px;">
                                                <input type="number" name="ns" id="ns" class="form-control" value="" required="required" placeholder="CODIGO NS" autofocus="autofocus" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" id="buscar" title="Buscar artículo"> <span class='glyphicon glyphicon-search'></span> </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="recibeData" style="text-align: center;">
                                        <!-- aquí irá el resultado de la búsqueda--> 
                                    </div>
                            
                                </form>

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


        <!-- Modal -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar zanco</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createZancos_bd.php">
          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
                </form>
            </div>
          </div>
        </div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

        <script type="text/javascript">

            function creaAjax()
            {
                var objetoAjax=false;
                try {
                    /*Para navegadores distintos a internet explorer*/
                    objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e)
                {
                    try {
                        /*Para explorer*/
                        objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (E) {
                        objetoAjax = false;
                        }
                    }
                if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
                    objetoAjax = new XMLHttpRequest();
                }
                return objetoAjax;
            }

            $("#buscar").on("click", function(e)
                {
                    e.preventDefault();
                    var ns = null;
                        ns = $("#ns").val();

                    if(ns != 0)
                    {
                       
                        $("#recibeData").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");
                        var ajax = creaAjax();
                        ajax.open("GET", "helper_herramientas.php?consulta=BUSQUEDA_POR_ASOCIADO&ns="+ns, true);
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
                                
                                if(str == '*NO ENCONTRADO*')
                                {
                                    $("#recibeData").text("Al parecer este asociado no cuenta con movimientos en la Base de Datos...");
                                    //return false;
                                }
                                else
                                {
                                    $("#recibeData").html(str);
                                }         
                              
                            } 
                        }
                        ajax.send(null);
                    }
                    else
                    {
                        return false;
                    }
                });

            // para buscar zancos por enter
            $("#clave").keypress(function( event ) 
            {
                
              if (event.which == 13) 
              {
                return false;
              }
            });

            $(document).ready(function()
            {
                
            }); // end ready
        </script>
</body>

</html>
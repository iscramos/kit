 <?php require_once(VIEW_PATH.'header.inc.php');
    include(VIEW_PATH.'indexMenu.php');
 ?>

            
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <button class="btn btn-primary btn-md expandir" title="Expandir"> <i class="fa fa-expand" aria-hidden="true"></i> </button>

                    <button class="btn btn-primary btn-md contraer hidden" title="Contraer"> <i class="fa fa-compress" aria-hidden="true"></i> </button>
                    <h1 class="page-header">MP vs MC</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <form class='form-inline'>
                                

                                <div class="form-group">
                                    <select class="form-control" id="ano">
                                        <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>
                                        <option value='2016' ">2016</option>
                                        <option value='2017' ">2017</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success btn-circle btn-md" title="Traer registros" id="verDisponibilidad"><i class="fa fa-database"></i>
                            </button>
                            </form>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" id="disponibilidad" >
                            
                            <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
           
            
        </div>
        <!-- /#page-wrapper -->


  		



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         <script type="text/javascript">
            //$('[data-toggle="tooltip"]').tooltip();
            /*$('[data-toggle="confirmation"]').confirmation(
            {
                title: '¿Eliminar?',
                btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
                      
                onConfirm: function(event) {
                  var idR = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteUser.php?id='+idR;
                },
            });*/

            $(document).ready(function()
            {
                $("#verDisponibilidad").click(function(event) 
                {
                    event.preventDefault();
                    var mes = $("#mes").val();
                    var ano = $("#ano").val();
                    var parametro = "MPvsMC";
                    var valorPlantel = $(this).attr('valorPlantel');

                    //Añadimos la imagen de carga en el contenedor
                    $('#disponibilidad').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperMp_Mc.php", {parametro:parametro, mes:mes, ano:ano} ,function(data)
                    {
                        $("#disponibilidad").html(data);
                    });
                    
                });// fin de disponibilidad

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

                function ajaxCargaDatos(divdestino, uID)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "updateUser.php?id="+uID, true);
                    ajax.onreadystatechange=function() 
                    { 
                        if (ajax.readyState==1)
                        {
                          // Mientras carga ponemos un letrerito que dice "Verificando..."
                          $('#'+divdestino).html='Cargando...';
                        }
                        if (ajax.readyState==4)
                        {
                          // Cuando ya terminó, ponemos el resultado
                            var str =ajax.responseText; 
                                        
                            $('#'+divdestino).html(''+str+'');
                            $("#modalAgregar").modal("show");
                
                        } 
                    }
                    ajax.send(null);
                }

                $('.dataTables-example').DataTable({
                //responsive: true,
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

            }); // end ready
        </script>
</body>

</html>
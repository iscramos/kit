 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>QR Generador...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                          </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Capturar <small> datos</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- aqui va el contenido -->

                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                                        <form class="form-horizontal" method="POST" action="qr_generador.php" target="_blank">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Equipo</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="atributo" required="required" onkeyup="mayus(this);" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Consulta</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="consulta" value="DATA_ACTIVE" readonly="true">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tamaño</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="tamano" id="tamano">
                                                        <option value="1">1</option>
                                                        <option value="2" selected="selected">2</option>
                                                        <option value="4">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-default">Generar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


        <!-- Modal -->
        <div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar programación</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createPlanner.php">
          
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
            //$('[data-toggle="tooltip"]').tooltip();
            
            function mayus(e) 
                {
                    e.value = e.value.toUpperCase();
                }

            $(document).ready(function()
            {


            }); // end ready
        </script>
</body>

</html>
<?php
session_start();
if (isset($_SESSION['usuarioActivo'])) {
    ?>
    <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<?php include("generalidades/apertura.php"); ?>
<body>
    <div id="wrapper">
        <?php include("generalidades/menu.php"); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php" style="font-size:15px;color:blue;">Inicio</a>
                    </li>
                    <li>
                        <a style="font-size:15px;"> Compras</a>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <?php
        $sql = "SELECT * from compra order by fecha_Com ASC";
        $compras = mysqli_query($conexion, $sql) or die("No se puedo ejecutar la consulta");
        ?>
        <div class="row">
            <div class="col-12">
                <div class="row" style="padding:20px">
                    <br>
                    <a class="pull-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modalEditarCompra" style="font-size:16px;">
                            Reporte
                            <span class="fa fa-file-pdf-o"></span>
                        </button>
                        &nbsp;
                    </a>
                    <a class="pull-right" href="AgregarCom.php">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo" style="font-size:16px;">
                            Agregar nueva compra
                            <span class="fa fa-plus"></span>
                        </button>
                        &nbsp;
                    </a>
                    <br><br>
                    <!-- TABLA COMPRAS-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="wrapper wrapper-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-content">
                                                <form class="form-horizontal" action="../Controlador/comprasC.php" method="POST" id="guardarCom" autocomplete="off">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered display" id="example">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:50px">Fecha/Hora</th>
                                                                    <th style="width:50px">N° de factura</th>
                                                                    <th style="width:150px">Proveedor</th>
                                                                    <th align="center" style="width:2px">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php While($compra = mysqli_fetch_assoc($compras)){?>
                                                                    <tr>
                                                                        <td><?php echo $compra['fecha_Com'] ?></td>
                                                                        <td><?php echo $compra['numFac_Com'] ?></td>
                                                                        <td>

<?php 
$aux = $compra['id_Proveedor'];
$sql1 = "SELECT nombre_Prov FROM proveedor where idProveedor = '$aux'";
$proveedor = mysqli_query($conexion, $sql1) or die("No se puedo ejecutar la consulta");
$proveedor = mysqli_fetch_array($proveedor);
echo $proveedor['nombre_Prov'];

/*
$localtime = localtime();
$localtime_assoc = localtime(time(), true);
//print_r($localtime);
//print_r($localtime_assoc);
echo $localtime_assoc['tm_mday']; 
echo "/";
echo $localtime_assoc['tm_mon']; 
echo "/";
echo $localtime_assoc['tm_year']; 
echo " Hora ";
echo $localtime_assoc['tm_hour']; 
echo ":";
echo $localtime_assoc['tm_min']; 
echo ":";
echo $localtime_assoc['tm_sec']; 
*/


 //echo $proveedor;
?>
                                                                        </td>
                                                                        <th align="center">
                                                                        <button title="Ver" type="button" class="btn btn-info fa fa-eye">
                                                                        </button>
                                                                        <button title="Editar" type="button" class="btn btn-success fa fa-pencil-square-o" data-toggle="modal" data-target="#modalEditarCompra" onclick="editarCom('<?php echo $compra['numFac_Com']?>','<?php echo $compra['fecha_Com']?>','<?php echo $compra['total_Com']?>','<?php echo $compra['idCompra']?>','<?php echo $compra['id_Proveedor']?>')">
                                                                        </button>
                                                                    </th>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL EDITAR COMPRA -->
                    <div class="modal fade" id="modalEditarCompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                     <?php 
                     $sql="SELECT * from proveedor where tipo_Prov = 1 order by nombre_Prov ASC";
                     $proveedores= mysqli_query($conexion, $sql) or die("No se puedo ejecutar la consulta"); 
                     ?>
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:#007bff;color:black;">

                                    <h3 class="modal-title" id="myModalLabel"> <i class="fa fa-user"></i> Compra</h3>
                                </div>
                                <div class="modal-body">
                                 <form action="../Controlador/comprasC.php" method="POST" id="editarPro" align="center" autocomplete="off">
                                    <h3><b>Datos generales</b></h3>
                                    <hr width="75%" style="background-color:#007bff;"/><br>
                                    <input type="hidden" value="EditarCom" name="bandera"/>
                                    <input type="hidden" value="" name="idcompra" id="idcompra"/>
                                    <div class="form-group row" id="data_2">
                                        <label for="empresa" class="col-sm-12 col-md-2 col-form-label">Numero de factura: </label>
                                        <div class="col-sm-12 col-md-3">
                                            <input class="form-control" type="number" id="nummeroFacComEditar" placeholder="" style="width:150px;height:40px">
                                        </div>
                                        <?php
                                        
                                            date_default_timezone_set('america/el_salvador');
                                            $hora1 = date("A");
                                            $hoy = getdate();
                                            $hora = date("g");
                                            //print_r($hoy);
                                            // echo " Fecha ";
                                            // echo ($hoy['mday']);
                                            // echo "/";
                                            // echo $hoy['mon'];
                                            // echo "/";
                                            // echo $hoy['year'];
                                            // echo "       Hora ";
                                            // echo $hora;
                                            // echo ":";
                                            // echo $hoy['minutes'];
                                            // echo ":";
                                            // echo $hoy['seconds'];
                                            // echo $hora1;
                                            
                                        ?>
                                        <label for="empresa" class="col-sm-12 col-md-2 col-form-label">Fecha: </label>
                                        <div class="col-sm-12 col-md-3 input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input class="form-control" type="text" id="fecha" value="01/01/2018" style="width:150px;height:40px">
                                        </div>
                                    </div>
                                    <div>
                                        
                                    </div>
                                    <div class="form-group row">
                                        <label for="empresa" class="col-sm-12 col-md-2 col-form-label">Proveedor:</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select style="width:350px;height:40px" class="form-control" name="proveedorComE" id="proveedorComEditar"> 
                                                <option value="">[Selecionar Proveedor]</option>
                                                <?php

                                                While($proveedor=mysqli_fetch_array($proveedores)){
                                                     echo '<option value="'.$proveedor['idProveedor'].'">'.$proveedor['nombre_Prov'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <h3><b>Datos del producto</b></h3>
                                    <hr width="75%" style="background-color:#007bff;"/><br>
                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-12 col-md-2 col-form-label">Cantidad:</label>
                                        <div class="col-sm-12 col-md-3">
                                            <input class="form-control" type="number" id="cantidadComEditar" placeholder="Cantidad" style="width:150px;height:40px">
                                        </div>
                                        <label for="direccion" class="col-sm-12 col-md-2 col-form-label">Precio Unitario:</label>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="input-group m-b"><span class="input-group-addon">$</span> <input type="number" class="form-control" id="preciouniComEditar"></div>
                                            <!-- <input class="form-control" type="number" placeholder="$" style="width:150px;height:40px"> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="empresa" class="col-sm-12 col-md-2 col-form-label">Categoria:</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select style="width:400px;height:40px" class="form-control" id="categoriaComEditar"> 
                                                <option value="">[Selecionar categoria]</option>
                                                <option value="1">AMORTIGUADORES</option>
                                                <option value="2">BUJÍAS</option>
                                                <option value="3">COMBUSTIBLE</option>
                                                <option value="4">ELÉCTRICO</option>
                                                <option value="5">ENFRIAMIENTO</option>
                                                <option value="6">FILTROS</option>
                                                <option value="7">FRENOS</option>
                                                <option value="8">MOTOR</option>
                                                <option value="8">SENSORES</option>
                                                <option value="10">SUSPENSIÓN Y DIRECCIÓN</option>
                                                <option value="11">TRANSMISIÓN Y EMBRAGUE</option>
                                                <option value="12">UNIVERSALES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="empresa" class="col-sm-12 col-md-2 col-form-label">Producto:</label>
                                        <div class="col-sm-12 col-md-8">
                                            <select  class="form-control" id="productoComEditar"> 
                                                <option value="">[Selecionar Producto]</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <button title="Ver caracteristicas" type="button" class="btn btn-info fa fa-eye" style="width:39px;height:39px" data-toggle="modal" data-target="#modalVerAddProducto"></button>
                                        </div>
                                    </div>
                                    <hr width="75%" /><br>
                                    <div class="form-group" align="center">
                                        <button title="Agregar a tabla" type="button" class="btn btn-primary fa fa-plus" style="width:80px;height:40px"></button>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h3><b>Detalles de la compra</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:10px">Cantidad</th>
                                                            <th style="width:200px">Producto</th>
                                                            <th style="width:30px">Precio unitario</th>
                                                            <th style="width:30px">Subtotal</th>
                                                            <th style="width:50px">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productos">
                                                        <tr>
                                                            <td>...</td>
                                                            <td>...</td>
                                                            <td>...</td>
                                                            <td>...</td>
                                                            <td>
                                                                <button title="Eliminar" type="button" class="btn btn-danger fa fa-trash"></button>
                                                            </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-footer small text-muted"></div>
                                        </div>
                                        <div class="form-group row">
                                            <label align="right" for="nrc" class="col-sm-12 col-md-8 col-form-label">Total de compra:</label>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input type="number" class="form-control" id="totalComEditar" readonly="readonly"></div>
                                                <!-- <input class="form-control" type="text" placeholder="$" style="width:150px;height:40px"> -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br><br>
                                <div class="modal-footer">
                                  <input type="hidden" id="anterior" value=""  />
                                  <button type="button" class="btn btn-default" style="background-color:#007bff;color:black;font-size:15px;">Aceptar</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#007bff;color:black;font-size:15px;">Cerrar</button>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="modal fade" id="modalVerAddProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                   <div class="modal-dialog modal-lg" role="document">
                       <div class="modal-content">
                           <div class="modal-header" style="background-color:#007bff;color:black;">

                               <h3 class="modal-title" id="myModalLabel"> <i class="fa fa-user"></i> Producto</h3>
                           </div>
                           <div class="modal-body">
                               <hr width="75%" style="background-color:#007bff;"/>
                               <div class="form-group ">
                                   <label align="right" for="nombre" class="col-sm-4 control-label" style="font-size:15px;">Codigo: </label>
                                   <div class="col-sm-7">
                                       <input class="form-control" type="text" id="codigoP" name="codigoP" readonly="readonly" aria-required="true" value="">
                                   </div>
                               </div>
                               <br><br><br><br>
                               <div class="form-group">
                                   <label align="right" for="tel3" class="col-sm-4 control-label" style="font-size:15px;">Nombre Producto:</label>
                                   <div  class="col-sm-7">
                                       <input class="form-control" type="text" id="nombreP" name="nombreP" disabled="true">
                                   </div>
                               </div>
                               <br><br><br>
                               <div class="form-group">
                                   <label align="right" for="cateP" class="col-sm-4 control-label" style="font-size:15px;">Categoria:</label>
                                   <div class="col-sm-3">
                                       <input class="form-control" type="text" id="cateP" name="cateP" value="" disabled="true">
                                   </div>
                               </div>
                               <br><br><br>
                               <div class="form-group">
                                   <label align="right" for="direccion" class="col-sm-4 control-label" style="font-size:15px;">Marca de Producto:</label>
                                   <div class="col-sm-7">
                                       <input class="form-control" type="text" type="text" name="marcaP"  id="marcaP" disabled="true">
                                   </div>
                               </div>
                               <br><br><br>
                               <div class="form-group">
                                   <label align="right" for="nombre" class="col-sm-4 control-label" style="font-size:15px;">Modelo de Vehiculo:</label>
                                   <div class="col-sm-7">
                                       <input class="form-control" type="text" id="modeloP" name="modeloP" disabled="true">
                                   </div>
                               </div>
                               <br><br><br>
                               <div class="form-group">
                                   <label align="right" for="usuario" class="col-sm-4 control-label" style="font-size:15px;">Año del Vehiculo:</label>
                                   <div class="col-sm-3">
                                       <input class="form-control" type="text" id="anioP" name="anioP" disabled="true">
                                   </div>
                               </div>
                               <div id="ocultar">
                                   <br><br><br>
                                   <div class="form-group">
                                       <label align="right" for="usuario" class="col-sm-4 control-label" style="font-size:15px;">Descripción:</label>
                                       <div class="col-sm-7">
                                        <textarea class="form-control" type="text" name="descripcion" id="descripcionP"  placeholder="Escriba aqui..."  disabled="true">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#007bff;color:black;font-size:15px;">Cerrar</button>
                       </div>
                   </div>
               </div>

           </div>

                  <script src="../assets/Validaciones/mostrarCompra.js"></script> 
                  <script src="../assets/js/plugins/chosen/chosen.jquery.js"></script>
                  <script src="../assets/js/plugins/jsKnob/jquery.knob.js"></script>
                  <script src="../assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>
                  <script src="../assets/js/plugins/fullcalendar/moment.min.js"></script>
              </div>
          </div>
          <?php include("generalidades/cierre.php"); ?>
      </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

<script>
        $(document).ready(function(){

            var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1.618,
                preview: ".img-preview",
                done: function(data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function() {
                window.open($image.cropper("getDataURL"));
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function() {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function() {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function() {
                $image.cropper("setDragMode", "crop");
            });

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            var elem_2 = document.querySelector('.js-switch_2');
            var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.demo1').colorpicker();

            var divStyle = $('.back-change')[0].style;
            $('#demo_apidemo').colorpicker({
                color: divStyle.backgroundColor
            }).on('changeColor', function(ev) {
                        divStyle.backgroundColor = ev.color.toHex();
                    });

            $('.clockpicker').clockpicker();

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            $(".select2_demo_3").select2({
                placeholder: "Select a state",
                allowClear: true
            });


            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin2").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%',
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });

            $(".touchspin3").TouchSpin({
                verticalbuttons: true,
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });


        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        $("#ionrange_1").ionRangeSlider({
            min: 0,
            max: 5000,
            type: 'double',
            prefix: "$",
            maxPostfix: "+",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_2").ionRangeSlider({
            min: 0,
            max: 10,
            type: 'single',
            step: 0.1,
            postfix: " carats",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_3").ionRangeSlider({
            min: -50,
            max: 50,
            from: 0,
            postfix: "°",
            prettify: false,
            hasGrid: true
        });

        $("#ionrange_4").ionRangeSlider({
            values: [
                "January", "February", "March",
                "April", "May", "June",
                "July", "August", "September",
                "October", "November", "December"
            ],
            type: 'single',
            hasGrid: true
        });

        $("#ionrange_5").ionRangeSlider({
            min: 10000,
            max: 100000,
            step: 100,
            postfix: " km",
            from: 55000,
            hideMinMax: true,
            hideFromTo: false
        });

        $(".dial").knob();

        $("#basic_slider").noUiSlider({
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min':  20,
                'max':  80
            }
        });

        $("#range_slider").noUiSlider({
            start: [ 40, 60 ],
            behaviour: 'drag',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });

        $("#drag-fixed").noUiSlider({
            start: [ 40, 60 ],
            behaviour: 'drag-fixed',
            connect: true,
            range: {
                'min':  20,
                'max':  80
            }
        });


    </script>


</body>
</html>
<?php
}else{
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="refresh" content="0;URL=/SISAUTO1/view/login.php">
    </head>
    <body>
    </body>
    </html>
    <?php
}
?>
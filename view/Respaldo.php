<?php
session_start();
if (isset($_SESSION['usuarioActivo'])) {
	?>
	<!DOCTYPE html>
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
					</ol>
				</div>
				<div class="col-lg-2">
				</div>
			</div>
			<form class="form-horizontal" action="../backup/backaup.php" method="POST">
				<input type="hidden" name="bandera" value="backup" />
				<a class="pull-right" href="">
					<button class="btn btn-success" style="font-size:16px;" type="submit">
						Nuevo
						<span class="fa fa-file-pdf-o"></span>
					</button>
					&nbsp;
				</a>
				<a class="pull-right" href="" data-toggle="modal" data-target="#modalSubirBackup">
					<button class="btn btn-success" style="font-size:16px;">
						Subir
						<span class="fa fa-file-pdf-o"></span>
					</button>
					&nbsp;
				</a>
			</form>
			<div class="row">

				<div class="col-lg-12">

					<div class="wrapper wrapper-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="ibox float-e-margins">
									<div class="ibox-content">
										<form class="form-horizontal" action="../Controlador/clienteC.php" method="POST" id="guardarCli">
											<div class="table-responsive">
												<?php  $ruta ="../backup/db";

												if (is_dir($ruta)) {
													$gestor = opendir($ruta);
													
													?>
													<table class="table table-striped table-bordered display" id="example">
														<thead>
															<tr>
																<th>Archivo</th>
																<th>Tamaño</th>
																<th>Fecha</th>
																<th>Acciones</th>
															</tr>
														</thead>
														<tbody>

															<?php  while (($archivo = readdir($gestor)) !== false)  {
														 // Recorre todos los elementos del directorio

																$ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
																if ($archivo != "." && $archivo != "..") {
																	?>
																	<tr>
																		<td>
																			<?php 
																			echo  $archivo ;
																			?>
																		</td>
																		<td>
																			<?php echo filesize( $ruta."/".$archivo) . " bytes"; ?>
																		</td>
																		<td>
																			<?php echo date("d-m-Y g:i:s a", filemtime($ruta."/".$archivo)); ?>
																		</td>	
																		<td>
																			<a title="Descargar"  class="btn btn-success fa fa-pencil-square-o" href="/SISAUTO1/backup/db/<?php echo $archivo ?><?php  ?>" ></a>
																			<a title="Respaldar"  class="btn btn-success " onclick="restaurar('<?php echo $archivo ?>');"></a>

																		</td>		
																	</tr>
																	<?php
																}
															}?>
														</tbody>

													</table>
													<?php
        // Cierra el gestor de directorios
													closedir($gestor);
												}else{

													echo "No es una ruta de directorio valido";

												} ?>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<script type="text/javascript">
			function restaurar(n){
				$.ajax({
					type: 'post',
					url: '/SISAUTO1/backup/backaup.php',
					data: {
						nombre: n,
						bandera: "respaldar",
					},
					success: function(r){
						console.log(r);
					}
				});
			}
			</script>

			<div class="modal fade" id="modalSubirBackup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
					<form class="form-horizontal" action="../backup/backaup.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="bandera" value="subida"/>
							<div class="modal-header" style="background-color:#007bff;color:black;">

								<h3 class="modal-title" id="myModalLabel"> <i class="fa fa-user"></i> Backup</h3>
							</div>
							<div class="modal-body">
								<h2 align="center"><b>Subir Archivo</b></h2>
								<hr width="75%" style="background-color:#007bff;"/>

								<div class="form-group">

									<div class="col-sm-12">
										<input class="form-control" type="file"  name="archivo" accept=".sql" required>
									</div>
								</div>
							</div>

							<br><br>
							<div class="modal-footer">
								<button type="submit" class="btn btn-default" style="background-color:#007bff;color:black;font-size:15px;">Aceptar</button>
								<button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#007bff;color:black;font-size:15px;">Cerrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>



			<?php include("generalidades/cierre.php"); ?>
		</div>


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

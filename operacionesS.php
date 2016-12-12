<!DOCTYPE html>
<?php
require 'ClaseConexion.php';
set_error_handler("Errores", E_WARNING);
function Errores(){
	echo '';
	}
?>
<html lang="es">

	<head>
		<meta charset='utf-8'>
		<link href="CSS/estilo.css" rel="stylesheet" >
	</head>
	<body>
    <a href="<?=$_SERVER['HTTP_REFERER']?>">Volver</a>
		<div id="principal">
		
			<header>
				<hgroup>
					<h1> SOFTWARE2 </h1>
				</hgroup>
				<nav>
					<ul>
						<li><a href='index.php'>INICIO</a></li>
						<li><a href='libros.php'>LIBROS</a></li>
						<li><a href='socios.php'>SOCIOS</a></li>
						<li><a href='prestamos.php'>PRESTAMOS</a></li>
						<li><a href='informes.php'>INFORMES</a></li>
						<li><a href='cerrar_sesion.php'>Cerrar Sesión</a></li>
					</ul>
				</nav>
			</header>
			<section>
				<div id="textoPr">
					<hgroup>
						<h1> Resultados</h1>
					</hgroup>
					<?php
					

					$socios= oci_parse($conn,"select * from socio");
					oci_execute($socios);
					if (isset($_POST["eliminarS"])){
								$socio=$_POST["eliminarS"];
								$cont=1;
								while($cont!=0){
									if($row=oci_fetch_row($socios)){
										if($row[0]==$socio){
											$stid = oci_parse($conn,"delete from GUTY17.socio where socio=$row[0]");
											oci_execute($stid);
											echo 'socio eliminado...';
											break;
										}
									}else{
										echo 'el socio no existe...';
										break;
										 }
								}
							}
					//-----------DATOS PARA SOCIOS--------------------------
					if (isset($_POST["btnActualizarS"])|| isset($_POST["btnGuardarS"])||isset($_POST["btnEliminarS"])||isset($_POST["eliminarS"])){

							$conexion = Conexion::getInstance();
							//ACCION BOTON GUARDAR SOCIO
							if (isset($_POST["btnGuardarS"])){
								
								$met = $conexion->Insertar('socio',array($_POST["socio"],$_POST["nombre"],$_POST["telefono"],date('d-m-Y', strtotime($_POST["fingreso"]))),array('socio','nombre','telefono','ingreso'));
								echo $met;
								
							}
							//ACCION BOTON ACTUALIZAR SOCIO
							if (isset($_POST["btnActualizarS"])){
								$met = $conexion->Actualizar('socio',array($_POST["socio"],$_POST["nombre"],$_POST["telefono"],date('d-m-Y', strtotime($_POST["fingreso"]))));
								echo $met;
							}
							//ACCION BOTON ELIMINAR SOCIO
							if (isset($_POST["btnEliminarS"])){
								if(isset($_POST["eliminarS"])){
									$met = $conexion->Eliminar('socio',$_POST["eliminarS"]);
								}else{
									$met = $conexion->Eliminar('socio',$_POST["socio"]);
								}
								echo $met;
								
							}
						
						
					}				
					
				?>
					
				</div>
				<br>
				<div id="tablaPr">
					<table id="consulta">
						<tr>
						<th>ID SOCIO</th>
						<th>NOMBRE</th>
						<th>TELEFONO</th>
						<th>FECHA DE INGRESO</th>
						</tr> 
						<?php 
							
							$conexion = Conexion::getInstance();
							if (isset($_POST["btnActualizarS"])|| isset($_POST["btnGuardarS"])||isset($_POST["btnEliminarS"])||isset($_POST["eliminarS"])){
								$result = $conexion->getSocios();
							}if(isset($_POST["btnBuscarS"])){
								$buscar = $_POST["buscar"];
								$result = $conexion->buscarSocios($buscar);
							}
								oci_execute($result);
								while ($row = oci_fetch_row($result)) {
									   echo" <tr>
									   <td>$row[0]</td>
									   <td>$row[1]</td>
									   <td>$row[2]</td>
									   <td>$row[3]</td>
									   </tr>";
								}
								
						
						?> 
			
					</table>   
				</div>			
			</section>
		</div>	
		
	</body>
</html>
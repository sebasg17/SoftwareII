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
						<h1> Resultados </h1>
					</hgroup>
					<?php
 
						//-----------DATOS PARA PRESTAMOS--------------------------
							//ACCION BOTON GUARDAR PRESTAMO
						
							$conexion = Conexion::getInstance();
							if (isset($_POST["btnGuardarP"])){
								$fdevolucion=$_POST["fdevolucion"];
								if($fdevolucion!=""){
								$fdevolucion = date('d-m-Y', strtotime($fdevolucion));
								}
								$met = $conexion->Insertar('prestamo',array($_POST["libro"],$_POST["socio"],date('d-m-Y', strtotime($_POST["fprestamo"])),$fdevolucion));
								echo $met;
							}
							//ACCION BOTON ACTUALIZAR PRESTAMO
							if (isset($_POST["btnActualizarP"])){
								$fdevolucion=$_POST["fdevolucion"];
								if($fdevolucion!=""){
								$fdevolucion = date('d-m-Y', strtotime($fdevolucion));
								}
								$met = $conexion->Actualizar('prestamo',array($_POST["libro"],$_POST["socio"],date('d-m-Y', strtotime($_POST["fprestamo"])),$fdevolucion));
								echo $met;
							}
							//ACCION BOTON ELIMINAR PRESTAMO
							if (isset($_POST["btnEliminarP"])||isset($_POST["eliminarP"])){
								if(isset($_POST["eliminarP"])){
									$coma = strpos($_POST["eliminarP"],',');
									$libro = substr($_POST["eliminarP"],0,$coma);
									$socio = substr($_POST["eliminarP"],$coma+1);  
									$met = $conexion->Eliminar('prestamo',array($libro,$socio));
								}else{
									$met = $conexion->Eliminar('prestamo',array($_POST["libro"],$_POST["socio"]));
								}
								echo $met;

							}
						

					
					
				?>
					
				</div>
				<br>
				<div id="tablaPr">
					<table id="consulta">
						<tr>
						<th>NOMBRE DEL LIBRO</th>
						<th>NOMBRE DEL SOCIO</th>
						<th>FECHA DE PRESTAMO</th>
						<th>FECHA DE DEVOLUCION</th>
						</tr> 
						<?php 
						if (isset($_POST["btnActualizarP"])|| isset($_POST["btnGuardarP"])||isset($_POST["btnEliminarP"])||isset($_POST['eliminarP'])){
							$result = oci_parse($conn,'SELECT libro.titulo,socio.nombre,prestamo.fprestamo,prestamo.fdevolucion FROM GUTY17.prestamo,GUTY17.socio,GUTY17.libro where libro.libro=prestamo.libro and socio.socio=prestamo.socio order by prestamo.fprestamo');
						}if(isset($_POST["btnBuscarP"])){
								$buscar=$_POST["buscar"];
								$result=oci_parse($conn,"select libro.titulo,socio.nombre,prestamo.fprestamo,prestamo.fdevolucion FROM GUTY17.prestamo,GUTY17.socio,GUTY17.libro where libro.libro=prestamo.libro and socio.socio=prestamo.socio and UPPER(libro.titulo) LIKE UPPER('%$buscar%')");
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
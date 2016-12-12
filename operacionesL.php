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
					

					//-----------DATOS PARA LIBRO--------------------------
					
					if (isset($_POST["btnActualizarL"])|| isset($_POST["btnGuardarL"])||isset($_POST["btnEliminarL"])||isset($_POST["eliminarL"])){
						$conexion = Conexion::getInstance();
						if (isset($_POST["btnGuardarL"])){
							$met = $conexion->Insertar('libro',array($_POST["libro"],$_POST["titulo"],$_POST["autor"],$_POST["numpaginas"]),array('libro','titulo','autor','numpag'));
							echo $met;
						}
							//ACCION BOTON ACTUALIZAR LIBRO
							if (isset($_POST["btnActualizarL"])){
								$met = $conexion->Actualizar('libro',array($_POST["libro"],$_POST["titulo"],$_POST["autor"],$_POST["numpaginas"]));
							echo $met;					
								
							}
						
							//ACCION BOTON ELIMINAR LIBRO
							if (isset($_POST["btnEliminarL"])||isset($_POST["eliminarL"])){
								if(isset($_POST["eliminarL"])){
									$met = $conexion->Eliminar('libro',$_POST["eliminarL"]);
								}else{
									$met = $conexion->Eliminar('libro',$_POST["libro"]);
								}
									echo $met;
							}
					}

										

				?>
					
				</div>
				<br>
				<div id="tablaPr">
					<table id="consulta" >
						<tr>
						<th>Libro</th>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Num. Paginas</th>
						</tr> 
						<?php 
							
							if (isset($_POST["btnActualizarL"])|| isset($_POST["btnGuardarL"])||isset($_POST["btnEliminarL"])||isset($_POST['eliminarL'])){
 								$result = oci_parse($conn,'SELECT * FROM GUTY17.libro order by libro');
																
							}if(isset($_POST["btnBuscarL"])){
								$buscar=$_POST["buscar"];
								$result=oci_parse($conn,"select * from GUTY17.libro where UPPER(titulo) LIKE UPPER('%$buscar%')");
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
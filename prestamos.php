<!DOCTYPE html>
<?php
require ('ClaseConexion.php');
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
					</ul>
				</nav>
			</header>
			<section>
				<div id="textoPr">
					<hgroup>
						<h1> PRESTAMOS </h1>
					</hgroup>
					<form method='POST' action='operacionesP.php'> 
						<label for='libro'>Libro: </label>
						<input type='number' id='libro' name='libro' placeholder='id del libro' required min='0'>
						<label for='socio'>Socio: </label>
						<input type='number' id='socio' name='socio' placeholder='id del socio' required min='0'>
						<label for='fprestamo'>Fecha Prestamo: </label>
						<input type='date' id='fprestamo' name='fprestamo' placeholder='Fecha del prestamo' required> 
						<label for='fdevolucion'>Fecha Devolucion: </label>
						<input type='date' id='fdevolucion' name='fdevolucion' placeholder='fecha de ingreso'>
                        <br>
						<!---<input type='submit' value='Guardar' id='btnGuardar' name='btn'>---> 
                        <input id="btnGuardarP" class="btnGuardarP" name="btnGuardarP" type="submit" value="Guardar"/>
						<input id="btnActualizarP" class="btnActualizarP" name="btnActualizarP" type="submit" value="Actualizar"/>
						<input id="btnEliminarP" class="btnEliminarP" name="btnEliminarP" type="submit" value="Eliminar"/>
					</form>
					
				</div>
				<br>
				<div id="tablaPr">
				<form method="POST" action="operacionesP.php">
                    	<input type='text' id='buscar' name='buscar' placeholder='buscar...' >
                    	<input id="btnBuscarP" class="btnBuscarP" name="btnBuscarP" type="submit" value="Buscar"/>
					<table id="consulta">
						<tr>

						<th>LIBRO</th>

						<th>SOCIO</th>
						<th>FECHA DE PRESTAVO</th>
						<th>FECHA DE DEVOLUCION</th>
						</tr> 
						<?php 
								$conexion = Conexion::getInstance();
								$result = oci_parse($conexion->getConexion(),'SELECT libro.libro,libro.titulo,socio.socio,socio.nombre,prestamo.fprestamo,prestamo.fdevolucion FROM prestamo,socio,libro where libro.libro=prestamo.libro and socio.socio=prestamo.socio order by prestamo.fprestamo');
								oci_execute($result);
								while ($row = oci_fetch_row($result)) {
									   echo" <tr>

									   <td>$row[1]</td>
									   <td>$row[3]</td>

									   <td>$row[4]</td>
									   <td>$row[5]</td>
									   <td><button name='eliminarP' type='submit' value=$row[0],$row[2]>Eliminar</button></td>
									   </tr>";
								}
						?> 
			
					</table>  
					</form> 
				</div>			
			
			</section>
		</div>	
		
	</body>
</html>
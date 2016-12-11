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
						<h1> SOCIOS </h1>
					</hgroup>
					<form method='POST' action='operacionesS.php'> 
						<label for='socio'>Socio: </label>
						<input type='number' id='socio' name='socio' placeholder='id del socio' required min='0'>
						<label for='nombre'>Nombre: </label>
						<input type='text' id='nombre' name='nombre' placeholder='Nombre del socio' required>
						<label for='telefono'>Telefono: </label>
						<input type='text' id='telefono' name='telefono' placeholder='Telefono del socio'> 
						<label for='fingreso'>Fecha Ingreso: </label>
						<input type='date' id='fingreso' name='fingreso' placeholder='fecha de ingreso' required>
                        <br>
						<!---<input type='submit' value='Guardar' id='btnGuardar' name='btn'>---> 
                        <input id="btnGuardarS" class="btnGuardarS" name="btnGuardarS" type="submit" value="Guardar"/>
						<input id="btnActualizarS" class="btnActualizarS" name="btnActualizarS" type="submit" value="Actualizar"/>
						<input id="btnEliminarS" class="btnEliminarS" name="btnEliminarS" type="submit" value="Eliminar"/>
					</form>
					
				</div>
				<br>
				<div id="tablaPr">
					<form method="POST" action="operacionesS.php">
                    	<input type='text' id='buscar' name='buscar' placeholder='buscar...' >
                    	<input id="btnBuscarS" class="btnBuscarS" name="btnBuscarS" type="submit" value="Buscar"/>
                    
                	<table id="consulta">
						<tr>
						<th>SOCIO</th>
						<th>NOMBRE</th>
						<th>TELEFONO</th>
						<th>FECHA DE INGRESO</th>
						</tr> 
						<?php 
								$conexion = Conexion::getInstance();
								$result = oci_parse($conexion->getConexion(),'SELECT * FROM SOCIO order by SOCIO');
								oci_execute($result);
								while ($row = oci_fetch_row($result)) {
									   echo" <tr>
									   <td>$row[0]</td>
									   <td>$row[1]</td>
									   <td>$row[2]</td>
									   <td>$row[3]</td>
									   <td><button name='eliminarS' type='submit' value=$row[0]>Eliminar</button></td>
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
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<link href="CSS/estilo.css" rel="stylesheet" >
	</head>
	<body>
		<div id="principal">
		
			<header>
				<hgroup>
					<h1> SOFWARE2.COM </h1>
				</hgroup>
				<nav>
					<ul>
						<li><a href='index.html'>INICIO</a></li>
						<li><a href='libros.html'>LIBROS</a></li>
						<li><a href='socios.html'>SOCIOS</a></li>
						<li><a href='prestamos.html'>PRESTAMOS</a></li>
						<li><a href='informes.html'>INFORMES</a></li>
					</ul>
				</nav>
			</header>
			<section>
				<div id="textoPr">
					<hgroup>
						<h1> Libros</h1>
					</hgroup>
					<form method='POST' action='operacionesL.php'> 
						<label for='libro'>Libro: </label>
						<input type='number' id='libro' name='libro' placeholder='id del libro' required min='0'>
						<label for='titulo'>Titulo: </label>
						<input type='text' id='titulo' name='titulo' placeholder='titulo del libro' required>
						<label for='autor'>Autor: </label>
						<input type='text' id='autor' name='autor' placeholder='autor del libro'> 
						<label for='numpaginas'>Num. Paginas: </label>
						<input type='number' id='numpaginas' name='numpaginas' placeholder='numero de paginas del libro' min='0'>
                        <br>
						<!---<input type='submit' value='Guardar' id='btnGuardar' name='btn'>---> 
                        <input id="btnGuardar" class="btnGuardar" name="btnGuardar" type="submit" value="Guardar"/>
						<input id="btnActualizar" class="btnActualizar" name="btnActualizar" type="submit" value="Actualizar"/>
						<input id="btnEliminar" class="btnEliminar" name="btnEliminar" type="submit" value="Eliminar"/>
					</form>
					
				</div>
				<br>
				<form method='POST' action='operacionesL.php'> 
				<div id="tablaPr">
					<table id="consulta">
						<tr>
						<th>Libro</th>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Num. Paginas</th>
						</tr> 
						<?php 
								$conn = oci_connect('didier','unillanos','localhost/XE'); 
								$result = oci_parse($conn,'SELECT * FROM libro order by libro');
								oci_execute($result);
								while ($row = oci_fetch_row($result)) {
									   echo" <tr>
									   <td>$row[0]</td>
									   <td>$row[1]</td>
									   <td>$row[2]</td>
									   <td>$row[3]</td>
									   <td><button name='eliminar' type='submit' value=$row[0]>Eliminar</button></td>
									   </tr>";
								}
						?> 
			
					</table>   
				</div>			
				</form>
			</section>
		</div>	
		
	</body>
</html>
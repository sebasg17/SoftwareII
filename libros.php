<!DOCTYPE html>
<?php
require ('ClaseConexion.php');
require ('ControlUsuarios.php');
$ctrlUsuarios = ControlUsuarios::getInstance();
$isL = $ctrlUsuarios->isLogueado();
if (!$isL){
	$_SESSION['mensaje'] = 'Inicie sesión para ver esta página';
	header("Location: login.php");
}
?>
<html lang="es">
	<head>
		<meta charset='utf-8'>
		<link href="CSS/estilo.css" rel="stylesheet" >
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#btnActualizarL').hide();
				$('#btnEliminarL').hide();
				$('#opcion').change(function(){
					var opc = $('#opcion').val();
					if (opc === 'crear'){
						$('#btnActualizarL').hide();
						$('#btnEliminarL').hide();
						$('#btnGuardarL').show();
						$('#titulo').show();
						$('#autor').show();
						$('#numpaginas').show();
						$('#labelTitulo').show();
						$('#labelAutor').show();
						$('#labelNumPaginas').show();
					}
					else if (opc === 'actualizar'){
						$('#btnActualizarL').show();
						$('#btnEliminarL').hide();
						$('#btnGuardarL').hide();
						$('#titulo').show();
						$('#autor').show();
						$('#numpaginas').show();
						$('#labelTitulo').show();
						$('#labelAutor').show();
						$('#labelNumPaginas').show();
					}
					else if (opc === 'eliminar'){
						$('#btnActualizarL').hide();
						$('#btnEliminarL').show();
						$('#btnGuardarL').hide();
						$('#titulo').hide();
						$('#autor').hide();
						$('#numpaginas').hide();
						$('#labelTitulo').hide();
						$('#labelAutor').hide();
						$('#labelNumPaginas').hide();
					}
				});
			});
		</script>
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
						<h1> LIBROS</h1>
					</hgroup>
					<select id="opcion">
						<option value="crear">Crear</option>
						<option value="actualizar">Actualizar</option>
						<option value="eliminar">Eliminar</option>
					</select>
					<form method='POST' action='operacionesL.php'> 
						<label for='libro'>Libro: </label>
						<input type='number' id='libro' name='libro' placeholder='id del libro' required min='0'>
						<label id="labelTitulo" for='titulo'>Titulo: </label>
						<input type='text' id='titulo' name='titulo' placeholder='titulo del libro'>
						<label id="labelAutor" for='autor'>Autor: </label>
						<input type='text' id='autor' name='autor' placeholder='autor del libro' value=""> 
						<label id="labelNumPaginas" for='numpaginas'>Num. Paginas: </label>
						<input type='number' id='numpaginas' name='numpaginas' placeholder='numero de paginas del libro' min='0'>
                        <br>
						<!---<input type='submit' value='Guardar' id='btnGuardar' name='btn'>---> 
                        <input id="btnGuardarL" class="btnGuardarL" name="btnGuardarL" type="submit" value="Guardar"/>
						<input id="btnActualizarL" class="btnActualizarL" name="btnActualizarL" type="submit" value="Actualizar"/>
						<input id="btnEliminarL" class="btnEliminarL" name="btnEliminarL" type="submit" value="Eliminar"/>
                        
					</form>
					
				</div>
				<br>
				<div id="tablaPr">
                	<form method="POST" action="operacionesL.php">
                    	<input type='text' id='buscar' name='buscar' placeholder='buscar...' >
                    	<input id="btnBuscarL" class="btnBuscarL" name="btnBuscarL" type="submit" value="Buscar"/>
                    
					<table id="consulta" >
						<tr>
						<th>Libro</th>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Num. Paginas</th>
						</tr> 
						<?php 
								$conexion = Conexion::getInstance();
								$result = oci_parse($conexion->getConexion(),'SELECT * FROM GUTY17.libro order by libro');
								oci_execute($result);
								while ($row = oci_fetch_row($result)) {
									   echo" <tr>
									   <td>$row[0]</td>
									   <td>$row[1]</td>
									   <td>$row[2]</td>
									   <td>$row[3]</td>
									   <td><button name='eliminarL' type='submit' value=$row[0]>Eliminar</button></td>
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
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
						<h1> Resultados</h1>
					</hgroup>
					<?php
require 'ClaseConexion.php';
$conexion = Conexion::getInstance();
$conn     = oci_connect('didier', 'unillanos', 'localhost/XE') or die("error al conectar");
//-----------DATOS PARA LIBRO--------------------------

$libro      = $_POST["libro"];
$titulo     = $_POST["titulo"];
$autor      = $_POST["autor"];
$numpaginas = $_POST["numpaginas"];
$libros     = oci_parse($conn, "select * from libro");
oci_execute($libros);
//ACCION BOTON GUARDAR LIBRO
if (isset($_POST["btnGuardarL"])) {
    $stid = oci_parse($conn, "insert into libro(libro,titulo,autor,numpag) 						   values('$libro','$titulo','$autor','$numpaginas')");
    $cont = 1;
    while ($cont != 0) {
        if ($row = oci_fetch_row($libros)) {
            if ($row[0] == $libro) {
                echo 'libro ya existe';
                break;
            }

        } else {
            oci_execute($stid);
            echo 'libro guardado';
            break;
        }
    }
}
//ACCION BOTON ACTUALIZAR LIBRO
if (isset($_POST["btnActualizarL"])) {
    $cont = 1;
    while ($cont != 0) {
        if ($row = oci_fetch_row($libros)) {
            if ($row[0] == $libro) {
                $stid = oci_parse($conn, "update libro set titulo='$titulo',autor='$autor',numpag='$numpaginas' where libro=$row[0] ");
                oci_execute($stid);
                echo 'libro actualizado';
                break;

            }
        } else {
            echo ' no existe ese libro';
            break;
        }

    }

}

//ACCION BOTON ELIMINAR LIBRO
if (isset($_POST["btnEliminarL"])) {
    $cont = 1;
    while ($cont != 0) {
        if ($row = oci_fetch_row($libros)) {
            if ($row[0] == $libro) {
                $stid = oci_parse($conn, "delete from libro where libro=$row[0] ");
                oci_execute($stid);
                echo 'libro eliminado...';
                break;
            }
        } else {
            echo 'el libro no existe...';
            break;
        }
    }

}

oci_close($conn);

?>

				</div>
				<br>
				<div id="tablaPr">
					<table id="consulta">
						<tr>
						<th>Libro</th>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Num. Paginas</th>
						</tr>
						<?php

$conn   = oci_connect('didier', 'unillanos', 'localhost/XE');
$result = oci_parse($conn, 'SELECT * FROM libro order by libro');
oci_execute($result);
while ($row = oci_fetch_row($result)) {
    echo " <tr>
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
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
					</ul>
				</nav>
			</header>
			<section>
				<div id="tablaPr">
					<?php
						$conexion = Conexion::getInstance();
						$conn = $conexion->getConexion();
						$valor=$_POST["lista"];
						if($valor==0){
							echo 'Escoge una opcion';
						}else{
							print "<table id='consulta'>\n";
						if($valor==1){
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th><th>TELEFONO</th><th>FECHA DE INGRESO</th></tr> \n";
							$stid = oci_parse($conn,'select s.socio,s.nombre,s.telefono,s.ingreso from GUTY17.socio s');
						}
						if($valor==2){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMEROD DE PAGINAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG from GUTY17.libro l');
						}
						if($valor==3){
							print "<tr><th>CANTIDAD DE SOCIOS</th></tr> \n";
							$stid = oci_parse($conn,'select count(s.SOCIO) Cantidad_Socios from GUTY17.socio s');
						}
						if($valor==4){
							print "<tr><th>CANTIDAD DE LIBROS</th></tr> \n";
							$stid = oci_parse($conn,'select count(l.LIBRO) Cantidad_Libros from GUTY17.libro l');
						}
						if($valor==5){
							print "<tr><th>ID DE SOCIO</th><th>NOMBRE</th><th>ID DE LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMERO DE PAGINAS</th></tr> \n";
							$stid = oci_parse($conn,'select s.SOCIO, s.NOMBRE, l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG from GUTY17.prestamo p, libro l,socio s where l.LIBRO=p.LIBRO and p.SOCIO=s.socio order by s.socio asc ,l.titulo asc');
						}
						if($valor==6){
							print "<tr><th>ID DE SOCIO</th><th>NOMBRE</th><th>TOTAL DE LIBROS PRESTADOS</th></tr> \n";
							$stid = oci_parse($conn,'select s.SOCIO, s.NOMBRE, count( p.libro ) from GUTY17.prestamo p, socio s where p.SOCIO=s.socio group by s.SOCIO, s.NOMBRE order by s.socio asc');
						}
						if($valor==7){
							print "<tr><th>ID DE LIBRO</th><th>LIBRO</th><th>VECES SOLICITADO</th></tr> \n";
							$stid = oci_parse($conn,'select prestamo.libro, libro.titulo, count(prestamo.LIBRO) from GUTY17.prestamo,libro where prestamo.LIBRO = libro.LIBRO group by prestamo.libro, libro.titulo having (count(*)>=(select max(count(prestamo.libro)) from GUTY17.prestamo group by prestamo.libro))');
						}
						if($valor==8){
							print "<tr><th>ID DE LIBRO</th><th>LIBRO</th><th>VECES SOLICITADO</th></tr> \n";
							$stid = oci_parse($conn,'select prestamo.libro,libro.TITULO ,count(prestamo.LIBRO) from GUTY17.prestamo,libro where libro.LIBRO =prestamo.LIBRO group by prestamo.libro, libro.TITULO having (count(*)<=(select min(count(prestamo.libro)) from GUTY17.prestamo group by prestamo.libro))');
						}
						if($valor==9){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMEROD DE PAGINAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG from GUTY17.libro l, prestamo p where l.libro=p.libro and p.FDEVOLUCION is not null');
						}
						if($valor==10){
							print "<tr><th>TOTAL DE LIBROS PRESTADOS</th></tr> \n";
							$stid = oci_parse($conn,'select count(p.LIBRO) Libros_Prestados from GUTY17.prestamo p');
						}
						if($valor==11){
							print "<tr><th>TOTAL DE LIBROS PRESTADOS Y DEVUELTOS</th></tr> \n";
							$stid = oci_parse($conn,'select count(p.LIBRO) Libros_Prestados_y_Devueltos from GUTY17.prestamo p where p.FDEVOLUCION is not null');
						}
						if($valor==12){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMEROD DE PAGINAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG from GUTY17.libro l, prestamo p where l.libro=p.libro and p.FDEVOLUCION is null');
						}
						if($valor==13){
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th></tr> \n";
							$stid = oci_parse($conn,'select socio, nombre from GUTY17.(select s.socio,s.nombre, count(p.libro) Total_Libro from GUTY17.prestamo p,socio s where p.socio=s.socio group by s.socio,s.nombre,p.libro order by Total_Libro desc) where rownum<=1');
						}
						if($valor==14){
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th></tr> \n";
							$stid = oci_parse($conn,"select distinct s.socio, s.nombre from GUTY17.prestamo p,socio s where p.LIBRO=s.socio and p.FPRESTAMO between to_date('01/03/2009','dd/mm/yyyy') and to_date ('31/03/2009','dd/mm/yyyy')");
						}
						if($valor==15){
							print "<tr><th>TOTAL DE LIBROS PRESTADOS EN EL MES DE ENERO</th></tr> \n";
							$stid = oci_parse($conn,"select count(p.libro) Total_Libro from GUTY17.prestamo p where p.FPRESTAMO between to_date('01/01/2009','dd/mm/yyyy') and to_date('31/01/2009','dd/mm/yyyy')");
						}
						if($valor==16){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMERO DE PAGINAS</th><th>FECHA DE PRESTAMOS</th><th>FECHA DE DEVOLUCION</th><th>TIEMPO EN DIAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG,p.FPRESTAMO,p.FDEVOLUCION ,(p.FDEVOLUCION-p.FPRESTAMO) Tiempo_Dias from GUTY17.prestamo p, libro l where p.libro=l.libro order by tiempo_dias');
						}
						if($valor==17){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMERO DE PAGINAS</th><th>TIEMPO EN DIAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG,avg( (p.FDEVOLUCION-p.FPRESTAMO)) Tiempo_Dias from GUTY17.prestamo p, libro l where p.libro=l.libro and p.FDEVOLUCION is not null group by l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG order by tiempo_dias');
						}
						if($valor==18){
							print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMERO DE PAGINAS</th><th>FECHA DE PRESTAMOS</th><th>TIEMPO EN DIAS</th></tr> \n";
							$stid = oci_parse($conn,'select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG,p.FPRESTAMO,ROUND((SYSDATE-p.FPRESTAMO),0) Tiempo_Dias from GUTY17.prestamo p, libro l where p.libro=l.libro and p.FDEVOLUCION is null order by tiempo_dias');
						}
						if($valor==19){
						print "<tr><th>ID LIBRO</th><th>TITULO</th><th>AUTOR</th><th>NUMERO DE PAGINAS</th><th>CANTIDAD DE LIBROS</th></tr> \n";
							$stid = oci_parse($conn,'select LIBRO,TITULO,AUTOR,NUMPAG, Cantidad_libros from GUTY17.(select l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG, count(p.libro) Cantidad_libros from GUTY17.prestamo p, libro l where p.LIBRO=l.libro group by l.LIBRO,l.TITULO,l.AUTOR,l.NUMPAG order by cantidad_libros desc) where rownum<=3');
						}
						if($valor==20){
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th></tr> \n";
							$stid = oci_parse($conn,'select socio, nombre from GUTY17.(select s.socio,s.nombre, count(p.libro) Total_Libro from GUTY17.prestamo p,socio s where p.socio=s.socio group by s.socio,s.nombre,p.libro order by Total_Libro desc) where rownum<=2');
						}
						if($valor==21){
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th><th>DIAS</th></tr> \n";
							$stid = oci_parse($conn,'select s.socio,s.nombre,(p.FDEVOLUCION-p.FPRESTAMO) from GUTY17.prestamo p,socio s where p.socio=s.socio and p.FDEVOLUCION is not null and (p.FDEVOLUCION-p.FPRESTAMO)>=2');
						}
						if($valor==22){
							$stid=oci_parse($conn,'select sel_socio(10) from GUTY17.dual');
						}
						if($valor==23){
							$stid2=oci_parse($conn,'call actualizar_telefono()');
							oci_execute($stid2);
							print "<tr><th>ID SOCIO</th><th>NOMBRE</th><th>TELEFONO</th><th>FECHA DE INGRESO</th></tr> \n";
							$stid = oci_parse($conn,'select s.socio,s.nombre,s.telefono,s.ingreso from GUTY17.socio s');
						}
						oci_execute($stid);
						
						/*print "<table id='consulta' >\n";*/
                        while ($fila = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                            print "<tr>\n";
                            foreach ($fila as $elemento) {
                                print "    <td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
                            }
                            print "</tr>\n";
                        }
                        print "</table>\n";
						}
					?>   
				</div>			
			</section>
		</div>	
		
	</body>
</html>
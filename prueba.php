<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table align="center" border="1">
	<tr>
    <td>Libro</td>
    <td>Titulo</td>
    <td>Autor</td>
    <td>Num. Paginas</td>
    </tr>
    <?php 
						$conn = oci_connect('didier','unillanos','localhost/XE'); 
						$result = oci_parse($conn,'SELECT * FROM libro');
						oci_execute($result);
						while ($row = oci_fetch_row($result)){ 
							   echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr> \n"; 
						} 
						 
					?>
</table>
 
</body>
</html>
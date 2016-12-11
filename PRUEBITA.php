<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xml:lang="es" xmlns="http://www.w3.org/1999/xhtml" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Titulo</title>
    </head>
    <body>
        <div id="tablaPr">
					
						<?php 
								$conn = oci_connect('didier','unillanos','localhost/XE'); 
								$result = oci_parse($conn,'SELECT * FROM libro');
								oci_execute($result);
								print "<table border='1'>\n";
								while ($fila = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
								    print "<tr>\n";
								    foreach ($fila as $elemento) {
							        print "    <td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
    								}
							    print "</tr>\n";
								}
								print "</table>\n";

								
								
						?> 
			
					   
						                 
				</div>
			
    </body>
</html>
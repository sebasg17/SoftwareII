<?php
$text = "Hola,Mundo";
$pos=strpos($text,',');
echo $pos."\n";
'<br>';
$libro=substr($text,0,$pos);
$autor=substr($text,$pos+1);
echo $libro."\n";
echo $autor."\n";
?>
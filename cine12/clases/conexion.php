<?php
date_default_timezone_set("America/Guayaquil");
$host='localhost';
$user='root';
$pass='';
$db='cine';
$mysqli=mysqli_connect($host, $user, $pass, $db);
if(!$mysqli){
	echo "Error al copnectar base de datos: ".mysqli_errno();
}
?>
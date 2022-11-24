<?php
require_once('clases/conexion.php');
require_once('clases/valida.php');

$sql_peli=sprintf("SELECT * FROM cartelera WHERE md5(carte_titulo)=%s",
				 valida::convertir($mysqli,$_GET['id'],"text"));
$q_peli=mysqli_query($mysqli,$sql_peli);
$r_peli=mysqli_fetch_assoc($q_peli);
$template=file_get_contents('./templates/peliculas.html');
$template=str_replace("**pelicula**",$r_peli['carte_titulo'],$template);
$template=str_replace("**actores**",$r_peli['carte_actor'],$template);
$template=str_replace("**imagen**",$r_peli['carte_image'],$template);
$template=str_replace("**sinopsis**",$r_peli['carte_sinop'],$template);
echo $template;

?>
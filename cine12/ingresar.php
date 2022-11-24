<?php
require_once('clases/conexion.php');
require_once('clases/valida.php');
$error=false;
if(isset($_POST['ingresar'])){
	$pelicula=str_replace(" ","", $_POST["titulo"]);
	$imagen=$_FILES['imagen']['tmp_name'];
	$partes=explode(".",$_FILES['imagen']['name']);
	$partes=$partes[count($partes)-1];
	$destino="./images/pelis/".$pelicula.".".$partes;
	//echo("fuente: ".$pelicula."<br>destino: ".$destino);
	if ($_FILES['imagen']['size']<3670016){
		if(move_uploaded_file($imagen,strtolower($destino))){
			$sql_insertar=sprintf("INSERT INTO cartelera (carte_titulo, carte_actor, carte_sinop, carte_inicio, carte_fin, carte_image) VALUES (%s, %s, %s, %s, %s, %s)",
					valida::convertir($mysqli, $_POST['titulo'],"text"),
					valida::convertir($mysqli, $_POST['actor'],"text"),
					valida::convertir($mysqli, $_POST['sinop'],"text"),
					valida::convertir($mysqli, $_POST['inicio'],"date"),
					valida::convertir($mysqli, $_POST['fin'],"date"),
					valida::convertir($mysqli, $destino,"text"));
			$q_insertar=mysqli_query($mysqli, $sql_insertar) ;
			if(!$q_insertar){
				$error=true;	$mensaje=valida::convertir($mysqli,mysqli_error($mysqli),"mensaje");
			}else{
				$insertar=true;
				$mensaje=valida::convertir($mysqli, $_POST['titulo'],"mensaje");
			}
		}else{
			echo("problemas al subir");
		}
	}else{
		echo "No se puede subir, el archivo es muy grande. Solo se admiten 3.5 Mb";
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Unicines</title>
<link rel="stylesheet" href="css/estilos.css">
<script src="./dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="./dist/sweetalert2.min.css">
</head>

<body>
<header>
	<img src='images/cine.png'/>
	
</header>
<form method="post" enctype="multipart/form-data" >
		<input type="text" name="titulo" placeholder="Titulo">
		<input type="text" name="actor" placeholder="Actor">
		<input type="text" name="sinop" placeholder="sinop">
		<input type="date" name='inicio'>
		<input type="date" name='fin'>
		<input type="file" name= 'imagen'>
		<input type="submit" name="ingresar" value="Ingresar">
	</form>
</body>
</html>
<?php
if($error){
	echo "<script>swal('Error','Fallo la insersion con el error: $mensaje','error')</script>";
}
if(isset($insertar) and $insertar){
	echo "<script>swal('Correcto','Se ha guardado la pelicula: $mensaje','success')</script>";
}
?>
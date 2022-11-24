<?php
require_once('clases/conexion.php');
require_once('clases/valida.php');
$error=false;

$sql_pelis=sprintf("SELECT carte_titulo titulo, carte_sinop sinopsis, carte_image imagen FROM cartelera WHERE carte_inicio<= %s AND carte_fin >= %s",
		valida::convertir($mysqli, date('Y-m-d'),"date"),
		valida::convertir($mysqli, date('Y-m-d'),"date")
				  );
$q_pelis=mysqli_query($mysqli, $sql_pelis);
if(!$q_pelis){
	$error=true;	$mensaje=valida::convertir($mysqli,mysqli_error($mysqli),"mensaje");
}
$r_pelis=mysqli_fetch_assoc($q_pelis);

if(isset($_POST['ingresar'])){
	$sql_login=sprintf("SELECT * FROM usuarios WHERE usu_email = %s AND usu_pass=%s",
				valida::convertir($mysqli, $_POST['user'],"text"),
				valida::convertir($mysqli, md5($_POST['pass']),"text")
					  );
	$q_login=mysqli_query($mysqli, $sql_login) or die("Error en login: ".mysqli_error($mysqli));
	$r_login=mysqli_fetch_assoc($q_login);
	$t_login=mysqli_num_rows($q_login);
	
	if ($t_login==1){
		if($r_login["usu_status"]==1){
			
			session_start();
		$_SESSION["user"]=$_POST["user"];
		header("location:./ingresar.php");
		}
	}else{
echo "error datos incorrectos";		
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
	<form method="post" enctype="multipart/form-data" >
		<input type="text" name="user" placeholder="Usuario">
		<input type="password" name="pass" placeholder="Contraseña">
		<input type="submit" name="ingresar" value="Ingresar">
	</form>
</header>
<?php
do{
	echo "<a href='pelis.php?id=".md5($r_pelis['titulo'])."'><div class='pelicula'><img src='".$r_pelis['imagen']."'></div></a>";
}while($r_pelis=mysqli_fetch_assoc($q_pelis));	
	?>


</body>
</html>
<?php
if($error){
	echo "<script>swal('Error','Fallo la insersion con el error: $mensaje','error')</script>";
}
?>
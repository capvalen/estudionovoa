<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql="UPDATE `usuario` SET `contrasena`= MD5('{$_POST['contrasena']}') WHERE `id`= {$_POST['id']};";
//echo $sql; die();
$resultado=$cadena->query($sql);
if($resultado){
	echo 'ok';
}else{
	echo 'error';
}

?>
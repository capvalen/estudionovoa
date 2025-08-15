<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql="INSERT INTO `clientes`(`id`, `ruc`, `razon_social`, `direccion`, `celular`, `activo`) VALUES (null,
'{$_POST['ruc']}', '{$_POST['razon_social']}', '{$_POST['direccion']}', '{$_POST['celular']}', 1)";
$resultado=$cadena->query($sql);
if($resultado){
	echo 'ok';
}else{
	echo 'error';
}
?>
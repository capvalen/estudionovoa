<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql="UPDATE `clientes` SET `ruc`= '{$_POST['ruc']}', `razon_social`= '{$_POST['razon_social']}', `direccion`= '{$_POST['direccion']}', `celular`='{$_POST['celular']}', `activo`='{$_POST['activo']}', `actualizado`=now() WHERE `id`= {$_POST['id']};";
//echo $sql;
$resultado=$cadena->query($sql);
if($resultado){
	echo 'ok';
}else{
	echo 'error';
}

?>
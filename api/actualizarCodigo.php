<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql="UPDATE `proceso` SET `codigo`= '{$_POST['codigo']}' WHERE `id`= {$_POST['id']};";
//echo $sql;
$resultado=$cadena->query($sql);
if($resultado){
	echo 'ok';
}else{
	echo 'error';
}

?>
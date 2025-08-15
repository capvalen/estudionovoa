<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql = $db->prepare("UPDATE `usuario` SET `activo` = '0' WHERE `id` = ?;
");
if($sql->execute([$_POST['id']])){
	echo 'ok';
}else{
	echo "error";
}
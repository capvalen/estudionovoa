<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];

$sql = $db->prepare("UPDATE `proceso` SET `IdEstadoProceso` = ? WHERE `id` = ?;");
if( $sql->execute([$_POST['estado'], $_POST['idProceso']]) ){
	echo "ok";
}
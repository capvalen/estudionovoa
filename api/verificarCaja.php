<?php 
include "conectkarl.php";
$_POST = json_decode(file_get_contents('php://input'),true);

if(!isset($_POST['idCaja'])){
	$sentencia = $db -> query("SELECT id, registro, nombreUsuario(usuario) as usuario, apertura, cierre, actual FROM `cuadre` where actual=1 and activo =1 ;");
}else{
	$sentencia = $db -> query("SELECT id, registro, nombreUsuario(usuario) as usuario, apertura, cierre, actual FROM `cuadre` where id={$_POST['idCaja']} and activo =1 ;");
}

$comprobantes = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

if($sentencia->rowCount() > 0){
	echo json_encode( $comprobantes[0]);
}else{ //vacío
	echo json_encode([]);
}
?>
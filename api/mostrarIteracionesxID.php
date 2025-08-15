<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];

$sql = $db->prepare("SELECT *, nombreUsuario(idUsuario) as nomUsuario FROM `iteraciones` 
where idProceso = ? and activo =1");
if( $sql->execute([$_POST['idProceso']]) ){
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$filas[]=$row;
	}
	echo json_encode($filas);
}
<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];

$sql = $db->prepare("SELECT *, nombreCliente(idCliente) as nomCliente, nombreUsuario(idUsuario) as nomUsuario, nombreEstado(IdEstadoProceso) as estadoProceso FROM `proceso` where activo = 1
and IdEstadoProceso<>4
order by id desc;
");
if($sql->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
	echo json_encode($filas);
}

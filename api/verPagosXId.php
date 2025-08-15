<?php 
include "conectkarl.php";
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];
$sql = $db->prepare("SELECT cu.*, tm.descripcion, DATEDIFF(cu.fecha, now()) as diferencia FROM `cuotas`  cu
inner join tipomovimiento tm on tm.id = cu.estado
where idProceso= ? ;
");

if($sql->execute([$_POST['id']])){

	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
	
	echo json_encode($filas);
}

<?php 

include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);


if( $_POST['idCuota']>0 ){
	$sqlCuota = $db->prepare('UPDATE `cuotas` SET `adelanto` = `adelanto` + ?,
	estado = if(cuota = adelanto , 0, 1)
	 WHERE `id` = ?;');
	$respCuota = $sqlCuota -> execute([ $_POST['monto'], $_POST['idCuota'] ]);
	//echo $sqlCuota -> debugDumpParams();
}

$sql = $db->prepare("INSERT INTO `caja`(`idProceso`, `monto`, `idUsuario`, `observaciones`, `atendido`, `idMovimiento`, `idMoneda`) VALUES
(?, ?, ?, ?, 0, ?, ?);");
$respuesta = $sql->execute([$_POST['idCuota'], $_POST['monto'], $_POST['idUsuario'], $_POST['detalle'], $_POST['queIngreso'], $_POST['moneda'] ]);

if($respuesta){

	//Verificamos si acabó de pagar todo:

	$sqlFin = $db->prepare("SELECT count(id) as contador FROM `cuotas` where idProceso = ? and estado=1; ");
	$sqlFin->execute([ $_POST['idProceso'] ]);
	$rowFin = $sqlFin -> fetch(PDO::FETCH_ASSOC);
	//echo "contador es {$rowFin['contador']}";
	if($rowFin['contador']==0){
		$sqlUpdate = $db-> query("UPDATE `proceso` SET `estadoPago` = '0' WHERE `id` = {$_POST['idProceso']};");
		$sqlUpdate->execute();
		//echo $sqlUpdate->debugDumpParams();
	}

	echo 'ok';


}else{
	print_r($sql->errorinfo());
}


?>
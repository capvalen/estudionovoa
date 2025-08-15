<?php 
include "conectkarl.php";
$_POST = json_decode(file_get_contents('php://input'),true);

$sentencia = $db -> prepare("UPDATE `cuadre` SET 
`cierre`= ?,
`obsCierre`= ?,
`horaCierre`=current_timestamp,
`actual`=0
WHERE id = ?; ");

$resultado = $sentencia -> execute([$_POST['monto'], $_POST['obs'], $_POST['idCaja'] ]);


if($resultado==true){
	echo 'ok';
}else{ //vacío
	die(print_r($db->errorInfo(), true));
}
?>
<?php 

include "conectkarl.php";
$_POST = json_decode(file_get_contents('php://input'),true);

$sentencia = $db -> prepare ("INSERT INTO `cuadre`(`apertura`, `cierre`, `obsApertura`, `obsCierre`, usuario) VALUES ( ? , 0, '' , '', ?); ");
$resultado = $sentencia -> execute([$_POST['monto'], $_POST['usuario']]);

if($resultado== true){
	echo $db->lastInsertId();
}else{
	echo 'Error';
}

?>
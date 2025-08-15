<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];
$sql=$db->prepare("SELECT `id`, `idCliente`, `caso`, `antecedentes`, `estadoPago`, `tipopago`, `precio`, `cuotas`, `plazos`, `fecha`, `registrado`, `documento`, `activo`, `rutaDocumento`, `idUsuario` , nombreCliente(idCliente) as nomCliente, nombreUsuario(idUsuario) as nomUsuario
FROM `proceso` WHERE idCliente=? and  activo =1 and estadoPago<>0;");
if($sql->execute( [$_POST['idCliente']] ) ){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
	echo json_encode($filas);
}

?>
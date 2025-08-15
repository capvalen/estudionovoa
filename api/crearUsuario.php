<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);


/*Revisando duplicado correo */
$sqlCorreo = $db->prepare("SELECT *  FROM `usuario` WHERE `user` LIKE ? and activo=1");
if($sqlCorreo->execute([$_POST['correo']]) ){
	
	if($sqlCorreo->rowCount() > 0){
		//existe correo
		echo 'existe';
	}else{
		//no existe registrar
		$sql=$db->prepare("INSERT INTO `usuario`(`nombres`, `apellidos`, `user`, `contrasena`, `activo`, `idTipo`) VALUES 
		(?, ?, ?, md5(?), 1, ?)");
		
		if( $sql->execute([ $_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['clave'], $_POST['tipo'] ])){
			echo 'ok';
		}else{
			echo 'error';
		}
	}
}



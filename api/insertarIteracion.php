<?php

include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$sql = $db->prepare("INSERT INTO `iteraciones`(`idProceso`, `idUsuario`, `titulo`, `contenido`, `archivos` ) VALUES 
(?, ?, ?, ?, ?); ");
if($sql->execute([ $_POST['idProceso'], $_POST['idUsuario'], $_POST['titulo'], $_POST['contenido'], json_encode($_POST['archivos']) ])){
	echo $db->lastInsertId();
}

//echo $sql->debugDumpParams();

?>
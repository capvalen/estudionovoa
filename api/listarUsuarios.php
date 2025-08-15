<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];

$sql = $db->prepare("SELECT `id`, `nombres`, `apellidos`, `user`, `idTipo` FROM `usuario`
where activo =1 order by apellidos;");
if( $sql->execute() ){
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
	echo json_encode($filas);
}
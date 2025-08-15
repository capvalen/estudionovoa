<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$filas = array();

$sql="SELECT *, nombreUsuario(usuario) as nomUser FROM `cuadre` where date(registro)  = '{$_POST['fecha']}' ;";
//echo $sql;
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	$filas[] = $row;
}
echo json_encode($filas);

?>
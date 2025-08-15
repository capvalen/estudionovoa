<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$filas = array();

$sql="SELECT * from moneda;";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	$filas[] = $row;
}
echo json_encode($filas);

?>
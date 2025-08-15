<?php 

include('conectkarl.php');

$filas = array();
$sql="SELECT a.*, ta.descripcion as desTipoAudiencia, concat(u.apellidos,' ', u.nombres) as nomAbogado FROM `agenda`a inner join tipoaudiencia ta on ta.id = a.idTipoAudiencia 
inner join usuario u on u.id = a.idAbogado
WHERE a.activo =1 and DATE_FORMAT(inicia, '%c-%Y') = '{$_POST['mes']}'; ";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	$filas[] = $row;
}
echo json_encode($filas);
?>
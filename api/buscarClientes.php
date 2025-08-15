<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);


$filas = array();

$sql="SELECT `id`, `ruc`, upper(`razon_social`) as razon_social, `direccion`, `celular`, `activo`, returnCantProcesoxIDCliente(id) as numProcesos FROM `clientes` where activo = 1 
and (ruc like '{$_POST['texto']}%' or razon_social like '%{$_POST['texto']}%' or celular like '{$_POST['texto']}%')
order by actualizado DESC ;";
//echo $sql;
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	$filas[] = $row;
}
echo json_encode($filas);

?>
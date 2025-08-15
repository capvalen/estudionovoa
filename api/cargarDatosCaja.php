<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$filas = array();

$sql=$db->prepare("SELECT ca.*, nombreCliente(pro.idCliente) as nomCliente, nombreUsuario(ca.idUsuario) as nomUsuario, tp.descripcion as movida, m.moneda
FROM `caja` ca
left join proceso pro on pro.id = ca.idProceso
inner join tipomovimiento tp on tp.id = ca.idMovimiento
inner join moneda m on m.id = ca.idMoneda
cross join cuadre cu
where ca.actualizado BETWEEN cu.registro and ifnull(cu.horaCierre , now())
and cu.id= ? order by ca.id  desc ;" );
if($sql->execute([$_POST['idCaja']])){
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$filas[]=$row;
	}	
}
echo json_encode($filas);
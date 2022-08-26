<?php

include 'conectkarl.php';

switch($_POST['tipo']){
	case 'R1': reporteCajas($db); break;
	case 'R2': procesosRegistrados($db,2); break;
	case 'R4': procesosRegistrados($db,1); break;
	case 'R3': procesosRegistrados($db,3); break;
	case 'R5': procesosRegistrados($db,4); break;
	case 'R6': deudasPendientes($db); break;
	case 'R7': procesosPagados($db); break;
}


function reporteCajas($db){
	$sql = $db->prepare("SELECT c.*, u.nombres FROM `cuadre` c 
		inner join usuario u on u.id = c.usuario
		where c.activo = 1 and c.registro BETWEEN ? and ?;");
	if($sql->execute([ 
		$_POST['fecha1'], $_POST['fecha2']
		])){ $i=0;
		?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Usuario</th>
					<th>Fecha apertura</th>
					<th>Fecha cierre</th>
					<th>Apertura</th>
					<th>Cierre</th>
					<th>Obs</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td><?= $i+1;?></td>
					<td><?= $row['nombres'];?></td>
					<td><a href="/caja/<?=$row['id'];?>"><?= $row['registro'];?></a></td>
					<td><?= $row['horaCierre'];?></td>
					<td><?= $row['apertura'];?></td>
					<td><?= $row['cierre'];?></td>
					<td><?= $row['obsApertura'];?> <?= $row['obsCierre'];?></td>
				</tr>
				<?php $i++;
				}
				?>
			</tbody>
		</table>
		<?php
	}else{
		echo -1;
	}
}

function procesosRegistrados($db, $id){
	$sql = $db->prepare("SELECT p.id, caso, p.idCliente, cl.razon_social, precio
	FROM `proceso` p 
	inner join clientes cl on cl.id = p.idCliente
	where IdEstadoProceso = ? and p.activo = 1 and p.registrado BETWEEN ? and ?;");
	if($sql->execute([ 
		$id,$_POST['fecha1'], $_POST['fecha2']
		])){ $i=0;
		?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Caso</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Precio</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td><?= $i+1;?></td>
					<td><a href="/procesos/detalle/<?=$row['id'];?>"><?= $row['caso'];?></a></td>
					<td><?= $row['razon_social'];?></td>
					<td><?= $row['registrado'];?></td>
					<td><?= $row['precio'];?></td>
				</tr>
				<?php $i++;
				}
				?>
			</tbody>
		</table>
		<?php
	}else{
		echo -1;
	}
}

function deudasPendientes($db){
	$sql = $db->prepare("SELECT p.*, cuantoPagoXCaso(p.id) as pago, cl.razon_social FROM `proceso` p
	inner join clientes cl on cl.id = p.idCliente
	where p.estadoPago=6;");
	if($sql->execute()){
		$i=0;
		?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Caso</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Deuda</th>
					<th>Pagado</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td><?= $i+1;?></td>
					<td><a href="/procesos/detalle/<?=$row['id'];?>"><?= $row['caso'];?></a></td>
					<td><?= $row['razon_social'];?></td>
					<td><?= $row['registrado'];?></td>
					<td class="text-primary"><?= $row['precio'];?></td>
					<td class="text-danger"><?= $row['pago'];?></td>
				</tr>
				<?php $i++;
				}
				?>
			</tbody>
		</table>
		<?php
	}else{
		echo -1;
	}
}

function procesosPagados($db){
	$sql = $db->prepare("SELECT p.*, cuantoPagoXCaso(p.id) as pago, cl.razon_social FROM `proceso` p
	inner join clientes cl on cl.id = p.idCliente
	where p.estadoPago in (0,7) and fecha between ? and ?
	;");
	if($sql->execute([ 
		$_POST['fecha1'], $_POST['fecha2']
		])){ 
		$i=0;
		?>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Caso</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Deuda</th>
					<th>Pagado</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row=$sql->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr>
					<td><?= $i+1;?></td>
					<td><a href="/procesos/detalle/<?=$row['id'];?>"><?= $row['caso'];?></a></td>
					<td><?= $row['razon_social'];?></td>
					<td><?= $row['registrado'];?></td>
					<td class="text-primary"><?= $row['precio'];?></td>
					<td class="text-danger"><?= $row['pago'];?></td>
				</tr>
				<?php $i++;
				}
				?>
			</tbody>
		</table>
		<?php
	}else{
		echo -1;
	}
}
?>
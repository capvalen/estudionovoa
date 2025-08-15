<template>
	<div class="container p-3">

		<p>Bienvenido, iniciaste como: <strong>{{returnNombreUsuario()}}</strong></p>

		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Total de Procesos activos </h5>
						<h3 class="display-4" id="pActivos"></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Total de cuotas vencidas</h5>
						<h3 class="display-4" id="pVencidas"></h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Entradas en caja </h5>
						<h3 class="display-4" id="pEntradas"></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Salidas en caja</h5>
						<h3 class="display-4" id="pSalidas"></h3>
					</div>
				</div>
			</div>
		</div>


		<div class="row mt-2">
			<div class="col">
				<button class="btn btn-outline-secondary" @click="cerrarSesion()"><i class="bi bi-box-arrow-in-left"></i> Cerrar sesión</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	methods:{
		cerrarSesion(){
			this.$emit('cerrarSesion');
		},
		returnNombreUsuario(){
			return sessionStorage.getItem('nombreUsuario')
		}
	},
	mounted(){
		axios.post(this.nombreApi+ '/estadisticaPrincipal.php')
		.then((response)=>{ console.log( response.data );
			document.getElementById('pActivos').innerHTML  = response.data.totalCasos;
			document.getElementById('pVencidas').innerHTML  = response.data.totalCuotas;
			document.getElementById('pEntradas').innerHTML  = parseFloat(response.data.sumaCuadre).toFixed(2);
			document.getElementById('pSalidas').innerHTML  = parseFloat(response.data.restaCuadre).toFixed(2);
		})
		.catch((error)=>{ console.log( error );});
	}
}
</script>
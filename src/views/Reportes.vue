<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Reportes</h4>
		</div>
		<div class="container" v-if="nivel==1">
			<p>Seleccione el tipo de reporte que desee ver:</p>
			<div class="row">
				<div class="col col-lg-6">
					<div class="form-floating">
						<select class="form-select" id="sltTipoReporte" aria-label=" " @change="cambiarVistas($event)">
							<option value="R8">Cajas</option>
							<option value="R1">Ver cajas aperturadas</option>
							<option value="R6">Deudas pendientes</option>
							<option value="R5">Procesos concluidos</option>
							<option value="R2">Procesos en calificación</option>
							<option value="R3">Procesos en trámite</option>
							<option value="R7">Procesos pagados</option>
							<option value="R4">Procesos registrados</option>
							<!-- <option value="R2">1Cajas</option>
							<option value="R2">3Cajas</option> -->
						</select>
						<label for="sltTipoReporte">Reportes</label>
					</div>
				</div>
				<div class="col col-lg-6">
					<div class="row row-cols-3">
						<div v-show="verFechas"><input class="form-control" type="date" name="" id="" v-model="fecha1"></div>
						<div v-show="verFechas"><input class="form-control" type="date" name="" id="" v-model="fecha2"></div>
						<div><button class="btn btn-outline-primary" @click="solicitarReporte"><i class="bi bi-search"></i> Buscar</button></div>
					</div>
				</div>
			</div>
			<div class="row" id="divResultados">

			</div>
		</div>
		<div v-else>
			<p class="ms-4">No tiene permiso para ver esta sección</p>
		</div>


	</div>
</template>

<script>


export default ({
	name: 'Reportes',
	data() {
		return{
			verFechas:true,
			fecha1:null,fecha2:null, nivel:3
		}
	},
	mounted(){
		this.nivel = sessionStorage.getItem('nivel');
		this.fecha1=moment().format('YYYY-MM-DD')
		this.fecha2=moment().add(1,'d').format('YYYY-MM-DD')
	},
	methods:{
		cambiarVistas(event){
			switch (event.target.value) {
				case "R6": this.verFechas=false; break;
				default: this.verFechas=true; break;
			}
		},
		async solicitarReporte(event){
			let datos = new FormData();
			datos.append('tipo', document.getElementById('sltTipoReporte').value)
			datos.append('fecha1', this.fecha1)
			datos.append('fecha2', this.fecha2)
			const respServ = await fetch(this.nombreApi +'/reportes.php',{
				method:'POST', body:datos
			});
			document.getElementById('divResultados').innerHTML = await respServ.text();
		}
	}
})
</script>

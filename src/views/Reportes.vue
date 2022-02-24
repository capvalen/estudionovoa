<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Reportes</h4>
		</div>
		<div class="container">
			<p>Seleccione el tipo de reporte que desee ver:</p>
			<div class="row">
				<div class="col col-lg-6">
					<div class="form-floating">
						<select class="form-select" id="floatingSelect" aria-label=" " @change="cambiarVistas($event)">
							<option value="R1">Cajas</option>
							<!-- <option value="R2">1Cajas</option>
							<option value="R2">3Cajas</option> -->
						</select>
						<label for="floatingSelect">Reportes</label>
					</div>
				</div>
				<div class="col col-lg-6">
					<div class="row row-cols-2">
						<div><input class="form-control" type="date" name="" id="" v-model="fecha1"></div>
						<div><input class="form-control" type="date" name="" id="" v-model="fecha2"></div>
					</div>
				</div>
			</div>
		</div>


	</div>
</template>

<script>


export default ({
	name: 'Reportes',
	data() {
		return{
			verFechas:false,
			fecha1:null,fecha2:null
		}
	},
	mounted(){
		this.fecha1=moment().format('YYYY-MM-DD')
		this.fecha2=moment().add(1,'d').format('YYYY-MM-DD')
	},
	methods:{
		cambiarVistas(event){
			switch (event.target.value) {
				case "R1":
					this.verFechas=true;
					break;
			
				default:
					break;
			}
		}
	}
})
</script>

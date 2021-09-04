<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Procesos</h4>
			<button class="btn btn-outline-secondary" @click="crearModal"><i class="bi bi-pin-angle"></i> Nuevo</button>
		</div>
		<div class="py-2 px-4 border-bottom">
			<span>Últimos casos registrados</span>
		</div>

		<div id="resultadoProcesos">
				<div class="py-2 px-4 border-bottom" >
					<span class="float-end"><small>hace 2 horas</small></span>
					<router-link :to="{name:'detalleProcesos', params: {id: 'faf5161s86q1'}}" tag="span" class="text-decoration-none">
						<p><i class="bi bi-box-arrow-in-right"></i> <strong>Prueba de sangre para control de embarazo</strong></p>
					</router-link>
					<p>De: <strong>Pilar Mateo Quincho</strong></p>
					<p>Estado: Registrado</p>
				</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>hace 3 horas</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Amenazas y lesiones leves</strong></p>
				<p>De: <strong>Maximiliano Gregorio Zapata</strong></p>
				<p>Estado: Expediente aceptado en el estudio</p>
			</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>ayer</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Abuso sexual infantil</strong></p>
				<p>De: <strong>Waldo Javier Norte</strong></p>
				<p>Estado: Adjunto la denuncia policial</p>
			</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>hace 2 días</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Custodia de hijos</strong></p>
				<p>De: <strong>Pamela Paola Urichi Perca</strong></p>
				<p>Estado: Generado acta de denuncia</p>
			</div>
		
		</div>

		<div class="modal fade" id="modalCrear" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title">Crear nuevo proceso</h5>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floCaso" placeholder="razon">
							<label for="floCaso">Caso</label>
						</div>
						<div class="form-floating mb-3">
							<textarea class="form-control" id="floAntecedentes" style="height: 100px" placeholder=" "></textarea>
							<label for="floAntecedentes">Antecedentes</label>
						</div>
					
						
						<div class="form-floating">
						  <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
						    <option selected>Seleccione un tipo</option>
						    <option value="1">Pago único</option>
						    <option value="2">En cuotas</option>
						  </select>
						  <label for="floatingSelect">Tipo de pago</label>
						</div>
						<div class="mb-3">
						  <label for="formFile" class="form-label">Adjuntar archivo</label>
						  <input class="form-control" type="file" id="formFile">
						</div>
						<div class="row row-cols-3">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floCuotas" placeholder=" ">
									<label for="floCuotas">N° de cuotas</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating">
								  <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
								    <option selected>Plazos</option>
								    <option value="1">Diario</option>
								    <option value="2">Semanal</option>
								    <option value="3">Mensual</option>
								    <option value="4">Anual</option>
								  </select>
								  <label for="floatingSelect">Tipo de pago</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="date" class="form-control" id="floCuotas" placeholder=" " v-model="fecha">
									<label for="floCuotas">Inicio de pago</label>
								</div>
							</div>

						</div>

						<div class="text-end"> <!-- d-flex justify-content-between -->
							<!-- <button type="button" class="btn btn-danger mx-2"><i class="bi bi-trash-fill"></i> Eliminar</button> -->
							<button type="button" class="btn btn-outline-primary mx-2"><i class="bi bi-hdd"></i> Crear proceso</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<style scoped>
	p{
		margin-bottom: .8rem;
	}
	#resultadoProcesos small{
		font-size: 0.75em;
	}
	#resultadoProcesos div:hover{
		cursor: pointer;
		background-color: whitesmoke;
	}
	
</style>

<script>
var modalCrear;
export default {
	name: 'Procesos',
	data(){
		return {
			fecha: '2021-08-26'
		}
	},
	mounted(){
		modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'))
	},
	methods: {
		crearModal(){
			modalCrear.show()
		}
	},
}
</script>
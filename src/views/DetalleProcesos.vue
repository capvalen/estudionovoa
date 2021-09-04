<template>
	<div >
		<div v-if="!pagos">
			<div class="bloqueCaso border-bottom">
				<div class="p-4 pb-2">
					<h5>Amenazas y lesiones leves <small class="text-primary" @click="pagos=true;" style="font-size: .575em; cursor:pointer;">Ver pagos</small></h5>
					<p><strong>Antecedentes</strong></p>
					<p>Según el requerimiento escrito de folios 01 a 06, el mismo que se
					oralizó en la audiencia de control, se le atribuye concretamente al imputado
					CRISANTO YNGA que el día 08 de Noviembre de 2017 siendo 10:45 horas
					aproximadamente, cuando la agraviada retornaba a su domicilio luego de
					haber tenido una reunión en su trabajo, se encontró con el imputado quien es
					su conviviente el que empezó reclamarle el motivo por el cual llegaba a dicha
					hora a la casa, en esa discusión le profirió insultos humillantes como “donde
					mierda haz estado”, “son horas de llegar”, “con quien ha estado”, que habrían
					generado una afectación psicológica</p>
						<p><i class="bi bi-paperclip"></i> <a class="text-decoration-none" href="/documentos/Exp.-00059-2019-0-2601-JR-PE-01-Legis.pe_.pdf">Adjunto: <strong>Exp 0059-2019-JR-PE 01.pdf</strong></a></p>
						<p><i class="bi bi-paperclip"></i> <a class="text-decoration-none" href="/documentos/1c6caeb7-f298-4279-a5c6-2394.jpg">Adjunto: <strong>1c6caeb7-f298-4279-a5c6-2394.jpg</strong></a></p>
						<p class="text-muted ">Registrado: 21/08/2021 11:36 am por Isabela R.</p>
				</div>
			</div>
			<div class="bloqueCaso border-bottom">
				<div class="p-4 pb-2">
					<p><strong>Interacción: Resolución del Juez Correccional</strong></p>
					<p>Al declarar la nulidad del requerimiento de elevación a juicio, resta valor probatorio a la declaración efectuada por la víctima realizada en la Oficina de Violencia Doméstica</p>
						<p><i class="bi bi-paperclip"></i> <a class="text-decoration-none" href="/documentos/4gf4g44verdoc.pdf">Adjunto: <strong>Resolucion juezcorreccinoal 05-2021 0005262.pdf</strong></a></p>
			
						<p class="text-muted ">Registrado: 23/08/2021 05:41 pm por Isabela R.</p>
				</div>
			</div>
		</div>
		<div v-else >
			<div class="p-4 pb-2">
				<h5>Plancha de pagos</h5>
				<div class="list-group">
				  <a href="#" class="list-group-item list-group-item-action" aria-current="true">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">Cuota #1</h5>
				      <small class="text-primary"><strong><i class="bi bi-check2"></i> Pagado</strong></small>
				    </div>
				    <small>Cancelado el 27/06/2021 7:20 pm. (Con 2 días de retraso) - Por Lucia W.</small>
				  </a>
				  <a href="#" class="list-group-item list-group-item-action" aria-current="true">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">Cuota #2</h5>
				      <small class="text-primary"><strong><i class="bi bi-check2"></i> Pagado</strong></small>
				    </div>
				    <small>Cancelado el 27/06/2021 7:20 pm. (Puntual) - Por Lucia W.</small>
				  </a>
				  <a href="#" class="list-group-item list-group-item-action" aria-current="true">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">Cuota #3</h5>
				      <small class="text-danger"><strong><i class="bi bi-record-circle"></i> Pendiente</strong></small>
				    </div>
				    <small>Planificado para el: 26/08/2021 (Hoy).</small>
				  </a>
				  <a href="#" class="list-group-item list-group-item-action" aria-current="true">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">Cuota #4</h5>
				      <small class="text-danger"><strong><i class="bi bi-record-circle"></i> Pendiente</strong></small>
				    </div>
				    <small>Planificado para el: 16/09/2021 (En 2 meses).</small>
				  </a>
				  
				</div>
			</div>
		</div>
		<div class="p-4">
			<button class="btn btn-outline-secondary mx-1" @click="abrirInteracion"><i class="bi bi-chat-left-dots"></i> Agregar iteracción</button>
			<button class="btn btn-outline-success mx-1"><i class="bi bi-command"></i> Finalizar caso</button>
		</div>

		<div class="modal fade" id="modalInteraccion" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title mb-2">Nueva interacción</h5>
										
						<div class="form-floating mb-3">
							<input type="asunto" class="form-control" id="floAsunto" placeholder=" ">
							<label for="floAsunto">Asunto de la interacción</label>
						</div>
						<div class="form-floating mb-3">
						  <textarea class="form-control" id="floAsunto" style="height: 100px" placeholder=" "></textarea>
							<label for="floAsunto">Argumento</label>
						</div>
						<div class="mb-3">
						  <label for="formFile" class="form-label">Adjuntar archivo</label>
						  <input class="form-control" type="file" id="formFile">
						</div>
						<div class="text-end">
							<button class="btn btn-outline-success mx-1"><i class="bi bi-command"></i> Registrar interacción</button>

						</div>

						
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
var modalInteraccion;
export default {
	name: 'DetalleProcesos',
	data(){ return { pagos:false}},
	mounted(){
		modalInteraccion = new bootstrap.Modal(document.getElementById('modalInteraccion'))
	},
	methods:{
		abrirInteracion(){
			modalInteraccion.show();
		}
	}
}
</script>
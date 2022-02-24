<template>
	<div>
		<span class="d-flex align-items-center justify-content-center rounded-circle ms-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Buscar " id="spanBusqueda" @click="abrirBuscador()"><i class="bi bi-search"></i></span>
		<div class="modal" tabindex="-1" id="modalBuscar">
			<div class="modal-dialog" >
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex">
							<h5 class="modal-title">Buscador</h5>
							<button type="button" class="btn-close me-2 m-auto " data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<p class="my-1">Término a buscar:</p>
						<input type="text" class="form-control form-control-lg" v-model="texto" @keyup.enter="buscar" >
						<div class="d-grid gap-1 my-2">
							<button class="btn btn-outline-primary btn-block" @click="buscar">Buscar</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</template>

<script>
var myModal;
export default {
	name:'Buscador',
	data(){ return {texto:''}},
	mounted(){
		myModal = new bootstrap.Modal(document.getElementById('modalBuscar'));
	},
	methods:{
		abrirBuscador(){
			//console.log( 'debo abrir' );
			myModal.show()
		},
		buscar(){
			console.log( 'buscar' );
			this.$emit('buscar', this.texto);
		},
		cerrarModal(){
			myModal.hide()

		}
	}
}
</script>
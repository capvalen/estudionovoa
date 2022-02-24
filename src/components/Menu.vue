<template>
	
	<div class=" col-md-4 col-lg-3 d-flex flex-column p-0">
		<div class="d-flex align-items-center d-block d-md-none my-3 p-2 pb-3" id="subMenu">
			<button class="btn btn-light border-0 mx-1" @click="mostrarSub" ><i class="bi bi-list"></i>  </button>
			<h4>Sistema - Estudio Novoa</h4>
		</div>
		<section class=" d-none d-md-block ps-3 ps-md-0" id="primeraColumna">
			<div>
				<img class="img-thumbnail rounded-circle my-2" src="images/infocat.jpg" alt="" id="imgPerfil">
			</div>
		
			<router-link class="fs-5 text-decoration-none my-2" to="/">
				<i class="bi bi-house-door"></i> <span class="ps-3">Inicio</span>
			</router-link>
			<router-link class="fs-5 text-decoration-none my-2" to="/caja">
				<i class="bi bi-tag"></i> <span class="ps-3">Caja</span>
			</router-link>
			<router-link class="fs-5 text-decoration-none my-2" to="/calendario">
				<i class="bi bi-calendar-week"></i> <span class="ps-3">Calendario</span>
			</router-link>
			<router-link class="fs-5 text-decoration-none my-2" to="/clientes">
				<i class="bi bi-person-bounding-box"></i> <span class="ps-3">Clientes</span>
			</router-link>
			<router-link class="fs-5 text-decoration-none my-2" to="/procesos">
				<i class="bi bi-inboxes"></i> <span class="ps-3">Procesos</span>
			</router-link>
			<router-link class="fs-5 text-decoration-none my-2" to="/usuarios">
				<i class="bi bi-person-badge"></i> <span class="ps-3">Usuarios</span>
			</router-link>
			<!-- <router-link class="fs-5 text-decoration-none my-2" to="/reportes">
				<i class="bi bi-file-earmark"></i> <span class="ps-3">Reportes</span>
			</router-link> -->
		
		

			<a href="#" class="fs-5 text-decoration-none my-2"><i class="bi bi-gear"></i> <span class="ps-3">Configuraciones</span></a>
			<!-- Perfil, configuraciones, modo oscuro, ayuda y soporte técnico -->
		</section>
	</div>
	
</template>

<script>
export default {
	name: 'Menu',
	methods:{
		mostrarSub(){
			var sub = document.getElementById('primeraColumna')
			sub.classList.remove('d-none')
		}
	}
	
}
</script>

<style scoped>
#primeraColumna>a{
	display: block;
}
#subMenu{
	box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
}
</style>
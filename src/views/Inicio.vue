<template>
	<div class="container p-3">
		<div class="row">
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
		}
	}
}
</script>
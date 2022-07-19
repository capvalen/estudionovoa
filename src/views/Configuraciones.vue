<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Configuraciones</h4>
		</div>

		<div class="card m-4">
			<div class="card-body">
				<h3>Cambio de contraseña</h3>
				<p>Ingrese sus nuevas claves</p>
				<div class="row row-cols-2">
					<div class="col mb-2">
						<input type="password" class="form-control" placeholder="Clave Anterior" v-model="anterior">
					</div>
					<div class="col mb-2">
						<input type="text" class="form-control" placeholder="Clave Anterior" v-model="nueva">
					</div>
					<div class="col mb-2">
						<button class="btn btn-outline-primary" @click="cambiarClave()">Cambiar clave</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card m-4">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
					<h5>Tipos de audiencia</h5>
					<button class="btn btn-outline-success" @click="nuevaAudiencia()">Nuevo tipo</button>
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item" v-for="(tipo, index) in tiposAudiencia" :key="tipo.id">
						<button class="btn btn-sm btn-outline-danger border-0" @click="borrarAudiencia(index)"><i class="bi bi-file-x"></i></button> <span>{{tipo.descripcion}}</span>
					</li>
				</ul>
			</div>
		</div>

		
	</div>
</template>

<script>
export default {
	name: 'Configuraciones',
	data(){
		return {
			anterior:'', nueva:'', tiposAudiencia:[]
		}
	},
	mounted(){
		this.cargarTipos();
	},
	methods:{
		async cambiarClave(){
			if( this.anterior!='' && this.nueva!=''){
				let datos = new FormData();
				datos.append('anterior', this.anterior)
				datos.append('nueva', this.nueva)
				datos.append('idUsuario', localStorage.idUsuario)
				
				let respServ = await fetch( this.nombreApi +"/cambiarClave.php",{
					method:'POST', body: datos
				});
				if(await respServ.text() ){
					this.$emit('mostrarToastBien', 'Contraseña actualizada');
				}else{
					this.$emit('mostrarToastMal', 'No se completó la actualización');
				}
			}
		},
		async cargarTipos(){
			fetch(this.nombreApi + '/listarTipoAudiencia.php', {
				method:'POST'
			})
			.then(res=> res.json())
			.then( respuesta => { //console.log( respuesta );
				this.tiposAudiencia = respuesta;
			});
		},
		async borrarAudiencia(index){
			if(confirm(`¿Deseas eliminar la audiencia: ${this.tiposAudiencia[index].descripcion}?`)){
				let datos = new FormData();
				datos.append('idAudiencia', this.tiposAudiencia[index].id)
				let respServ = await fetch( this.nombreApi +"/eliminarAudiencia.php",{
					method:'POST', body: datos
				});
				if(await respServ.text()=='ok'){
					this.tiposAudiencia.splice(index, 1);
					this.$emit('mostrarToastBien', 'Campo eliminado');
				}else{
					this.$emit('mostrarToastMal', 'El campo no se borró');
				}
			}
		},
		async nuevaAudiencia(){
			var nuevo = prompt(`¿Cuál es el nombre de la nueva audiencia`)
			if( nuevo!='' ){
				let datos = new FormData();
				datos.append('texto', nuevo)
				let respServ = await fetch( this.nombreApi +"/agregarAudiencia.php",{
					method:'POST', body: datos
				});
				let queResp = await respServ.text();
				if( parseInt(queResp) > 0){
					this.tiposAudiencia.push({
						id: queResp,
						descripcion: nuevo
					});
					this.$emit('mostrarToastBien', 'Se agregó exitósamente');
				}else{
					this.$emit('mostrarToastMal', 'El campo no se guardó');
				}
			}
		}
	}
	
}
</script>

<style scoped>
iframe{
	height: 150vh!important;
}
</style>
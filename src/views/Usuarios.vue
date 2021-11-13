<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Usuarios</h4>
			<button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCrear"><i class="bi bi-pin-angle"></i> Nuevo</button>
		</div>
		<div class="container">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>N°</th>
						<th>Usuario</th>
						<th>Nick</th>
						<th>Rol</th>
						<th>@</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(usuario, index) in usuarios" :key="usuario.id">
						<td>{{index+1}}</td>
						<td>{{usuario.nombres+" "+usuario.apellidos}}</td>
						<td>{{usuario.user}}</td>
						<td>
							<span v-if="usuario.idTipo==1">Administrador</span>
							<span v-else>Caja</span>
						</td>
						<td>
							<button class="btn btn-outline-danger btn-sm border-0" @click="borrar(usuario.id, usuario.user)"><i class="bi bi-x-lg"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>


		<!--modal-->
		<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floUser" placeholder=" " autocomplete="off">
							<label for="floUser">Nombre de usuario</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floUser" placeholder=" " autocomplete="off">
							<label for="floUser">Nick de login</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floPassw" placeholder=" " autocomplete="off">
							<label for="flPasswr">Contraseña</label>
						</div>
						<div class="form-floating">
							<select class="form-select" id="floatingSelect" aria-label=" ">
								<option value="2">Caja</option>
								<option value="1">Administrador</option>
							</select>
							<label for="floatingSelect">Roles</label>
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-primary">Crear usuario</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

var modalCrear;
export default ({
	name: 'Usuarios',
	data() {
		return{
			usuarios:[]
		}
	},
	mounted(){
		modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'))
		this.cargarDatos();
	},
	methods:{
		cargarDatos(){
			axios.post(this.nombreApi+'listarUsuarios.php')
		.then((response)=>{ //console.log( response.data );
			this.usuarios = response.data;
		})
		.catch((error)=>{ console.log( error );});
		},
		borrar(id, nombre){
			if(confirm(`¿Deseas borrar el usuario: ${nombre}?`)){
				axios.post( this.nombreApi+ 'eliminarUsuario.php', {id})
				.then((response)=>{ console.log( response.data );
					this.cargarDatos();
					if(response.data=='ok'){
						this.$emit('mostrarToastBien', 'Usuario borrado con éxito');
					}else{
						this.$emit('mostrarToastMal', 'Hubo un error al intentar guardar');
					}
				})
				.catch((error)=>{ console.log( error );
					this.$emit('mostrarToastMal', 'Hubo un error al intentar guardar');
				});
			}
		}
	}
})
</script>

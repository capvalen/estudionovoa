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
						<th>Correo</th>
						<th>Rol</th>
						<th>@</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(usuario, index) in usuarios" :key="usuario.id">
						<td>{{index+1}}</td>
						<td class="text-capitalize">{{usuario.nombres+" "+usuario.apellidos}}</td>
						<td>{{usuario.user}}</td>
						<td>
							<span v-if="usuario.idTipo==1">Administrador</span>
							<span v-if="usuario.idTipo==2">Caja</span>
							<span v-if="usuario.idTipo==3">Abogado</span>
						</td>
						<td>
							<button class="btn btn-outline-secondary btn-sm border-0" @click="modalClave(usuario.id, usuario.user)"><i class="bi bi-key"></i></button>
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
					<form @submit="crearUsuario" >
					<div class="modal-body">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floUser" placeholder=" " autocomplete="off" v-model="nombre">
							<label for="floUser">Nombres</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floUser" placeholder=" " autocomplete="off" v-model="apellido">
							<label for="floUser">Apellidos</label>
						</div>
						<div class="form-floating mb-3">
							<input type="mail" class="form-control" id="floUser" placeholder=" " autocomplete="off" v-model="correo">
							<label for="floUser">Correo electrónico de login</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floPassw" placeholder=" " autocomplete="off" v-model="contrasena">
							<label for="flPasswr">Contraseña</label>
						</div>
						<div class="form-floating">
							<select class="form-select" id="floatingSelect" aria-label=" " v-model="poder">
								<option value="1">Administrador</option>
								<option value="3">Abogado</option>
								<option value="2">Caja</option>
								
							</select>
							<label for="floatingSelect">Roles</label>
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-outline-primary">Crear usuario</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		<!--modal-->
		<div class="modal fade" id="modalCambiar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p>Ingrese la nueva contraseña para <strong>{{nombre}}</strong></p>
						<input type="text" class="form-control" autocomplete ="off" v-model="contrasena">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-primary" @click="cambiarClave()">Cambiar contraseña</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

var modalCrear, modalCambiar;
export default ({
	name: 'Usuarios',
	data() {
		return{
			usuarios:[],
			nombre:'', apellido:'', correo:'', contrasena:'', poder:2, id:''
		}
	},
	mounted(){
		modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'))
		modalCambiar = new bootstrap.Modal(document.getElementById('modalCambiar'))
		this.cargarDatos();
	},
	methods:{
		cargarDatos(){
			axios.post(this.nombreApi+'/listarUsuarios.php')
		.then((response)=>{ //console.log( response.data );
			this.usuarios = response.data;
		})
		.catch((error)=>{ console.log( error );});
		},
		borrar(id, nombre){
			if(confirm(`¿Deseas borrar el usuario: ${nombre}?`)){
				axios.post( this.nombreApi+ '/eliminarUsuario.php', {id})
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
		},
		modalClave(id, nombre){
			this.id=id,
			this.nombre = nombre;
			this.contrasena = '';
			modalCambiar.show();
		},
		cambiarClave(){
			if(confirm(`¿Es correcto el cambio de clave?`)){
				axios.post( this.nombreApi+ '/actualizarClave.php', {
					id: this.id, contrasena: this.contrasena
				})
				.then((response)=>{ console.log( response.data );
					if(response.data=='ok'){
						this.$emit('mostrarToastBien', 'Clave actualizada con éxito');
					}else{
						this.$emit('mostrarToastMal', 'Hubo un error al intentar guardar');
					}
				})
				.catch((error)=>{ console.log( error );
					this.$emit('mostrarToastMal', 'Hubo un error al intentar guardar');
				});
				modalCambiar.hide();
			}
		},
		crearUsuario(e){
			e.preventDefault();
			
			if( this.nombre=='' || this.correo=='' || this.contrasena==''){
				this.$emit('mostrarToastMal', 'Ningún campo debe estar en blanco');
			}
			else if(!this.validEmail(this.correo)) {    
				this.$emit('mostrarToastMal', 'Correo inválido');
			}else{
				axios.post(this.nombreApi + '/crearUsuario.php', {
					nombre: this.nombre,
					apellido: this.apellido,
					correo: this.correo,
					clave: this.contrasena,
					tipo:this.poder
				})
				.then((response)=>{ console.log( response.data );
					if(response.data=='existe'){
						this.$emit('mostrarToastMal', 'Correo duplicado, ya fue registrado');
					}else if(response.data=='error'){
						this.$emit('mostrarToastMal', 'Error interno');
					}else if(response.data=='ok'){
						this.cargarDatos();
						this.$emit('mostrarToastBien', 'Correo se registró correctamente');
						modalCrear.hide();
					}
				})
				.catch((error)=>{ console.log( error );});
			}
		},
		validEmail:function(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
    }
	}
})
</script>

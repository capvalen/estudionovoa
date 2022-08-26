<template>
	<div >
		<div class="d-flex justify-content-between align-items-center py-2 px-4 border-bottom">
			<h4 >Clientes <small style="font-size: .675em;color: #9a9a9a;">(30 últimos)</small></h4>
			<div class="d-flex">
				<button class="btn btn-outline-secondary " @click="crearModal"><i class="bi bi-pin-angle"></i> Nuevo</button>
				<Buscador ref="compBuscador" @buscar="consultar" />
			</div>
		</div>
		
		<div id="resultadoClientes">
			<div class="py-2 px-4 border-bottom" @click="editarTodo(index)" v-for="(cliente, index) in clientes" :key="cliente.id">
				<p>
					<span class="pe-2">
						<span v-if="cliente.ruc.length==11"><i class="bi bi-building"></i></span>
						<span v-else><i class="bi bi-person-fill"></i></span>
					</span>
					<strong>{{cliente.razon_social}}</strong></p>
				<p><span v-if="cliente.ruc.length>8">R.U.C.</span><span v-else>D.N.I.</span>: <strong>{{cliente.ruc}}</strong> | <small>Celular: <span>{{cliente.celular}}</span></small></p>
				<p>Tiene <strong class="text-danger">{{cliente.numProcesos}}</strong> casos activos <span id="spanVer" @click.stop="verCaso(cliente.id)" class="text-primary"><i class="bi bi-chat-right-dots-fill"></i></span>
					<!-- <span class="text-success float-end" @click.stop="sumarCaso(1)"><i class="bi bi-bookmark-plus"></i> </span> -->
				</p>
			</div>
		
		</div>

		<div class="modal fade" id="modalCrear" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title" v-if="crear">Crear nuevo cliente</h5>
						<h5 class="modal-title" v-else>Editar cliente</h5>
						
						<div class="form-floating mb-3">
							<input type="ruc" class="form-control" id="floRuc" placeholder="Ruc" v-model="ruc">
							<label for="text">Ruc o Dni</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floRazon" placeholder="razon" v-model="razon_social">
							<label for="floRazon">Razón social o Nombres</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floDireccion" placeholder="direccion" v-model="direccion">
							<label for="floDireccion">Dirección</label>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floCelular" placeholder="celular" v-model="celular">
							<label for="floCelular">Celular</label>
						</div>

						<div class="d-flex justify-content-between"> <!-- text-end -->
							<button type="button" class="btn btn-outline-primary mx-2" v-if="crear" @click="crearCliente()"><i class="bi bi-hdd"></i> Crear Cliente</button>
							
							<button type="button" class="btn btn-outline-success mx-2" v-if="!crear" @click="actualizarCliente()"><i class="bi bi-hdd"></i> Actualizar Cliente</button>
							<button type="button" class="btn btn-danger mx-2" v-if="!crear" @click="eliminarCliente()" ><i class="bi bi-trash-fill"></i> Eliminar</button>
								
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalProcesos" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title mb-2">Detalle de procesos abiertos</h5>
						
						<div class="list-group">
						  <div class="list-group-item list-group-item-action " aria-current="true" v-for="(caso, index) in casosCliente" :key="caso.id" @click="irA(caso.id)">
						    <div class="d-flex w-100 justify-content-between">
						      <h5 class="mb-1 text-capitalize">{{index+1}}. {{caso.caso}}</h5>
						      <small>{{fechaDesdeHoy(caso.fecha)}}</small>
						    </div>
								<p class="mb-1">Estado: <span class="text-success">En revisión</span></p>
						    <small class="text-muted text-capitalize">Registrador: {{caso.nomUsuario}}</small>
						    
						  </div>
							<div class="list-group-item list-group-item-action " aria-current="true" v-if="casosCliente.length==0" >
						    <div class="d-flex w-100 justify-content-between">
						      <h5 class="mb-1">No hay casos asignados al cliente</h5>
						      
						    </div>
								<p class="mb-1">Agrege uno en la sección de procesos</p>
						    <small class="text-muted">Suerte!</small>
						    
						  </div>
						  
						</div>

						
					</div>
				</div>
			</div>
		</div>
		

	</div>
</template>


<script>
moment.locale('es');
import Buscador from '@/components/Buscador.vue'


var modalCrear, modalProcesos;
export default {
	name: "Clientes",
	data(){
		return {
			clientes:[],
			id:'', ruc:'',razon_social:'',direccion:'',celular:'', activo:0, crear:true,
			casosCliente:[]
		}
	},
	components:{Buscador},
	mounted(){
		modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'))
		modalProcesos = new bootstrap.Modal(document.getElementById('modalProcesos'))
		this.solicitarClientes();
		if( window.location.pathname =='/clientes/nuevo' ){
			this.crearModal()
		}
	},
	methods:{
		crearModal(){
			this.limpiar()
			modalCrear.show();
		},
		editarTodo(index){
			this.crear=false;
			this.id= this.clientes[index].id;
			this.ruc = this.clientes[index].ruc;
			this.razon_social = this.clientes[index].razon_social;
			this.direccion = this.clientes[index].direccion;
			this.celular = this.clientes[index].celular;
			this.activo = this.clientes[index].activo;

			modalCrear.show();
			//console.log( 'todo' );
		},
		verCaso(idCliente){
			console.log( idCliente );
			axios.post( this.nombreApi + '/listarProcesosDeClientes.php',{ idCliente: idCliente})
			.then((response)=>{ //console.log( response );
				this.casosCliente = response.data;
				console.log( this.casosCliente );
				modalProcesos.show();
			})
			.catch((error)=>{ console.log( error );});
		},
		sumarCaso(id){
			//llevar a un lado con el id para registrar caso
			console.log( 'llevar a algun lado' );
		},
		limpiar(){
			this.crear=true;
			this.ruc='';
			this.id='';
			this.razon_social='';
			this.direccion='';
			this.celular='';
			this.activo=1;
		},
		crearCliente(){
			if( this.validarInfo()){
				axios.post(this.nombreApi+'/insertarCliente.php', {ruc: this.ruc, razon_social: this.razon_social, direccion: this.direccion, celular: this.celular, })
				.then((response)=>{
					console.log( response.data );
					
					if(response.data=='ok'){
						this.$emit('mostrarToastBien', 'Cliente registrado')
					}else{
						this.$emit('mostrarToastMal', 'Hubo un error al guardar')
					}
					modalCrear.hide();
				})
				.catch((error)=>{ console.log( error );});
			}

		},
		actualizarCliente(){
			if(this.validarInfo()){
				axios.post(this.nombreApi+'/actualizarCliente.php',  {ruc: this.ruc, razon_social: this.razon_social, direccion: this.direccion, celular: this.celular, activo:this.activo, id:this.id } )
				.then((response)=>{
					if(response.data =='ok'){
						modalCrear.hide();
						this.solicitarClientes();
						this.$emit('mostrarToastBien', 'Cliente actualizado');
					}else{
						this.$emit('mostrarToastMal', 'Hubo un error al actualizar');
					}
			  })
				.catch((error)=>{ console.log( error ); });
			}
		},
		eliminarCliente(){
			this.activo=0;
			if(confirm("¿Desea realizar el borrado del cliente?")){
				this.actualizarCliente();
			}
		},
		solicitarClientes(){
			axios.post(this.nombreApi+'/listarClientes.php')
			.then((response)=>{ console.log( response.data ); this.clientes = response.data; })
			.catch((error)=>{ console.log( error );});
		},
		validarInfo(){
			if(this.ruc==''){ this.$emit('mostrarToastMal', 'No se puede guardar un Dni/RUC en blanco'); return false;}
			else if(this.razon_social==''){ this.$emit('mostrarToastMal', 'No se puede guardar Nombre/Razón social en blanco'); return false;}
			else{
				return true;
			}
		},
		consultar(texto){
			//console.log( 'debo Buscar' );
			axios.post( this.nombreApi + '/buscarClientes.php', {texto})
			.then((response)=>{
				this.clientes = response.data;
				this.$refs.compBuscador.cerrarModal();
				//console.log( response.data );
			})
			.catch((error)=>{ console.log( error );});
		},
		fechaDesdeHoy(fecha){
			return moment(fecha).fromNow();
		},
		irA(id){
			modalProcesos.hide();
			this.$router.push({ name: 'detalleProcesos', params: { id } })
		}
	}
}
</script>

<style scoped>
	p{
		margin-bottom: .8rem;
	}
	
	#resultadoClientes div:hover{
		cursor: pointer;
		background-color: whitesmoke;
	}
/* 	#resultadoClientes div{
		color:#505050;
	} */
	
	#modalProcesos h5{
		font-size: 1rem;
	}
	.list-group-item:hover{cursor:pointer;}
</style>

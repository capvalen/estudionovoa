<template>
	<div >
		<div v-if="!pagos">
			<div class="bloqueCaso border-bottom">
				<div class="p-4 pb-2">
					<h5 class="text-capitalize display-6">{{titulo}} <small class="text-primary" @click="verPagos()" style="font-size: .7em; cursor:pointer;"><i class="bi bi-arrow-right-circle"></i> Ver pagos</small></h5>
					<h5>Estado: <span class="text-primary">{{estadoProceso}}</span> <small class="btn btn-outline-primary border px-2 py-1" @click="abrirModalEstado()"><i class="bi bi-broadcast-pin"></i> Cambiar estado</small></h5>
					<p class="mb-0"><strong>Antecedentes</strong></p>
					<div class="my-2" v-html="casoPrevio"></div>
					<p v-if="ruta!=''"><i class="bi bi-paperclip"></i> Adjunto: <a class="text-decoration-none" :href="'/documentos/'+ruta"> <strong>{{documento}}</strong></a></p>
						<p class="text-muted ">Registrado: {{fechaLatam(fechaInicial)}} por <span class="text-capitalize">{{usuario}}</span>.</p>
				</div>
			</div>
			<div class="bloqueCaso iteracion ps-4 border-bottom" v-for="iteracion in iteraciones" :key="iteracion.id">
				<div class="p-4 pb-2 " >
					<p class="mb-0"> <i class="bi bi-arrow-bar-right"></i> <strong>Iteracción: {{iteracion.titulo}}</strong></p>
					<div class="my-2" v-html="iteracion.contenido.replace(/(?:\r\n|\r|\n)/g, '<br />')"></div>
						<p v-if="iteracion.link!=''"><i class="bi bi-paperclip"></i>Adjunto: <a class="text-decoration-none" :href="'/documentos/'+iteracion.link"> <strong>{{iteracion.adjunto}}</strong></a></p>
			
						<p class="text-muted ">Registrado: {{fechaLatam(iteracion.fecha)}} por <span class="text-capitalize">{{iteracion.nomUsuario}}</span></p>
				</div>
			</div>

			<div class="p-4">
				<button class="btn btn-outline-secondary mx-1" @click="abrirInteracion"><i class="bi bi-chat-left-dots"></i> Agregar iteracción</button>
				<button class="btn btn-outline-success mx-1"><i class="bi bi-command"></i> Finalizar caso</button>
			</div>
			
		</div>
		<div v-else >
			<div class="p-4 pb-2">
				<h5>Plancha de pagos <small @click="volverCasos()" class="text-primary" style="font-size: 0.7em; cursor: pointer;"><i class="bi bi-arrow-left-circle"></i> Volver a ver casos</small></h5>
				<div class="list-group  col col-lg-8">
				  <a href="#" class="list-group-item list-group-item-action" aria-current="true" v-for="(pago, index) in todosPagos" :key="pago.id">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">Cuota #{{index+1}}: S/ {{parseFloat(pago.cuota).toFixed(2)}}</h5>
				      <small v-if="pago.estado==1" class="text-danger"><strong><i class="bi bi-x"></i> {{pago.descripcion}}</strong></small>
				      <small v-else class="text-primary"><strong><i class="bi bi-check2"></i> {{pago.descripcion}}</strong></small>
				    </div>
				    <small v-if="pago.estado==1">Retraso: {{fechaHace(pago.fecha)}} </small>
				    <small v-else> Realizado el: {{fechaLatamSinHora(pago.fecha)}}</small>
				  </a>
				  
				  
				</div>
			</div>
		</div>
		

		<div class="modal fade" id="modalInteraccion" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title mb-2">Nueva interacción</h5>
										
						<div class="form-floating mb-3">
							<input type="asunto" class="form-control" id="floAsunto" placeholder=" " autocomplete="off" v-model="nAsunto">
							<label for="floAsunto">Asunto de la interacción</label>
						</div>
						<div class="form-floating mb-3">
						  <textarea class="form-control" id="floAsunto" style="height: 100px" placeholder=" " v-model="nContenido"></textarea>
							<label for="floAsunto">Argumento</label>
						</div>
						<div class="mb-3">
						  <label for="formFile" class="form-label">Adjuntar archivo</label>
						  <input class="form-control" type="file" id="txtArchivo" ref="archivo" @change="habilitarDoc()">
						</div>
						<div class="text-end">
							<button class="btn btn-outline-success mx-1" @click="registrarIteracion()"><i class="bi bi-command"></i> Registrar iteracción</button>
						</div>

						
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalNuevoEstado" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title mb-2">Nueva interacción</h5>
						<p>Seleccione el nuevo estado que va a pasar el proceso:</p>
						<div class="form-floating">
						  <select class="form-select" id="floEstado" aria-label="Estados">
						    <option value="-1" selected>Seleccione el nuevo estado</option>
						    <option value="2">Calificación</option>
						    <option value="3">Trámite</option>
						    <option value="4">Concluido</option>
						  </select>
						  <label for="floatingSelect">Estados</label>
						</div>
					
						<div class="text-end mt-2">
							<button class="btn btn-outline-success mx-1" @click="cambiarEstado()"><i class="bi bi-broadcast"></i> Cambiar estado</button>
						</div>

						
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
var modalInteraccion, modalNuevoEstado;
export default {
	name: 'DetalleProcesos',
	data(){ return {
		titulo: '', casoPrevio:'', ruta:'', documento:'', fechaInicial:'', usuario:'',
		pagos:false, todosPagos:[], iteraciones:[],
		nAsunto:'', nContenido:'', nArchivo:'', estadoProceso:''
		}
	},
	mounted(){
		moment.locale('es');
		modalInteraccion = new bootstrap.Modal(document.getElementById('modalInteraccion'))
		modalNuevoEstado = new bootstrap.Modal(document.getElementById('modalNuevoEstado'))
		//Muestra el ID por Router
		//console.log( this.$route.params.id );
		axios.post(this.nombreApi + 'solicitarCabeceraProceso.php', { id: this.$route.params.id})
		.then((response)=>{ console.log( response.data );
			let datos = response.data
			this.titulo = datos.caso;
			this.casoPrevio = datos.antecedentes.replace(/(?:\r\n|\r|\n)/g, '<br />');
			this.ruta = datos.rutaDocumento;
			this.documento = datos.documento;
			this.fechaInicial = datos.registrado;
			this.usuario = datos.nomUsuario;
			this.estadoProceso = datos.estadoProceso;
		})
		.catch((error)=>{ console.log( error );});
		this.cargarIteraciones();
	},
	methods:{
		cargarIteraciones(){
			axios.post(this.nombreApi+'mostrarIteracionesxID.php', { idProceso: this.$route.params.id})
			.then((response)=>{ console.log( response.data );
				this.iteraciones = response.data;
			})
			.catch((error)=>{ console.log( error );});
		},
		abrirInteracion(){
			modalInteraccion.show();
		},
		volverCasos(){
			this.pagos=false;
		},
		fechaLatam(fe){
			return moment(fe).format('DD/MM/YYYY hh:mm a');
		},
		fechaLatamSinHora(fe){
			return moment(fe).format('DD/MM/YYYY');
		},
		fechaHace(fe){
			return moment(fe).fromNow();
		},
		habilitarDoc(){
			this.nArchivo = this.$refs.archivo.files[0];
		},
		verPagos(){
			axios.post(this.nombreApi+'verPagosXId.php', { id: this.$route.params.id})
			.then((response)=>{ console.log( response.data );
				this.todosPagos = response.data;
			})
			.catch((error)=>{ console.log( error );});
			this.pagos=true;
		},
		evaluarCampos(){
			if(this.nAsunto==''){ this.$emit('mostrarToastMal', 'El asunto está vacío'); return false; }
			else if(this.nContenido==''){ this.$emit('mostrarToastMal', 'El contenido está vacío'); return false; }
			else{ return true; }
		},
		registrarIteracion(){
			let nombreSubida='', nombreRuta='';
			let that = this;
			if( this.evaluarCampos() ){
				if( document.getElementById("txtArchivo").files.length==0){
					//Guardar sin archivo
					console.log( 'sin archivo' );
					this.mandarDatos(nombreSubida,nombreRuta);
				}else{
					//guardar con archivo
					console.log( 'con archivo' );


					let formData = new FormData();
					formData.append('archivo', this.nArchivo);
					formData.append('ruta', this.rutaDocs);
					axios.post(this.nombreApi+'subidaAdjunto.php', formData, {
						headers: {
							'Content-Type' : 'multipart/form-data'
						}
					}).then( function (response){
						console.log( response.data );
						if( response.data =='Error subida' ){
							nombreSubida='';
							nombreRuta='';
							that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto');
							//console.log( 'err1' );
						}else{ //subió bien
							nombreSubida=document.getElementById("txtArchivo").files[0].name;
							nombreRuta = response.data;
							that.mandarDatos(nombreSubida, nombreRuta);
							console.log( 'subio correcto' );
						}
	
					}).catch(function(){
						//console.log( 'err2' );
						that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto'); return false;
					})
					
	
				}
			}
		},
		mandarDatos(nomArchivo, ruta){
			
			axios.post(this.nombreApi + 'insertarIteracion.php', {
				idProceso: this.$route.params.id,
				idUsuario: localStorage.idUsuario,
				titulo: this.nAsunto,
				contenido: this.nContenido,
				adjunto: nomArchivo,
				link: ruta
			})
			.then((response)=>{ console.log( response.data );
				if(!isNaN(response.data)){
					modalInteraccion.hide();
					this.$emit('mostrarToastBien', 'Iteración guardada');
					this.iteraciones.push({
						id: response.data,
						idProceso: this.$route.params.id,
						fecha: moment(),
						titulo: this.nAsunto,
						contenido: this.nContenido,
						nomUsuario: localStorage.nombreUsuario,
						link: ruta,
						adjunto: nomArchivo

					})
				}
			})
			.catch((error)=>{ console.log( error );});
		},
		abrirModalEstado(){
			modalNuevoEstado.show()
		},
		cambiarEstado(){
			if( document.getElementById('floEstado').value!="-1"){
				axios.post(this.nombreApi + 'cambiarEstadoProceso.php', { idProceso: this.$route.params.id,
					estado: document.getElementById('floEstado').value
				})
				.then((response)=>{ //console.log( response.data );
					modalNuevoEstado.hide();
					if(response.data=='ok'){
						this.estadoProceso = document.getElementById("floEstado").options[document.getElementById("floEstado").selectedIndex].text;
						this.$emit('mostrarToastBien', 'Estado actualizado');
					}else{
						this.$emit('mostrarToastMal', 'Error intentando actualizar el estado');
					}
				})
				.catch((error)=>{ console.log( error );});
			}
		}
	}
}
</script>
<style scoped>
.text-block {
    white-space: pre;
}

</style>
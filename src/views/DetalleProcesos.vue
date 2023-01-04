<template>
	<div >
		<div v-if="!pagos">
			<div class="bloqueCaso border-bottom">
				<div class="p-4 pb-2">
					<h5 class="text-capitalize display-6">{{titulo}} <small class="text-primary" @click="verPagos()" style="font-size: .7em; cursor:pointer;"><i class="bi bi-arrow-right-circle"></i> Ver pagos</small></h5>
					<h5>Estado: <span class="text-primary">{{estadoProceso}}</span> <small class="btn btn-outline-primary border px-2 py-1" @click="abrirModalEstado()"><i class="bi bi-broadcast-pin"></i> Cambiar estado</small></h5>
					<p class="mb-0"><strong>Antecedentes</strong></p>
					<div class="my-2" v-html="casoPrevio"></div>
					<p class="mb-0"><strong>Documentos adjuntos</strong></p>

					<ul class="list-group row col-12 col-md-8 mb-3 ms-3">
						<li v-for="(documento, indice) in documentos" :key="documento.id" class="list-group-item d-flex justify-content-between align-items-start">
							<div class="ms-2 me-auto"><i class="bi bi-paperclip"></i> Adjunto: <a class="text-decoration-none" :href="'/documentos/'+documento.nombreRuta"> <strong>{{documento.nombreSubida}}</strong></a></div>
							<a href="#!" v-if="nivel==1" @click="sustituir(indice)"><span class="badge bg-success rounded-pill mx-2"><i class="bi bi-sd-card"></i></span></a>
							<a href="#!" v-if="nivel==1" @click="borrarDocumento(indice)"><span class="badge bg-danger rounded-pill"><i class="bi bi-x"></i></span></a>
						</li>
					</ul>
					<p class="text-muted ">Registrado: {{fechaLatam(fechaInicial)}} por <span class="text-capitalize">{{usuario}}</span>.</p>
				</div>
			</div>
		
			<div class="bloqueCaso iteracion ps-4 border-bottom" v-for="(iteracion, indiceInt) in iteraciones" :key="iteracion.id">
				
				<div class="p-4 pb-2 " >
					<p class="mb-0"> <i class="bi bi-arrow-bar-right"></i> <strong>Iteracción: {{iteracion.titulo}}</strong></p>
					<div class="my-2" v-html="iteracion.contenido.replace(/(?:\r\n|\r|\n)/g, '<br />')"></div>
						<p v-if="iteracion.link!=''"><i class="bi bi-paperclip"></i>Adjunto: <a class="text-decoration-none" :href="'/documentos/'+iteracion.link"> <strong>{{iteracion.adjunto}}</strong></a></p>
			
						<p class="text-muted ">Registrado: {{fechaLatam(iteracion.fecha)}} por <span class="text-capitalize">{{iteracion.nomUsuario}}</span></p>

						<ul class="list-group row col-12 col-md-8 mb-3 ms-3">
							<li v-for="(archivos, indice) in iteracion.archivos" class="list-group-item d-flex justify-content-between align-items-start">
								<div class="ms-2 me-auto"><i class="bi bi-paperclip"></i> Adjunto: <a class="text-decoration-none" :href="'/documentos/'+archivos.nombreRuta"> <strong>{{archivos.nombreSubida}}</strong></a></div>
								<a href="#!" v-if="nivel==1" @click="borrarDocumentoInteracion(indiceInt, indice, iteracion.id)"><span class="badge bg-danger rounded-pill"><i class="bi bi-x"></i></span></a>
							</li>
						</ul>
				
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
						<!-- <div class="mb-3">
						  <label for="formFile" class="form-label">Adjuntar archivo</label>
						  <input class="form-control" type="file" id="txtArchivo" ref="archivo" @change="habilitarDoc()">
						</div> -->
						<div class="input-group mb-3">
							<input type="file" ref="archivoFile" id="formFile" class="form-control" placeholder=" " accept=".docx, application/msword, .xlsx, application/vnd.ms-excel, .jpg, .png, .mp3, .mpeg, .mp4" >
							<button class="btn btn-outline-secondary" type="button" id="button-addon1" @click="subirANube()"><i class="bi bi-file-earmark-plus"></i> Adjuntar</button>
						</div>

						<div v-if="documentosInt.length>=1">
							<p class="mb-0 " v-for="documentoInt in documentosInt" :key="documentoInt.id"><span class="text-danger"><i class="bi bi-file-earmark-excel"></i> </span> <a :href="'documentos/'+documentoInt.nombreRuta">{{documentoInt.nombreSubida}}</a></p>
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

		<div class="modal fade" id="modalSustituir" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title mb-2">Sustituir archivo</h5>
						<p>Estas por actualizar tu archivo a una nueva versión</p>
						<p><strong>Archivo:</strong> {{ sustituto.nombreSubida }}</p>
						<hr>
						<p>Selecciona el nuevo archivo a cambiar</p>
						<input type="file" class="form-control" id="archivoNuevo" ref="archivoNuevo">
					
						<div class="text-end mt-2">
							<button class="btn btn-outline-success mx-1" @click="cambiarArchivo()"><i class="bi bi-sd-card"></i> Intercambiar archivo</button>
						</div>

						
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
var modalInteraccion, modalNuevoEstado, modalSustituir;
export default {
	name: 'DetalleProcesos',
	data(){ return {
		titulo: '', casoPrevio:'', ruta:'', documento:'', fechaInicial:'', usuario:'',
		pagos:false, todosPagos:[], iteraciones:[],
		nAsunto:'', nContenido:'', nArchivo:'', estadoProceso:'', documentos:[], documentosInt:[], nivel:3, sustituto:[], queIndice:-1
		}
	},
	mounted(){
		moment.locale('es');
		modalInteraccion = new bootstrap.Modal(document.getElementById('modalInteraccion'))
		modalNuevoEstado = new bootstrap.Modal(document.getElementById('modalNuevoEstado'))
		modalSustituir = new bootstrap.Modal(document.getElementById('modalSustituir'))
		this.nivel = localStorage.getItem('nivel');
		//Muestra el ID por Router
		//console.log( this.$route.params.id );
		axios.post(this.nombreApi + '/solicitarCabeceraProceso.php', { id: this.$route.params.id})
		.then((response)=>{ console.log( response.data );
			let datos = response.data
			this.titulo = datos.caso;
			this.casoPrevio = datos.antecedentes.replace(/(?:\r\n|\r|\n)/g, '<br />');
			
			this.documentos = JSON.parse(datos.documento);
			this.fechaInicial = datos.registrado;
			this.usuario = datos.nomUsuario;
			this.estadoProceso = datos.estadoProceso;
		})
		.catch((error)=>{ console.log( error );});
		this.cargarIteraciones();
	},
	methods:{
		cargarIteraciones(){
			axios.post(this.nombreApi+'/mostrarIteracionesxID.php', { idProceso: this.$route.params.id})
			.then((response)=>{ console.log( response.data );
				this.iteraciones = response.data;

				this.iteraciones.forEach((itera, index)=>{
					if(itera.archivos!=''){
						this.iteraciones[index].archivos = JSON.parse(JSON.parse(itera.archivos))
					}else{
						this.iteraciones[index].archivos = [];
					}
					
				})
				
			})
			.catch((error)=>{ console.log( error );});
			
		},
		abrirInteracion(){
			this.documentosInt = [];
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
			axios.post(this.nombreApi+'/verPagosXId.php', { id: this.$route.params.id})
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
			if( this.evaluarCampos() ){
				this.mandarDatos();
			}
		},
		mandarDatos(){
			
			axios.post(this.nombreApi + '/insertarIteracion.php', {
				idProceso: this.$route.params.id,
				idUsuario: localStorage.idUsuario,
				titulo: this.nAsunto,
				contenido: this.nContenido,
				archivos: JSON.stringify(this.documentosInt),
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
						link: '',
						adjunto:'',
						archivos: this.documentosInt

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
				axios.post(this.nombreApi + '/cambiarEstadoProceso.php', { idProceso: this.$route.params.id,
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
		},
		borrarDocumento(indice){
			if(confirm(`¿Deseas eliminar el documento ${this.documentos[indice].nombreSubida}?`)){
				const eliminar = this.documentos[indice].nombreRuta;
				this.documentos.splice(indice,1);
	
				axios.post(this.nombreApi + '/borrarDocumentoProceso.php', {
					id: this.$route.params.id, documentos: JSON.stringify(this.documentos),eliminar:eliminar
				})
				.then(response =>{
					console.log(response.data);
						
					if(response.data =='1'){ this.$emit('mostrarToastBien', 'Documento eliminado'); }else{
						this.$emit('mostrarToastMal', 'Error borrando el documento');
					}
				})
			}
		},
		borrarDocumentoInteracion(indice, index, id){
			if(confirm(`¿Deseas eliminar el documento ${this.iteraciones[indice].archivos[index].nombreSubida}?`)){
				const eliminar = this.iteraciones[indice].archivos[index].nombreRuta;
				this.iteraciones[indice].archivos.splice(index,1);

				axios.post(this.nombreApi + '/borrarDocumentoIteracion.php', {
					id: id, documentos: JSON.stringify(this.iteraciones[indice].archivos),eliminar:eliminar
				})
				.then(response =>{
					console.log(response.data);
						
					if(response.data =='1'){ this.$emit('mostrarToastBien', 'Documento eliminado'); }else{
						this.$emit('mostrarToastMal', 'Error borrando el documento');
					}
				})
			}
		},
		subirANube(){
			var that = this;
			this.archivo = this.$refs.archivoFile.files[0];
			if(document.getElementById("formFile").files.length>0){
				console.log( 'deberia subir a la nube' );

				let formData = new FormData();
				formData.append('archivo', this.archivo);
				formData.append('ruta', this.rutaDocs );
				axios.post(this.nombreApi+'/subidaAdjunto.php', formData, {
					headers: {
						'Content-Type' : 'multipart/form-data'
					}
				}).then( function (response){
					console.log( response.data );
					if( response.data =='Error subida' ){
						nombreSubida='';
						nombreRuta='';
						that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto');
						console.log( 'err1' );
					}else{ //subió bien
						that.documentosInt.push({
							nombreSubida : document.getElementById("formFile").files[0].name,
							nombreRuta : response.data
						});
					}

				}).catch(function(ero){
					console.log( 'err2' + ero );
					that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto'); return false;
				})
			}
		},
		sustituir(indice){
			this.sustituto = this.documentos[indice];
			this.queIndice = indice;
			modalSustituir.show()
		},
		cambiarArchivo(){
			var that = this;
			this.archivo = this.$refs.archivoNuevo.files[0];
			if(document.getElementById("archivoNuevo").files.length>0){
				console.log( 'deberia subir a la nube' );

				let formData = new FormData();
				formData.append('archivo', this.archivo);
				formData.append('ruta', this.rutaDocs );
				
				axios.post(this.nombreApi+'/subidaAdjunto.php', formData, {
					headers: {
						'Content-Type' : 'multipart/form-data'
					}
				}).then( function (response){
					console.log( response.data );
					if( response.data =='Error subida' ){
						
						that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto');
						console.log( 'err1' );
					}else{ //subió bien
						that.actualizarReemplazo(document.getElementById("archivoNuevo").files[0].name, response.data);
					}

				}).catch(function(ero){
					console.log( 'err2' + ero );
					that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto'); return false;
				})
			}
		},
		actualizarReemplazo(nombre, ruta){
			const eliminar = this.documentos[this.queIndice].nombreRuta;
			this.documentos[this.queIndice].nombreRuta = ruta;
			this.documentos[this.queIndice].nombreSubida = nombre;
			
			axios.post(this.nombreApi + '/borrarDocumentoProceso.php', {
				id: this.$route.params.id, documentos: JSON.stringify(this.documentos),eliminar:eliminar
			})
			.then(response =>{
				if(response.data =='1'){ this.$emit('mostrarToastBien', 'Documento actualizado'); }else{
					this.$emit('mostrarToastMal', 'Error borrando el documento');
				}
				modalSustituir.hide();
			})
		},
	}
}
</script>
<style scoped>
.text-block {
    white-space: pre;
}
.bg-success{background-color:#2dc11b!important}
</style>
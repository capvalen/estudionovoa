<template>
	<div>
		<div class="d-flex justify-content-between align-items-center py-2 px-4 ">
			<h4 >Procesos</h4>
			<button class="btn btn-outline-secondary" @click="crearModal"><i class="bi bi-pin-angle"></i> Nuevo</button>
		</div>
		<div class="py-2 px-4 border-bottom">
			<span>Últimos casos registrados</span>
		</div>

		<div id="resultadoProcesos">
				<div class="py-2 px-4 border-bottom" >
					<span class="float-end"><small>hace 2 horas</small></span>
					<router-link :to="{name:'detalleProcesos', params: {id: 'faf5161s86q1'}}" tag="span" class="text-decoration-none">
						<p><i class="bi bi-box-arrow-in-right"></i> <strong>Prueba de sangre para control de embarazo</strong></p>
					</router-link>
					<p>De: <strong>Pilar Mateo Quincho</strong></p>
					<p>Estado: Registrado</p>
				</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>hace 3 horas</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Amenazas y lesiones leves</strong></p>
				<p>De: <strong>Maximiliano Gregorio Zapata</strong></p>
				<p>Estado: Expediente aceptado en el estudio</p>
			</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>ayer</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Abuso sexual infantil</strong></p>
				<p>De: <strong>Waldo Javier Norte</strong></p>
				<p>Estado: Adjunto la denuncia policial</p>
			</div>
			<div class="py-2 px-4 border-bottom" @click="editarTodo()">
				<span class="float-end"><small>hace 2 días</small></span>
				<p><i class="bi bi-box-arrow-in-right"></i> <strong>Custodia de hijos</strong></p>
				<p>De: <strong>Pamela Paola Urichi Perca</strong></p>
				<p>Estado: Generado acta de denuncia</p>
			</div>
		
		</div>

		<div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
						<h5 class="modal-title">Crear nuevo proceso</h5>
						<label class="my-2"><small><strong>Ubique al cliente</strong></small></label>
						<div class="input-group mb-3">
							<button class="btn btn-outline-secondary" type="button" id="button-addon1"><i class="bi bi-cloud-plus-fill"></i> Nuevo</button>
							<input type="text" class="form-control" placeholder="Buscar cliente por Dni o apellidos" aria-label="Example text with button addon" aria-describedby="button-addon1" @keyup.enter="buscarCliente" v-model="clienteBuscar">
							<button class="btn btn-outline-primary" @click="buscarCliente" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
						</div>
						<div id="divClienteUbicado" class="d-none p-2">
							<p class="mb-0"><small>DNI: {{dniElegido}}</small></p>
							<h5>Cliente: <small class="text-muted">{{nombreELegido}}</small></h5>
						</div>
						<label class="mb-2"><strong><small>Datos del Caso:</small></strong></label>

						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floCaso" placeholder="razon" v-model="caso">
							<label for="floCaso">Caso</label>
						</div>
						<div class="form-floating mb-3">
							<textarea class="form-control" id="floAntecedentes" style="height: 100px" placeholder=" " v-model="antecedentes"></textarea>
							<label for="floAntecedentes">Antecedentes</label>
						</div>

						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="" id="chkDocumentos" v-model="chkDocumentos">
						  <label class="form-check-label" for="chkDocumentos">
						    Adjuntar Documentos
						  </label>
						</div>
						
						<div class="mb-3" v-if="chkDocumentos">
							<label for="formFile" class="form-label">Buscar archivo</label>
							<input class="form-control form-control-sm" ref="formFile" type="file" id="formFile">
						</div>
				
						<label for="" class="my-2"><small><strong>Datos del pago:</strong></small></label>
						
						<div class="row">
							<div class="col-6">
								<div class="form-floating mb-3">
									<select class="form-select" id="floPagos" @change="cambioPago($event)">
										<option selected>Seleccione un tipo</option>
										<option value="1">Pago único</option>
										<option value="2">En cuotas</option>
									</select>
									<label for="floPagos">Tipo de pago</label>
								</div>
							</div>
							<div class="col-6">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floMonto" placeholder=" " min=0 v-model="precio">
									<label for="floMonto">Monto (S/)</label>
								</div>
							</div>
						</div>
						
						<div class="row row-cols-3 mt-3 d-none" id="divDetallePagos">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floCuotas" placeholder=" " v-model="numCuotas">
									<label for="floCuotas">N° de cuotas</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating">
									<select class="form-select" id="floatingSelect" v-model="plazos">
										<option selected>Plazos</option>
										<option value="1">Diario</option>
										<option value="2">Semanal</option>
										<option value="3">Mensual</option>
										<option value="4">Anual</option>
									</select>
									<label for="floatingSelect">Tipo de pago</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="date" class="form-control" id="floCuotas" placeholder=" " v-model="fecha">
									<label for="floCuotas">Inicio de pago</label>
								</div>
							</div>

						</div>

						<div class="text-end"> <!-- d-flex justify-content-between -->
							<!-- <button type="button" class="btn btn-danger mx-2"><i class="bi bi-trash-fill"></i> Eliminar</button> -->
							<button type="button" class="btn btn-outline-primary mx-2" @click="crearProceso()" ><i class="bi bi-hdd"></i> Crear proceso</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
<div class="modal fade" id="modalVarios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="d-flex justify-content-between pb-3">
					<h5 class="modal-title" id="staticBackdropLabel">Coincidencias</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>N°</th>
							<th>Apellidos y Nombres</th>
							<th>DNI</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(elegido, index) in elegidos" :key="elegido.id" style="cursor:pointer" @click="seleccionar(index)">
							<td>{{index+1}}</td>
							<td><span class="text-muted"><span v-if="elegido.ruc.length==8"><i class="bi bi-person"></i></span><span v-else><i class="bi bi-building"></i></span></span> {{elegido.razon_social}}</td>
							<td>{{elegido.ruc}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
		<!-- Modal -->
<div class="modal fade" id="modalRegistrado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="d-flex justify-content-end pb-0">
					
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					
				</div>
				<p class="mb-0 mt-1 text-center text-muted">Código de pago:</p>
				<h4 class="text-center text-primary display-5">CS-{{codigo}}</h4>
				<p class="text-center text-muted">Se realizó el registro para el Cliente: <strong>{{nombreELegido}}</strong>, por el caso: <strong>{{caso}}</strong>. En {{numCuotas}} pagos a partir de {{fechaLatam(fecha)}} </p>
				
				
			</div>
			
		</div>
	</div>
</div>

	</div>
</template>

<style scoped>
	p{
		margin-bottom: .8rem;
	}
	#resultadoProcesos small{
		font-size: 0.75em;
	}
	#resultadoProcesos div:hover{
		cursor: pointer;
		background-color: whitesmoke;
	}
	
</style>

<script>
var modalCrear, modalVarios, divCli, modalRegistrado;
export default {
	name: 'Procesos',
	data(){
		return {
			fecha: null, clienteBuscar:'', dniElegido:'', nombreELegido:'', cliElegido:'',
			elegidos:[], numCuotas: null, plazos:null, chkDocumentos:false, precio:0,
			caso:'', antecedentes:'', codigo:null
		}
	},
	mounted(){
		modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'))
		modalVarios = new bootstrap.Modal(document.getElementById('modalVarios'))
		modalRegistrado = new bootstrap.Modal(document.getElementById('modalRegistrado'))
		divCli= document.getElementById('divClienteUbicado')
	},
	methods: {
		crearModal(){
			modalCrear.show()
		},
		buscarCliente(){
			var that = this;
			if(this.clienteBuscar.trim() !=''){
				axios.post( this.nombreApi + '/buscarClientes.php', {texto: this.clienteBuscar})
				.then((response)=>{
					that.elegidos = response.data;
					if( that.elegidos.length==1){
						that.dniElegido= that.elegidos[0].ruc
						that.nombreELegido= that.elegidos[0].razon_social
						that.cliElegido = that.elegidos[0].id
						divCli.classList.remove('d-none')
						//console.log( 'solo uno' );
					}else if(this.elegidos.length>=1){
						modalCrear.hide()
						modalVarios.show()
						
						//divCli.classList.remove('d-none')
						//console.log( 'varios' );
					}else{
						this.cliElegido='';
						//console.log( 'ninguno' );
						divCli.classList.add('d-none')
					}
					
					//console.log( response.data );
				})
				.catch((error)=>{ console.log( error );});
			}
		},
		seleccionar(index){
			//console.log( this.elegidos[index] );
				this.dniElegido= this.elegidos[index].ruc
				this.nombreELegido= this.elegidos[index].razon_social
				this.cliElegido= this.elegidos[index].id;
				divCli.classList.remove('d-none')
				modalCrear.show()
				modalVarios.hide()
		},
		cambioPago(e){
			let tip = e.target.value
			var divPagos = document.getElementById('divDetallePagos');
			if(tip =='1'){
				this.numCuotas=1;
				divPagos.classList.add('d-none')
			}else if(tip =='2'){
				divPagos.classList.remove('d-none')
			}
		},
		crearProceso(){
			

			if(this.evaluarCampos()){
				
				axios.post(this.nombreApi+'/insertarProceso.php', {
					cliElegido: this.cliElegido, 
					caso: this.caso,
					antecedentes: this.antecedentes,
					floPagos: document.getElementById('floPagos').value,
					precio: this.precio,
					numCuotas:this.numCuotas,
					plazos: this.plazos,
					fecha: this.fecha,
					idUsuario: localStorage.idUsuario
				})
				.then((response)=>{ //console.log( response.data );
					if(Number.isInteger(response.data)){
						this.codigo=response.data;
						modalCrear.hide();
						modalRegistrado.show();
					}
				})
				.catch((error)=>{ console.log( error );});

				this.$emit('mostrarToastBien', 'Proceso Guardado');

			}
		},
		evaluarCampos(){
			//console.log( document.getElementById('floPagos').value );

			if(this.cliElegido==''){  this.$emit('mostrarToastMal', 'Falta seleccionar un cliente'); return false;}
			else if(this.caso==''){ this.$emit('mostrarToastMal', 'Falta poner título al caso'); return false;}
			else if(this.antecedentes==''){ this.$emit('mostrarToastMal', 'Falta poner descripción como antecedentes'); return false;}
			/* else if(this.chkDocumentos){ this.$emit('mostrarToastMal', 'Falta poner descripción como antecedentes'); return false; } */
			else if(document.getElementById('floPagos').value=='Seleccione un tipo'){ this.$emit('mostrarToastMal', 'Debe seleccionar un tipo de pago'); return false;}
			else if(this.precio<=0){ this.$emit('mostrarToastMal', 'El pago no puede ser 0 o negativo'); return false; }
			else if(document.getElementById('floPagos').value=='2' && (this.numCuotas=='' || this.numCuotas==null) ){ this.$emit('mostrarToastMal', 'Ingrese cantidad una cuotas'); return false;}
			else if(document.getElementById('floPagos').value=='2' && (this.plazos=='' || this.plazos==null) ){ this.$emit('mostrarToastMal', 'Ingrese los plazos de las cuotas'); return false;}
			else if(document.getElementById('floPagos').value=='2' && (this.fecha=='' || this.fecha==null ) ){ this.$emit('mostrarToastMal', 'Ingrese fecha inicial de las cuotas'); return false;}
			else{
				return true;
			}
			
		},
		fechaLatam(fe){

			
			return moment(fe).format('DD/MM/YYYY');
		}
	},
}
</script>
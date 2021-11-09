<template>
	<div class="">
		<div class="d-flex justify-content-between align-items-center py-2 px-4 border-bottom">
			<h4 >Caja <small style="font-size: .675em;color: #9a9a9a;">Abierta por: {{quienAbrio}}</small></h4>
			<div class="d-flex">
				<button class="btn btn-outline-secondary " v-if="!cajaAbierta" @click="abrirCaja"><i class="bi bi-pin-angle"></i> Abrir Caja</button>
				<button class="btn btn-outline-secondary " v-else @click="porCerrarCaja"><i class="bi bi-pin-angle"></i> Cerrar Caja</button>
			</div>
		</div>
		<div class="border-bottom py-2 px-4" v-if="idCaja!=-1">
			<p class="mb-0 text-muted"><i class="bi bi-calendar2-check"></i> Aperturado el <span class=" text-capitalize">{{(fechaAbrio)}}</span>  </p>
		</div>
		<div class="border-bottom py-2 px-4" v-if="idCaja!=-1">
			<div class="d-flex justify-content-between  ">
				<button class="btn btn-outline-primary mx-2" type="button" @click="nuevaEntrada()"><i class="bi bi-cart-plus"></i> Nueva entrada S/</button>
				<button class="btn btn-outline-danger mx-2" type="button" @click="nuevaSalida()"><i class="bi bi-cart-dash"></i> Nueva salida S/</button>
				<button class="btn btn-outline-warning mx-2" type="button" @click="cobrarCli()"><i class="bi bi-cart-dash"></i> Cobrar cliente</button>
			</div>
		</div>
		<h5 class="fs-5 m-2">Movimientos</h5>
		<div class="row container">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>N°</th>
						<th>Concepto</th>
						<th>Movimento</th>
						<th>Moneda</th>
						<th>Precio</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(movida, index) in movidasCaja" :key="movida.id">
						<td>{{index+1}}</td>
						<td class="text-capitalize">{{movida.observaciones}}</td>
						<td>
							<span>{{movida.movida}}</span>
						</td>
						<td>{{movida.moneda}}</td>
						<td :class="{'text-primary': aSumas.includes(movida.idMovimiento), 'text-danger': aRestas.includes(movida.idMovimiento)}">S/ 
							<span v-if="aSumas.includes(movida.idMovimiento)">+</span>
							<span v-if="aRestas.includes(movida.idMovimiento)">-</span>
							<span>{{parseFloat(movida.monto).toFixed(2)}}</span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" class="text-end">TOTAL:</td>
						<td >S/ {{parseFloat(sumaMovimientos).toFixed(2)}}</td>
					</tr>

					<tr v-for="rango in sumaRangos" :key="rango.id" >
						<td colspan="4" class="text-end">Total de {{nombreMoneda(rango.id)}}:</td>
						<td >S/ {{parseFloat(rango.suma).toFixed(2)}}</td>
					</tr>
					
				</tfoot>
			</table>
		</div>

	<!-- Modal aperturar Caja -->
	<div class="modal fade" id="modalAbrirCaja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{mensajeAbrir}}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p class="mb-2"><small>¿Cuánto hay en caja?</small></p>
					<div class="form-floating mb-3">
						<input type="number" class="form-control" id="floSaldo" placeholder=" " v-model="montoInicial">
						<label for="floSaldo">Monto</label>
					</div>
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="floObs" placeholder=" " v-model="obs">
						<label for="floObs">Observaciones</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-primary" v-if="mensajeAbrir=='Abrir caja'" @click="aperturarCaja()"><i class="bi bi-bootstrap-reboot"></i> Aperturar Caja</button>
					<button type="button" class="btn btn-outline-primary" v-else @click="cerrarCaja()"><i class="bi bi-bootstrap-reboot"></i> Cierre de Caja</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal registrar nuevo evento -->
	<div class="modal fade" id="modalRegistrarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header border-0">
					<h5 class="modal-title" id="mdTitulo">TITULO</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body border-0">
					<div class="text-center px-4">
						<img src="/images/cupones.png" class="img-fluid">
					</div>
					<div class="form-floating mb-3">
						<select class="form-select" id="floMoneda" aria-label=" " v-model="queMoneda">
							<option v-for="moneda in monedas" :key="moneda.id" :value="moneda.id" >{{moneda.moneda}}</option>
						</select>
						<label for="floMoneda">Tipo de moneda</label>
					</div>
					<div class="form-floating mb-3">
						<input type="number" class="form-control" id="floMonto" placeholder=" " min=0 v-model="eMonto">
						<label for="floMonto">Monto</label>
					</div>
					<div class="form-floating mb-3">
						<input type="text" class="form-control text-capitalize" id="floDetalle" placeholder=" " v-model="eDetalle">
						<label for="floDetalle">Detalle</label>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-outline-primary" @click="guardarEvento()"><i class="bi bi-cloud-download"></i> Insertar evento</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para cobrar al cliente -->
	<div class="modal fade" id="modalCobrarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header border-0">
					<h5 class="modal-title" id="mdTitulo">Cobrar al cliente</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body border-0">
					<p>Ubique al cliente con DNI/RUC o Nombre/Razón social</p>
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="Buscar cliente por Dni o apellidos" aria-label="Example text with button addon" aria-describedby="button-addon1" @keyup.enter="buscarCliente" v-model="clienteBuscar">
						<button class="btn btn-outline-primary" @click="buscarCliente" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
					</div>
					<div id="divClienteUbicado" class="d-none p-2">
						<p class="mb-0"><small>DNI: {{dniElegido}}</small></p>
						<h5>Cliente: <small class="text-muted">{{nombreELegido}}</small></h5>
					</div>

					<div class="form-floating mb-3">
						<select class="form-select" id="floCasoActivo" aria-label="Floating label select example" @change="updateCasoActivo()">
							<option v-for="caso in casosCliente" :key="caso.id" :value="caso.id">{{caso.caso}} </option>
							<option v-if="casosCliente.length==0" value="-1">No tiene ningún procesos activos </option>
							
						</select>
						<label for="floCasoActivo">Casos del cliente</label>
					</div>
					<div>
						<p class="mb-0"><strong>Detalle:</strong> <span>{{casoDetalle}}</span></p>
						<p class="mb-0"><strong>Cuotas pendientes:</strong> </p>
						<div class="collapse show" id="divChecks">
							<div class="card card-body">
								<div class="form-check" v-for="(precio, index) in listaPrecios" :key="precio.id" >
								  <input class="form-check-input" type="checkbox" value="" :id="'flexCheckDefault'+index" :que-id="precio.id" @click="selectAnteriores(index, $event)">
								  <label class="form-check-label" :for="'flexCheckDefault'+index">
								    Cuota del {{fechaLatam(precio.fecha)}} de S/ {{parseFloat(parseFloat(precio.cuota) - parseFloat(precio.adelanto)).toFixed(2)}}
								  </label>
								</div>
							</div>
						</div>
						<div>
							<p class=" mt-2 mb-0"><strong>Total a pagar: S/ {{parseFloat(sumaElegidos).toFixed(2)}}</strong></p>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-outline-primary" @click="pagarCuotas()"><i class="bi bi-cloud-download"></i> Pagar seleccionado</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal para varios -->
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
	

	</div>
</template>

<script>
var modalAbrirCaja, modalRegistrarEvento, modalCobrarCliente, modalVarios, divCli;
export default {
	name: 'Caja',
	props:['monedas'],
	data() {
		return {
			mensajeAbrir:'',
			idCaja:-1,cajaAbierta:false, montoInicial:0, obs:'',
			quienAbrio:'', cuandoAbrio:'', eMonto:0, eDetalle:'', queIngreso:'', clienteBuscar:'',
			cobrarFiltro:'', elegidos:[], dniElegido:'',nombreELegido:'',cliElegido:'', casosCliente:[], casoElegido:-1, casoDetalle:'', casoCosto:0,
			movidasCaja:[], queMoneda:1, sumaRangos:[], casosPrecios:[], listaPrecios:[], sumaElegidos:0,
			aSumas : ['2', '4'], aRestas: ['5']
		}
	},
	beforeMount(){
		
	},
	mounted(){
		moment.locale('es');
		//this.monedas.forEach(mone=>{ mone.suma=0; });

		modalAbrirCaja = new bootstrap.Modal(document.getElementById('modalAbrirCaja'));
		modalRegistrarEvento = new bootstrap.Modal(document.getElementById('modalRegistrarEvento'));
		modalCobrarCliente = new bootstrap.Modal(document.getElementById('modalCobrarCliente'));
		modalVarios = new bootstrap.Modal(document.getElementById('modalVarios'));
		divCli= document.getElementById('divClienteUbicado');
		


		axios.post(this.nombreApi + '/verificarCaja.php')
		.then((response)=>{ //console.log( response.data.id );
			if(response.data.id!=null){
				this.cajaAbierta=true;
				this.idCaja = response.data.id;
				this.cuandoAbrio = response.data.registro;
				this.quienAbrio = response.data.usuario;
				this.montoInicial = response.data.apertura;
				this.cargarDatosCaja();
			}
		})
		.catch((error)=>{ console.log( error );});

		
		
	},
	
	methods:{
		abrirCaja(){
			this.mensajeAbrir="Abrir caja";
			modalAbrirCaja.show();
		},
		porCerrarCaja(){
			this.obs=''; this.montoInicial=0;
			this.mensajeAbrir="Cerrar caja";
			modalAbrirCaja.show();
		},
		aperturarCaja(){
			axios.post(this.nombreApi + '/abrirCaja.php', {monto: this.montoInicial, usuario: localStorage['idUsuario']})
			.then((response)=>{ //console.log( response.data );
				if(Number.isInteger(response.data)){
					this.idCaja = response.data;
					this.cajaAbierta=true;
					this.quienAbrio=localStorage.nombreUsuario;
					this.cuandoAbrio=moment();
					modalAbrirCaja.hide();
					this.cargarDatosCaja();
				}
			})
			.catch((error)=>{ console.log( error );});
			
		},
		cerrarCaja(){
			axios.post(this.nombreApi + '/cerrarCaja.php', {idCaja: this.idCaja, obs: this.obs, monto: this.montoInicial})
			.then((response)=>{ console.log( response.data );
				if(response.data =='ok'){
					this.idCaja = -1;
					this.cajaAbierta=false;
					this.cuandoAbrio='';
					this.quienAbrio='',
					this.montoInicial=0,
					modalAbrirCaja.hide();
				}
			})
			.catch((error)=>{ console.log( error );});
		},
		nuevaEntrada(){
			document.getElementById('mdTitulo').textContent='Nueva entrada de dinero';
			modalRegistrarEvento.show();
			this.queIngreso=4;//tabla tipoMovimiento
		},
		nuevaSalida(){
			document.getElementById('mdTitulo').textContent='Nueva salida de dinero';
			modalRegistrarEvento.show();
			this.queIngreso=5;//tabla tipoMovimiento
		},
		guardarEvento(){
			if( this.eMonto <=0 ){ this.$emit('mostrarToastMal', 'El monto no puede ser 0 o menor'); }
			else if( this.eDetalle =='' ){ this.$emit('mostrarToastMal', 'Debe ingresar un detalle'); }
			else{
				axios.post(this.nombreApi+ '/insertarProcesoCaja.php', {
					idProceso:0,
					idCuota:0,
					queIngreso: this.queIngreso,
					monto: this.eMonto,
					detalle:this.eDetalle,
					idUsuario: localStorage.idUsuario,
					moneda: this.queMoneda
				})
				.then((response)=>{ console.log( response.data );
					if(response.data=='ok'){
						this.cargarDatosCaja();
						this.$emit('mostrarToastBien', 'Proceso registrado con éxito');
					}else{
						this.$emit('mostrarToastMal', 'Hubo un error guardando el registro')
					}
				})
				.catch((error)=>{ console.log( error );});
				modalRegistrarEvento.hide();
			}
		},
		cobrarCli(){
			modalCobrarCliente.show();
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
						this.pagosPendientesCliente();
						//console.log( 'solo uno' );
					}else if(this.elegidos.length>=1){
						modalCobrarCliente.hide();
						modalVarios.show();
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
			this.pagosPendientesCliente();
			divCli.classList.remove('d-none')
			modalCobrarCliente.show()
			modalVarios.hide()
		},
		pagosPendientesCliente(){
			
			axios.post( this.nombreApi + '/listarProcesosDeClientes.php',{ idCliente: this.cliElegido})
			.then((response)=>{
				console.log( response.data );
				let casos = response.data;
				this.casosCliente=casos;
				this.casoDetalle = this.casosCliente[0].caso;

				axios.post(this.nombreApi + '/pedirCuotasVariosProcesos.php', {procesos: this.casosCliente})
				.then((response)=>{
					//console.log( response.data );
					this.casosPrecios = response.data;
					this.updateCasoActivo();
					
				})
				.catch((error)=> console.log( error ) );

				
				/* var sel = document.getElementById("floCasoActivo");
				let newOption = new Option('texto del opcion', '2')
				sel.add(newOption, undefined); */
				//document.getElementById('floCasoActivo').appendChild= `<option value="1">One</option>`;
			})
			.catch((error)=>{ console.log( error );});
		},
		updateCasoActivo(){
			this.casoElegido=document.getElementById('floCasoActivo').value;
			this.listaPrecios = this.casosPrecios.filter(x => x.idProceso === document.getElementById('floCasoActivo').value);
			console.log( 'el indice '+ this.casoElegido  );
			let queIndice = this.casosCliente.findIndex( y=> y.id == this.casoElegido); //this.casosCliente[].caso;
			this.casoDetalle = this.casosCliente[queIndice].caso;
			//console.log( this.listaPrecios );
			//console.log(this.listaPrecios)
			//this.casoDetalle = this.casosCliente[this.casoElegido].antecedentes;
			
		},
		cargarDatosCaja(){
			axios.post(this.nombreApi + '/cargarDatosCaja.php', {idCaja : this.idCaja})
			.then((response)=>{ //console.log( response.data );
				this.movidasCaja=response.data;
			})
			.catch((error)=>{ console.log( error );});
		},
		nombreMoneda(ind){
			let queMon = this.monedas.map(x=> x.id).indexOf(ind);
			return this.monedas[queMon].moneda;
		},
		fechaLatam(fechita){
			return moment(fechita).format('DD/MM/YYYY');
		},
		selectAnteriores(indice, e){
			this.sumaElegidos=0;
			for (let index = 0; index < document.querySelectorAll('#divChecks .form-check-input').length; index++) {
				//console.log(document.querySelectorAll('#divCheks .form-check-input')[index])
				if(index<=indice){
					document.querySelectorAll('#divChecks .form-check-input')[index].checked =true;	
					this.sumaElegidos += this.listaPrecios[index].cuota - this.listaPrecios[index].adelanto;
					
				}else{
					document.querySelectorAll('#divChecks .form-check-input')[index].checked =false;
				}
			}
			
		},
		pagarCuotas(){
			//let listaIDS = []
			for (let index = 0; index < document.querySelectorAll('#divChecks .form-check-input').length; index++) {
				if( document.querySelectorAll('#divChecks .form-check-input')[index].checked ){
					let elemento =  this.listaPrecios.find(x => x.id === document.querySelectorAll('#divChecks .form-check-input')[index].getAttribute('que-id') );
					let idInmediato =parseFloat(elemento.cuota-elemento.adelanto);
					
					//listaIDS.push( document.querySelectorAll('#divChecks .form-check-input')[index].getAttribute('que-id') )

					axios.post(this.nombreApi+ '/insertarProcesoCaja.php', {
						idProceso: this.casoElegido,
						idCuota: document.querySelectorAll('#divChecks .form-check-input')[index].getAttribute('que-id'),
						queIngreso: 2, //cuota pagada
						monto: idInmediato,
						detalle:this.casoDetalle,
						idUsuario: localStorage.idUsuario,
						moneda: this.queMoneda
					})
					.then((response)=>{ console.log( response.data );
						if(response.data=='ok'){
							this.cargarDatosCaja();
							this.$emit('mostrarToastBien', 'Proceso registrado con éxito');
						}else{
							this.$emit('mostrarToastMal', 'Hubo un error guardando el registro')
						}
					})
					.catch((error)=>{ console.log( error );});

				}
			}
			modalCobrarCliente.hide();


			//console.log( listaIDS );
		}
	},
	computed:{
		fechaAbrio(){
			return moment(this.cuandoAbrio).format('dddd DD [de] MMMM YYYY - h:mm a');
		},
		
		sumaMovimientos(){
			let suma=0;
			
			this.movidasCaja.forEach(movid =>{
				console.log( movid );
				let indice = this.sumaRangos.map( rang => rang.id ).indexOf(movid.idMoneda);
				let subIndice =-1;
				
				if(indice==-1){
					this.sumaRangos.push({id: movid.idMoneda, suma:0});
				}
				//subIndice = this.sumaRangos.map( x => x.id).indexOf(movid.idMoneda);
				subIndice = this.sumaRangos.findIndex( x => x.id===movid.idMoneda );
				
				let anterior = parseFloat(this.sumaRangos[subIndice].suma);
				
				if(this.aSumas.indexOf(movid.idMovimiento)>-1){ //suma
					suma += parseFloat(movid.monto);
					this.sumaRangos[subIndice].suma = anterior + parseFloat(movid.monto);
					//console.log( `id: ${subIndice}; queMonto: ${movid.monto} ya voy sumando en efec: ${this.sumaRangos[0].suma}` );
				}
				if(this.aRestas.indexOf(movid.idMovimiento)>-1){ //resta
					suma -= parseFloat(movid.monto);
					this.sumaRangos[subIndice].suma = anterior - parseFloat(movid.monto);
				}
			});
			return suma;
		},
		
	}
}
</script>
<style scoped>
.table-hover>tfoot>tr:hover {
	--bs-table-accent-bg: var(--bs-table-hover-bg);
}
</style>
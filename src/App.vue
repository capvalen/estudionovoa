<template>
	<div >
		<div v-if="loginIn" class="container">
			<div class="row ">
				<Menu @cerrarSesion='removerSesion()'  />
				<section class="col-md-8 col-lg-9 border-start border-end p-0" id="segundaColumna">
					<div class="p-3 d-flex justify-content-between border-bottom d-none d-md-block">
						<h3 class="mb-0">Sistema - Estudio Novoa</h3>
					</div>
					<div id="contenido" class="">
			
						<router-view ref="routerVista" @cerrarSesion='removerSesion()' @mostrarToastBien="mostrarToastBien" @mostrarToastMal="mostrarToastMal" :monedas="monedas" ></router-view>
			
					</div>
				</section>
			</div>
		</div>
		<div class="container" v-else>
			<div id="cuadroLogin">
				<div class="row row-col-2">
					<div class="col">
						<p class="text-center mb-1">¿Tienes un proceso que estamos llevándolo?</p>
						<p class="text-center"><small>Ingresa tu DNI o RUC para ubicar todos sus registros</small></p>
						<div class="mx-auto w-75">
							<div class="form-floating mb-3">
							  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
							  <label for="floatingInput">D.N.I. / R.U.C.</label>
							</div>
						</div>
						<img src="/images/despegue.png" class="img-fluid mx-auto">
					</div>
					<div class="col border-start">
						<p class="fs-5 text-center">¿Eres personal administrativo?</p>
						<p class="fs-5 text-center">Ingresa tus credenciales</p>
						<div class="form-floating mb-3">
						  <input type="text" class="form-control" id="floUsuario" placeholder=" " autocomplete="off" v-model="userNick" @keyup.enter="intentarLog">
						  <label for="floUsuario">Usuario</label>
						</div>
						<div class="form-floating">
						  <input type="password" class="form-control" id="floPassword" placeholder="Password" autocomplete="off" v-model="userPass" @keyup.enter="intentarLog">
						  <label for="floPassword">Contraseña</label>
						</div>
						<div class="d-grid mt-3">
							<button class="btn btn-success btn-block" id="btnAcceder" @click="intentarLog()" >Acceder al sistema</button>
						</div>
						<div>
							<p class="text-muted text-end mt-4"><small>¿Olvidó su contraseña?</small></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="toast-container"><Tostadas :mensaje="mensaje" /></div>
		
	</div>

</template>



<script>
import Menu from '@/components/Menu.vue'
import Tostadas from '@/components/Tostadas.vue'
var tostadaBuena, tostadaMala, toastOk, toastMal

export default {
	data(){
		return {
			loginIn:false, userNick:'', userPass:'', mensaje:'', monedas:[]
		}
	},
	methods:{
		intentarLog(){
			let that = this;
			axios.post(this.nombreApi+'/validarUsuario.php', {userNick: this.userNick, userPass: this.userPass})
			.then((response)=>{ 
				console.log( response.data );
				if( Number.isInteger(response.data.id) ){
					this.mostrarToastBien('Inicio correctamente');
					this.loginIn=true;
					sessionStorage.loginIn = this.loginIn;
					sessionStorage.idUsuario = response.data.id;
					sessionStorage.nombreUsuario = response.data.nombre;
					sessionStorage.nivel = response.data.tipo;
					sessionStorage.hora = moment().add(8,'h').format('YYYY-MM-DDTHH:mm')
					const cincoMinutos = 5 * 60 * 1000;
					setInterval(this.comprobarLogeo , cincoMinutos);
				}else{
					this.mostrarToastMal('Datos erróneos');
				}
			})
			.catch((error)=>{ console.log( error );});
		
		},
		mostrarToastBien(texto){ this.mensaje= texto; toastOk.show(); },
		mostrarToastMal(texto){ this.mensaje= texto; toastMal.show(); },
		cargarMonedas(){
			axios.post(this.nombreApi+'/listarMonedas.php')
			.then((response)=>{ //console.log( response.data );
				this.monedas=response.data;
			})
			.catch((error)=>{ console.log( error );});
		},
		removerSesion(){
			this.userNick=''; this.userPass='';
			sessionStorage.removeItem('idUsuario');
			sessionStorage.removeItem('loginIn');
			sessionStorage.removeItem('nivel');
			sessionStorage.removeItem('nombreUsuario');
			sessionStorage.removeItem('nombreUsuario');
			sessionStorage.removeItem('limite')
			sessionStorage.removeItem('hora')			
			this.loginIn=false;
		},
		comprobarLogeo(){
			console.log('check log')
			var ahora = moment(); // Hora actual
			var limite = moment( sessionStorage.getItem('hora') );

			if (ahora.isBefore(limite)) {
					//pasa a usar el sistema
			} else {
					this.removerSesion()
			}
		}
	},
	mounted(){
		//let ahora = moment()
		tostadaBuena = document.getElementById('tostadaBien'); toastOk = new bootstrap.Toast(tostadaBuena)
		tostadaMala = document.getElementById('tostadaMal'); toastMal = new bootstrap.Toast(tostadaMala)

		if ( sessionStorage.getItem('hora') == null){
			this.removerSesion()
			return false;
		}else{
			this.loginIn = true
			const cincoMinutos = 5 * 60 * 1000;
			setInterval(this.comprobarLogeo , cincoMinutos);
		}	
		
		this.cargarMonedas();
		
	},
	components:{
		Menu, Tostadas
	}
}
</script>

<style>
*{font-family: 'Roboto', sans-serif;}
	section a{color:#8a96a3}
	section a.active, .router-link-exact-active{color:#242529}
	#imgPerfil{max-width: 15%;}

	#primeraColumna, #segundaColumna{min-height: 100vh;}
	#primeraColumna i{font-size: 1.7rem;}
	#spanBusqueda{ cursor:pointer; width: 2rem; height: 2rem;}
	#spanBusqueda:hover, .divContenido:hover{
		background-color: #2424249e; cursor:pointer;
	}
	#spanBusqueda:hover i{
		color:white;
	}
	.btn-primary{background-color: #8f28f0; border: 1px solid #8f28f0;}
	.btn-primary:hover, .btn-check:active+.btn-primary, .btn-check:checked+.btn-primary, .btn-primary.active, .btn-primary:active, .show>.btn-primary.dropdown-toggle, .btn-check:focus+.btn-primary, .btn-primary:focus{background-color: #7c23d0; border: 1px solid #7c23d0;}
	hr{
		background-color: #dee2e6
	}
	.btn-success{ background-color: #0bbd4a;
    border-color: #10bd6d;}
	.btn-outline-success {
    color: #0bbd4a;
    border-color: #0bbd4a;}
	.btn-success:hover, .btn-outline-success:hover {
    color: #fff;
    background-color: #0bbd4a;
    border-color: #039e3a;
	}
	.form-floating>.form-control, .form-floating>.form-control, .form-floating>.form-select{
		height: calc(2.5rem + 2px);
	}
	.form-floating>label{
		font-size: .8rem;
		padding: .5rem .75rem;
	}
	.form-floating>.form-select{
		padding-top: 1.1rem;
		padding-bottom: .25rem;
	}
	#cuadroLogin{
		margin-top: 5rem;
		padding: 3rem;
		box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
	}
	#btnAcceder{
		background-color: #47af01;
    border: 1px solid #59a029;
	}
	.breadcrumb-item + .breadcrumb-item::before {
		font-family: bootstrap-icons !important;
	}
</style>
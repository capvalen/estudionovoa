import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//createApp(App).use(router).mount('#app')


const app= createApp(App);
//Pruebas local
/* app.config.globalProperties.nombreApi ='http://localhost/novoa/api';
app.config.globalProperties.rutaDocs = '/srv/http/novoa/documentos/'; */

//Demo
/* app.config.globalProperties.nombreApi ='https://novoademo.infocatsoluciones.com/api';
app.config.globalProperties.rutaDocs ='/home/wfvrkfap/apps/demos/novoa/documentos/'; */

//Producción
app.config.globalProperties.nombreApi ='https://intranet.novoa-medicos-abogados.com/api';
app.config.globalProperties.rutaDocs ='/home/wfvrkfap/WEBS/novoa-medicos-abogados.com/intranet/documentos/';


app.use(router).mount('#app')
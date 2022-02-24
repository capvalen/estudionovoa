import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//createApp(App).use(router).mount('#app')


const app= createApp(App);
//Pruebas local
/* app.config.globalProperties.nombreApi ='http://localhost/novoaApi';
app.config.globalProperties.rutaDocs ='D:/Archivos/Programado/estudionovoa/public/documentos/'; */

//Producción
app.config.globalProperties.nombreApi ='https://intranet.novoa-medicos-abogados.com/api';
app.config.globalProperties.rutaDocs ='/home/wfvrkfap/WEBS/novoa-medicos-abogados.com/intranet/documentos/';

app.use(router).mount('#app')
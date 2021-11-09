import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//createApp(App).use(router).mount('#app')


const app= createApp(App);

app.config.globalProperties.nombreApi ='https://intranet.novoa-medicos-abogados.com/api'; //http://localhost/novoaApi

app.use(router).mount('#app')
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
	{
		path: '/',
		name: 'Inicio',
		component: function () {
			return import('../views/Inicio.vue')
		}
	},
	{
		path: '/clientes',
		name: 'Clientes',
		component: function () {
			return import('../views/Clientes.vue')
		}
	},
	{
		path: '/procesos',
		name: 'Procesos',
		component: function () {
			return import('../views/Procesos.vue')
		}
	},
	{
		path: '/procesos/detalle/:id',
		name: 'detalleProcesos',
		component: function () {
			return import('../views/DetalleProcesos.vue')
		}
	},
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
})

export default router

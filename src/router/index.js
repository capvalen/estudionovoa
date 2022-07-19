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
		path: '/clientes/nuevo',
		name: 'ClientesNuevo',
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
		path: '/caja',
		name: 'Caja',
		component: function () {
			return import('../views/Caja.vue')
		}
	},
	{
		path: '/procesos/detalle/:id',
		name: 'detalleProcesos',
		component: function () {
			return import('../views/DetalleProcesos.vue')
		}
	},
	{
		path: '/calendario',
		name: 'Calendario',
		component: function () {
			return import('../views/Calendario.vue')
		}
	},
	{
		path: '/usuarios',
		name: 'Usuarios',
		component: function () {
			return import('../views/Usuarios.vue')
		}
	},
	{
		path: '/reportes',
		name: 'Reportes',
		component: function () {
			return import('../views/Reportes.vue')
		}
	},
	{
		path: '/configuraciones',
		name: 'Configuraciones',
		component: function () {
			return import('../views/Configuraciones.vue')
		}
	},
]

const router = createRouter({
	mode: 'history',
	history: createWebHistory(process.env.BASE_URL),
	routes
})

export default router

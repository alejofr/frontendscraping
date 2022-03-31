
export const routes = [
	{
		name: 'Scraping',
		path: '/',
		component:  () => import ('./components/WebScraping/Scraping.vue'),
		meta: { requiresAuth: true }
	},
	{
		name: 'Redireccionamiento',
		path: '/redireccionamiento',
		component:  () => import ('./components/Redireccionamiento.vue'),
		meta: { requiresAuth: false }
	},
	{
		name: 'Login',
		path: '/login',
		component:  () => import ('./components/Login.vue')
	}
];

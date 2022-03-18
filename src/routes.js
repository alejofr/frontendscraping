export const routes = [
	{
		name: 'Scraping',
		path: '/',
		component:  () => import ('./components/WebScraping/Scraping.vue'),
		meta: { requiresAuth: true }
	},
	{
		name: 'Login',
		path: '/login',
		component:  () => import ('./components/Login.vue')
	}
]
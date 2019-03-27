import VueRouter from 'vue-router';


let routes = [
	{
		path: '/',
		name: 'home',
		component: require('./components/Home').default
	},
	{
		path: '/jobs',
		name: 'jobs',
		component: require('./components/Jobs').default
	},
  {
		path: '/jobs/crud/:token?',
		name: 'crud-job',
		component: require('./components/CRUDJob').default
	},
	{
		path: '/flats',
		name: 'flats',
		component: require('./components/Flats').default
	},
	{
		path: '/flats/crud/:token?',
		name: 'crud-flat',
		component: require('./components/CRUDFlat').default
	},
	{
		path: '/foodshopping',
		name: 'foodshopping',
		component: require('./components/Foodshopping').default
	},
	{
		path: '/foodshopping/crud/:token?',
		name: 'crud-articles',
		component: require('./components/CRUDArticles').default
	},
  {
		path: '/purchases',
		name: 'purchases',
		component: require('./components/Purchases').default
	},
]

export default new VueRouter({
	routes,
	mode: 'history',
	hashbang: false,
	linkActiveClass : "active"
})

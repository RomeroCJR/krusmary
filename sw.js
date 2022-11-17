;
const CACHE_NAME = 'v1_cache_dist_krusmary',
urlsToCache = [
	'templates/app',
	'https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap',
    'https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap',
	'css/style.css'
]

self.addEventListener('install', e => {
	e.waitUntil(
		caches.open(CACHE_NAME)
		.then(cache => {
			return cache.addAll(urlsToCache)
			.then(() => self.skipWaiting())
		})
		.catch(err => console.log('Falló registro de cache', err))
	)
})

self.addEventListener('activate', e => {
	const cacheWhitelist = [CACHE_NAME]

	e.waitUntil(
		caches.keys()
		.then(cachesNames => {
			cacheNames.map(cacheName => {
				if (cacheWhitelist.indexOf(cacheName) === -1) {
					return caches.delete(cacheName)
				}
			})
		})
		.then(()=>self.clients.claim())
	)
})

self.addEventListener('fetch', e => {
	e.respondWith(
		caches.match(e.request)
		.then(res => {
			if (res) {
				return res
			}
			return fetch(e.request)
		})
	)
})
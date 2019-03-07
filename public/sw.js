importScripts("/service-worker/precache-manifest.d36c52b586eb1c7fc2eb09e1eca6492e.js", "https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

// importScripts('/service-worker/precache-manifest.fc21ecfebb4853d725aa822e2382fb14.js', 'https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js')

workbox.skipWaiting()
workbox.clientsClaim()

workbox.precaching.precacheAndRoute(self.__precacheManifest)

workbox.routing.registerRoute(
  new RegExp('.(?:jpg|jpeg|png|gif|svg|webp)$'),
  workbox.strategies.cacheFirst({
    cacheName: 'images',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 20,
        purgeOnQuotaError: true
      })
    ]
  })
)

workbox.routing.registerRoute(
  '/',
  workbox.strategies.staleWhileRevalidate({ cacheName: 'landing' })
)

workbox.routing.registerRoute(
  '/public/css/*',
  workbox.strategies.staleWhileRevalidate({ cacheName: 'css' })
)

workbox.routing.registerRoute(
  '/public/favicon-32x32',
  workbox.strategies.cacheFirst({ cacheName: 'favicon' })
)
workbox.routing.registerRoute(
  new RegExp('/tasques'),
  new workbox.strategies.NetworkFirst()
);


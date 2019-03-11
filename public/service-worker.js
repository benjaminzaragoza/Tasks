// importScripts('/service-worker/precache-manifest.fc21ecfebb4853d725aa822e2382fb14.js', 'https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js')
workbox.setConfig({
  debug: true
})

// workbox.skipWaiting()
// workbox.clientsClaim()
workbox.core.skipWaiting()
workbox.core.clientsClaim()

workbox.precaching.cleanupOutdatedCacjes();

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
const bgSyncPlugin = new workbox.backgroundSync.Plugin('newsletter', {
  maxRetentionTime: 24 * 60, // Retry for max of 24 Hours
  callbacks: {
    queueDidReplay: showNotification
  }
})

workbox.routing.registerRoute(
  '/',
  new workbox.strategies.staleWhileRevalidate({ cacheName: 'landing' })
)

workbox.routing.registerRoute(
  '/public/css/*',
  new workbox.strategies.staleWhileRevalidate({ cacheName: 'css' })
)

workbox.routing.registerRoute(
  '/public/favicon-32x32',
  new workbox.strategies.cacheFirst({ cacheName: 'favicon' })
)
workbox.routing.registerRoute(
  new RegExp('/tasques'),
  new workbox.strategies.NetworkFirst()
)
workbox.routing.registerRoute(
  '/api/v1/newsletter',
  new workbox.strategies.NetworkOnly({
    plugins: [bgSyncPlugin]
  }),
  'POST'
)

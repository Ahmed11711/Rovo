importScripts("https://js.pusher.com/beams/service-worker.js");

const CACHE_NAME = 'your-cache-name';
const OFFLINE_URL = '/offline'; // Make sure this path is correct

// Install Event - Caching the offline page and other assets
self.addEventListener('install', (event) => {
   event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(OFFLINE_URL);
        })
    );
        self.skipWaiting();

});

self.addEventListener('push', (event) => {
  let options = {
    body: event.data.text(),
    icon: '/img/192x192.png',
    badge: '/icons/badge-72x72.png'
  };

  event.waitUntil(
    self.registration.showNotification('New Notification', options)
  );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(OFFLINE_URL);
        })
    );
});

// Activate Event - Clean up old caches (optional)
self.addEventListener('activate', (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});



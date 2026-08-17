const CACHE_NAME = 'online-towing-v2';

self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(names =>
            Promise.all(
                names.map(name => caches.delete(name))
            )
        )
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {
    // Never interfere with POST requests such as login/logout.
    if (event.request.method !== 'GET') {
        return;
    }

    // For now, always fetch normally.
    // This tests registration without caching Laravel pages.
});
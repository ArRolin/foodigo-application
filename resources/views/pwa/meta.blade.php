<!-- PWA Meta Tags -->
@php
    $settings = Modules\GlobalSetting\App\Models\GlobalSetting::get()->keyBy('key');
    $logoPath = $settings->get('logo')->value ?? null;
    $faviconPath = $settings->get('favicon')->value ?? null;
    $isSvg = $logoPath && pathinfo($logoPath, PATHINFO_EXTENSION) === 'svg';
@endphp
<link rel="manifest" href="{{ url('/manifest.json') }}">
<meta name="theme-color" content="#ff6b35">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="{{ $settings->get('app_name')->value ?? 'Foodigo' }}">
<meta name="application-name" content="{{ $settings->get('app_name')->value ?? 'Foodigo' }}">
<meta name="msapplication-TileColor" content="#ff6b35">
<meta name="msapplication-config" content="/browserconfig.xml">

<!-- Apple Touch Icons -->
<link rel="apple-touch-icon" href="{{ asset($faviconPath ?? '/images/icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset($faviconPath ?? '/images/icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset($faviconPath ?? '/images/icons/icon-192x192.png') }}">
<link rel="apple-touch-icon" sizes="167x167" href="{{ asset($faviconPath ?? '/images/icons/icon-152x152.png') }}">

<!-- PWA Icons -->
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset($faviconPath ?? '/images/icons/icon-72x72.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset($faviconPath ?? '/images/icons/icon-72x72.png') }}">

<!-- Service Worker Registration -->
<script>
if ('serviceWorker' in navigator) {
    console.log('Service Worker: Supported');
    window.addEventListener('load', function() {
        console.log('Service Worker: Registering...');
        navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
                // Check if service worker is active
                if (registration.active) {
                    console.log('Service Worker: Active');
                } else if (registration.installing) {
                    console.log('Service Worker: Installing');
                } else if (registration.waiting) {
                    console.log('Service Worker: Waiting');
                }
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed: ', err);
                console.log('Error details:', err.message);
            });
    });
} else {
    console.log('Service Worker: Not supported');
}
</script>

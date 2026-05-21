@php
    $settings = Modules\GlobalSetting\App\Models\GlobalSetting::get()->keyBy('key');
    $setting_logo = Modules\GlobalSetting\App\Models\GlobalSetting::where('key','favicon')->first();
    $logoPath =  $setting_logo->value ?? null;
    $isSvg = $logoPath && pathinfo($logoPath, PATHINFO_EXTENSION) === 'svg';

    // Get PWA icons from database
    $pwaIcons = Modules\GlobalSetting\App\Models\PwaIconSetting::getActiveIcons();

    // Log PWA icon information for debugging
    \Log::info('PWA Manifest - Icons Loaded', [
        'total_icons' => $pwaIcons->count(),
        'icons' => $pwaIcons->map(function($icon) {
            return [
                'size' => $icon->icon_size,
                'path' => $icon->icon_path,
                'type' => $icon->icon_type,
                'purpose' => $icon->purpose,
                'active' => $icon->is_active
            ];
        })->toArray()
    ]);
@endphp
{
    "name": "{{ $settings->get('app_name')->value ?? 'Foodigo - Food Delivery' }}",
    "short_name": "{{ $settings->get('app_name')->value ?? 'Foodigo' }}",
    "description": "{{ $settings->get('app_name')->value ?? 'Foodigo' }} - Order delicious food online",
    "start_url": "/",
    "display": "standalone",
    "background_color": "#ffffff",
    "theme_color": "#ff6b35",
    "orientation": "portrait",
    "scope": "/",
    "lang": "en",
    "categories": ["food", "lifestyle", "shopping"],
    "icons": [
        @foreach($pwaIcons as $icon)
        {
            "src": "{{ $icon->icon_path ? asset($icon->icon_path) : asset('/images/icons/logo-' . $icon->icon_size . '.png') }}",
            "sizes": "{{ $icon->icon_size }}",
            "type": "{{ $icon->icon_type }}",
            "purpose": "{{ $icon->purpose }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}

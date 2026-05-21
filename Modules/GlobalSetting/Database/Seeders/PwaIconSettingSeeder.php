<?php

namespace Modules\GlobalSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\App\Models\PwaIconSetting;

class PwaIconSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultIcons = [
            ['icon_size' => '72x72', 'icon_path' => 'uploads/pwa-icons/pwa-icon-72x72-2025-08-07-03-26-54-8296.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '96x96', 'icon_path' => 'uploads/pwa-icons/pwa-icon-96x96-2025-08-07-03-26-54-6678.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '128x128', 'icon_path' => 'uploads/pwa-icons/pwa-icon-128x128-2025-08-07-03-27-15-8215.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '144x144', 'icon_path' => 'uploads/pwa-icons/pwa-icon-144x144-2025-08-07-03-27-15-9110.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '152x152', 'icon_path' => 'uploads/pwa-icons/pwa-icon-152x152-2025-08-07-03-27-15-2133.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '192x192', 'icon_path' => 'uploads/pwa-icons/pwa-icon-192x192-2025-08-07-03-31-55-7708.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '384x384', 'icon_path' => 'uploads/pwa-icons/pwa-icon-384x384-2025-08-07-03-31-55-4877.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
            ['icon_size' => '512x512', 'icon_path' => 'uploads/pwa-icons/pwa-icon-512x512-2025-08-07-03-31-55-1741.png', 'icon_type' => 'image/png', 'purpose' => 'any maskable'],
        ];

        foreach ($defaultIcons as $icon) {
            PwaIconSetting::updateOrCreate(
                ['icon_size' => $icon['icon_size']],
                $icon
            );
        }
    }
}

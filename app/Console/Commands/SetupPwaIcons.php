<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\GlobalSetting\App\Models\PwaIconSetting;

class SetupPwaIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pwa:setup-icons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup PWA icons with default configurations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up PWA icons...');

        // Check if icons exist
        $iconCount = PwaIconSetting::count();

        if ($iconCount > 0) {
            $this->info("Found {$iconCount} PWA icon configurations.");

            $icons = PwaIconSetting::all();
            $this->table(
                ['Size', 'Path', 'Type', 'Purpose', 'Active'],
                $icons->map(function ($icon) {
                    return [
                        $icon->icon_size,
                        $icon->icon_path ?: 'Default',
                        $icon->icon_type,
                        $icon->purpose,
                        $icon->is_active ? 'Yes' : 'No'
                    ];
                })->toArray()
            );
        } else {
            $this->error('No PWA icons found. Please run the seeder first.');
            $this->info('Run: php artisan db:seed --class="Modules\GlobalSetting\Database\Seeders\PwaIconSettingSeeder"');
        }

        $this->info('PWA icon setup completed!');
        $this->info('You can now manage PWA icons from the admin panel at: /admin/configuration/pwa-icon-settings');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'QR Davetiye',
            'site_description' => 'Dijital davetiyelerinizi QR kodları ile oluşturun, yönetin ve paylaşın.',
            'contact_email' => 'info@qr-davetiye.com',
            'default_plan_id' => '1',
            'max_upload_size' => '64000',
            'maintenance_mode' => 'false',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_twitter' => '',
            'tax_rate' => '20',
            'bank_name' => 'Yapı Kredi Bankası',
            'bank_holder' => 'UMUT UÇAR',
            'bank_iban' => 'TR450006701000000048863426',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}

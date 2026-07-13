<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(
            ['name' => 'Deneme'],
            [
                'name' => 'Deneme',
                'description' => '3 günlük ücretsiz deneme. Sınırsız özellik, 1 davetiye.',
                'monthly_price' => 0,
                'yearly_price' => 0,
                'max_invitations' => 1,
                'max_images_per_invitation' => 3,
                'music_feature' => true,
                'video_feature' => true,
                'cover_video_feature' => true,
                'rsvp_feature' => true,
                'qr_download' => true,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Temel'],
            [
                'name' => 'Temel',
                'description' => 'Tek davetiye ile başlamak isteyenler için ideal.',
                'monthly_price' => 99.90,
                'yearly_price' => 799.90,
                'max_invitations' => 1,
                'max_images_per_invitation' => 5,
                'music_feature' => false,
                'video_feature' => false,
                'rsvp_feature' => true,
                'qr_download' => false,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Standart'],
            [
                'name' => 'Standart',
                'description' => 'Daha fazla davetiye ve müzik özelliği ile öne çıkın.',
                'monthly_price' => 149.90,
                'yearly_price' => 1299.90,
                'max_invitations' => 5,
                'max_images_per_invitation' => 15,
                'music_feature' => true,
                'video_feature' => false,
                'rsvp_feature' => true,
                'qr_download' => true,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Premium'],
            [
                'name' => 'Premium',
                'description' => 'Sınırsız davetiye, video ve tüm özelliklerle profesyonel çözüm.',
                'monthly_price' => 249.90,
                'yearly_price' => 2199.90,
                'max_invitations' => -1,
                'max_images_per_invitation' => -1,
                'music_feature' => true,
                'video_feature' => true,
                'cover_video_feature' => true,
                'rsvp_feature' => true,
                'qr_download' => true,
                'is_active' => true,
            ]
        );
    }
}

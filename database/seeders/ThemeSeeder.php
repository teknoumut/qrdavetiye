<?php

namespace Database\Seeders;

use App\Models\InvitationTheme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        InvitationTheme::firstOrCreate(
            ['slug' => 'classic'],
            [
                'name' => 'Klasik',
                'slug' => 'classic',
                'description' => 'Altın ve beyazın zarif uyumu, geleneksel şıklık.',
                'primary_color' => '#d4af37',
                'secondary_color' => '#ffffff',
                'font_family' => 'Playfair Display, serif',
                'blade_template' => 'classic',
                'is_active' => true,
                'is_premium' => false,
            ]
        );

        InvitationTheme::firstOrCreate(
            ['slug' => 'modern'],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'Lacivert ve gümüş tonlarıyla çağdaş tasarım.',
                'primary_color' => '#1a237e',
                'secondary_color' => '#c0c0c0',
                'font_family' => 'Montserrat, sans-serif',
                'blade_template' => 'modern',
                'is_active' => true,
                'is_premium' => false,
            ]
        );

        InvitationTheme::firstOrCreate(
            ['slug' => 'romantic'],
            [
                'name' => 'Romantik',
                'slug' => 'romantic',
                'description' => 'Pembe ve beyaz tonlarında romantik bir atmosfer.',
                'primary_color' => '#e91e63',
                'secondary_color' => '#fff0f5',
                'font_family' => 'Great Vibes, cursive',
                'blade_template' => 'romantic',
                'is_active' => true,
                'is_premium' => true,
            ]
        );

        InvitationTheme::firstOrCreate(
            ['slug' => 'nature'],
            [
                'name' => 'Doğa',
                'slug' => 'nature',
                'description' => 'Yeşil ve krem tonlarıyla doğadan ilham alan tasarım.',
                'primary_color' => '#2e7d32',
                'secondary_color' => '#f5f5dc',
                'font_family' => 'Lora, serif',
                'blade_template' => 'nature',
                'is_active' => true,
                'is_premium' => true,
            ]
        );
    }
}

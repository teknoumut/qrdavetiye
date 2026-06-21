<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatternSeeder extends Seeder
{
    private array $names = [
        '2ntQK70ZcGe0pmq0U9RV3HLR8Cak1IWZeo8UTu97.png' => 'Desen 1',
        '62k0QBhvzF6fp5UCraIDDFR5SuUWFWOuJ4BZyDP9.png' => 'Desen 2',
        '8Xxn2YlMXkkJVuFDKTVTo1f9cp52nERPINqk1gK5.png' => 'Desen 3',
        'dsupDBs0KGj4AavFg6FfclXIg40HO2cg79zi2BXf.png' => 'Desen 4',
        'EkMmUjeIt0LrXurXfWy7P5vQxNmyZRlu6dFhUtp9.png' => 'Desen 5',
        'LnkBtxrsXMntpaz8mgq0iHQleJSTX1JrVKnokoYL.png' => 'Desen 6',
        'nBc8xVg7G6K8w40MK5AmimiFuNeiR7EFTedm6lfR.png' => 'Desen 7',
        'o59eQuZR1q6EiN3CIgyAJy961WgXbpAtpq40JoGc.png' => 'Desen 8',
        'OmpPaszngLdkyAYAElyGNs2ZD4XrsiOCQlkFm5of.png' => 'Desen 9',
        'Ots9AWDTuSVTAa9TbTW99rQIMpjJRlLtYD1sXKgK.png' => 'Desen 10',
        'Pct4YN2eTEnSipIJuTq7ilkYrrQljRPN8yA1JMxf.png' => 'Desen 11',
        'rjPug3Bd17mzkt9ZON6Ad4nYoIE7hf4TFL7pdcVK.png' => 'Desen 12',
        'rPvQQXk7DFBCMLdoQKyvxWSnFOBGCFOI9ee3ZZCf.png' => 'Desen 13',
        'syXHYSjIGCgSJAFk5tlliOP7izayIYDqqLkxHgbs.png' => 'Desen 14',
        'WKSjOSXfOWNBdFdtxUqts1hIL3ReDr5NBuwRzh8J.png' => 'Desen 15',
    ];

    public function run(): void
    {
        if (Pattern::count() > 0) {
            $this->command->warn('Patterns tablosu zaten dolu. Tekrar eklemek icin once tabloyu temizleyin.');
            $this->command->warn('php artisan tinker --execute="\App\Models\Pattern::truncate()"');

            return;
        }

        $assetsDir = __DIR__.'/assets/patterns';

        if (! is_dir($assetsDir)) {
            $this->command->error("Klasor bulunamadi: $assetsDir");

            return;
        }

        $count = 0;

        foreach ($this->names as $filename => $label) {
            $filePath = $assetsDir.'/'.$filename;

            if (! file_exists($filePath)) {
                $this->command->warn("Dosya bulunamadi: $filename");

                continue;
            }

            $contents = file_get_contents($filePath);

            $stored = Storage::disk('public')->put('patterns/'.$filename, $contents);

            if (! $stored) {
                $this->command->error("Dosya yazilamadi: $filename");

                continue;
            }

            $slug = Str::slug($label).'-'.Str::random(4);

            Pattern::create([
                'name' => $label,
                'slug' => $slug,
                'image_path' => 'patterns/'.$filename,
                'is_active' => true,
                'is_premium' => false,
            ]);

            $count++;
        }

        $this->command->info("$count desen basariyla eklendi.");
    }
}

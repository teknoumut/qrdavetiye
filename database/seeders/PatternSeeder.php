<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatternSeeder extends Seeder
{
    public function run(): void
    {
        if (Pattern::count() > 0) {
            $this->command->info('Patterns tablosu zaten dolu, atlaniyor.');

            return;
        }

        $assetsDir = __DIR__.'/assets/patterns';
        $files = glob($assetsDir.'/*.png');

        if (! $files) {
            $this->command->error('database/seeders/assets/patterns/ klasorunde PNG dosyasi bulunamadi.');

            return;
        }

        $names = [
            'LnkBtxrsXMntpaz8mgq0iHQleJSTX1JrVKnokoYL.png' => 'Desen 1',
            'OmpPaszngLdkyAYAElyGNs2ZD4XrsiOCQlkFm5of.png' => 'Desen 2',
            '8Xxn2YlMXkkJVuFDKTVTo1f9cp52nERPINqk1gK5.png' => 'Desen 3',
            'o59eQuZR1q6EiN3CIgyAJy961WgXbpAtpq40JoGc.png' => 'Desen 4',
            'rjPug3Bd17mzkt9ZON6Ad4nYoIE7hf4TFL7pdcVK.png' => 'Desen 5',
            'syXHYSjIGCgSJAFk5tlliOP7izayIYDqqLkxHgbs.png' => 'Desen 6',
            'EkMmUjeIt0LrXurXfWy7P5vQxNmyZRlu6dFhUtp9.png' => 'Desen 7',
            'rPvQQXk7DFBCMLdoQKyvxWSnFOBGCFOI9ee3ZZCf.png' => 'Desen 8',
            '2ntQK70ZcGe0pmq0U9RV3HLR8Cak1IWZeo8UTu97.png' => 'Desen 9',
            'Pct4YN2eTEnSipIJuTq7ilkYrrQljRPN8yA1JMxf.png' => 'Desen 10',
            'dsupDBs0KGj4AavFg6FfclXIg40HO2cg79zi2BXf.png' => 'Desen 11',
            'Ots9AWDTuSVTAa9TbTW99rQIMpjJRlLtYD1sXKgK.png' => 'Desen 12',
            'nBc8xVg7G6K8w40MK5AmimiFuNeiR7EFTedm6lfR.png' => 'Desen 13',
            '62k0QBhvzF6fp5UCraIDDFR5SuUWFWOuJ4BZyDP9.png' => 'Desen 14',
            'WKSjOSXfOWNBdFdtxUqts1hIL3ReDr5NBuwRzh8J.png' => 'Desen 15',
        ];

        sort($files);

        foreach ($files as $filePath) {
            $filename = basename($filePath);

            $storedPath = Storage::disk('public')->putFileAs(
                'patterns',
                new File($filePath),
                $filename
            );

            $name = $names[$filename] ?? 'Desen '.pathinfo($filename, PATHINFO_FILENAME);
            $slug = Str::slug($name).'-'.Str::random(4);

            Pattern::create([
                'name' => $name,
                'slug' => $slug,
                'image_path' => $storedPath,
                'is_active' => true,
                'is_premium' => false,
            ]);
        }

        $this->command->info(count($files).' desen basariyla eklendi.');
    }
}

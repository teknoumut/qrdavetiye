<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:png,jpg|max:1024',
            'site_favicon' => 'nullable|file|mimes:ico,png|max:512',
            'smtp_host' => 'nullable|string',
            'smtp_port' => 'nullable|integer',
            'smtp_username' => 'nullable|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'nullable|string',
            'smtp_from_address' => 'nullable|email',
            'smtp_from_name' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'whatsapp_message' => 'nullable|string',
            'admin_primary_color' => 'nullable|string|max:20',
            'site_primary_color' => 'nullable|string|max:20',
            'site_secondary_color' => 'nullable|string|max:20',

            'iyzico_api_key' => 'nullable|string',
            'iyzico_secret_key' => 'nullable|string',
            'iyzico_base_url' => 'nullable|string',

            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'bank_name' => 'nullable|string|max:255',
            'bank_holder' => 'nullable|string|max:255',
            'bank_iban' => 'nullable|string|max:50',

            'notification_sound_preset' => 'nullable|string|in:ding,chime,triple,custom',
            'notification_sound_custom' => 'nullable|string|max:500',
            'notification_sound_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a,mp4|max:2048',
            'hero_video' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
        ]);

        if ($request->hasFile('notification_sound_file')) {
            $file = $request->file('notification_sound_file');
            $filename = 'notification_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('sounds'), $filename);
            $data['notification_sound_custom'] = asset('sounds/'.$filename);
            $data['notification_sound_preset'] = 'custom';
        }

        foreach ($data as $key => $value) {
            if ($key === 'notification_sound_file') {
                continue;
            }
            if ($key === 'site_logo' && $request->hasFile('site_logo')) {
                $value = $request->file('site_logo')->store('settings', 'public');
            }
            if ($key === 'site_favicon' && $request->hasFile('site_favicon')) {
                $value = $request->file('site_favicon')->store('settings', 'public');
            }
            if ($key === 'hero_video' && $request->hasFile('hero_video')) {
                $value = $request->file('hero_video')->store('hero', 'public');
            }
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Ayarlar güncellendi.');
    }

    public function downloadYoutubeSound(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $url = $request->input('url');

        if (! preg_match('/youtube\.com|youtu\.be/i', $url)) {
            return response()->json(['success' => false, 'message' => 'Geçerli bir YouTube linki girin.'], 422);
        }

        $ytDlp = $this->ensureYtDlp();
        if (! $ytDlp) {
            return response()->json(['success' => false, 'message' => 'yt-dlp indirilemedi. Lütfen https://github.com/yt-dlp/yt-dlp/releases adresinden manuel indirin ve storage/app/bin/yt-dlp.exe konumuna koyun.'], 500);
        }

        $soundsDir = public_path('sounds');
        if (! is_dir($soundsDir)) {
            mkdir($soundsDir, 0755, true);
        }

        $filename = 'yt_'.Str::random(12).'.m4a';
        $outputPath = $soundsDir.DIRECTORY_SEPARATOR.$filename;

        $process = new Process([
            $ytDlp,
            '-f', 'bestaudio[ext=m4a]',
            '--no-playlist',
            '-o', $outputPath,
            $url,
        ]);
        $process->setTimeout(120);
        $process->run();

        if (! $process->isSuccessful() || ! file_exists($outputPath) || filesize($outputPath) === 0) {
            $process = new Process([
                $ytDlp,
                '-f', 'bestaudio',
                '--no-playlist',
                '-o', $outputPath,
                $url,
            ]);
            $process->setTimeout(120);
            $process->run();
        }

        if (! file_exists($outputPath) || filesize($outputPath) === 0) {
            if (file_exists($outputPath)) {
                unlink($outputPath);
            }

            return response()->json(['success' => false, 'message' => 'Ses indirilemedi. YouTube linkini kontrol edin veya direkt MP3 URL\'si kullanın.'], 500);
        }

        $publicUrl = asset('sounds/'.$filename);

        return response()->json([
            'success' => true,
            'url' => $publicUrl,
            'message' => 'Ses başarıyla indirildi.',
        ]);
    }

    private function ensureYtDlp(): ?string
    {
        $paths = [
            'yt-dlp',
            'yt-dlp.exe',
            storage_path('app/bin/yt-dlp.exe'),
            storage_path('app/bin/yt-dlp'),
        ];

        foreach ($paths as $path) {
            $resolved = is_file($path) ? realpath($path) : (shell_exec('where '.escapeshellarg($path).' 2>nul') ?: null);
            if ($resolved) {
                return trim($resolved);
            }
        }

        $binDir = storage_path('app/bin');
        if (! is_dir($binDir)) {
            mkdir($binDir, 0755, true);
        }

        $dest = $binDir.DIRECTORY_SEPARATOR.'yt-dlp.exe';
        $ytDlpUrl = 'https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp.exe';

        $ch = curl_init($ytDlpUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $content) {
            file_put_contents($dest, $content);

            return realpath($dest) ?: $dest;
        }

        return null;
    }
}

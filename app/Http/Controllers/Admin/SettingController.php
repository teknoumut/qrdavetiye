<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
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
        ]);

        foreach ($data as $key => $value) {
            if ($key === 'site_logo' && $request->hasFile('site_logo')) {
                $value = $request->file('site_logo')->store('settings', 'public');
            }
            if ($key === 'site_favicon' && $request->hasFile('site_favicon')) {
                $value = $request->file('site_favicon')->store('settings', 'public');
            }
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Ayarlar güncellendi.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvitationTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = InvitationTheme::latest()->get();

        return view('admin.themes.index', compact('themes'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'font_family' => 'nullable|string',
            'blade_template' => 'required|string',
            'is_premium' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        InvitationTheme::create($data);

        return redirect()->route('admin.themes.index')->with('success', 'Tema oluşturuldu.');
    }

    public function edit(InvitationTheme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Request $request, InvitationTheme $theme)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'font_family' => 'nullable|string',
            'blade_template' => 'required|string',
            'is_premium' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $theme->update($data);

        return redirect()->route('admin.themes.index')->with('success', 'Tema güncellendi.');
    }

    public function destroy(InvitationTheme $theme)
    {
        $theme->delete();

        return redirect()->route('admin.themes.index')->with('success', 'Tema silindi.');
    }
}

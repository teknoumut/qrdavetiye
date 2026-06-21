<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pattern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatternController extends Controller
{
    public function index()
    {
        $patterns = Pattern::latest()->get();

        return view('admin.patterns.index', compact('patterns'));
    }

    public function create()
    {
        return view('admin.patterns.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:20480',
            'is_premium' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['image_path'] = $request->file('image')->store('patterns', 'public');
        $data['is_premium'] = $request->boolean('is_premium');

        Pattern::create($data);

        return redirect()->route('admin.patterns.index')->with('success', 'Desen eklendi.');
    }

    public function edit(Pattern $pattern)
    {
        return view('admin.patterns.edit', compact('pattern'));
    }

    public function update(Request $request, Pattern $pattern)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:20480',
            'is_premium' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_premium'] = $request->boolean('is_premium');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($pattern->image_path);
            $data['image_path'] = $request->file('image')->store('patterns', 'public');
        }

        $pattern->update($data);

        return redirect()->route('admin.patterns.index')->with('success', 'Desen güncellendi.');
    }

    public function destroy(Pattern $pattern)
    {
        Storage::disk('public')->delete($pattern->image_path);
        $pattern->delete();

        return redirect()->route('admin.patterns.index')->with('success', 'Desen silindi.');
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Hiçbir desen seçilmedi.');
        }

        $patterns = Pattern::whereIn('id', $ids)->get();

        foreach ($patterns as $pattern) {
            Storage::disk('public')->delete($pattern->image_path);
            $pattern->delete();
        }

        Log::info('Toplu desen silme', ['ids' => $ids, 'count' => $patterns->count(), 'by' => auth()->id()]);

        return redirect()->route('admin.patterns.index')->with('success', count($ids).' desen silindi.');
    }
}

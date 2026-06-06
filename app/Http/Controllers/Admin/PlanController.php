<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_invitations' => 'required|integer|min:-1',
            'max_images_per_invitation' => 'required|integer|min:-1',
            'music_feature' => 'boolean',
            'video_feature' => 'boolean',
            'rsvp_feature' => 'boolean',
            'qr_download' => 'boolean',
        ]);

        $data['is_active'] = true;
        Plan::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Paket oluşturuldu.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_invitations' => 'required|integer|min:-1',
            'max_images_per_invitation' => 'required|integer|min:-1',
            'music_feature' => 'boolean',
            'video_feature' => 'boolean',
            'rsvp_feature' => 'boolean',
            'qr_download' => 'boolean',
        ]);

        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('success', 'Paket güncellendi.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Paket silindi.');
    }

    public function toggleActive(Plan $plan)
    {
        $plan->update(['is_active' => ! $plan->is_active]);

        return back()->with('success', 'Paket durumu güncellendi.');
    }
}

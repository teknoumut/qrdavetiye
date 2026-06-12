<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('invitations')->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $plans = Plan::all();

        return view('admin.users.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'is_active' => 'boolean',
            'plan_id' => 'nullable|exists:plans,id',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date|after:subscription_start',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] ??= true;

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı oluşturuldu.');
    }

    public function edit(User $user)
    {
        $plans = Plan::all();

        return view('admin.users.edit', compact('user', 'plans'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'is_active' => 'boolean',
            'plan_id' => 'nullable|exists:plans,id',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date|after:subscription_start',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] ??= false;

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı güncellendi.');
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendinizin admin yetkisini değiştiremezsiniz.');
        }

        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', 'Kullanıcı admin yetkisi '.($user->is_admin ? 'verildi' : 'alındı').'.');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Admin kullanıcı silinemez.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı silindi.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'Kullanıcı durumu güncellendi.');
    }

    public function extendSubscription(Request $request, User $user)
    {
        $request->validate(['days' => 'required|integer|min:1|max:365']);

        $newEnd = $user->subscription_end && $user->subscription_end > now()
            ? $user->subscription_end->addDays($request->days)
            : now()->addDays($request->days);

        $user->update([
            'subscription_end' => $newEnd,
            'is_active' => true,
        ]);

        return back()->with('success', $request->days.' gün eklendi. Yeni bitiş: '.$newEnd->format('d.m.Y'));
    }

    public function invitations(User $user)
    {
        $invitations = $user->invitations()->withCount('rsvps')->latest()->paginate(20);

        return view('admin.users.invitations', compact('user', 'invitations'));
    }

    public function uploadPhoto(Request $request, User $user)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with('success', 'Profil resmi güncellendi.');
    }

    public function deletePhoto(User $user)
    {
        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
        }

        return back()->with('success', 'Profil resmi kaldırıldı.');
    }
}

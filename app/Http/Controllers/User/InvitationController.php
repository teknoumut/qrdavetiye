<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\InvitationService;
use App\Http\Services\QrCodeService;
use App\Models\Invitation;
use App\Models\InvitationImage;
use App\Models\InvitationMusic;
use App\Models\InvitationTheme;
use App\Models\InvitationVideo;
use App\Models\Plan;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    protected InvitationService $invitationService;

    protected QrCodeService $qrCodeService;

    public function __construct(InvitationService $invitationService, QrCodeService $qrCodeService)
    {
        $this->invitationService = $invitationService;
        $this->qrCodeService = $qrCodeService;
    }

    public function index()
    {
        $invitations = auth()->user()->invitations()
            ->withCount('rsvps')
            ->latest()
            ->paginate(10);

        return view('user.invitations.index', compact('invitations'));
    }

    public function create()
    {
        $user = auth()->user();

        if (! $user->plan_id && ! $user->is_admin) {
            return redirect()->to(route('home').'#pricing')
                ->with('error', 'Davetiye oluşturmak için bir plan satın almalısınız.');
        }

        if (request()->attributes->get('subscription_expired')) {
            return redirect()->route('dashboard')
                ->with('error', 'Üyelik süreniz doldu. Yeni davetiye oluşturmak için planınızı yenileyin.');
        }

        $themes = InvitationTheme::where('is_active', true)->get();
        $plans = Plan::where('is_active', true)->get();
        $userPlan = $user->plan;

        return view('user.invitations.create', compact('themes', 'plans', 'userPlan'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($request->attributes->get('needs_subscription')) {
            return redirect()->to(route('home').'#pricing')
                ->with('error', 'Davetiye oluşturmak için bir plan satın almalısınız.');
        }

        if ($request->attributes->get('subscription_expired')) {
            return back()->with('error', 'Üyelik süreniz doldu. Yeni davetiye oluşturmak için planınızı yenileyin.');
        }

        $limit = $this->checkInvitationLimit($user);
        if ($limit) {
            return $limit;
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'event_type' => 'nullable|string|in:wedding,engagement,circumcision,birthday,corporate',
            'short_link' => 'nullable|string|max:60|unique:invitations,short_link|regex:/^[a-z0-9-]+$/',
            'plan_id' => 'nullable|exists:plans,id',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string',
            'event_address' => 'nullable|string',
            'event_location' => 'nullable|string',
            'event_lat' => 'nullable|numeric',
            'event_lng' => 'nullable|numeric',
            'welcome_message' => 'nullable|string',
            'story' => 'nullable|string',
            'special_note' => 'nullable|string',
            'theme' => 'required|string',
            'font_family' => 'nullable|string',
            'envelope_animation' => 'nullable|string|max:50',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:131072',
            'envelope_pattern' => 'nullable|string|max:50',
            'custom_pattern' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:131072',
            'corner_decoration' => 'nullable|image|mimes:png,webp|max:5120',
            'envelope_text_color' => 'nullable|string|max:20',
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('invitations/covers', 'public');
        }

        if ($request->hasFile('custom_pattern')) {
            $data['custom_pattern'] = $request->file('custom_pattern')
                ->store('invitations/patterns', 'public');
        }

        if ($request->hasFile('corner_decoration')) {
            $data['corner_decoration'] = $request->file('corner_decoration')
                ->store('invitations/corners', 'public');
        }

        $invitation = auth()->user()->invitations()->create($data);

        return redirect()->route('user.invitations.edit', $invitation)
            ->with('success', 'Davetiye oluşturuldu.');
    }

    public function show(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $stats = $this->invitationService->getStats($invitation);

        return view('user.invitations.show', compact('invitation', 'stats'));
    }

    public function edit(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $themes = InvitationTheme::where('is_active', true)->get();
        $plans = Plan::where('is_active', true)->get();
        $userPlan = auth()->user()->plan;

        $suggestedPlan = null;
        if ($userPlan) {
            $suggestedPlan = Plan::active()->where('monthly_price', '>', $userPlan->monthly_price)->orderBy('monthly_price')->first();
        } else {
            $suggestedPlan = Plan::active()->orderBy('monthly_price')->first();
        }

        return view('user.invitations.edit', compact('invitation', 'themes', 'plans', 'userPlan', 'suggestedPlan'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'event_type' => 'nullable|string|in:wedding,engagement,circumcision,birthday,corporate',
            'short_link' => 'nullable|string|max:60|unique:invitations,short_link,'.$invitation->id.'|regex:/^[a-z0-9-]+$/',
            'plan_id' => 'nullable|exists:plans,id',
            'groom_name' => 'sometimes|required|string|max:255',
            'bride_name' => 'sometimes|required|string|max:255',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string',
            'event_address' => 'nullable|string',
            'event_location' => 'nullable|string',
            'event_lat' => 'nullable|numeric',
            'event_lng' => 'nullable|numeric',
            'welcome_message' => 'nullable|string',
            'story' => 'nullable|string',
            'special_note' => 'nullable|string',
            'theme' => 'sometimes|required|string',
            'font_family' => 'nullable|string',
            'envelope_animation' => 'nullable|string|max:50',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:131072',
            'envelope_pattern' => 'nullable|string|max:50',
            'custom_pattern' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:131072',
            'corner_decoration' => 'nullable|image|mimes:png,webp|max:5120',
            'envelope_text_color' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($invitation->cover_image) {
                Storage::disk('public')->delete($invitation->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('invitations/covers', 'public');
        }

        if ($request->hasFile('custom_pattern')) {
            if ($invitation->custom_pattern) {
                Storage::disk('public')->delete($invitation->custom_pattern);
            }
            $data['custom_pattern'] = $request->file('custom_pattern')
                ->store('invitations/patterns', 'public');
        }

        if ($request->hasFile('corner_decoration')) {
            if ($invitation->corner_decoration) {
                Storage::disk('public')->delete($invitation->corner_decoration);
            }
            $data['corner_decoration'] = $request->file('corner_decoration')
                ->store('invitations/corners', 'public');
        }

        $invitation->update($data);

        return back()->with('success', 'Davetiye güncellendi.');
    }

    public function destroy(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $invitation->delete();

        return redirect()->route('user.invitations.index')
            ->with('success', 'Davetiye silindi.');
    }

    public function publish(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $this->invitationService->publish($invitation);

        return back()->with('success', 'Davetiye yayınlandı.');
    }

    public function unpublish(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $this->invitationService->unpublish($invitation);

        return back()->with('success', 'Davetiye yayından kaldırıldı.');
    }

    public function clone(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        if (request()->attributes->get('subscription_expired')) {
            return back()->with('error', 'Üyelik süreniz doldu. Yeni davetiye oluşturmak için planınızı yenileyin.');
        }

        $limit = $this->checkInvitationLimit(auth()->user());
        if ($limit) {
            return $limit;
        }

        $clone = $this->invitationService->clone($invitation);

        return redirect()->route('user.invitations.edit', $clone)
            ->with('success', 'Davetiye kopyalandı.');
    }

    public function preview(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        return view('invitation.show', compact('invitation'));
    }

    protected function checkInvitationLimit($user)
    {
        $plan = $user->plan;

        if (! $plan) {
            return null;
        }

        if ($plan->max_invitations === -1) {
            return null;
        }

        $count = $user->invitations()->count();
        if ($count >= $plan->max_invitations) {
            return back()->with('error', 'Planınız en fazla '.$plan->max_invitations.' davetiyeye izin veriyor. Yeni davetiye oluşturmak için planınızı yükseltin.');
        }

        return null;
    }

    // Image management
    public function uploadImage(Request $request, Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $plan = auth()->user()->plan;
        if ($plan && $plan->max_images_per_invitation >= 0) {
            $count = $invitation->images()->count();
            if ($count >= $plan->max_images_per_invitation) {
                return back()->with('error', 'Planınız en fazla '.$plan->max_images_per_invitation.' fotoğrafa izin veriyor.');
            }
        }

        $data = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('invitations/images', 'public');

        $invitation->images()->create([
            'image_path' => $path,
            'caption' => $data['caption'] ?? null,
            'order' => $invitation->images()->count() + 1,
        ]);

        return back()->with('success', 'Fotoğraf yüklendi.');
    }

    public function deleteImage(InvitationImage $image)
    {
        if ($image->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Fotoğraf silindi.');
    }

    // Video management
    public function addVideo(Request $request, Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $plan = auth()->user()->plan;
        if ($plan && ! $plan->video_feature) {
            return back()->with('error', 'Planınız video özelliğini desteklemiyor.');
        }

        $data = $request->validate([
            'url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov|max:51200',
            'type' => 'nullable|in:youtube,vimeo,upload',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('video_file')) {
            $data['file_path'] = $request->file('video_file')
                ->store('invitations/videos', 'public');
            $data['type'] = 'upload';
            unset($data['url']);
        } elseif ($request->filled('url')) {
            $data['type'] = $data['type'] ?? 'youtube';
        } else {
            return back()->with('error', 'Video URL girin veya bir dosya yükleyin.');
        }

        unset($data['video_file']);
        $invitation->videos()->create($data);

        return back()->with('success', 'Video eklendi.');
    }

    public function deleteVideo(InvitationVideo $video)
    {
        if ($video->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($video->file_path) {
            Storage::disk('public')->delete($video->file_path);
        }

        $video->delete();

        return back()->with('success', 'Video silindi.');
    }

    // Music management
    public function uploadMusic(Request $request, Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $plan = auth()->user()->plan;
        if ($plan && ! $plan->music_feature) {
            return back()->with('error', 'Planınız müzik özelliğini desteklemiyor.');
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'music_file' => 'nullable|file|mimes:mp3,wav,ogg|max:30720',
            'embed_url' => 'nullable|string',
        ]);

        if ($request->hasFile('music_file')) {
            $data['file_path'] = $request->file('music_file')
                ->store('invitations/music', 'public');
        }

        $invitation->music()->create($data);
        $invitation->update(['has_music' => true]);

        return back()->with('success', 'Müzik eklendi.');
    }

    public function deleteMusic(InvitationMusic $music)
    {
        if ($music->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($music->file_path) {
            Storage::disk('public')->delete($music->file_path);
        }

        $music->delete();

        if ($music->invitation->music()->count() === 0) {
            $music->invitation->update(['has_music' => false]);
        }

        return back()->with('success', 'Müzik silindi.');
    }

    // QR management
    public function qrCode(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $qrCode = $invitation->qrCode;

        if (! $qrCode) {
            $this->qrCodeService->generate($invitation);
            $qrCode = $invitation->qrCode()->first();
        }

        return view('user.invitations.qrcode', compact('invitation', 'qrCode'));
    }

    public function regenerateQr(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $this->qrCodeService->generate($invitation);

        return back()->with('success', 'QR kod yeniden oluşturuldu.');
    }

    // All RSVPs for current user
    public function allRsvps()
    {
        $invitationIds = auth()->user()->invitations()->pluck('id');
        $rsvps = Rsvp::whereIn('invitation_id', $invitationIds)
            ->with('invitation')
            ->latest()
            ->paginate(30);

        return view('user.rsvps.index', compact('rsvps'));
    }

    // RSVP management
    public function rsvps(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $rsvps = $invitation->rsvps()->latest()->paginate(20);

        return view('user.invitations.rsvps', compact('invitation', 'rsvps'));
    }

    public function exportRsvp(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $headers = ['Name', 'Email', 'Phone', 'Status', 'Guests', 'Message', 'Date'];
        $rows = $invitation->rsvps()->get()->map(fn ($r) => [
            $r->name, $r->email, $r->phone, $r->status, $r->guest_count, $r->message, $r->created_at->format('d.m.Y H:i'),
        ])->toArray();

        $callback = function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $headers, ';');
            foreach ($rows as $row) {
                fputcsv($file, $row, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="rsvp-'.$invitation->slug.'.csv"',
        ]);
    }

    public function confirmRsvp(Rsvp $rsvp)
    {
        if ($rsvp->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $rsvp->update(['is_confirmed' => true]);

        return back()->with('success', 'Katılımcı onaylandı.');
    }

    public function rejectRsvp(Rsvp $rsvp)
    {
        if ($rsvp->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $rsvp->update(['is_confirmed' => false]);

        return back()->with('success', 'Katılımcı reddedildi.');
    }

    public function destroyRsvp(Rsvp $rsvp)
    {
        if ($rsvp->invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $rsvp->delete();

        return back()->with('success', 'Katılımcı kaydı silindi.');
    }
}

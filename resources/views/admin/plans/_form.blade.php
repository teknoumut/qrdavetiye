<div class="mb-5">
    <label>Paket Adı</label>
    <input type="text" name="name" value="{{ old('name', $plan->name ?? '') }}" required>
</div>
<div class="mb-5">
    <label>Açıklama</label>
    <textarea name="description" rows="2">{{ old('description', $plan->description ?? '') }}</textarea>
</div>
<div class="grid grid-cols-2 gap-5 mb-5">
    <div>
        <label>Aylık Fiyat (TL)</label>
        <input type="number" step="0.01" name="monthly_price" value="{{ old('monthly_price', $plan->monthly_price ?? 0) }}">
    </div>
    <div>
        <label>Yıllık Fiyat (TL)</label>
        <input type="number" step="0.01" name="yearly_price" value="{{ old('yearly_price', $plan->yearly_price ?? 0) }}">
    </div>
</div>
<div class="grid grid-cols-2 gap-5 mb-5">
    <div>
        <label>Maks. Davetiye</label>
        <input type="number" name="max_invitations" value="{{ old('max_invitations', $plan->max_invitations ?? 5) }}">
        <small style="color:#94a3b8;font-size:0.7rem">Sınırsız için -1 girin</small>
    </div>
    <div>
        <label>Maks. Fotoğraf/Davetiye</label>
        <input type="number" name="max_images_per_invitation" value="{{ old('max_images_per_invitation', $plan->max_images_per_invitation ?? 10) }}">
        <small style="color:#94a3b8;font-size:0.7rem">Sınırsız için -1 girin</small>
    </div>
</div>
<div class="grid grid-cols-2 gap-4 mb-4">
    <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
        <input type="checkbox" name="music_feature" value="1" {{ old('music_feature', $plan->music_feature ?? false) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
        <span class="text-sm font-medium" style="color:#1e293b">Müzik</span>
    </label>
    <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
        <input type="checkbox" name="video_feature" value="1" {{ old('video_feature', $plan->video_feature ?? false) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
        <span class="text-sm font-medium" style="color:#1e293b">Video</span>
    </label>
    <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
        <input type="checkbox" name="cover_video_feature" value="1" {{ old('cover_video_feature', $plan->cover_video_feature ?? false) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
        <span class="text-sm font-medium" style="color:#1e293b">Kapak Videosu</span>
    </label>
    <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
        <input type="checkbox" name="rsvp_feature" value="1" {{ old('rsvp_feature', $plan->rsvp_feature ?? true) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
        <span class="text-sm font-medium" style="color:#1e293b">RSVP</span>
    </label>
    <label class="flex items-center gap-2.5 cursor-pointer" style="text-transform:none;letter-spacing:normal">
        <input type="checkbox" name="qr_download" value="1" {{ old('qr_download', $plan->qr_download ?? true) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#6366f1">
        <span class="text-sm font-medium" style="color:#1e293b">QR İndirme</span>
    </label>
</div>

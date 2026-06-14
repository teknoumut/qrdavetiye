<x-admin-layout>
    <style>
        .section-icon { background: var(--accent-light); color: var(--accent); }
    </style>
    <x-slot name="header">
        <div>
            Site Ayarları
            <span class="sub">Platform genel ayarlarını yapılandırın</span>
        </div>
    </x-slot>
    <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6 md:p-8 max-w-4xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" class="section-icon">⚙️</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Genel Ayarlar</h3>
                    <p class="text-xs text-gray-400">Site bilgileri ve marka ayarları</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>Site Adı</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? config('app.name')) }}">
                </div>
                <div>
                    <label>Site Logosu</label>
                    <input type="file" name="site_logo" accept="image/*" style="padding:8px 14px">
                </div>
            </div>

            <div class="mb-6">
                <label>Site Açıklaması</label>
                <textarea name="site_description" rows="2">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>

            <div class="mb-6">
                <label>Favicon</label>
                <input type="file" name="site_favicon" accept=".ico,.png" style="padding:8px 14px">
            </div>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="section-icon">🎨</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Site Renkleri</h3>
                    <p class="text-xs text-gray-400">Site anasayfasının ana vurgu renkleri</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>Ana Renk (Altın)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="site_primary_color" value="{{ old('site_primary_color', $settings['site_primary_color'] ?? '#d4a61e') }}" style="width:60px;height:44px;padding:4px;cursor:pointer">
                        <span class="text-sm text-gray-400" id="sitePrimaryLabel">{{ old('site_primary_color', $settings['site_primary_color'] ?? '#d4a61e') }}</span>
                    </div>
                </div>
                <div>
                    <label>İkinci Renk (Pembe)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="site_secondary_color" value="{{ old('site_secondary_color', $settings['site_secondary_color'] ?? '#e05278') }}" style="width:60px;height:44px;padding:4px;cursor:pointer">
                        <span class="text-sm text-gray-400" id="siteSecondaryLabel">{{ old('site_secondary_color', $settings['site_secondary_color'] ?? '#e05278') }}</span>
                    </div>
                </div>
            </div>

            <script>
                document.querySelector('[name="site_primary_color"]')?.addEventListener('input', function() {
                    document.getElementById('sitePrimaryLabel').textContent = this.value;
                });
                document.querySelector('[name="site_secondary_color"]')?.addEventListener('input', function() {
                    document.getElementById('siteSecondaryLabel').textContent = this.value;
                });
            </script>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="section-icon">📧</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">SMTP Ayarları</h3>
                    <p class="text-xs text-gray-400">E-posta gönderim ayarları</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>Host</label>
                    <input type="text" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host'] ?? '') }}">
                </div>
                <div>
                    <label>Port</label>
                    <input type="number" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port'] ?? '') }}">
                </div>
                <div>
                    <label>Kullanıcı Adı</label>
                    <input type="text" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}">
                </div>
                <div>
                    <label>Şifre</label>
                    <input type="password" name="smtp_password" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}">
                </div>
                <div>
                    <label>Şifreleme (tls/ssl)</label>
                    <input type="text" name="smtp_encryption" value="{{ old('smtp_encryption', $settings['smtp_encryption'] ?? '') }}">
                </div>
                <div>
                    <label>Gönderici E-posta</label>
                    <input type="email" name="smtp_from_address" value="{{ old('smtp_from_address', $settings['smtp_from_address'] ?? '') }}">
                </div>
            </div>

            <div class="mb-6">
                <label>Gönderici Adı</label>
                <input type="text" name="smtp_from_name" value="{{ old('smtp_from_name', $settings['smtp_from_name'] ?? '') }}">
            </div>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" class="section-icon">🎨</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Admin Tema Rengi</h3>
                    <p class="text-xs text-gray-400">Admin panelinin ana vurgu rengini belirleyin</p>
                </div>
            </div>

            <div class="mb-6">
                <label>Ana Vurgu Rengi</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="admin_primary_color" value="{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#4f46e5') }}" style="width:60px;height:44px;padding:4px;cursor:pointer">
                    <span class="text-sm text-gray-400" id="adminColorLabel">{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#4f46e5') }}</span>
                </div>
            </div>

            <script>
                document.querySelector('[name="admin_primary_color"]')?.addEventListener('input', function() {
                    document.getElementById('adminColorLabel').textContent = this.value;
                });
            </script>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" class="section-icon">💬</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">WhatsApp Ayarları</h3>
                    <p class="text-xs text-gray-400">WhatsApp paylaşım ayarları</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>WhatsApp Numarası</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="905551234567">
                </div>
                <div>
                    <label>Varsayılan Mesaj</label>
                    <textarea name="whatsapp_message" rows="2">{{ old('whatsapp_message', $settings['whatsapp_message'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="section-icon">💳</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">İyiziko Ödeme Ayarları</h3>
                    <p class="text-xs text-gray-400">Test (sandbox) veya canlı API anahtarlarını girin</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>API Anahtarı</label>
                    <input type="text" name="iyzico_api_key" value="{{ old('iyzico_api_key', $settings['iyzico_api_key'] ?? '') }}" placeholder="sandbox-xxxx">
                </div>
                <div>
                    <label>Gizli Anahtar</label>
                    <input type="password" name="iyzico_secret_key" value="{{ old('iyzico_secret_key', $settings['iyzico_secret_key'] ?? '') }}" placeholder="sandbox-xxxx">
                </div>
                <div class="md:col-span-2">
                    <label>API URL</label>
                    <input type="text" name="iyzico_base_url" value="{{ old('iyzico_base_url', $settings['iyzico_base_url'] ?? 'https://sandbox-api.iyzipay.com') }}" placeholder="https://sandbox-api.iyzipay.com">
                </div>
            </div>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="section-icon">💳</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Banka Havale/EFT Ayarları</h3>
                    <p class="text-xs text-gray-400">EFT/Havale ödeme yönteminde gösterilecek bilgiler</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label>KDV Oranı (%)</label>
                    <input type="number" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? '20') }}" min="0" max="100" step="0.1">
                </div>
                <div>
                    <label>Banka Adı</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $settings['bank_name'] ?? '') }}" placeholder="Yapı Kredi Bankası">
                </div>
                <div>
                    <label>Alıcı Adı</label>
                    <input type="text" name="bank_holder" value="{{ old('bank_holder', $settings['bank_holder'] ?? '') }}" placeholder="UMUT UÇAR">
                </div>
                <div>
                    <label>IBAN</label>
                    <input type="text" name="bank_iban" value="{{ old('bank_iban', $settings['bank_iban'] ?? '') }}" placeholder="TR450006701000000048863426">
                </div>
            </div>

            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <span class="section-icon">🔔</span>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">Bildirim Sesi</h3>
                    <p class="text-xs text-gray-400">Admin panelinde yeni bildirim geldiğinde çalacak ses</p>
                </div>
            </div>

            <div class="mb-4">
                <label>Hazır Ses</label>
                <div class="flex gap-2">
                    <select name="notification_sound_preset" onchange="presetChanged(this)" class="flex-1">
                        <option value="ding" {{ ($settings['notification_sound_preset'] ?? 'ding') === 'ding' ? 'selected' : '' }}>Ding (tek ton)</option>
                        <option value="chime" {{ ($settings['notification_sound_preset'] ?? '') === 'chime' ? 'selected' : '' }}>Chime (iki ton)</option>
                        <option value="triple" {{ ($settings['notification_sound_preset'] ?? '') === 'triple' ? 'selected' : '' }}>Triple (üç ton)</option>
                        <option value="custom" {{ ($settings['notification_sound_preset'] ?? '') === 'custom' ? 'selected' : '' }}>Özel Ses</option>
                    </select>
                    <button type="button" onclick="testPresetSound()" class="btn-ghost shrink-0">🔊 Test</button>
                </div>
            </div>

            <div class="mb-6" id="customSoundUrlField" style="display:{{ ($settings['notification_sound_preset'] ?? 'ding') === 'custom' ? 'block' : 'none' }}">
                <label class="mb-3">Bilgisayardan Ses Yükle</label>
                <input type="file" name="notification_sound_file" accept="audio/mp3,audio/wav,audio/ogg,audio/m4a,.mp3,.wav,.ogg,.m4a" style="padding:8px 14px">
                <p class="text-xs text-gray-400 mt-1.5 mb-4">MP3, WAV, OGG veya M4A dosyası yükleyin. Maksimum 2MB.</p>

                <div class="border-t border-gray-100 pt-4">
                    <label class="mb-2">Ya da direkt URL girin (opsiyonel)</label>
                    <div class="flex gap-2">
                        <input type="text" name="notification_sound_custom" id="soundCustomInput" value="{{ old('notification_sound_custom', $settings['notification_sound_custom'] ?? '') }}" placeholder="https://example.com/ses.mp3" class="flex-1">
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Dosya yüklemezseniz bu URL kullanılır. Sadece direkt MP3/OGG/WAV linkleri çalışır.</p>
                </div>
            </div>

            <script>
                var notifCtx = null;
                function getAudioCtx() {
                    if (!notifCtx) { try { notifCtx = new (window.AudioContext || window.webkitAudioContext)(); } catch(e) {} }
                    if (notifCtx && notifCtx.state === 'suspended') notifCtx.resume();
                    return notifCtx;
                }
                function playBeep(freq, start, dur) {
                    var ctx = getAudioCtx(); if (!ctx) return;
                    var g = ctx.createGain(); g.connect(ctx.destination); g.gain.value = 0.12;
                    var o = ctx.createOscillator(); o.type = 'sine'; o.frequency.value = freq;
                    o.connect(g); o.start(ctx.currentTime + start); o.stop(ctx.currentTime + start + dur);
                }
                function playPreset(name) {
                    if (name === 'ding') { playBeep(880, 0, 0.2); }
                    else if (name === 'chime') { playBeep(523, 0, 0.15); playBeep(659, 0.16, 0.2); }
                    else if (name === 'triple') { playBeep(523, 0, 0.12); playBeep(659, 0.13, 0.15); playBeep(784, 0.29, 0.2); }
                }
                function presetChanged(sel) {
                    document.getElementById('customSoundUrlField').style.display = sel.value === 'custom' ? 'block' : 'none';
                }
                function testPresetSound() {
                    var preset = document.querySelector('[name="notification_sound_preset"]').value;
                    if (preset === 'custom') {
                        var url = document.querySelector('[name="notification_sound_custom"]').value;
                        if (url) {
                            try { var a = new Audio(url); a.volume = 0.4; a.play().catch(function() { alert('Ses çalınamadı.'); }); } catch(e) { alert('Geçersiz URL'); }
                        }
                        else { alert('Önce bir ses dosyası yükleyin veya URL girin, sonra ayarları kaydedin.'); }
                    } else {
                        playPreset(preset);
                    }
                }
            </script>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary">Ayarları Kaydet</button>
            </div>
        </form>
    </div>
</x-admin-layout>

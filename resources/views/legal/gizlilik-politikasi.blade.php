<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Gizlilik Politikası</h1>
        <div class="prose prose-gray max-w-none space-y-6">
            <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>

            <h2 class="text-xl font-semibold mt-8">1. Giriş</h2>
            <p>senindavetiyen.com.tr ("Platform", "biz", "bize", "bizim") olarak, kullanıcılarımızın ("Kullanıcı", "siz", "size") gizliliğine saygı duyuyor ve kişisel verilerinizin korunmasına büyük önem veriyoruz. Bu Gizlilik Politikası, Platform'u ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda kişisel verilerinizin nasıl toplandığını, kullanıldığını, saklandığını ve paylaşıldığını açıklamaktadır.</p>

            <h2 class="text-xl font-semibold mt-8">2. Toplanan Veriler</h2>
            <p>Platform'u kullanırken aşağıdaki kişisel verileriniz toplanabilir:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Kimlik Bilgileri:</strong> Ad, soyad</li>
                <li><strong>İletişim Bilgileri:</strong> E-posta adresi, telefon numarası</li>
                <li><strong>Kullanıcı Bilgileri:</strong> Kullanıcı adı, profil bilgileri</li>
                <li><strong>Davetiye Bilgileri:</strong> Oluşturduğunuz davetiyelere ait içerikler (metin, görsel, video, müzik)</li>
                <li><strong>Davetli Bilgileri:</strong> RSVP yanıtları, katılımcı isimleri ve iletişim bilgileri</li>
                <li><strong>Teknik Veriler:</strong> IP adresi, tarayıcı türü, işletim sistemi, ziyaret süresi ve sayfa görüntüleme istatistikleri</li>
                <li><strong>Ödeme Bilgileri:</strong> Ödeme işlemlerine ait fatura bilgileri (kredi kartı bilgileri tarafımızca saklanmaz)</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">3. Verilerin Kullanım Amaçları</h2>
            <p>Kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Platform hizmetlerinin sağlanması ve yönetilmesi</li>
                <li>Hesap oluşturma ve doğrulama işlemleri</li>
                <li>Davetiye oluşturma, yayınlama ve paylaşma hizmetleri</li>
                <li>RSVP yanıtlarının toplanması ve iletilmesi</li>
                <li>Ödeme işlemlerinin gerçekleştirilmesi ve faturalandırma</li>
                <li>Müşteri desteği ve iletişim taleplerinin yanıtlanması</li>
                <li>Platform kullanımının iyileştirilmesi</li>
                <li>Yasal yükümlülüklerin yerine getirilmesi</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">4. Verilerin Saklanması ve Güvenliği</h2>
            <p>Kişisel verileriniz, hizmetin gerektirdiği süre boyunca ve yasal yükümlülükler çerçevesinde saklanmaktadır. Verilerinizin güvenliği için endüstri standardı güvenlik önlemleri (SSL şifreleme, güvenli sunucu altyapısı, düzenli güvenlik denetimleri) uygulanmaktadır.</p>

            <h2 class="text-xl font-semibold mt-8">5. Verilerin Paylaşılması</h2>
            <p>Kişisel verileriniz, aşağıdaki durumlar haricinde üçüncü taraflarla paylaşılmaz:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Yasal yükümlülükler gereği yetkili kamu kurumları ile</li>
                <li>Ödeme işlemlerinin gerçekleştirilmesi için ödeme hizmet sağlayıcıları ile</li>
                <li>Barındırma ve altyapı hizmeti alınan üçüncü taraflar ile</li>
                <li>Açık rızanız doğrultusunda belirttiğiniz üçüncü taraflar ile</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">6. Çerezler (Cookies)</h2>
            <p>Platform, kullanıcı deneyimini iyileştirmek ve hizmet kalitesini artırmak amacıyla çerezler kullanmaktadır. Çerez tercihlerinizi tarayıcı ayarlarından yönetebilirsiniz.</p>

            <h2 class="text-xl font-semibold mt-8">7. Haklarınız</h2>
            <p>KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                <li>İşlenmişse buna ilişkin bilgi talep etme</li>
                <li>İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme</li>
                <li>Yurt içi/yurt dışı aktarım yapılan üçüncü kişileri bilme</li>
                <li>Eksik/yanlış işleme durumunda düzeltme talep etme</li>
                <li>KVKK'nın 7. maddesinde öngörülen şartlar çerçevesinde silme/yok etme talep etme</li>
                <li>İşlenen verilerin münhasıran otomatik sistemlerle analiz edilmesine itiraz etme</li>
                <li>Kanuna aykırı işleme nedeniyle zararın giderilmesini talep etme</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">8. İletişim</h2>
            <p>Gizlilik politikamız hakkında sorularınız veya talepleriniz için bizimle iletişime geçebilirsiniz:</p>
            <p><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</p>

            <p class="mt-8 text-sm text-gray-500">Bu gizlilik politikası önceden haber verilmeksizin güncellenebilir. Güncellemeler Platform'da yayınlandığı tarihte yürürlüğe girer.</p>
        </div>
    </div>
</x-app-layout>

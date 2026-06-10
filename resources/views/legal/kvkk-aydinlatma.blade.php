<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">KVKK Aydınlatma Metni</h1>
        <div class="prose prose-gray max-w-none space-y-6">
            <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>

            <h2 class="text-xl font-semibold mt-8">Veri Sorumlusu</h2>
            <p>6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") uyarınca, kişisel verileriniz aşağıda açıklanan kapsamda veri sorumlusu tarafından işlenebilecektir.</p>

            <h2 class="text-xl font-semibold mt-8">Kişisel Verilerin İşlenme Amacı ve Hukuki Sebebi</h2>
            <p>Kişisel verileriniz, Platform hizmetlerinin sunulması, kullanıcı kaydı oluşturma, davetiye oluşturma ve yönetme, ödeme işlemlerinin gerçekleştirilmesi, müşteri hizmetleri sağlanması ve yasal yükümlülüklerin yerine getirilmesi amaçlarıyla KVKK'nın 5. ve 6. maddelerinde belirtilen hukuki sebeplere dayalı olarak işlenmektedir.</p>

            <h2 class="text-xl font-semibold mt-8">İşlenen Kişisel Veriler</h2>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Kimlik Verisi:</strong> Ad, soyad</li>
                <li><strong>İletişim Verisi:</strong> E-posta adresi, telefon numarası, adres</li>
                <li><strong>Müşteri İşlem Verisi:</strong> Davetiye içerikleri, RSVP kayıtları</li>
                <li><strong>İşlem Güvenliği Verisi:</strong> IP adresi, oturum bilgileri</li>
                <li><strong>Finansal Veri:</strong> Fatura bilgileri</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">Kişisel Verilerin Aktarılması</h2>
            <p>Kişisel verileriniz, yukarıda belirtilen amaçların gerçekleştirilmesi doğrultusunda, yasal yükümlülükler çerçevesinde yetkili kamu kurum ve kuruluşlarına, ödeme hizmet sağlayıcılarına ve hizmet alınan yurt içi/yurt dışı üçüncü taraflara KVKK'nın 8. ve 9. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları çerçevesinde aktarılabilecektir.</p>

            <h2 class="text-xl font-semibold mt-8">Kişisel Veri Toplamanın Yöntemi</h2>
            <p>Kişisel verileriniz, Platform üzerinden elektronik ortamda, otomatik veya otomatik olmayan yöntemlerle, web sitesi, mobil uygulama, çağrı merkezi ve benzeri kanallar aracılığıyla toplanmaktadır.</p>

            <h2 class="text-xl font-semibold mt-8">KVKK Kapsamındaki Haklarınız</h2>
            <p>KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>
            <ol class="list-decimal pl-6 space-y-2">
                <li>Kişisel verinizin işlenip işlenmediğini öğrenme,</li>
                <li>Kişisel verileriniz işlenmişse buna ilişkin bilgi talep etme,</li>
                <li>Kişisel verilerinizin işlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme,</li>
                <li>Yurt içinde veya yurt dışında kişisel verilerinizin aktarıldığı üçüncü kişileri bilme,</li>
                <li>Kişisel verilerinizin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme,</li>
                <li>KVKK'nın 7. maddesinde öngörülen şartlar çerçevesinde kişisel verilerinizin silinmesini veya yok edilmesini isteme,</li>
                <li>Düzeltme, silme veya yok etme işlemlerinin, kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,</li>
                <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme,</li>
                <li>Kişisel verilerinizin kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız hâlinde zararın giderilmesini talep etme.</li>
            </ol>

            <h2 class="text-xl font-semibold mt-8">İletişim</h2>
            <p>Haklarınızı kullanmak veya sorularınız için bizimle iletişime geçebilirsiniz:</p>
            <p><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</p>
        </div>
    </div>
</x-app-layout>

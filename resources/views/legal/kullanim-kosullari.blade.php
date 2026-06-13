<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Kullanım Koşulları</h1>
        <div class="prose prose-gray max-w-none space-y-6">
            <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>

            <h2 class="text-xl font-semibold mt-8">1. Taraflar</h2>
            <p>İşbu Kullanım Koşulları ("Sözleşme"), senindavetiyen.com.tr ("Platform") ile Platform'a üye olan kullanıcı ("Kullanıcı") arasında düzenlenmiştir.</p>

            <h2 class="text-xl font-semibold mt-8">2. Hizmetin Kapsamı</h2>
            <p>Platform, kullanıcılara dijital davetiye oluşturma, yayınlama, paylaşma ve RSVP takibi hizmetleri sunmaktadır. Platform'da sunulan hizmetler, kullanıcının seçtiği plan kapsamında belirlenen özelliklerle sınırlıdır.</p>

            <h2 class="text-xl font-semibold mt-8">3. Hesap Güvenliği</h2>
            <p>Kullanıcı, hesabının güvenliğinden ve hesabı altında gerçekleşen tüm işlemlerden sorumludur. Kullanıcı şifresini gizli tutmayı kabul eder. Hesap güvenliğinin ihlal edildiği durumlarda derhal Platform'a bildirim yapılmalıdır.</p>

            <h2 class="text-xl font-semibold mt-8">4. Kullanıcı Sorumlulukları</h2>
            <ul class="list-disc pl-6 space-y-2">
                <li>Kullanıcı, Platform'u yalnızca yasal amaçlarla kullanmayı kabul eder.</li>
                <li>Kullanıcı, davetiye içeriklerinin hukuka, genel ahlaka ve üçüncü kişi haklarına aykırı olmamasını sağlamakla yükümlüdür.</li>
                <li>Kullanıcı, başka kullanıcıların hesaplarına erişmeye çalışmayacağını kabul eder.</li>
                <li>Kullanıcı, Platform'un işleyişini bozacak teknik müdahalelerde bulunmayacağını taahhüt eder.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">5. Fikri Mülkiyet</h2>
            <p>Platform'un tüm hakları saklıdır. Platform'un yazılımı, tasarımı, logosu ve içeriği fikri mülkiyet kanunları kapsamında korunmaktadır. Kullanıcı tarafından oluşturulan davetiye içeriklerinin tüm hakları kullanıcıya aittir.</p>

            <h2 class="text-xl font-semibold mt-8">6. Sorumluluğun Sınırlandırılması</h2>
            <p>Platform, hizmetlerin kesintisiz veya hatasız çalışacağını garanti etmez. Platform, üçüncü tarafların erişim sağlayıcı kaynaklı sorunlar, siber saldırılar veya mücbir sebeplerden kaynaklanan hizmet kesintilerinden sorumlu değildir.</p>

            <h2 class="text-xl font-semibold mt-8">7. Abonelik ve Ödeme</h2>
            <p>Kullanıcı, seçtiği plana ait ücreti ödeyerek hizmeti kullanmaya hak kazanır. Ödemeler, seçilen periyoda (aylık/yıllık) göre tahsil edilir. Abonelik iptali durumunda mevcut davetiyeler yayında kalmaya devam eder ancak yeni davetiye oluşturulamaz.</p>
            <p>Önemli: Abonelik satın alındıktan sonra davetiye oluşturulup yayınlandığı anda hizmet tüketilmiş sayılır. Bu nedenle, yayınlanmış bir davetiye için iade yapılmaz. İade koşulları hakkında detaylı bilgi için <a href="{{ route('legal.iade') }}" class="text-blue-600 hover:text-blue-800 underline">İade ve İptal Politikası</a>'nı inceleyiniz.</p>

            <h2 class="text-xl font-semibold mt-8">8. Hesap Feshi</h2>
            <p>Platform, Kullanıcı'nın bu koşullara aykırı davranması durumunda hesabını askıya alma veya sonlandırma hakkını saklı tutar. Kullanıcı, dilediği zaman hesabını kapatarak hizmeti sonlandırabilir.</p>

            <h2 class="text-xl font-semibold mt-8">9. Değişiklikler</h2>
            <p>Platform, bu Kullanım Koşulları'nı önceden haber vermeksizin değiştirme hakkını saklı tutar. Değişiklikler, Platform'da yayınlandığı anda yürürlüğe girer.</p>

            <h2 class="text-xl font-semibold mt-8">10. Uyuşmazlıkların Çözümü</h2>
            <p>İşbu Sözleşme'nin uygulanmasından doğabilecek uyuşmazlıklarda Türkiye Cumhuriyeti kanunları uygulanır ve İstanbul mahkemeleri ve icra daireleri yetkilidir.</p>

            <h2 class="text-xl font-semibold mt-8">11. İletişim</h2>
            <p><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</p>
        </div>
    </div>
</x-app-layout>

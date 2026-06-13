<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mesafeli Satış Sözleşmesi</h1>
        <div class="prose prose-gray max-w-none space-y-6">
            <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>

            <h2 class="text-xl font-semibold mt-8">1. Sözleşmenin Tarafları</h2>
            <p>İşbu Mesafeli Satış Sözleşmesi ("Sözleşme"), aşağıda belirtilen taraflar arasında elektronik ortamda akdedilmiştir.</p>

            <h2 class="text-xl font-semibold mt-8">2. Sözleşmenin Konusu</h2>
            <p>İşbu Sözleşme, Alıcı'nın Satıcı'ya ait senindavetiyen.com.tr internet sitesinden elektronik ortamda sipariş ettiği dijital davetiye hizmeti aboneliğinin satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince tarafların hak ve yükümlülüklerini düzenler.</p>

            <h2 class="text-xl font-semibold mt-8">3. Satıcı Bilgileri</h2>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Platform:</strong> senindavetiyen.com.tr</li>
                <li><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">4. Alıcı Bilgileri</h2>
            <p>Alıcı, abonelik satın alırken bildirdiği ad, soyad, e-posta adresi ve fatura bilgileri ile tanımlanır.</p>

            <h2 class="text-xl font-semibold mt-8">5. Hizmet Bilgileri</h2>
            <p>Abonelik hizmeti, Alıcı'nın seçtiği plan kapsamında belirtilen özellikleri içerir. Hizmet, ödemenin tamamlanmasını takiben anında aktif hale gelir.</p>

            <h2 class="text-xl font-semibold mt-8">6. Ödeme ve Teslimat</h2>
            <p>Ödeme, Platform üzerinden kredi kartı veya banka kartı ile gerçekleştirilir. Dijital hizmet teslimatı, ödeme onayını takiben anında gerçekleşir.</p>

            <h2 class="text-xl font-semibold mt-8">7. Cayma Hakkı</h2>
            <p>Alıcı, 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği kapsamında, dijital hizmetin ifasına Alıcı'nın onayı ile başlanması nedeniyle cayma hakkını kullanamayacağını kabul eder. Abonelik başlangıcından itibaren 7 gün içinde ve henüz hiçbir davetiye yayınlanmamış/kullanılmamışsa kullanılmayan hizmet bedeli iade edilir. Davetiye oluşturulup yayınlandıktan sonra hizmet tamamen tüketilmiş sayılır ve iade yapılmaz.</p>

            <h2 class="text-xl font-semibold mt-8">8. Uyuşmazlık Çözümü</h2>
            <p>İşbu Sözleşme'nin uygulanmasından doğabilecek uyuşmazlıklarda Tüketici Hakem Heyetleri ve Tüketici Mahkemeleri yetkilidir.</p>

            <h2 class="text-xl font-semibold mt-8">9. Yürürlük</h2>
            <p>İşbu Sözleşme, Alıcı tarafından online olarak onaylandığı anda yürürlüğe girer. Alıcı, Sözleşme'yi onaylayarak hükümlerini kabul ettiğini beyan eder.</p>

            <h2 class="text-xl font-semibold mt-8">10. İletişim</h2>
            <p><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</p>
        </div>
    </div>
</x-app-layout>

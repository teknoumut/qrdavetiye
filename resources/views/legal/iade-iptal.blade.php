<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">İade ve İptal Politikası</h1>
        <div class="prose prose-gray max-w-none space-y-6">
            <p class="text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>

            <h2 class="text-xl font-semibold mt-8">1. Abonelik İptali</h2>
            <p>Kullanıcı, dilediği zaman aboneliğini iptal edebilir. İptal sonrasında:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li>Mevcut davetiyeleriniz yayında kalmaya devam eder.</li>
                <li>Yeni davetiye oluşturamazsınız.</li>
                <li>Mevcut özellikleriniz, faturalandırma döneminin sonuna kadar aktif kalır.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">2. İade Koşulları</h2>
            <p>Dijital hizmetlerin doğası gereği, abonelik ücretleri için aşağıdaki iade koşulları geçerlidir:</p>
            <ul class="list-disc pl-6 space-y-2">
                <li><strong>Hizmet Kullanılmamışsa (İlk 7 Gün):</strong> Abonelik başlangıcından itibaren 7 gün içinde ve henüz hiçbir davetiye yayınlanmamış/kullanılmamışsa tam iade yapılır.</li>
                <li><strong>Hizmet Kullanılmışsa:</strong> Davetiye oluşturulup yayınlandıktan, link paylaşıldıktan veya QR kod dağıtıldıktan sonra hizmet tamamen tüketilmiş sayılır. Bu durumda iade yapılmaz.</li>
                <li><strong>7 Gün Sonrası:</strong> Abonelik başlangıcından itibaren 7 gün geçtikten sonra iade yapılmaz, ancak hizmet mevcut fatura döneminin sonuna kadar aktif kalır.</li>
                <li><strong>Yıllık Abonelikler:</strong> Yıllık aboneliklerde iade yalnızca yukarıdaki şartlar sağlanıyorsa ve kullanılmayan aylar oranında yapılır.</li>
            </ul>

            <h2 class="text-xl font-semibold mt-8">3. İade Süreci</h2>
            <p>İade talepleri değerlendirilir ve 7 iş günü içinde sonuçlandırılır. İade, ödemenin yapıldığı kaynağa geri gönderilir.</p>

            <h2 class="text-xl font-semibold mt-8">4. Hizmet Kesintisi</h2>
            <p>Platform kaynaklı uzun süreli (24 saat üzeri) hizmet kesintilerinde, kesinti süresiyle orantılı olarak hizmet süresi uzatılır veya iade sağlanır.</p>

            <h2 class="text-xl font-semibold mt-8">5. İletişim</h2>
            <p>İade ve iptal talepleriniz için:</p>
            <p><strong>E-posta:</strong> {{ env('MAIL_FROM_ADDRESS', 'info@senindavetiyen.com.tr') }}</p>
        </div>
    </div>
</x-app-layout>

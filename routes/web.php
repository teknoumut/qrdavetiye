<?php

use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PaymentNotificationController as AdminPaymentNotificationController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ThemeController as AdminThemeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EftPaymentController;
use App\Http\Controllers\InvitationPublicController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Profile\PublicProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\InvitationController as UserInvitationController;
use App\Models\ContactMessage;
use App\Models\Invoice;
use App\Models\PaymentNotification;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $reviews = Review::approved()->with('user')->latest()->get();

    return view('welcome', compact('reviews'));
})->name('home');

Route::get('/s/{shortLink}', [InvitationPublicController::class, 'shortLink'])->name('invitation.short');
Route::get('/invitation/{slug}', [InvitationPublicController::class, 'show'])->name('invitation.show');
Route::post('/invitation/{slug}/rsvp', [InvitationPublicController::class, 'rsvp'])->name('invitation.rsvp');
Route::get('/invitation/{slug}/qr-scan', [InvitationPublicController::class, 'trackQrScan'])->name('invitation.qr-scan');

Route::get('/sitemap.xml', [InvitationPublicController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [InvitationPublicController::class, 'robots'])->name('robots');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::view('/gizlilik-politikasi', 'legal.gizlilik-politikasi')->name('legal.gizlilik');
Route::view('/kvkk-aydinlatma-metni', 'legal.kvkk-aydinlatma')->name('legal.kvkk');
Route::view('/kullanim-kosullari', 'legal.kullanim-kosullari')->name('legal.kullanim');
Route::view('/iade-iptal-politikasi', 'legal.iade-iptal')->name('legal.iade');
Route::view('/mesafeli-satis-sozlesmesi', 'legal.mesafeli-satis')->name('legal.mesafeli');

Route::get('/yorumlar', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/yorumlar', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('/kullanici/{user}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/pay/{plan}/{interval}', [PaymentController::class, 'pay'])->name('payment.pay');

    Route::get('/payment/eft/{plan}', [EftPaymentController::class, 'checkout'])->name('payment.eft.checkout');
    Route::get('/payment/eft/{plan}/success', [EftPaymentController::class, 'success'])->name('payment.eft.success');
    Route::post('/payment/eft/notify', [EftPaymentController::class, 'notify'])->name('payment.eft.notify');
    Route::get('/payment/eft/{plan}/{interval}', [EftPaymentController::class, 'show'])->name('payment.eft.pay');
    Route::post('/payment/eft/upgrade/{plan}', [EftPaymentController::class, 'showUpgrade'])->name('payment.eft.upgrade');

    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resubscribe', [SubscriptionController::class, 'resubscribe'])->name('subscription.resubscribe');

    Route::get('/faturalar/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/faturalar/{invoice}/indir', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/faturalar/{invoice}/iade-talep', [InvoiceController::class, 'requestRefund'])->name('invoices.refund-request');
});

Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/success/{plan}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/fail/{plan}', [PaymentController::class, 'fail'])->name('payment.fail');
});

Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('invitations', UserInvitationController::class)->except(['show']);
        Route::get('invitations/{invitation}', [UserInvitationController::class, 'show'])->name('invitations.show');
        Route::post('invitations/{invitation}/publish', [UserInvitationController::class, 'publish'])->name('invitations.publish');
        Route::post('invitations/{invitation}/unpublish', [UserInvitationController::class, 'unpublish'])->name('invitations.unpublish');
        Route::post('invitations/{invitation}/clone', [UserInvitationController::class, 'clone'])->name('invitations.clone');
        Route::get('invitations/{invitation}/preview', [UserInvitationController::class, 'preview'])->name('invitations.preview');
        Route::get('invitations/{invitation}/qr', [UserInvitationController::class, 'qrCode'])->name('invitations.qr');
        Route::post('invitations/{invitation}/qr-regenerate', [UserInvitationController::class, 'regenerateQr'])->name('invitations.qr-regenerate');
        Route::get('invitations/{invitation}/rsvps', [UserInvitationController::class, 'rsvps'])->name('invitations.rsvps');
        Route::post('rsvps/{rsvp}/confirm', [UserInvitationController::class, 'confirmRsvp'])->name('rsvps.confirm');
        Route::post('rsvps/{rsvp}/reject', [UserInvitationController::class, 'rejectRsvp'])->name('rsvps.reject');
        Route::delete('rsvps/{rsvp}', [UserInvitationController::class, 'destroyRsvp'])->name('rsvps.destroy');
        Route::get('invitations/{invitation}/rsvps-export', [UserInvitationController::class, 'exportRsvp'])->name('invitations.rsvps-export');
        Route::get('rsvps', [UserInvitationController::class, 'allRsvps'])->name('rsvps.index');

        Route::post('invitations/{invitation}/images', [UserInvitationController::class, 'uploadImage'])->name('invitations.images.upload');
        Route::delete('invitations/images/{image}', [UserInvitationController::class, 'deleteImage'])->name('invitations.images.delete');

        Route::post('invitations/{invitation}/videos', [UserInvitationController::class, 'addVideo'])->name('invitations.videos.add');
        Route::delete('invitations/videos/{video}', [UserInvitationController::class, 'deleteVideo'])->name('invitations.videos.delete');

        Route::post('invitations/{invitation}/music', [UserInvitationController::class, 'uploadMusic'])->name('invitations.music.upload');
        Route::delete('invitations/music/{music}', [UserInvitationController::class, 'deleteMusic'])->name('invitations.music.delete');

        Route::delete('invitations/{invitation}/cover-image', [UserInvitationController::class, 'deleteCoverImage'])->name('invitations.cover-image.delete');
        Route::delete('invitations/{invitation}/cover-video', [UserInvitationController::class, 'deleteCoverVideo'])->name('invitations.cover-video.delete');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::post('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::post('users/{user}/extend-subscription', [AdminUserController::class, 'extendSubscription'])->name('users.extend-subscription');
    Route::get('users/{user}/invitations', [AdminUserController::class, 'invitations'])->name('users.invitations');
    Route::post('users/{user}/photo', [AdminUserController::class, 'uploadPhoto'])->name('users.photo.upload');
    Route::delete('users/{user}/photo', [AdminUserController::class, 'deletePhoto'])->name('users.photo.delete');

    Route::resource('plans', AdminPlanController::class);
    Route::post('plans/{plan}/toggle-active', [AdminPlanController::class, 'toggleActive'])->name('plans.toggle-active');

    Route::resource('themes', AdminThemeController::class);

    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('payment-notifications', [AdminPaymentNotificationController::class, 'index'])->name('payment-notifications.index');
    Route::get('payment-notifications/pending-count', function () {
        $count = PaymentNotification::where('status', 'pending')->count()
            + Review::where('is_approved', false)->count()
            + Invoice::where('refund_status', 'requested')->count()
            + ContactMessage::where('is_read', false)->count();

        return response()->json([
            'count' => $count,
        ]);
    })->name('payment-notifications.pending-count');
    Route::post('payment-notifications/{notification}/approve', [AdminPaymentNotificationController::class, 'approve'])->name('payment-notifications.approve');
    Route::post('payment-notifications/{notification}/reject', [AdminPaymentNotificationController::class, 'reject'])->name('payment-notifications.reject');
    Route::delete('payment-notifications/{notification}', [AdminPaymentNotificationController::class, 'destroy'])->name('payment-notifications.destroy');
    Route::post('payment-notifications/reset-revenue', [AdminPaymentNotificationController::class, 'resetRevenue'])->name('payment-notifications.reset-revenue');

    Route::get('refund-requests', [RefundController::class, 'index'])->name('refund-requests.index');
    Route::post('refund-requests/{invoice}/approve', [RefundController::class, 'approve'])->name('refund-requests.approve');
    Route::post('refund-requests/{invoice}/reject', [RefundController::class, 'reject'])->name('refund-requests.reject');

    Route::get('invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index');

    Route::get('visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::post('visitors/reset', [VisitorController::class, 'reset'])->name('visitors.reset');

    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');

});

require __DIR__.'/auth.php';

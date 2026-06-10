<?php

use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\ThemeController as AdminThemeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InvitationPublicController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Profile\PublicProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\InvitationController as UserInvitationController;
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

Route::get('/yorumlar', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/yorumlar', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('/kullanici/{user}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/pay/{plan}/{interval}', [PaymentController::class, 'pay'])->name('payment.pay');

    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resubscribe', [SubscriptionController::class, 'resubscribe'])->name('subscription.resubscribe');

    Route::get('/faturalar/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/faturalar/{invoice}/indir', [InvoiceController::class, 'download'])->name('invoices.download');
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
        Route::get('invitations/{invitation}/rsvps-export', [UserInvitationController::class, 'exportRsvp'])->name('invitations.rsvps-export');
        Route::get('rsvps', [UserInvitationController::class, 'allRsvps'])->name('rsvps.index');

        Route::post('invitations/{invitation}/images', [UserInvitationController::class, 'uploadImage'])->name('invitations.images.upload');
        Route::delete('invitations/images/{image}', [UserInvitationController::class, 'deleteImage'])->name('invitations.images.delete');

        Route::post('invitations/{invitation}/videos', [UserInvitationController::class, 'addVideo'])->name('invitations.videos.add');
        Route::delete('invitations/videos/{video}', [UserInvitationController::class, 'deleteVideo'])->name('invitations.videos.delete');

        Route::post('invitations/{invitation}/music', [UserInvitationController::class, 'uploadMusic'])->name('invitations.music.upload');
        Route::delete('invitations/music/{music}', [UserInvitationController::class, 'deleteMusic'])->name('invitations.music.delete');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::post('users/{user}/extend-subscription', [AdminUserController::class, 'extendSubscription'])->name('users.extend-subscription');
    Route::get('users/{user}/invitations', [AdminUserController::class, 'invitations'])->name('users.invitations');

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

});

require __DIR__.'/auth.php';

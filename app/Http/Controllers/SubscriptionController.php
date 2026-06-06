<?php

namespace App\Http\Controllers;

use App\Http\Services\SubscriptionService;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function cancel(Request $request)
    {
        $user = auth()->user();

        if ($user->subscription_status !== User::STATUS_ACTIVE) {
            return redirect()->route('dashboard')->with('error', 'Aktif bir aboneliğiniz bulunmuyor.');
        }

        $service = new SubscriptionService;
        $service->cancel($user);

        return redirect()->route('dashboard')->with('success', 'Aboneliğiniz iptal edildi. Plan özelliklerini süre sonuna kadar kullanmaya devam edebilirsiniz.');
    }

    public function resubscribe(Request $request)
    {
        $user = auth()->user();

        if ($user->subscription_status !== User::STATUS_CANCELLED) {
            return redirect()->route('dashboard')->with('error', 'İptal edilmiş bir aboneliğiniz bulunmuyor.');
        }

        $service = new SubscriptionService;
        $service->reactivate($user);

        return redirect()->route('dashboard')->with('success', 'Aboneliğiniz yeniden aktifleştirildi.');
    }
}

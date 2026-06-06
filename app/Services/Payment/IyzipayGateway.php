<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Contracts\PaymentResult;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class IyzipayGateway implements PaymentGateway
{
    private function getOptions(): Options
    {
        $options = new Options;
        $options->setApiKey(config('payment.gateways.iyzico.api_key', ''));
        $options->setSecretKey(config('payment.gateways.iyzico.secret_key', ''));
        $options->setBaseUrl(config('payment.gateways.iyzico.base_url', 'https://sandbox-api.iyzipay.com'));

        return $options;
    }

    public function getName(): string
    {
        return 'iyzico';
    }

    public function initialize(User $user, Plan $plan, string $interval): PaymentResult
    {
        $price = $interval === 'yearly' ? $plan->yearly_price : $plan->monthly_price;

        if (! $price || $price <= 0) {
            return new PaymentResult(
                success: false,
                message: 'Bu plan için ödeme gerekmiyor.',
            );
        }

        $conversationId = 'qr_'.$user->id.'_'.$plan->id.'_'.now()->timestamp.'_'.bin2hex(random_bytes(4));

        $request = new CreateCheckoutFormInitializeRequest;
        $request->setLocale('tr');
        $request->setConversationId($conversationId);
        $request->setPrice((float) $price);
        $request->setPaidPrice((float) $price);
        $request->setCurrency('TRY');
        $request->setBasketId((string) $plan->id);
        $request->setPaymentGroup('PRODUCT');
        $request->setCallbackUrl(route('payment.callback', [
            'plan' => $plan->id,
            'interval' => $interval,
            'conversation_id' => $conversationId,
        ]));
        $request->setEnabledInstallments([]);

        $buyer = new Buyer;
        $buyer->setId((string) $user->id);
        $buyer->setName($user->name ?: 'User');
        $buyer->setSurname('');
        $buyer->setGsmNumber($user->phone ?? '');
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber(config('payment.gateways.iyzico.identity_number', '11111111111'));
        $buyer->setLastLoginDate($user->last_login_at ?? '');
        $buyer->setRegistrationDate($user->created_at?->format('Y-m-d H:i:s') ?? '');
        $buyer->setRegistrationAddress('N/A');
        $buyer->setIp(request()->ip());
        $buyer->setCity('Istanbul');
        $buyer->setCountry('Turkey');
        $request->setBuyer($buyer);

        $shippingAddress = new Address;
        $shippingAddress->setContactName($user->name ?: 'User');
        $shippingAddress->setCity('Istanbul');
        $shippingAddress->setCountry('Turkey');
        $shippingAddress->setAddress('N/A');
        $shippingAddress->setZipCode('');
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new Address;
        $billingAddress->setContactName($user->name ?: 'User');
        $billingAddress->setCity('Istanbul');
        $billingAddress->setCountry('Turkey');
        $billingAddress->setAddress('N/A');
        $billingAddress->setZipCode('');
        $request->setBillingAddress($billingAddress);

        $basketItem = new BasketItem;
        $basketItem->setId((string) $plan->id);
        $basketItem->setName($plan->name.' ('.($interval === 'yearly' ? 'Yıllık' : 'Aylık').')');
        $basketItem->setCategory1('Davetiye');
        $basketItem->setItemType('VIRTUAL');
        $basketItem->setPrice((float) $price);
        $request->setBasketItems([$basketItem]);

        try {
            $checkoutForm = CheckoutFormInitialize::create($request, $this->getOptions());

            if ($checkoutForm->getStatus() === 'success') {
                return new PaymentResult(
                    success: true,
                    redirectUrl: $checkoutForm->getPayWithIyzicoPageUrl(),
                    transactionId: $conversationId,
                );
            }

            $errorMsg = $checkoutForm->getErrorMessage() ?? 'Ödeme başlatılamadı.';
            Log::warning('Iyzipay initialize failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $errorMsg,
            ]);

            return new PaymentResult(success: false, message: $errorMsg);
        } catch (\Throwable $e) {
            Log::error('Iyzipay initialize exception', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            return new PaymentResult(success: false, message: 'Ödeme sistemi geçici olarak kullanılamıyor.');
        }
    }

    public function verify(array $data): PaymentResult
    {
        $token = $data['token'] ?? null;

        if (! $token) {
            Log::warning('Iyzipay verify called without token', [
                'ip' => request()->ip(),
                'data' => $data,
            ]);

            return new PaymentResult(success: false, message: 'Ödeme tokenı bulunamadı.');
        }

        try {
            $request = new RetrieveCheckoutFormRequest;
            $request->setLocale('tr');
            $request->setToken($token);

            $checkoutForm = CheckoutForm::retrieve($request, $this->getOptions());

            if ($checkoutForm->getPaymentStatus() === 'SUCCESS') {
                Log::info('Iyzipay payment verified', [
                    'token' => $token,
                    'conversation_id' => $data['conversation_id'] ?? null,
                ]);

                return new PaymentResult(
                    success: true,
                    transactionId: $checkoutForm->getToken(),
                    message: 'Ödeme başarılı.',
                );
            }

            Log::warning('Iyzipay payment verification failed', [
                'token' => $token,
                'status' => $checkoutForm->getPaymentStatus(),
                'error' => $checkoutForm->getErrorMessage(),
            ]);

            return new PaymentResult(
                success: false,
                message: $checkoutForm->getErrorMessage() ?? 'Ödeme doğrulanamadı.',
            );
        } catch (\Throwable $e) {
            Log::error('Iyzipay verify exception', [
                'token' => $token,
                'error' => $e->getMessage(),
            ]);

            return new PaymentResult(success: false, message: 'Ödeme doğrulama sistemi geçici olarak kullanılamıyor.');
        }
    }
}

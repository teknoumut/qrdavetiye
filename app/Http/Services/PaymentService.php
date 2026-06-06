<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class PaymentService
{
    private function getOptions(): Options
    {
        $options = new Options;
        $options->setApiKey(Setting::getValue('iyzico_api_key', 'sandbox-api-key'));
        $options->setSecretKey(Setting::getValue('iyzico_secret_key', 'sandbox-secret-key'));
        $options->setBaseUrl(Setting::getValue('iyzico_base_url', 'https://sandbox-api.iyzipay.com'));

        return $options;
    }

    public function initializeCheckout(User $user, Plan $plan, string $interval): ?CheckoutFormInitialize
    {
        $price = $interval === 'yearly' ? $plan->yearly_price : $plan->monthly_price;
        if (! $price || $price <= 0) {
            return null;
        }

        $conversationId = uniqid('qr_', true);

        $request = new CreateCheckoutFormInitializeRequest;
        $request->setLocale('tr');
        $request->setConversationId($conversationId);
        $request->setPrice($price);
        $request->setPaidPrice($price);
        $request->setCurrency('TRY');
        $request->setBasketId((string) $plan->id);
        $request->setPaymentGroup('PRODUCT');
        $request->setCallbackUrl(route('payment.callback', ['plan' => $plan->id, 'interval' => $interval, 'conversation_id' => $conversationId]));
        $request->setEnabledInstallments([]);

        $buyer = new Buyer;
        $buyer->setId((string) $user->id);
        $buyer->setName($user->name ?: 'User');
        $buyer->setSurname('');
        $buyer->setGsmNumber('');
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber(substr($user->id, 0, 11));
        $buyer->setLastLoginDate('');
        $buyer->setRegistrationDate($user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '');
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
        $basketItem->setPrice($price);
        $request->setBasketItems([$basketItem]);

        return CheckoutFormInitialize::create($request, $this->getOptions());
    }

    public function verifyPayment(string $token): ?CheckoutForm
    {
        $request = new RetrieveCheckoutFormRequest;
        $request->setLocale('tr');
        $request->setToken($token);

        return CheckoutForm::retrieve($request, $this->getOptions());
    }
}

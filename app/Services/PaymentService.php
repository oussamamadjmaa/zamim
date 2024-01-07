<?php

namespace App\Services;

use AmazonPaymentServicesSdk\AmazonPaymentServices\Exceptions\APSException;
use AmazonPaymentServicesSdk\AmazonPaymentServices\Merchant\APSMerchant;
use AmazonPaymentServicesSdk\FrontEndAdapter\Payments\CCRedirect;

class PaymentService
{
    protected $APSMerchant;

    public function __construct(APSMerchant $APSMerchant)
    {
        $this->APSMerchant = $APSMerchant;
        $this->APSMerchant->setMerchantParams(config('services.aps'));
    }

    public function createPaymentIntent($amount, $merchantReference, $currency = 'SAR', $callbackUrl, $email, $description)
    {
        //Generate payment
        $paymentData =  [
            'merchant_reference' => $merchantReference,
            'amount'            => $amount,
            'currency'          => $currency,
            'language'          => 'en',
            'customer_email'    => $email,
            'order_description' => $description,
            'merchant_extra' => 'subscription_payment'
        ];

        try {
            $button = (new CCRedirect())
                ->setPaymentData($paymentData)
                ->usePurchaseCommand()
                ->setCallbackUrl($callbackUrl)
                ->render([
                    'button_text'   => __('الإنتقال للدفع')
                ]);
        } catch (APSException $e) {
            return $e->getMessage();
        }

        return $button;
    }
}

<?php

namespace App\Http\Controllers\Backend\School;

use AmazonPaymentServicesSdk\AmazonPaymentServices\Exceptions\APSException;
use AmazonPaymentServicesSdk\AmazonPaymentServices\Merchant\APSMerchant;
use AmazonPaymentServicesSdk\AmazonPaymentServices\Model\APSResponse;
use AmazonPaymentServicesSdk\FrontEndAdapter\Core\ResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\Subscription\SubscriptionPayment;
use Illuminate\Http\Request;

class SubscriptionPaymentCallbackController extends Controller
{
    protected $APSMerchant;

    public function __construct(APSMerchant $APSMerchant)
    {
        $this->APSMerchant = $APSMerchant;
        $this->APSMerchant->setMerchantParams(config('services.aps'));
    }

    public function callback(Request $request, $provider) {
        abort_if(!in_array($provider, ['payfort']), 404);

        return $this->{$provider.'Callback'}($request);
    }

    protected function payfortCallback($request)
    {
        abort_if(!$orderNumber = $request->merchant_reference ?? '', 404);

        // sample app approach is to load the order data from a sample file
        $paymentData =  [
            'merchant_reference' => $orderNumber,
            'language'          => 'en',
        ];

        $subscriptionPayment = SubscriptionPayment::whereMerchantReference($orderNumber)->firstOrFail();

        try {
            (new ResponseHandler($paymentData))
                ->onSuccess(function (APSResponse $responseHandlerResult) use($subscriptionPayment, $request) {
                    $response = $responseHandlerResult->getResponseData();
                    $responseCode = $response['status'];
                    $responseMessage = $response['response_message'];

                    if ($responseHandlerResult->isSuccess()) {
                        $subscriptionPayment->complete($responseMessage);
                    } elseif (in_array($responseCode, ['19', '20'])) {
                        $subscriptionPayment->on_hold($responseMessage);
                    }

                    if (isset($response['fort_id']) && !$subscriptionPayment->transaction_id) {
                        $subscriptionPayment->transaction_id = $response['fort_id'];
                        $subscriptionPayment->save();
                    }

                    if (!$request->expectsJson()) {
                        header('Location: ' . route('school.subscription.payment.status', $subscriptionPayment->id));
                        exit;
                    }
                })
                ->onError(function (APSResponse $responseHandlerResult) use($subscriptionPayment, $request) {
                    $response = $responseHandlerResult->getResponseData();
                    $responseCode = $response['status'];
                    $responseMessage = $response['response_message'];

                    if ($responseCode != '00') {
                        $subscriptionPayment->failed($responseMessage);
                    }

                    if (isset($response['fort_id']) && !$subscriptionPayment->transaction_id) {
                        $subscriptionPayment->transaction_id = $response['fort_id'];
                        $subscriptionPayment->save();
                    }

                    if (!$request->expectsJson()) {
                        header('Location: ' . route('school.subscription.payment.status', $subscriptionPayment->id));
                        exit;
                    }
                })
                ->onHtml(function (string $htmlContent, APSResponse $responseHandlerResult) {
                    // the payment requires 3ds verification
                    if (!($merchantParams['3ds_modal'] ?? false)) {
                        header('Location: ' . $responseHandlerResult->get3dsUrl());
                        exit;
                    exit;
                    } else {
                        // open 3ds verification inside the iframe (print html code)
                        return response($htmlContent)->header('Content-Type', 'text/html');
                    }
                })
                ->handleResponse();
        } catch (APSException $e) {
            return "Error";
        }

        return response()->html('OK');
    }
}

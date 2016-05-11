<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

use App\Http\Requests;

class AuthorizeController extends Controller
{

    public function buyProduct(Request $request)
    {
        $Product = Product::find($request->product_id);
        if (!$Product) {
            return bach()->with('error_message', 'Product not found.');
        }

        $merchantAuthentication = $this->getMerchantAuthentication();
        $creditCard = $this->setCreditCard($request);

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $transactionRequestType = $this->createTransaction($Product->price, $paymentOne);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) {
            $tresponse = $response->getTransactionResponse();

            if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
                return back()->with('success_message', "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "<br>" . "Charge Credit Card TRANS ID  : " . $tresponse->getTransId());
            } else {
                return back()->with('warning_message', 'Charge Credit Card ERROR :  Invalid response' . '<br>' . $tresponse->getErrors()[0]->getErrorText());
            }
        } else {
            return back()->with('warning_message', 'Charge Credit card Null response returned');
        }
    }

    private function getMerchantAuthentication()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('AUTHORIZE_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('AUTHORIZE_TRANSACTION_KEY'));
        return $merchantAuthentication;
    }

    public function setCreditCard(Request $request)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->card_number);
        $creditCard->setCardCode($request->cvv);
        $creditCard->setExpirationDate($request->exp_year . '-' . $request->exp_month);
        return $creditCard;
    }

    public function createTransaction($price, $paymentOne)
    {
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($price);
        $transactionRequestType->setPayment($paymentOne);
        return $transactionRequestType;
    }
}

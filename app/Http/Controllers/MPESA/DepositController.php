<?php

namespace App\Http\Controllers\MPESA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchantDeposit;
use Carbon\Carbon;
use App\Models\User;
class DepositController extends Controller
{
    /**
     * pay via mpesaTransactions
     */
    public function returnAccessToken($consumerKey, $consumerSecret)
    {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        $json = json_decode($curl_response);
        $my_token = $json->access_token;

        return $my_token;
    }

    /**
     *pass the following parameters: (phone_number,account_reference,transaction_description,org_id)
     */
    public function lipaNaMpesa(Request $request)
    {

        $consumerKey = 'iqnjQZETM5KDkogiVHPRxmJiBUiJ8xXM';
        $consumerSecret = 'Cb4GVWhyAtkb6tKs';

        $acc_token = $this->returnAccessToken($consumerKey, $consumerSecret);

        //initiate safaricom payment
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $transaction_type = 'CustomerBuyGoodsOnline';
        $timestamp = '20' . date("ymdhis");
        $shortcode = '140570';
        $PartyB = "142392";
        $AccountReference= "MDeposit";
        $pass_key = '2a214d33c22817761164f6ba2a7c51cbbd9c0982915c34e1596fa09d7859ada4';
        $appKeySecret = $shortcode . $pass_key . $timestamp;
        $password = base64_encode($appKeySecret);
        $CallBackURL= "http://acp.nyayomat.com/api/mpesaipn";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $acc_token)); //setting custom header

        $curl_post_data = array(
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => $transaction_type,
            'Amount' => $request->Amount,
            'PartyA' => $request->PhoneNumber,
            'PartyB' => $PartyB,
            'PhoneNumber' => $request->PhoneNumber,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $request->TransactionDesc
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        return $curl_response;
        // $my_data = json_decode($curl_response);
        \Log::info($curl_response);
    }


    public function mpesaIPN(Request $request)
    {
        $_date_now = Carbon::now();

        // Check if IPN server has made a callback
        try {
            \Log::info(" Mpesa IPN server has made a callback");
            if (count($request->all()) > 0) {
                \Log::info('ipn call back request');
                \Log::info($request->all());

                $merchant_request_id = $request['Body']['stkCallback']['MerchantRequestID'];
                $checkout_request_id = $request['Body']['stkCallback']['CheckoutRequestID'];
                $result_code = $request['Body']['stkCallback']['ResultCode'];
                $result_desc = $request['Body']['stkCallback']['ResultDesc'];

                if($result_code == 0){
                $meta = $request['Body']['stkCallback']['CallbackMetadata']['Item'];
                $amount = $meta[0]['Value'];
                $MpesaReceiptNumber = $meta[1]['Value'];
                $TransactionDate = $meta[3]['Value'];
                $PhoneNumber = $meta[4]['Value'];


                $mpesa = new MerchantDeposit();
                $mpesa->merchant_id = 3;
                $mpesa->merchant_request_id = $merchant_request_id;
                $mpesa->checkout_request_id = $checkout_request_id;
                $mpesa->result_code = $result_code;
                $mpesa->result_description = $result_desc;
                $mpesa->amount = $amount;
                $mpesa->mpesa_receipt_no = $MpesaReceiptNumber;
                $mpesa->transaction_date = $TransactionDate;
                $mpesa->phone_number = $PhoneNumber;
                $mpesa->transaction_type = 'Deposit';
                

                \Log::info('Log call before saving ...');
                \Log::info($mpesa);
                if($mpesa->save()){
                    $merchant = User::where('id', 3)->first();
                    if($merchant){
                        $merchant->account_balance = $merchant->account_balance + $amount;
                        $merchant->save();
                        \Log::info("Balance::: Balance updated successfully.");
                    }else{
                        \Log::info("Balance::: Balance not updated.");
                    }
                }else{
                    \Log::info("Transaction::: Transaction not save in db.");
                }



                 
                }
            } else {
                \Log::info("not working.");
            }

        } catch (Exception $exception) {
            $errormsg = "";
            $result = false;

            $errormsg = '' . $exception->getMessage();
            if (strpos($errormsg, "1062 Duplicate entry")) {
                return response()->json(['response' => "Duplicate entries not acceptable"]);
            } else if (strpos($errormsg, "1366 Incorrect integer value")) {
                return response()->json(['response' => "Integer Value Required!!!"]);
            } else {
                return response()->json(['response' => 'apa kuna error' . $errormsg]);
            }
        }

    }
}

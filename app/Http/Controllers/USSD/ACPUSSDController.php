<?php
namespace App\Http\Controllers\USSD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\MerchantTransaction;
use App\Models\MerchantAsset;
use App\Models\MerchantAssetOrder;
use Carbon\Carbon;

class ACPUSSDController extends Controller {
    /**
     * Store a new ussd request.
     *
     * @param  Request  $request
     * @return Response
     */
    private function get_single_asset_amount($merchant_id, $assetId, $ids, $today_date) {
        $single_asset_amount = MerchantTransaction::where("merchant_id", $merchant_id)
        ->where("asset_id", $assetId)
        ->whereIn("asset_id", $ids)
        ->where("due_date", "<=", $today_date)
        ->wherenull("paid_on")
        ->sum("amount");

        return $single_asset_amount;
    }

    private function get_single_asset_total_paid_amount($merchant_id, $assetId, $today_date) {
        $single_asset_amount = MerchantTransaction::where("merchant_id", $merchant_id)
        ->where("asset_id", $assetId)
        ->where("due_date", "<=", $today_date)
        ->whereNotNull("paid_on")
        ->sum("amount");

        return $single_asset_amount;
    }

    private function get_single_asset_outstanding_amount($merchant_id, $assetId) {
        $asset_out_standing_amount = MerchantAssetOrder::where("merchant_id", $merchant_id)
        ->where("status", "delivered")
        ->where("asset_id", $assetId)
        ->sum("total_out_standing_amount");

        return $asset_out_standing_amount;
    }

    private function make_payment($merchant_id, $type) {
        $callback_url = "http://acp.nyayomat.com/api/merchant/pay/all/$merchant_id/$type";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$callback_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $success_msg = json_decode(curl_exec($ch))->message;
        $response = 'END '.$success_msg;
        
        return $response;
    }

    public function get_asset_name($assetId) {
        $assetName = MerchantAsset::where("id", $assetId)->first();
        return $assetName->asset_name;
    }
    public function get_assets_count($merchantId) {
        $assets_ids= MerchantTransaction::where("merchant_id", $merchantId)->pluck("asset_id")->all();
        if (count($assets_ids) > 0) {
            return count(array_unique($assets_ids));
        }
        else {
            return 0;
        }
    }

    public function store(Request $request) {
        $input_response = explode('*', $request->input("text"));
        // Read the variables sent via POST from Africa's Talking API
        $sessionId = $request->input("sessionId");
        $serviceCode = $request->input("serviceCode");
        $phoneNumber = $request->input("phoneNumber");
        $text = $request->input("text");
        $response = "";

        $today_date = Carbon::now("Africa/Nairobi")->toDateString();

        $makePaymentText = "1. Make Payment \n";
        $cancelSession = "2. Cancel \n";
        $assetsCancelSession = "00. Cancel";


        $email_screen = array(
            "pre" => "CON Welcome to Nyayomat! Please input your email",
        );

        $pwd_screen = array(
            "pre" => "CON Enter password",
        );

        $assetsMenu = array(
            "pre" => "CON Please Select Type Of Assets \n",
            "options" => array("1. Ongoing Assets \n", "2. Defaulted Assets \n", "3. Completed Assets \n\n")
        );

        if ($text == "") {
            $response = $email_screen['pre'];
            
        } else if (isset($input_response[0]) && !isset($input_response[1])) {
            $response = $pwd_screen['pre'];

        } else if (isset($input_response[0]) && isset($input_response[1])){
            $merchant = User::where('email', $input_response[0])->first();
            if($merchant){
                if (Hash::check($input_response[1], $merchant->password)) {
                    $transactions = MerchantTransaction::where("merchant_id", $merchant->id)
                            ->wherenull("paid_on")
                            ->groupBy("asset_id")
                            ->selectRaw("asset_id, count(*) as total_due_count")
                            ->where("due_date", "<=", $today_date)
                            ->get();

                    $total_due_id = array();
                    foreach ($transactions as $transaction) {
                        if($transaction->total_due_count == 1){
                            $total_due_id[] = $transaction->asset_id;
                        }
                    }     
                    $total_due_amount = MerchantTransaction::where("merchant_id", $merchant->id)
                                        ->whereIn("asset_id", $total_due_id)
                                        ->where("due_date", "<=", $today_date)
                                        ->wherenull("paid_on")
                                        ->sum("amount");

                    $total_pending_id = array();
                    foreach ($transactions as $transaction) {
                        if($transaction->total_due_count >= 1){
                            $total_pending_id[] = $transaction->asset_id;
                        }
                    }

                    $total_pending_amount = MerchantTransaction::where("merchant_id", $merchant->id)
                                                            ->whereIn("asset_id", $total_pending_id)
                                                            ->where("due_date", "<=", $today_date)
                                                            ->wherenull("paid_on")
                                                            ->sum("amount");

                    $total_over_due_id = array();
                    foreach ($transactions as $transaction) {
                        if($transaction->total_due_count >= 2){
                            $total_over_due_id[] = $transaction->asset_id;
                        }
                    }            
                    $total_over_due_amount = MerchantTransaction::where("merchant_id", $merchant->id)
                                                            ->whereIn("asset_id", $total_over_due_id)
                                                            ->where("due_date", "<=", $today_date)
                                                            ->wherenull("paid_on")
                                                            ->sum("amount");

                    $total_past_over_due_id = array();
                    foreach ($transactions as $transaction) {
                        if($transaction->total_due_count >= 3){
                            $total_past_over_due_id[] = $transaction->asset_id;
                        }
                    }            
                    $total_past_over_due_amount = MerchantTransaction::where("merchant_id", $merchant->id)
                                                            ->whereIn("asset_id", $total_past_over_due_id)
                                                            ->where("due_date", "<=", $today_date)
                                                            ->wherenull("paid_on")
                                                            ->sum("amount");

                    $total_defaulted_id = array();
                    foreach ($transactions as $transaction) {
                        if($transaction->total_due_count >= 4){
                            $total_defaulted_id[] = $transaction->asset_id;
                        }
                    }            
                    $total_defaulted_amount =  MerchantTransaction::where("merchant_id", $merchant->id)
                                                            ->whereIn("asset_id", $total_defaulted_id)
                                                            ->where("due_date", "<=", $today_date)
                                                            ->wherenull("paid_on")
                                                            ->sum("amount");

                    $completed_assets_id = MerchantAssetOrder::where("merchant_id", $merchant->id)
                                                            ->where("total_out_standing_amount", 0)->pluck("asset_id")->all();

                    $all_ongoing_assets_id = array_merge($total_due_id, $total_pending_id, $total_over_due_id, $total_past_over_due_id);
                    if (count($all_ongoing_assets_id) > 0) {
                        $ongoing_assets_ids = array_unique($all_ongoing_assets_id);
                    } else {
                        $ongoing_assets_ids = [];
                    }
                    if (count($total_defaulted_id) > 0) {
                        $defaulted_assets_ids = array_unique($total_defaulted_id);
                    } else {
                        $defaulted_assets_ids = [];
                    }
                    if (count($completed_assets_id) > 0) {
                        $completed_assets_ids = array_unique($completed_assets_id->all());
                    } else {
                        $completed_assets_ids = [];
                    }

                    $merchantMenu = array(
                        "pre" =>  "CON What would you want to check \n",
                        "options" => array("1. Due Payments \n", "2. Pending Payments \n",
                                            "3. Overdue Payments \n", "4. Past Overdue Payments\n", "5. Defaulted Payments \n", "6. My Assets \n",
                                            "7. Summary Statement", ) 
                    );

                    $duePayment = array(
                        "pre" => "CON Total Due Payment Today is KES {$total_due_amount} \n",
                        "options" => array($makePaymentText, $cancelSession)
                    );
                    $pendingPayment = array(
                        "pre" => "CON Total Pending Payment Today is KES {$total_pending_amount} \n",
                        "options" => array($makePaymentText, $cancelSession)
                    );
                    $overduePayment = array(
                        "pre" => "CON Total Overdue Payment Today is KES {$total_over_due_amount} \n",
                        "options" => array($makePaymentText, $cancelSession)
                    );

                    $pastOverduePayment = array(
                        "pre" => "CON Total Past Overdue Payment Today is KES {$total_past_over_due_amount} \n",
                        "options" => array($makePaymentText, $cancelSession)
                    );

                    $defaultedPayment = array(
                        "pre" => "CON Total Defaulted Payment Today is KES {$total_defaulted_amount} \n",
                        "options" => array($makePaymentText, $cancelSession)
                    );

                    $summaryStatement = array(
                        "pre" => "CON Total # of Assets: {Number} \n Total Due: {KES} \n Total Pending: {KES} \n Total Overdue{KES} \n Total Defaulted: {KES} \n\n Total Paid: {KES} \n Total Outstanding: {KES} \n\n",
                    );
                    $ongoingAssets = array(
                        "pre" => "CON The assets with ONGOING status are: \n",
                        "options" => array("1. asset # 1")
                    );
                    $defaultedAssets = array(
                        "pre" => "CON The assets with DEFAULTED status are: \n",
                        "options" => array("1. asset # 1")
                    );
                    $completedAssets = array(
                        "pre" => "CON The assets with COMPLETED status are: \n",
                        "options" => array("1. asset # 1")
                    );

                    $ongoingAssetsIndexes = array_keys($ongoing_assets_ids);
                    $defaultedAssetsIndexes = array_keys($defaulted_assets_ids);
                    $completedAssetsIndexes = array_keys($completed_assets_ids);

                    $ongoingAssetsText = [];
                    $defaultedAssetsText = [];
                    $completedAssetsText = [];

                    $merchantCredentials = $input_response[0].'*'.$input_response[1];

                    for ($x=0; $x < count($ongoingAssetsIndexes); $x++) {
                        array_push($ongoingAssetsText, $merchantCredentials.'*'."6*1*{$x}");
                    }
                    for ($x=0; $x < count($defaultedAssetsIndexes); $x++) {
                        array_push($defaultedAssetsText, $merchantCredentials.'*'."6*2*{$x}");
                    }
                    if ($text == $merchantCredentials){
                        $response  = $merchantMenu['pre'];
                        $response .= $merchantMenu['options'][0];
                        $response .= $merchantMenu['options'][1];
                        $response .= $merchantMenu['options'][2];
                        $response .= $merchantMenu['options'][3];
                        $response .= $merchantMenu['options'][4];
                        $response .= $merchantMenu['options'][5];
                        $response .= $merchantMenu['options'][6];

                    } else if ($text == $merchantCredentials.'*'.'1') {
                        $response = $duePayment["pre"];
                        $response .= $duePayment["options"][0];
                        $response .= $duePayment["options"][1];
            
                    } else if ($text == $merchantCredentials.'*'.'1'.'*'.'1') {
                        $response = $this->make_payment($merchant->id, 'today');

                    } else if ($text == $merchantCredentials.'*'.'1'.'*'.'2') {
                        $response = 'END Goodbye!';

                    } else if ($text == $merchantCredentials.'*'.'1'.'*'.'2'.'*'.'2') {
                        $response = $pendingPayment["pre"];
                        $response .= $pendingPayment["options"][0];
                        $response .= $pendingPayment["options"][1];
            
                    } else if ($text == $merchantCredentials.'*'.'2'.'*'.'1') {
                        $response = $this->make_payment($merchant->id, 'pending');

                    } else if ($text == $merchantCredentials.'*'.'2'.'*'.'2') {
                        $response = 'END Goodbye!';

                    } else if ($text == $merchantCredentials.'*'.'3') {
                        $response = $overduePayment["pre"];
                        $response .= $overduePayment["options"][0];
                        $response .= $overduePayment["options"][1];
            
                    }  else if ($text == $merchantCredentials.'*'.'3'.'*'.'1') {
                        $response = $this->make_payment($merchant->id, 'over_due');

                    } else if ($text == $merchantCredentials.'*'.'3'.'*'.'2') {
                        $response = 'END Goodbye!';

                    } else if ($text == $merchantCredentials.'*'.'4') {
                        $response = $pastOverduePayment["pre"];
                        $response .= $pastOverduePayment["options"][0];
                        $response .= $pastOverduePayment["options"][1];
            
                    } else if ($text == $merchantCredentials.'*'.'4'.'*'.'1') {
                        $response = $this->make_payment($merchant->id, 'past_over_due');


                    } else if ($text == $merchantCredentials.'*'.'4'.'*'.'2') {
                        $response = 'END Goodbye!';

                    } else if ($text == $merchantCredentials.'*'.'5') {
                        $response = $defaultedPayment["pre"];
                        $response .= $defaultedPayment["options"][0];
                        $response .= $defaultedPayment["options"][1];
            
                    } else if ($text == $merchantCredentials.'*'.'5'.'*'.'1') {
                        $response = $this->make_payment($merchant->id, 'defaulted');

                    } else if ($text == $merchantCredentials.'*'.'5'.'*'.'2') {
                        $response = 'END Goodbye!';

                    } else if($text == $merchantCredentials.'*'.'6') { 
                        $response = $assetsMenu["pre"];
                        $response .= $assetsMenu["options"][0];
                        $response .= $assetsMenu["options"][1];
                        $response .= $assetsMenu["options"][2];
                        $response .= $assetsCancelSession;
            
                    } else if($text == $merchantCredentials.'*'.'6'.'*'.'1') {
                        $response = $ongoingAssets["pre"];
                        if ($ongoing_assets_ids) {
                            foreach($ongoing_assets_ids as $asset_index => $asset)
                                $response .= $asset_index.'. '.$this->get_asset_name($asset). "\n";
                            $response .= $assetsCancelSession;
                        } else if (!$ongoing_assets_ids) {
                            $response = 'END You do not have any ONGOING assets!';
                        }
            
                    } else if($text == $merchantCredentials.'*'.'6'.'*'.'1'.'*'.'00') {
                        $response = 'END Goodbye!';

                    } else if(in_array($text, $ongoingAssetsText)) {
                        $selectedAsset = explode('*', $text)[4];
                        $assetId = $ongoing_assets_ids[$selectedAsset];
                        $single_asset_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_due_id, $today_date);
                        $single_asset_pending = $this->get_single_asset_amount($merchant->id, $assetId, $total_pending_id, $today_date);
                        $single_asset_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_over_due_id, $today_date);
                        $single_asset_past_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_past_over_due_id, $today_date);
                        $single_asset_total_paid = $this->get_single_asset_total_paid_amount($merchant->id, $assetId, $today_date);
                        $single_asset_outstanding = $this->get_single_asset_outstanding_amount($merchant->id, $assetId);
                        $response = "CON Status on {$this->get_asset_name($assetId)} is ONGOING. \nDue Payment: $single_asset_due \nPending: $single_asset_pending \n Overdue: $single_asset_over_due \n Past Ovedue: $single_asset_past_over_due \n Total Paid: $single_asset_total_paid \n Outstanding: $single_asset_outstanding";
                
                    } else if($text == $merchantCredentials.'*'.'6'.'*'.'2') {
                        $response = $defaultedAssets["pre"];
                        if ($defaulted_assets_ids) {
                            foreach($defaulted_assets_ids as $asset_index => $asset)
                                $response .= $asset_index.'. '.$this->get_asset_name($asset). "\n";
                            $response .= $assetsCancelSession;
                        } else if (!$defaulted_assets_ids) {
                            $response = 'END You do not have any DEFAULTED assets!';
                        }
            
                    }else if($text == $merchantCredentials.'*'.'6'.'*'.'2'.'*'.'00') {
                        $response = 'END Goodbye!';
            
                    } else if(in_array($text, $defaultedAssetsText)) {
                        $selectedAsset = explode('*', $text)[4];
                        $assetId = $ongoing_assets_ids[$selectedAsset];
                        $single_asset_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_due_id, $today_date);
                        $single_asset_pending = $this->get_single_asset_amount($merchant->id, $assetId, $total_pending_id, $today_date);
                        $single_asset_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_over_due_id, $today_date);
                        $single_asset_past_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_past_over_due_id, $today_date);
                        $single_asset_total_paid = $this->get_single_asset_total_paid_amount($merchant->id, $assetId, $today_date);
                        $single_asset_outstanding = $this->get_single_asset_outstanding_amount($merchant->id, $assetId);
                        $response = "CON Status on {$this->get_asset_name($assetId)} is DEFAULTED. \nDue Payment: $single_asset_due \nPending: $single_asset_pending \n Overdue: $single_asset_over_due \n Past Ovedue: $single_asset_past_over_due \n Total Paid: $single_asset_total_paid \n Outstanding: $single_asset_outstanding";
                
                    } else if($text == $merchantCredentials.'*'.'6'.'*'.'3') {
                        $response = $completedAssets["pre"];
                        if ($completed_assets_ids) {
                            foreach($completed_assets_ids as $asset_index => $asset)
                                $response .= $asset_index.'. '.$this->get_asset_name($asset). "\n";
                            $response .= $assetsCancelSession;
                        } else if (!$completed_assets_ids) {
                            $response = 'END You do not have any COMPLETED assets!';
                        }
                        
            
                    }else if($text == $merchantCredentials.'*'.'6'.'*'.'3'.'*'.'00') {
                        $response = 'END Goodbye!';
            
                    } else if(in_array($text, $defaultedAssetsText)) {
                        $selectedAsset = explode('*', $text)[4];
                        $assetId = $ongoing_assets_ids[$selectedAsset];
                        $single_asset_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_due_id, $today_date);
                        $single_asset_pending = $this->get_single_asset_amount($merchant->id, $assetId, $total_pending_id, $today_date);
                        $single_asset_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_over_due_id, $today_date);
                        $single_asset_past_over_due = $this->get_single_asset_amount($merchant->id, $assetId, $total_past_over_due_id, $today_date);
                        $single_asset_total_paid = $this->get_single_asset_total_paid_amount($merchant->id, $assetId, $today_date);
                        $single_asset_outstanding = $this->get_single_asset_outstanding_amount($merchant->id, $assetId);
                        $response = "CON Status on {$this->get_asset_name($assetId)} is DEFAULTED. \nDue Payment: $single_asset_due \nPending: $single_asset_pending \n Overdue: $single_asset_over_due \n Past Ovedue: $single_asset_past_over_due \n Total Paid: $single_asset_total_paid \n Outstanding: $single_asset_outstanding";
                
                    } else if($text == $merchantCredentials.'*'.'6'.'*'.'00') {
                        $response = 'END Goodbye!';

                    }else if($text == $merchantCredentials.'*'.'7') {
                        $response = "CON Total number of assets: {$this->get_assets_count($merchant->id)} \nTotal Due: $total_due_amount \nTotal Pending: $total_pending_amount \n Total Overdue: $total_over_due_amount \n Total Past Ovedue: $total_past_over_due_amount \nTotal Defaulted: $total_defaulted_amount \n\n";
                        $response .= $assetsCancelSession;

                    } else if($text == $merchantCredentials.'*'.'7'.'*'.'00') {
                        $response = 'END Goodbye!';
            
                    }
                }
                else {
                    $response .= 'END Invalid Password';
                    return $response;
                }
                }else{
                    $response .= 'END The user email does not exist.';
                    return $response;
                }
            }


        header('Content-type: text/plain');
        echo $response;


    }
}
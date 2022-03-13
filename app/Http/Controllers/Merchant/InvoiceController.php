<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MerchantAssetOrder;
use App\Models\MerchantTransaction;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {

        $merchant = User::where("id",session("merchant_id"))->first();
        $today_date = Carbon::now("Africa/Nairobi")->toDateString();
        $products_engaged = MerchantAssetOrder::where("merchant_id",session("merchant_id"))
                            ->where("status", "delivered")
                            ->count();

        $calculation = MerchantAssetOrder::where("merchant_id",session("merchant_id"))
                            ->where("status", "delivered")
                            ->selectraw("sum(units * unit_cost) as total_assets_value , sum(total_out_standing_amount) as total_out_standing_amount, count(*) as asset_engaged")
                            ->first();


        $product_owned = MerchantAssetOrder::where("merchant_id",session("merchant_id"))
                            ->where("status", "delivered")
                            ->where("total_out_standing_amount", 0)
                            ->count();

        $get_dues_invoice = MerchantTransaction::where("tbl_acp_merchant_transaction.merchant_id",session("merchant_id"))
                            ->where("due_date", "<" , $today_date)
                            ->wherenull("paid_on")
                            ->groupby("order_id")
                            ->selectraw("count(*) as dues")
                            ->get();
        $product_defaulted = 0;
        foreach ($get_dues_invoice as  $get_count) {
            if($get_count->dues >= 4){
                $product_defaulted++;
            }
        }
        $unpaid = MerchantTransaction::select("tbl_acp_merchant_transaction.*", "tbl_acp_assets.asset_name")
                        ->where("tbl_acp_merchant_transaction.merchant_id",session("merchant_id"))
                        ->where("due_date", "<=" , $today_date)->wherenull("paid_on")
                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_transaction.asset_id")
                        ->get();
        $paid = MerchantTransaction::select("tbl_acp_merchant_transaction.*", "tbl_acp_assets.asset_name")
                        ->wherenotnull("paid_on")
                        ->where("tbl_acp_merchant_transaction.merchant_id",session("merchant_id"))
                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_transaction.asset_id")
                        ->get();
        //return response()->json($calculation);
        return view('merchant.invoice.index')
                ->with('merchant', $merchant)
                ->with("calculation", $calculation)
                ->with("product_defaulted", $product_defaulted)
                ->with("product_owned",$product_owned)
                ->with('unpaid', $unpaid)
                ->with('paid', $paid);
    }



    public function payNow($id)
    {
        try{
            $transaction = MerchantTransaction::where("id", $id)->first();

            $merchant = User::where('id', session('merchant_id'))->first();
            if($merchant){
                if($merchant->account_balance >= $transaction->amount){
                    $order = MerchantAssetOrder::where("id", $transaction->order_id)->first();
                    $transaction->paid_on = Carbon::now("Africa/Nairobi")->toDateString();
                    if($transaction->save()){
                        $merchant->account_balance = $merchant->account_balance - $transaction->amount;
                        $merchant->save();
                        $order->total_out_standing_amount = $order->total_out_standing_amount - $transaction->amount;
                        if($order->save()){
                            return back()->withSuccess("Successfully Paid :)")->withInput();
                        }else{
                            return back()->withError("Something went wrong :(")->withInput();
                        }
                    }else{
                        return back()->withError("Something went wrong :(")->withInput();
                    }
                }else{
                    return back()->withError("You have insufficient funds to pay this invoice.")->withInput(); 
                }
                
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
            
            
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
        
    }

}

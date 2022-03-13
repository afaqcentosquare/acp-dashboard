<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MerchantAssetOrder;
use App\Models\AssetProviderTransaction;
use App\Models\Asset;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {

        $today_date = Carbon::now("Africa/Nairobi")->toDateString();
    

       
        $unpaid = AssetProviderTransaction::select("tbl_acp_asset_provider_transaction.*", "tbl_acp_assets.asset_name", "tbl_acp_asset_providers.shop_name")
                        ->where("due_date", "<=" , $today_date)->wherenull("paid_on")
                        ->join("tbl_acp_asset_providers","tbl_acp_asset_providers.id", "tbl_acp_asset_provider_transaction.asset_provider_id")
                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_asset_provider_transaction.asset_id")
                        ->get();
        $paid = AssetProviderTransaction::select("tbl_acp_asset_provider_transaction.*", "tbl_acp_assets.asset_name", "tbl_acp_asset_providers.shop_name")
                        ->wherenotnull("paid_on")
                        ->join("tbl_acp_asset_providers","tbl_acp_asset_providers.id", "tbl_acp_asset_provider_transaction.asset_provider_id")
                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_asset_provider_transaction.asset_id")
                        ->get();
        //return response()->json($product_defaulted);
        return view('superadmin.invoice.index')
                ->with('unpaid', $unpaid)
                ->with('paid', $paid);
    }

    public function payNow($id)
    {
        try{
            $transaction = AssetProviderTransaction::where("id", $id)->first();

            $order = Asset::where("id", $transaction->asset_id)->first();
    
    
            $transaction->paid_on = Carbon::now("Africa/Nairobi")->toDateString();
            if($transaction->save()){
                $order->total_out_standing_amount = $order->total_out_standing_amount - $transaction->amount;
                if($order->save()){
                    return back()->withSuccess("Successfully Paid :)")->withInput();
                }else{
                    return back()->withError("Something went wrong :(")->withInput();
                }
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
            
            
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
        
    }
}

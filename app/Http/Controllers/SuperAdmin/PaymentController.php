<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchantTransaction;
use App\Models\AssetProviderTransaction;
use App\Models\MerchantAssetOrder;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fullfilled_payments = MerchantTransaction::select("tbl_acp_merchant_transaction.*","tbl_acp_assets.asset_name", "users.name")
                                ->wherenotnull("paid_on")
                                ->join("users","users.id", "tbl_acp_merchant_transaction.merchant_id")
                                ->join("tbl_acp_assets","tbl_acp_assets.id", "tbl_acp_merchant_transaction.asset_id")
                                ->get();
        $covered_payments = AssetProviderTransaction::select("tbl_acp_asset_provider_transaction.*","tbl_acp_assets.asset_name", "tbl_acp_asset_providers.shop_name")
                                ->wherenotnull("paid_on")
                                ->join("tbl_acp_asset_providers","tbl_acp_asset_providers.id", "tbl_acp_asset_provider_transaction.asset_provider_id")
                                ->join("tbl_acp_assets","tbl_acp_assets.id", "tbl_acp_asset_provider_transaction.asset_id")
                                ->get();
        $total_fullfilled = MerchantTransaction::wherenotnull("paid_on")->sum("amount");
        $total_covered = AssetProviderTransaction::wherenotnull("paid_on")->sum("amount");
        $today_date = Carbon::now("Africa/Nairobi")->toDateString();
        $provider_asset_value = MerchantAssetOrder::where("tbl_acp_merchant_asset_order.status", "delivered")
                            ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
                            ->selectraw("sum(tbl_acp_merchant_asset_order.units * tbl_acp_assets.unit_cost) as total_assets_value")
                            ->first();
        $merchant_asset_value = MerchantAssetOrder::where("merchant_id",session("merchant_id"))
                            ->where("status", "delivered")
                            ->selectraw("sum(units * unit_cost) as total_assets_value")
                            ->first();

        $year = Carbon::now()->format('Y');

        $due_today = AssetProviderTransaction::where("due_date", "<" , $today_date)
                            ->wherenull("paid_on")
                            ->sum("amount");

        $covered_jan = AssetProviderTransaction::whereMonth("paid_on", 1)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_feb = AssetProviderTransaction::whereMonth("paid_on", 2)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $covered_march = AssetProviderTransaction::whereMonth("paid_on", 3)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_april = AssetProviderTransaction::whereMonth("paid_on", 4)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_may = AssetProviderTransaction::whereMonth("paid_on", 5)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $covered_june = AssetProviderTransaction::whereMonth("paid_on", 6)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_july = AssetProviderTransaction::whereMonth("paid_on", 7)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_aug = AssetProviderTransaction::whereMonth("paid_on", 8)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $covered_sep = AssetProviderTransaction::whereMonth("paid_on", 9)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
                                        
        $covered_oct= AssetProviderTransaction::whereMonth("paid_on", 10)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $covered_nov = AssetProviderTransaction::whereMonth("paid_on", 11)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $covered_dec = AssetProviderTransaction::whereMonth("paid_on", 12)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_jan = MerchantTransaction::whereMonth("paid_on", 1)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_feb = MerchantTransaction::whereMonth("paid_on", 2)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $fullfilled_march = MerchantTransaction::whereMonth("paid_on", 3)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_april = MerchantTransaction::whereMonth("paid_on", 4)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_may = MerchantTransaction::whereMonth("paid_on", 5)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $fullfilled_june = MerchantTransaction::whereMonth("paid_on", 6)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_july = MerchantTransaction::whereMonth("paid_on", 7)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_aug = MerchantTransaction::whereMonth("paid_on", 8)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $fullfilled_sep = MerchantTransaction::whereMonth("paid_on", 9)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
                                        
        $fullfilled_oct= MerchantTransaction::whereMonth("paid_on", 10)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");

        $fullfilled_nov = MerchantTransaction::whereMonth("paid_on", 11)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
        
        $fullfilled_dec = MerchantTransaction::whereMonth("paid_on", 12)
                                        ->whereYear("paid_on", $year)
                                        ->sum("amount");
       //return response()->json($jan);
        return view('superadmin.payments.index')
            ->with("fullfilled_payments", $fullfilled_payments)
            ->with("covered_payments", $covered_payments)
            ->with("total_fullfilled", $total_fullfilled)
            ->with("total_covered", $total_covered)
            ->with("provider_asset_value", $provider_asset_value)
            ->with("merchant_asset_value", $merchant_asset_value)
            ->with("due_today", $due_today)
            ->with("covered_jan", $covered_jan)
            ->with("covered_feb", $covered_feb)
            ->with("covered_march", $covered_march)
            ->with("covered_april", $covered_april)
            ->with("covered_may", $covered_may)
            ->with("covered_june", $covered_june)
            ->with("covered_july", $covered_july)
            ->with("covered_aug", $covered_aug)
            ->with("covered_sep", $covered_sep)
            ->with("covered_oct", $covered_oct)
            ->with("covered_nov", $covered_nov)
            ->with("covered_dec", $covered_dec)
            ->with("fullfilled_jan", $fullfilled_jan)
            ->with("fullfilled_feb", $fullfilled_feb)
            ->with("fullfilled_march", $fullfilled_march)
            ->with("fullfilled_april", $fullfilled_april)
            ->with("fullfilled_may", $fullfilled_may)
            ->with("fullfilled_june", $fullfilled_june)
            ->with("fullfilled_july", $fullfilled_july)
            ->with("fullfilled_aug", $fullfilled_aug)
            ->with("fullfilled_sep", $fullfilled_sep)
            ->with("fullfilled_oct", $fullfilled_oct)
            ->with("fullfilled_nov", $fullfilled_nov)
            ->with("fullfilled_dec", $fullfilled_dec);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

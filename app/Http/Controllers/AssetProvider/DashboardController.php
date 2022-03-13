<?php

namespace App\Http\Controllers\AssetProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetProvider;
use App\Models\Asset;
use App\Models\MerchantAssetOrder;
use Carbon\Carbon;
use App\Models\AssetProviderTransaction;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asset_provider_detail = AssetProvider::where("id", session("asset_provider_id"))->withCount("assets")->first();
        $total_assets_value = Asset::where("asset_provider_id", session("asset_provider_id"))->selectRaw('SUM(units * unit_cost) as total')->groupBy("asset_provider_id")->first();
        $today_date = Carbon::now("Africa/Nairobi")->toDateString();

        $products_engaged = MerchantAssetOrder::where("asset_provider_id", session("asset_provider_id"))
                            ->where("status", "delivered")
                            ->groupBy("asset_id")
                            ->get();
        $total_paid = AssetProviderTransaction::where("asset_provider_id", session("asset_provider_id"))
                                                ->wherenotnull("paid_on")
                                                ->sum("amount");
        $total_out_standing_amount = Asset::where("asset_provider_id", session("asset_provider_id"))->sum("total_out_standing_amount");
        $calculation = MerchantAssetOrder::where("tbl_acp_merchant_asset_order.asset_provider_id", session("asset_provider_id"))
                            ->where("tbl_acp_merchant_asset_order.status", "delivered")
                            ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
                            ->selectraw("count(*) as asset_engaged")
                            ->first();

        $total_received_amount = AssetProviderTransaction::where("asset_provider_id", session("asset_provider_id"))
                                                        ->wherenotnull("paid_on")
                                                        ->sum("amount");
        
        $get_dues_invoice = AssetProviderTransaction::where("tbl_acp_asset_provider_transaction.asset_provider_id",session("asset_provider_id"))
                            ->where("due_date", "<" , $today_date)
                            ->wherenull("paid_on")
                            ->groupby("asset_id")
                            ->selectraw("count(*) as dues")
                            ->get();
        $product_defaulted = 0;
        foreach ($get_dues_invoice as  $get_count) {
            if($get_count->dues >= 4){
                $product_defaulted++;
            }
        }

        $approve_assets = Asset::where("asset_provider_id", session("asset_provider_id"))->where("status", "approved")
                        ->with(["orderAssets" => function ($query){
                            $query->selectraw("asset_id, sum(units) as order_units")->groupBy("asset_id");
                        }])
                        ->with(["transactions" => function($query){
                            $query->wherenotnull("paid_on")->where("type", "!=", "deposit")->orderBy('paid_on', 'DESC');
                        }])
                        ->withcount(["transactions" => function($query){
                            $query->wherenotnull("paid_on")->where("type", "!=", "deposit");
                        }])
                        ->with("nextReceipt", function($query) use($today_date){
                            $query->wherenull("paid_on")->where("due_date", ">=", $today_date);
                        })->get();

       // return response()->json($approve_assets);
        $pending_assets = Asset::where("asset_provider_id", session("asset_provider_id"))->where("status", "pending")->get();
        //return response()->json($approve_assets);
        return view('assetprovider.dashboard.index')
                ->with("asset_provider_detail", $asset_provider_detail)
                ->with("total_assets_value", $total_assets_value)
                ->with("products_engaged", $products_engaged)
                ->with("calculation", $calculation)
                ->with("total_received_amount", $total_received_amount)
                ->with("product_defaulted",$product_defaulted)
                ->with("approve_assets", $approve_assets)
                ->with("pending_assets", $pending_assets)
                ->with("total_paid", $total_paid)
                ->with("total_out_standing_amount",$total_out_standing_amount);
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

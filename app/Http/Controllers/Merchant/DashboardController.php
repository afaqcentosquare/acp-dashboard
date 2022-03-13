<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MerchantAssetOrder;
use App\Models\MerchantTransaction;
use Carbon\Carbon;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session([
            "merchant_id" => 3
        ]);

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
        $orders = MerchantAssetOrder::select("tbl_acp_merchant_asset_order.*", "tbl_acp_assets.asset_name")
                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
                        ->where("tbl_acp_merchant_asset_order.merchant_id",session("merchant_id"))
                        ->where("tbl_acp_merchant_asset_order.status", "delivered")
                        ->with(["transactions" => function($query){
                            $query->wherenotnull("paid_on")->where("type", "!=", "deposit")->orderBy('paid_on', 'DESC');
                        }])
                        ->withcount(["transactions" => function($query){
                            $query->wherenotnull("paid_on")->where("type", "!=", "deposit");
                        }])
                        ->with("nextReceipt", function($query) use($today_date){
                            $query->wherenull("paid_on")->where("due_date", ">=", $today_date);
                        })->get();
        
       // return response()->json($orders);
        return view('merchant.dashboard.index')
                ->with("calculation", $calculation)
                ->with("product_defaulted", $product_defaulted)
                ->with("product_owned",$product_owned)
                ->with('merchant', $merchant)
                ->with('orders', $orders);
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

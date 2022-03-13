<?php

namespace App\Http\Controllers\AssetProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\MerchantAssetOrder;
use Carbon\Carbon;

class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = MerchantAssetOrder::select("tbl_acp_merchant_asset_order.units as order_units","tbl_acp_assets.*")
                                        ->where("tbl_acp_merchant_asset_order.status", "pending")
                                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
                                        ->get();
        $delivered_assets = MerchantAssetOrder::select("tbl_acp_merchant_asset_order.units as order_units", "tbl_acp_assets.*")
                                        ->where("tbl_acp_merchant_asset_order.status", "delivered")
                                        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
                                        ->get();
        return view('assetprovider.productcatalog.index')
                    ->with("assets", $assets)
                    ->with("delivered_assets", $delivered_assets);
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

    public function updateStatus($id, $is_single)
    {
        try{
            if($is_single){
                Asset::where('id', $id)->update([
                    "status" => "approved",
                    "updated_at" => Carbon::now()
                ]);
            }else{
                Asset::where('asset_provider_id', $id)->update([
                    "status" => "approved",
                    "updated_at" => Carbon::now()
                ]);
            }

            return redirect()->route('assetprovider.dashboard');

        }catch(Exception $ex){
            return redirect()->route('assetprovider.dashboard');
        }
    }


    public function updateStock(Request $request,$id)
    {
        $request->validate([
            "units" => "required|numeric|min:1"
        ]);
        try{
            $asset = Asset::where("id", $id)->first();
            $asset->units = $request->units + $asset->units;
            if($asset->save()){
                return redirect()->route('assetprovider.dashboard')->withSuccess("Asset updated Successfully")->withInput();
            }else{
                return redirect()->route('assetprovider.dashboard')->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return redirect()->route('assetprovider.dashboard')->withError($ex->getMessage())->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\MerchantAsset;
class ProductCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edited = MerchantAsset::pluck("id");
        //return response()->json($ordered);
        $prep_assets = Asset::select("tbl_acp_assets.*","tbl_acp_asset_providers.shop_name","tbl_acp_groups.group_name","tbl_acp_subgroup.sub_group_name","tbl_acp_categories.category_name")
                        ->where("tbl_acp_assets.status", "approved")
                        ->whereNotIn("tbl_acp_assets.id",$edited)
                        ->join("tbl_acp_asset_providers", "tbl_acp_asset_providers.id", "tbl_acp_assets.asset_provider_id")
                        ->join("tbl_acp_groups", "tbl_acp_groups.id", "tbl_acp_assets.group_id")
                        ->join("tbl_acp_subgroup", "tbl_acp_subgroup.id", "tbl_acp_assets.sub_group_id")
                        ->join("tbl_acp_categories", "tbl_acp_categories.id", "tbl_acp_assets.category_id")
                        ->get();
        $live_assets = MerchantAsset::select("tbl_acp_merchant_assets.*","tbl_acp_asset_providers.shop_name")
                        ->join("tbl_acp_asset_providers", "tbl_acp_asset_providers.id", "tbl_acp_merchant_assets.asset_provider_id")
                        ->get();
                        
        //return response()->json($live_assets);
        return view('superadmin.productcatalog.index')
                ->with("prep_assets", $prep_assets)
                ->with("live_assets", $live_assets);
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

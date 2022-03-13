<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchantAssetOrder;
use App\Models\MerchantTransaction;
use App\Models\AssetProvider;
use App\Models\User;
use App\Models\Asset;
use Carbon\Carbon;
class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_engaged = MerchantAssetOrder::where("status", "delivered")
                            ->join("users","users.id", "merchant_id")
                            ->groupBy("merchant_id")
                            ->selectRaw("merchant_id,name,mobile,count(*) as total_engaged, sum(total_out_standing_amount) as total_out_standing_amount")
                            ->get();
       
        $asset_providers = AssetProvider::where("status","approved")->get();  
                         
        return view('superadmin.performance.index')
                    ->with("products_engaged", $products_engaged)
                    ->with("asset_providers", $asset_providers);
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

    public function defaulterMerchant($id)
    {
        $merchant = User::where("id", $id)->with(["orderAssets" => function ($query){
                    $query->groupBy("asset_id");
        }])->first();
        return view("superadmin.performance.defaulter")->with("merchant", $merchant);
    }
}

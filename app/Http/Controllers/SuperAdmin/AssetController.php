<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\MerchantAsset;
use App\Models\MerchantAssetOrder;
use App\Models\MerchantTransaction;
use App\Models\User;
class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $engaged_assets = MerchantAssetOrder::selectRaw("asset_id, asset_name,sum(tbl_acp_merchant_asset_order.units) as engaged_units, tbl_acp_merchant_asset_order.unit_cost, sum(tbl_acp_merchant_asset_order.units * tbl_acp_merchant_asset_order.unit_cost) as total")
        ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_merchant_asset_order.asset_id")
        ->with(["engagedTransaction" => function($query){
            $query->wherenotnull("paid_on")
            ->selectraw("asset_id,merchant_id,sum(amount) as total_paid")
            ->groupBy("merchant_id","asset_id");
        }])
        ->groupBy("asset_id")
        ->where("tbl_acp_merchant_asset_order.status", "delivered")
        ->get();
        //return response()->json($merchant_order);                        
        return view('superadmin.assets.index')
                ->with("engaged_assets", $engaged_assets);
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
        $request->validate([
            "asset_name" => "required",
            "units" => "required|numeric|min:1",
            "unit_cost" => "required|numeric|min:1",
            "holiday_provision" => "numeric",
            "deposit_amount" => "numeric",
            "installment" => "numeric",
            "payment_frequency" => "required",
            "payment_method" => "required",
            "group_id" => "required",
            "sub_group_id" => "required",
            "category_id" => "required",
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        try{
           
            //$image_path = $request->file('image')->store('public/uploads');
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploadedimages'), $imageName);
            $asset = new Asset();
            $asset->asset_provider_id = $request->asset_provider_id;
            $asset->asset_name = $request->asset_name;
            $asset->group_id = $request->group_id;
            $asset->sub_group_id = $request->sub_group_id;
            $asset->category_id = $request->category_id;
            $asset->image = '/uploadedimages/'.$imageName;
            $asset->units = $request->units;
            $asset->unit_cost = $request->unit_cost;
            $asset->holiday_provision = $request->holiday_provision;
            $asset->deposit_amount = $request->deposit_amount;
            $asset->installment = $request->installment;
            $asset->payment_frequency = $request->payment_frequency;
            $asset->payment_method = $request->payment_method;
            
            if($asset->save()){
                return redirect()->route('superadmin.assetprovider')->withSuccess("Asset added Successfully")->withInput();
            }else{
                return redirect()->route('superadmin.assetprovider')->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return redirect()->route('superadmin.assetprovider')->withError($ex->getMessage())->withInput();
        }
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
        $request->validate([
            "asset_name" => "required",
            "units" => "required|numeric|min:1",
            "unit_cost" => "required|numeric|min:1",
            "holiday_provision" => "numeric",
            "deposit_amount" => "numeric",
            "installment" => "numeric",
            "payment_frequency" => "required",
            "payment_method" => "required",
        ]);
        try{

            $is_exist = MerchantAsset::where("id", $request->asset_id)->where("asset_provider_id", $id)->first();
            if($is_exist){
                $is_exist->asset_name = $request->asset_name;
                $is_exist->units = $request->units;
                $is_exist->unit_cost = $request->unit_cost;
                $is_exist->holiday_provision = $request->holiday_provision;
                $is_exist->deposit_amount = $request->deposit_amount;
                $is_exist->installment = $request->installment;
                $is_exist->payment_frequency = $request->payment_frequency;
                $is_exist->payment_method = $request->payment_method;
                if($is_exist->save()){
                    return back()->withSuccess("Asset Live Successfully")->withInput();
                }else{
                    return back()->withError("Something went wrong :(")->withInput();
                }
            }else{
                $asset = new MerchantAsset();
                $asset->id = $request->asset_id;
                $asset->asset_provider_id = $id;
                $asset->asset_name = $request->asset_name;
                $asset->units = $request->units;
                $asset->unit_cost = $request->unit_cost;
                $asset->holiday_provision = $request->holiday_provision;
                $asset->deposit_amount = $request->deposit_amount;
                $asset->installment = $request->installment;
                $asset->payment_frequency = $request->payment_frequency;
                $asset->payment_method = $request->payment_method;
                if($asset->save()){
                    return back()->withSuccess("Asset Live Successfully")->withInput();
                }else{
                    return back()->withError("Something went wrong :(")->withInput();
                }
            }
            
            
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
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

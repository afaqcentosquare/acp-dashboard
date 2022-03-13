<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetProvider;
use Carbon\Carbon;
use App\Models\Asset;
use App\Models\Group;
use App\Models\SubGroup;
use App\Models\Category;
use Mail;
class AssetProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = AssetProvider::where("status", "pending")->get();
        $approves = AssetProvider::where("status", "approved")->with(["assets" => function($query){
            $query->where("status", "approved");
        }])->get();
        $total_assets_value = Asset::selectRaw('asset_provider_id, SUM(units * unit_cost) as total_asset')->where("status", "approved")->groupBy("asset_provider_id")->get();
        $groups = Group::select("tbl_acp_groups.*")
                    ->join("tbl_acp_subgroup", "tbl_acp_subgroup.group_id", "tbl_acp_groups.id")
                    ->join("tbl_acp_categories", "tbl_acp_categories.group_id", "tbl_acp_groups.id")
                    ->distinct()
                    ->get();
        $shortlisted = AssetProvider::where("status", "shortlist")->get();
        $suspended = AssetProvider::where("status", "suspend")->get();
        return view('superadmin.assetprovider.index')
                ->with("applications", $applications)
                ->with("approves", $approves)
                ->with("shortlisted", $shortlisted)
                ->with("suspended", $suspended)
                ->with("total_assets_value", $total_assets_value)
                ->with("groups", $groups);

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

    /**
     * Update the status of specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id,$status)
    {
        try{
            $asset_provider_detail = AssetProvider::where('id',$id)->first();
            AssetProvider::where('id', $id)->update([
                "status" => $status,
                "updated_at" => Carbon::now()
            ]);

            if($status == "decline"){
                $data = array('name'=>$asset_provider_detail->shop_name);
                Mail::send('mail.decline', $data, function($message) use ($asset_provider_detail) {
                $message->to($asset_provider_detail->email, $asset_provider_detail->applicant_name)->subject('Your expression of interest - Nyayomat');
                $message->from('no-reply@nyayomat.com','Nyayomat');
                });
            }elseif($status == "approved"){
                $data = array('name'=>$asset_provider_detail->shop_name, "id" => encrypt($id));
                Mail::send('mail.approve', $data, function($message) use ($asset_provider_detail) {
                $message->to($asset_provider_detail->email, $asset_provider_detail->applicant_name)->subject('Congratulations on joining Nyayomat ACP');
                $message->from('no-reply@nyayomat.com','Nyayomat');
                });
            }elseif($status == "shortlist"){
                $data = array('name'=>$asset_provider_detail->shop_name);
                Mail::send('mail.shortlist', $data, function($message) use ($asset_provider_detail) {
                $message->to($asset_provider_detail->email, $asset_provider_detail->applicant_name)->subject('Congratulations on shortlist status - Nyayomat ACP');
                $message->from('no-reply@nyayomat.com','Nyayomat');
                });
            }elseif($status == "suspend"){
                $data = array('name'=>$asset_provider_detail->shop_name, "date" => Carbon::now()->toFormattedDateString());
                Mail::send('mail.suspend', $data, function($message) use ($asset_provider_detail) {
                $message->to($asset_provider_detail->email, $asset_provider_detail->applicant_name)->subject('Account suspension status - Nyayomat ACP');
                $message->from('no-reply@nyayomat.com','Nyayomat');
                });
            }

            return back();

        }catch(Exception $ex){
            return back();
        }
    }

    public function getSubGroups(Request $request)
    {
        $data = SubGroup::where("tbl_acp_subgroup.group_id",$request->group_id)
                    ->join("tbl_acp_categories", "tbl_acp_categories.sub_group_id", "tbl_acp_subgroup.id")
                    ->distinct()
                    ->get(["tbl_acp_subgroup.id as id","sub_group_name"]);
         return response()->json($data);
    }


    public function getCategoriesBySubGroups(Request $request)
    {
        $data = Category::where("sub_group_id",$request->sub_group_id)
                    ->get(["id","category_name"]);
         return response()->json($data);
    }

}

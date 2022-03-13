<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\SubGroup;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::withCount("subGroup")->withCount("categories")->get();
        //return response()->json($groups);
        return view('superadmin.categories.index')->with("groups", $groups);
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
            "category_name" => "required",
        ]);
        try{
            $category = new Category();
            $category->group_id = $request->group_id;
            $category->sub_group_id = $request->sub_group_id;
            $category->category_name = $request->category_name;
            $category->description = $request->description;
            if($category->save()){
                return back()->withSuccess("Category added Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        if($type == 'group'){
            $data = Category::select("tbl_acp_categories.id","tbl_acp_categories.category_name","tbl_acp_groups.id as group_id", "tbl_acp_groups.group_name", 
                    "tbl_acp_subgroup.id as sub_group_id", "tbl_acp_subgroup.sub_group_name")
                    ->where("tbl_acp_categories.group_id", $id)
                    ->join("tbl_acp_groups", "tbl_acp_groups.id", "tbl_acp_categories.group_id")
                    ->join("tbl_acp_subgroup", "tbl_acp_subgroup.id", "tbl_acp_categories.sub_group_id")
                    ->get();
        }else{
            $data = Category::select("tbl_acp_categories.id","tbl_acp_categories.category_name","tbl_acp_groups.id as group_id", "tbl_acp_groups.group_name", 
                    "tbl_acp_subgroup.id as sub_group_id", "tbl_acp_subgroup.sub_group_name")
                    ->where("tbl_acp_categories.sub_group_id", $id)
                    ->join("tbl_acp_groups", "tbl_acp_groups.id", "tbl_acp_categories.group_id")
                    ->join("tbl_acp_subgroup", "tbl_acp_subgroup.id", "tbl_acp_categories.sub_group_id")
                    ->get();
        }

       
        return view('superadmin.categories.category')->with("data", $data);
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
     * Store a newly group created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGroup(Request $request)
    {
        $request->validate([
            "group_name" => "required",
            "status" => "required"
        ]);
        try{
            $group = new Group();
            $group->group_name = $request->group_name;
            $group->status = $request->status;
            $group->description = $request->description;
            if($group->save()){
                return redirect()->route('superadmin.categories')->withSuccess("Group added Successfully")->withInput();
            }else{
                return redirect()->route('superadmin.categories')->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return redirect()->route('superadmin.categories')->withError($ex->getMessage())->withInput();
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subGroupView($id)
    {
        $sub_groups = Group::where("id", $id)->with(["subGroup" => function ($query){
            $query->withCount("categories");
        }])->first();
       
        return view('superadmin.subgroup.index')
                ->with("sub_groups",$sub_groups);
    }

    /**
     * Store a newly sub group created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubGroup(Request $request)
    {
       
        $request->validate([
            "sub_group_name" => "required",
            "status" => "required"
        ]);
        try{
            $sub_group = new SubGroup();
            $sub_group->group_id = $request->group_id;
            $sub_group->sub_group_name = $request->sub_group_name;
            $sub_group->status = $request->status;
            $sub_group->description = $request->description;
            if($sub_group->save()){
                return back()->withSuccess("SubGroup added Successfully")->withInput();
            }else{
                return back()->withError("Something went wrong :(")->withInput();
            }
        }catch(Exception $ex){
            return back()->withError($ex->getMessage())->withInput();
        }
    }
}

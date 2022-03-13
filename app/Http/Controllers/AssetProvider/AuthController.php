<?php

namespace App\Http\Controllers\AssetProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetProvider;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{

    /**
     * Display a register request view.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerRequestView()
    {
        return view('assetprovider.auth.register');
    }


    /**
     * Display a login view.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginView()
    {
        return view('assetprovider.auth.login');
    }

    /**
     * Store Asset Provider Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerRequest(Request $request)
    {
        
        $request->validate([
            "applicant_name" => "required",
            "shop_name" => "required",
            "phone" => "required",
            "email" => "required|email|unique:tbl_acp_asset_providers,email",
            "county" => "required",
            "sub_county" => "required",
            "location" => "required"
        ]);

        try{
            $operating_days = array();
            $operating_days["monday"] = $request->monday;
            $operating_days["tuesday"] = $request->tuesday;
            $operating_days["wednesday"] = $request->wednesday;
            $operating_days["thursday"] = $request->thursday;
            $operating_days["friday"] = $request->friday;
            $operating_days["saturday"] = $request->saturday;
            $operating_days["sunday"] = $request->sunday;
            
            $asset_provider = new AssetProvider();
            $asset_provider->applicant_name = $request->applicant_name;
            $asset_provider->shop_name = $request->shop_name;
            $asset_provider->phone = $request->phone;
            $asset_provider->email = $request->email;
            $asset_provider->county = $request->county;
            $asset_provider->sub_county = $request->sub_county;
            $asset_provider->operating_days = $operating_days;
            $asset_provider->location = $request->location;

            if($asset_provider->save()){
                return redirect()->route('assetprovider.registerview')->withSuccess("Your request Successfully Submitted. We will send you a confirmation email once your request has been approved")->withInput();
            }else{
                return redirect()->route('assetprovider.registerview')->withError("Something went wrong with your request :(")->withInput();
            }

        }catch(Exception $ex){
            return redirect()->route('assetprovider.registerview')->withError($ex->getMessage())->withInput();
        }
        
    }


    public function checkLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $asset_provider = AssetProvider::where('email', $request->email)->first();
        if($asset_provider){
            if($asset_provider->password != null){
                if (Hash::check($request->password, $asset_provider->password)) {
                    if($asset_provider->status == "approved"){
                        session([
                            'asset_provider_id' => $asset_provider->id
                        ]);
                        return redirect()->route('assetprovider.dashboard');
                    }else{
                        return back()->withError("your account status is ".$asset_provider->status. ". Please contact your administrator")->withInput();
                    }
                }else{
                        return back()->withError("email or password is incorrect")->withInput();
                }
            }else{
                return back()->withError("you did not set your password please contact admin")->withInput();
            }
            
        }else{
            return back()->withError("email or password is incorrect")->withInput();
        }
    }

    public function setPasswordView($id)
    {
        $asset_provider = AssetProvider::where("id", decrypt($id))->first();

        if($asset_provider->password == null){
            return view('assetprovider.auth.set_password')->with("asset_provider", $asset_provider);
        }else{
            return redirect()->route('assetprovider.loginview')->withSuccess("You already set a password please login");
        }
        
    }

    public function setPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        try{
            $asset_provider = AssetProvider::where('id', decrypt($id))->first();
            if($asset_provider){
                $asset_provider->password = bcrypt($request->password);
                if($asset_provider->save()){
                    return redirect()->route('assetprovider.loginview');
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

    public function logout()
    {
        session()->forget('asset_provider_id');
        return redirect()->route('assetprovider.loginview');
    }

}

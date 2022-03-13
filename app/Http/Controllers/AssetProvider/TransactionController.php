<?php

namespace App\Http\Controllers\AssetProvider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetProvider;
use App\Models\AssetProviderTransaction;
use App\Models\AssetProviderWithdrawal;
use App\Http\Controllers\MPESA\MpesaController;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = AssetProviderTransaction::select("tbl_acp_asset_provider_transaction.*", "tbl_acp_assets.asset_name")
                            ->join("tbl_acp_assets", "tbl_acp_assets.id", "tbl_acp_asset_provider_transaction.asset_id")
                            ->where("tbl_acp_asset_provider_transaction.asset_provider_id", session("asset_provider_id"))
                            ->wherenotnull("paid_on")
                            ->get();
        return view('assetprovider.transaction.index')->with("transactions", $transactions);
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


    public function withDrawCash(Request $request)
    {
        $request->validate([
            "amount_withdraw" => "required|numeric|min:10",
        ]);
        
        try{
            $total_paid = AssetProviderTransaction::where("asset_provider_id", session("asset_provider_id"))->wherenotnull("paid_on")->sum("amount");
            $total_withdraw = AssetProviderWithdrawal::where("asset_provider_id", session("asset_provider_id"))->sum("amount_withdraw");
            $asset_provider_detail = AssetProvider::where("id", session("asset_provider_id"))->first();
            $balance = $total_paid - $total_withdraw;
            if($balance >= $request->amount_withdraw){
                $mpesa = new MpesaController();

                $request->merge([
                    'InitiatorName' => 'Developer3',
                    'SecurityCredential' => 'Maseno,.17',
                    'Occassion' => 'StallOwner',
                    'CommandID' => 'BusinessPayment',
                    'PartyA' => '309523',
                    'PartyB' => $asset_provider_detail->phone,
                    'Remarks' => 'Paid to '.$asset_provider_detail->shop_name,
                    'Amount' => $request->amount_withdraw,
                    'QueueTimeOutURL' => url('api/b2c/timeout'),
                    'ResultURL' => url('api/b2c/result'),
                    
                ]);
                
                $response = $mpesa->paymentRequest($request);
                
                $response = json_decode($response, true);
               
                if(isset($response["ResponseCode"])){
                    if($response["ResponseCode"] == "0"){
                        $withdraw_now = new AssetProviderWithdrawal();
                        $withdraw_now->asset_provider_id = session("asset_provider_id");
                        $withdraw_now->amount_withdraw = $request->amount_withdraw;
                        if($withdraw_now->save()){
                             return back()->withSuccess("Successfully withdrawn :)");
                        }else{
                            return back()->withError("Something went wrong");
                        }
                    }elseif($response["ResponseCode"] == "1"){
                        return back()->withError("The balance is insufficient for the transaction");
                    }elseif($response["ResponseCode"] == "2"){
                        return back()->withError("Declined due to limit rule: less than the minimum transaction amount.");
                    }
                }else{
                    return back()->withError("Something went wrong");
                }
                
            }else{
                return back()->withError("You have insufficient funds to withdraw");
            }

        }catch(Exception $e){
            return back()->withError("Something went wrong");
        }
    }
}

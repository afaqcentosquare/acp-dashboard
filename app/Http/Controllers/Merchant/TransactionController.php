<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MPESA\DepositController;
use App\Models\User;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('merchant.transaction.index');
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

    public function depositAmount(Request $request)
    {
        
        $request->validate([
            "deposit_amount" => "required|numeric|min:10",
        ]);

        $merchant = User::where('id', session('merchant_id'))->first();
        if($merchant){
            $request->merge([
                'Amount' => $request->deposit_amount,
                'PartyA' => '142392',
                'PhoneNumber' => $merchant->mobile,
                'TransactionDesc' => 'Deposit'
                
            ]);
            
            $mpesa = new DepositController();
    
            $response = $mpesa->lipaNaMpesa($request);
                    
            $response = json_decode($response, true);
           
            if(isset($response["ResponseCode"])){
                if($response["ResponseCode"] == "0"){
                        return back()->withSuccess("Once you authorize payment, kindly refresh the page to see the updated account balance.")->withInput();
                }else{
                    return back()->withError("Something went wrong")->withInput();
                }
            }else{
                return back()->withError("Something went wrong")->withInput();
            }
        }else{
            return back()->withError("Something went wrong")->withInput();
        }
    }
}

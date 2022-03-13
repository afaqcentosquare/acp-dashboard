@extends('assetprovider.master', 
                        [
                            'title' => __("Asset Provider Dashboard"),
                            'page_name' => 'Asset Provider Dashboard',
                            'bs_version' => 'bootstrap@4.6.0',
                            'left_nav_color' => 'lightseagreen',
                            'nav_icon_color' => '#fff',
                            'active_nav_icon_color' => '#fff',
                            'active_nav_icon_color_border' => 'greenyellow' ,
                            'top_nav_color' => '#F7F6FB',
                            'background_color' => '#F7F6FB',
                        ])

@push('link-css')
    {{-- <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <link href="{{asset('css/graphs.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.css" />
    @verbatim
        <style>
           

           
            /* test Graphs */
            .collapse{
                width: 100%;
            }

            .acp-text{
                color: lightseagreen;
            }
            .nyayomat-blue{
                color: #036CB1
            }
            .bg-nyayomat-blue{
                background-color: #036CB1
            }

            .height-cap {
                max-height: 15vh;
            }

            /* // Small devices (landscape phones, 576px and up) */
            @media (min-width: 350px) {
                .big-money {
                    font-size: 3.5vw;
                }
                
                h3 > small {
                    font-size: 2.0vw
                }
                .icon-size {
                    font-size: 3rem;
                }

                .display-4-mobile{
                    font-size: 3.5vh;
                }
            }

            /* // Medium devices (tablets, 768px and up) */
            @media (min-width: 768px) {  }

            /* // Large devices (desktops, 992px and up) */
            @media (min-width: 992px) { }

            /* // Extra large devices (large desktops, 1200px and up) */
            @media (min-width: 1200px) { 
                .big-money {
                    font-size: 1vw;
                }
                .chart-height{
                    height: 35vh;
                }
                h3 > small {
                    font-size: 2.0vw
                }

                .icon-size{
                    font-size: 4.0vh;
                }
            }
        </style>
    @endverbatim
@endpush

@push('link-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.3.0/snap.svg-min.js"></script>
@endpush


@push('navs')
@include('assetprovider.nav') 
@endpush



@section('content')
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="col-12 mt-2 mb-3 font-weight-light">
            <i class='bx bx-subdirectory-right mr-2 text-primary' style="font-size: 2.8vh;"></i>
            <a href="" class="text-muted mr-1">
                {{Str::ucfirst(config('app.name'))}}
            </a> /
            <a href="" class="text-muted ml-1">
                Dashboard
            </a>  /
            <a href="" class="text-primary ml-1">
                Asset Provider Dashboard
            </a> 
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    <br>
                    @endforeach
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-3">
        {{-- @include('layouts.alerts.success') --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2 class="font-weight-bold col-12">
                {{$asset_provider_detail->shop_name}}
            </h2>
            <span class="col-12">
                {{$asset_provider_detail->location}}, {{$asset_provider_detail->sub_county}} , {{$asset_provider_detail->county}}
            </span>
            <p class="col-12 mt-3">
                <span class="text-muted mr-2 font-weight-bold">
                    Contacts :
                </span>
                <a href="tel:+" class="mr-4">
                    <i class="bx bx-phone mr-1"></i> {{$asset_provider_detail->phone}}
                </a>
                <a href="mailto:+" class="">
                    <i class="bx bx-at mr-1"></i> {{$asset_provider_detail->email}}
                </a>
            </p>
            <br>
        </div>
        
        <div class="col-md-6 text-md-right">
            <h3 class="font-weight-bold text-muted col-12">
                Account Details
            </h3>
            <ul class="col-12 list-unstyled">
                <li>
                    Engaged Assets : &nbsp;
                    @php
                      $total_engage_assets = App\Models\MerchantAssetOrder::where("asset_provider_id",$asset_provider_detail->id)->groupBy("asset_id")->get();
                      $total_engage_assets_value = App\Models\Asset::where("tbl_acp_assets.asset_provider_id", $asset_provider_detail->id)
                                                                    ->join("tbl_acp_merchant_asset_order","tbl_acp_merchant_asset_order.asset_id","tbl_acp_assets.id")
                                                                    ->selectraw("tbl_acp_assets.id, sum(tbl_acp_merchant_asset_order.units * tbl_acp_assets.unit_cost) as total")
                                                                    ->first();
                      $account_balance = App\Models\AssetProviderWithdrawal::where("asset_provider_id", $asset_provider_detail->id)->sum("amount_withdraw");
                                                                                
                    @endphp
                    <span class="mr-3">
                        {{count($total_engage_assets)}}
                    </span>
                </li>
                <li>
                    Value of Engaged Assets : &nbsp;
                    Ksh.
                    <span class="mr-3">
                        {{number_format($total_engage_assets_value->total,2)}}
                    </span>
                </li>
                <li>
                    Total Received : &nbsp;
                    Ksh.
                    <span class="mr-3">
                        {{number_format($total_received_amount,2)}}
                    </span>
                </li>
                <li>
                    Total Outstanding : &nbsp;
                    Ksh.
                    <span class="mr-3">
                        {{number_format($total_out_standing_amount,2)}}
                    </span>
                </li>
                <li>
                    Account Balance : &nbsp;
                    Ksh.
                    
                    <span class="mr-3">
                        {{number_format($total_received_amount - $account_balance,2)}}
                    </span>
                </li>
                {{-- <li>
                    Next Receipt : &nbsp;
                    <span class="mr-3">
                        {{Carbon\Carbon::now("Africa/Nairobi")-> addDays(rand(10,20))->format('D , d - M - Y')}}
                    </span>
                </li> --}}

                <li>
                    <a data-toggle="modal" href="#withdraw" class="btn btn-sm btn-outline-info mr-3 mt-2">
                        <i class="bx bx-money mr-1"></i> Withdraw Cash
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                My Assets
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                Pending Approvals
            </a>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                Browse
            </a>
        </li> --}}
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">        
            <div class="row mt-4">
                <div class="col-12 mb-4">
                    <span class="font-weight-bold text-success mr-4">
                        @if($total_paid != null && $total_paid != 0 && $total_out_standing_amount != null && $total_out_standing_amount != 0)
                        Total Paid : {{number_format(($total_paid/($total_paid + $total_out_standing_amount))* 100,2)}} %
                        @else
                        Total Paid : 0 %
                        @endif
                    </span>
                    <span class="font-weight-bold text-secondary mr-4">
                        Engaged Assets : {{$products_engaged ? count($products_engaged) : 0}}
                    </span>
                    {{-- <span class="font-weight-bold text-secondary mr-4">
                        Idle Assets : 0
                    </span>
                    <span class="font-weight-bold text-danger mr-4">
                        Returned Assets : 0
                    </span> --}}
                </div>
                <div class="col-12 mb-4">

                    <span class="font-weight-bold text-muted mr-4">
                        D = Daily
                    </span>

                    <span class="font-weight-bold text-muted mr-4">
                        W = Weekly
                    </span>

                    <span class="font-weight-bold text-muted mr-4">
                        M = Monthly
                    </span>

                </div>
                <div class="col-12 table-responsive">
                    <table id="mytableID" class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    Name
                                </th>
                                <th nowrap>
                                    Units in Stock
                                </th>
                                
                                <th nowrap>
                                    Engaged Units
                                </th>
                                
                                <th nowrap class="">
                                    Holiday Period <br> <sub class="font-weight-normal">End Date</sub>
                                </th>
                                <th nowrap class="">
                                    Cost (Ksh)
                                </th>
                                <th nowrap>
                                    Installment <br> Amount (Ksh)
                                </th>
                               
                                <th nowrap>
                                    Next Receipt 
                                </th>
                                <th nowrap>
                                    Status
                                </th>
                                <th nowrap>
                                    Installments
                                </th>
                                <th nowrap>
                                    Total <br> Outstanding
                                    (Ksh)
                                </th>
                               
                                
                                <th nowrap>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="groupDescription">
                            @foreach ($approve_assets as $key => $approve_asset)
                            @php
                            $order_units = 0;
                            if(isset($approve_asset->orderAssets[0]->order_units)){
                                $order_units = $approve_asset->orderAssets[0]->order_units;
                            }
                            @endphp
                                <tr class="" style="">
                                    <td nowrap>
                                        
                                        {{$approve_asset->asset_name}}
                                    </td>
                                    <td nowrap>
                                        {{$approve_asset->units}}
                                    </td>
                                    @if($order_units != 0)
                                    <td nowrap>
                                     {{$order_units}}
                                    </td>
                                    @else
                                    <td nowrap>
                                     ---
                                    </td>
                                    @endif
                                    <td nowrap>
                                        {{Carbon\Carbon::now("Africa/Nairobi")->addDays($approve_asset->holiday_provision)->format('D , d - M - Y')}} 
                                    </td>
                                    <td nowrap>
                                        {{$approve_asset->unit_cost}}
                                    </td>
                                    @if($order_units != 0)
                                    <td nowrap>
                                        {{($approve_asset->unit_cost - $approve_asset->deposit_amount) / ($approve_asset->installment)}} - 
                                        
                                        @if ($approve_asset->payment_frequency == "Weekly")
                                        W
                                        @elseif ($approve_asset->payment_frequency == "Daily")
                                        D
                                        @elseif ($approve_asset->payment_frequency == "Monthly")
                                        M   
                                        @endif
                                    </td>
                                    <td nowrap>
                                        @if (isset($approve_asset->nextReceipt->due_date))
                                        {{Carbon\Carbon::parse($approve_asset->nextReceipt->due_date)->format('D , d - M - Y')}}  
                                        @else
                                        --
                                        @endif
                                    </td>
                                    <td nowrap>
                                        <div class="progress">
                                            @php
                                                $progress = (((($order_units * $approve_asset->unit_cost) - $approve_asset->total_out_standing_amount)/($order_units * $approve_asset->unit_cost))) * 100;
                                            @endphp
                                            {{-- @if($progress <= 0)
                                            <div class="progress-bar bg-danger" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            @elseif ($progress > 0 && $progress <=49) --}}
                                                <div class="progress-bar bg-success" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            {{-- @elseif ($progress >= 50 && $progress <=70)
                                            <div class="progress-bar bg-success" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            @else
                                            <div class="progress-bar bg-priamry" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            @endif    --}}
                                        </div>
                                    </td>
                                    <td nowrap>
                                        {{$approve_asset->transactions_count}} /
                                        {{$approve_asset->installment}}
                                    </td>
                                    <td nowrap>
                                        {{$approve_asset->total_out_standing_amount}}
                                    </td>
                                    @else
                                    <td nowrap>
                                      ---
                                    </td>
                                    <td nowrap>
                                      ---
                                    </td>
                                    <td nowrap>
                                      ---
                                    </td>
                                    <td nowrap>
                                      ---
                                    </td>
                                    <td nowrap>
                                      ---
                                    </td>
                                    @endif
                                    
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#restock_collapse{{$key}}" aria-expanded="false" aria-controls="restock_collapse{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-warning" style="font-size: .7rem">
                                            <i class="bx bx-up-arrow-alt  mr-1"></i> Restock
                                        </a>
                                        <br>
                                        
                                        <a  data-toggle="collapse" href="#transaction_collapse{{$key}}" aria-expanded="false" aria-controls="transaction_collapse{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary" style="font-size: .7rem">
                                            <i class="bx bx-hourglass  mr-1"></i> Transactions
                                        </a>
                                    </td>
                                </tr>
        
                                <tr id="restock_collapse{{$key}}" class="collapse" aria-labelledby="restock_collapse{{$key}}" data-parent="#groupDescription">
                                    <td colspan="11">
                                        <form action="{{route('assetprovider.productcatalog.update.stock',$approve_asset->id)}}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="inputEmail4">
                                                        Number of Units 
                                                    </label>
                                                    <input type="number" autocomplete="off" class="form-control" name="units">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <button type="submit" class="btn btn-outline-success col-12">
                                                    Add Stock
                                                </button>
                                            </div>
                                        </form>
                                        
                                    </td>
                                </tr>
                                <tr id="transaction_collapse{{$key}}" class="collapse" aria-labelledby="transaction_collapse{{$key}}" data-parent="#groupDescription">
                                    <td colspan="11">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-dark custom-radius">
                                                
                                                <thead class="nyayomat-blue">
                                                    <tr>
                                                        <th>
                                                            Transaction ID
                                                        </th>
                                                        <th>
                                                            Transaction Date
                                                        </th>
                                                        <th>
                                                            Amount  <small>Ksh</small>
                                                        </th>
                                                        <th nowrap>
                                                            Installment Number
                                                        </th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($approve_asset->transactions as $key => $transaction)    
                                                    <tr>
                                                        <td nowrap>
                                                            {{$transaction->id}}
                                                        </td>
                                                        <td nowrap>
                                                            {{Carbon\Carbon::parse($transaction->paid_on)->format('D , d - M - Y')}}
                                                        </td>
                                                        <td nowrap>
                                                            {{number_format($transaction->amount,2)}}
                                                        </td>
                                                        <td nowrap>
                                                            {{count($approve_asset->transactions) - $key}} / {{$approve_asset->installment}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                              
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            ...
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row mt-4">
                <div class="col-12 mb-4">

                    <span class="font-weight-bold text-muted mr-4">
                        D = Daily
                    </span>

                    <span class="font-weight-bold text-muted mr-4">
                        W = Weekly
                    </span>

                    <span class="font-weight-bold text-muted mr-4">
                        M = Monthly
                    </span>

                </div>
                @if(count($pending_assets) > 0)
                <div class="col-12 text-right">
                    <a  data-toggle="modal" href="#application" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary" style="font-size: .7rem">
                        <i class="bx bx-check-double  mr-1"></i> Approve All
                    </a>
                </div>
                @endif
                <div class="col-12 table-responsive">
                    <table id="mytableID" class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    Image
                                </th>
                                <th nowrap>
                                    Name
                                </th>
                                <th nowrap>
                                    Units
                                </th>
                                <th nowrap class="">
                                    Holiday Period <br> <sub class="font-weight-normal">Days</sub>
                                </th>
                                <th nowrap class="">
                                    Unit Cost (Ksh)
                                </th>
                                <th nowrap class="">
                                    Deposit <br> Amount (Ksh)
                                </th>
                                <th nowrap>
                                    Installment <br> Amount (Ksh)
                                </th>
                                <th nowrap>
                                   No of Installments <br>(Per Unit)
                                </th>
                                <th nowrap>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="groupDescription">
                            @foreach ($pending_assets as $key => $pending_asset)
                                <tr class="" style="">
                                    <td nowrap>
                                        <img src="{{ asset($pending_asset->image)}}" width="50px" height="30px"/>
                                    </td>
                                    <td nowrap>
                                        {{$pending_asset->asset_name}}
                                    </td>
                                    <td nowrap>
                                        {{$pending_asset->units}}
                                    </td>
                                    <td nowrap>
                                        {{$pending_asset->holiday_provision}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($pending_asset->unit_cost,2)}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($pending_asset->deposit_amount,2)}}
                                    </td>
                                    <td nowrap>
                                        {{number_format(($pending_asset->unit_cost - $pending_asset->deposit_amount)/($pending_asset->installment),2)}} - 
                                        
                                        @if ($pending_asset->payment_frequency == "Weekly")
                                        W
                                        @elseif ($pending_asset->payment_frequency == "Daily")
                                        D
                                        @elseif ($pending_asset->payment_frequency == "Monthly")
                                        M 
                                        @endif
                                    </td>
                                    <td nowrap>
                                        {{$pending_asset->installment}} 
                                    </td>
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success" style="font-size: .7rem">
                                            <i class="bx bx-check  mr-1"></i> Approve
                                        </a>
                                    </td>
                                </tr>
        
                                <tr id="collapse{{$key}}" class="collapse" aria-labelledby="collapse{{$key}}" data-parent="#groupDescription">
                                    <td colspan="8">
                                        <p class="">
                                            Are you sure you want to approve this asset ?
                                        </p>
                                        <a href="{{route('assetprovider.productcatalog.update.status',[$pending_asset->id,1])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('collapse{{$key}}')" class="btn btn-sm btn-outline-danger">
                                            No
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    
    {{-- Start Application --}}
    <div class="modal fade" id="application"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">
                        Bulk Approval
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="row">
                        <p class="col-12">        
                            You are about approve multiple items, Are you sure you wish to proceed
                        </p>
                        <p class="col-12">
                        </p>
                        <p class="col-12">
                            <a href="{{route('assetprovider.productcatalog.update.status',[$asset_provider_detail->id,0])}}" class="btn h5 btn-sm btn-outline-success">
                                Yes, Proceed
                            </a>

                            <a class="btn h5 btn-sm btn-outline-danger">
                                Cancel
                            </a>
                        </p>
                   </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Application --}}


     {{-- Withdraw Start --}}
     <div class="modal fade" id="withdraw"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
           
            <div class="modal-content border-0 shadow-lg">
                <form method="post" action="{{route('assetprovider.withdraw.amount')}}">
                    @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">
                        Withdraw Cash
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                   <div class="row">
                        <div class="col-12">
                            <input type="number" name="amount_withdraw" class="form-control" placeholder="Enter withdrawal amount here..."/>
                        </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <button  class="btn h5 btn-sm btn-outline-success">
                            Yes, Proceed
                        </button>
                        <a class="btn h5 btn-sm btn-outline-danger">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
            </div>
            
        </div>
    </div>
    {{-- Withdraw End --}}

@endsection

@push('scripts')

    <script>
        var checkboxes = $("input[type='checkbox']"),
        submitButt = $("button[type='submit']");
        checkboxes.click(function() {
            submitButt.attr("disabled", !checkboxes.is(":checked"));
        });
    </script>
    <script>
        var active_accounts = [...Array(10)].map(() => Math.floor(Math.random() * 950));       
        var applications = [...Array(10)].map(() => Math.floor(Math.random() * 1550));
        var suspended_accounts = [...Array(10)].map(() => Math.floor(Math.random() * 20));
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sept",
                            "Oct"],
                datasets: [{
                    label: 'Active', // Name the series
                    data: active_accounts, // Specify the data values array
                    fill: false,
                    borderColor: '#4CAF507B', // Add custom color border (Line)
                    backgroundColor: '#4CAF507B', // Add custom color background (Points and Fill)
                    borderWidth: 3 ,// Specify bar border width
                    tension: 0.3
                },
                {
                    label: 'Applications', // Name the series
                    data: applications, // Specify the data values array
                    fill: false,
                    borderColor: '#036CB17B', // Add custom color border (Line)
                    backgroundColor: '#036CB17B', // Add custom color background (Points and Fill)
                    borderWidth: 3 ,// Specify bar border width
                    tension: 0.2
                },
                {
                    label: 'Suspended', // Name the series
                    data: suspended_accounts, // Specify the data values array
                    fill: false,
                    borderColor: '#ff00007B', // Add custom color border (Line)
                    backgroundColor: '#ff00007B', // Add custom color background (Points and Fill)
                    borderWidth: 3 ,// Specify bar border width
                    tension: 0.2
                },]
            },
            options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
            }
        });
    </script>
    {{-- Parent Child Selects --}}
    <script>
        function filterChild(){
            var parent =  $(this).val();
            var child = $('#child-select');
        
            child.find('option').each(function(){
                $(this).toggle($(this).hasClass(parent));
            });
           child.val('');
        }

        $(document).ready(filterChild);
        $('#parent-select').on('change', filterChild);
    </script>
    <script>
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
              
              $(document).ready(function() {
                  $(".sampleTable").fancyTable({
                    /* Column number for initial sorting*/
                     sortColumn:0,
                     /* Setting pagination or enabling */
                     pagination: true,
                     /* Rows per page kept for display */
                     perPage:3,
                     globalSearch:true
                     });
                                
              });
          </script>
    </script>
    <script>
        function filterChild(){
            var child =  $(this).val();
            var grand_child = $('#grand-child-select');
        
            child.find('option').each(function(){
                $(this).toggle($(this).hasClass(child));
            });
           child.val('');
        }

        $(document).ready(filterGrandChild);
        $('#child-select').on('change', filterGrandChild);
    </script>
@endpush

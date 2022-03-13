@extends('superadmin.master', 
                        [
                            'title' => __("Performance"),
                            'page_name' => 'Performance',
                            'bs_version' => 'bootstrap@4.6.0',
                            'left_nav_color' => 'lightseagreen',
                            'nav_icon_color' => '#fff',
                            'active_nav_icon_color' => '#fff',
                            'active_nav_icon_color_border' => 'greenyellow' ,
                            'top_nav_color' => '#F7F6FB',
                            'background_color' => '#F7F6FB',
                        ])

@push('link-css')
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    @verbatim
        <style>
            .collapse{
                width: 100%
            }

            .nyayomat-blue{
                color: #036CB1
            }
            .bg-nyayomat-blue{
                background-color: #036CB1
            }
            /* // Small devices (landscape phones, 576px and up) */
            @media (min-width: 350px) {
                .big-money {
                    font-size: 4vw;
                }
                
                h3 > small {
                    font-size: 2.0vw
                }
                .icon-size {
                    font-size: 3rem;
                }
            }

            /* // Medium devices (tablets, 768px and up) */
            @media (min-width: 768px) {  }

            /* // Large devices (desktops, 992px and up) */
            @media (min-width: 992px) { }

            /* // Extra large devices (large desktops, 1200px and up) */
            @media (min-width: 1200px) { 
                .big-money {
                    font-size: 2vw;
                }
                
                h3 > small {
                    font-size: 2.0vw
                }
                .icon-size {
                    font-size: 3rem;
                }
                .icon-size{
                    font-size: 7.0vh;
                }
            }
        </style>
    @endverbatim
@endpush

@push('navs')
@include('superadmin.nav') 
@endpush

@push('link-js')
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="col-12 mt-2 mb-3 font-weight-light">
            <i class='bx bx-subdirectory-right mr-2 text-primary' style="font-size: 2.8vh;"></i>
            <a href="" class="text-muted mr-1">
                {{Str::ucfirst(config('app.name'))}}
            </a> /
            <a href="" class="text-primary ml-1">
                Performance
            </a>  
        </div>
    </div>
    
    <ul class="nav nav-pills nav-list mb-3" id="pills-tab" role="tablist">
        <li class="nav-item mr-2" role="presentation">
            <a class="nav-link active" id="pills-merchants-tab" data-toggle="pill" href="#pills-merchants" role="tab" aria-controls="pills-merchants" aria-selected="true">
                Merchants
            </a>
        </li>
        <li class="nav-item mr-5" role="presentation">
            <a class="nav-link" id="pills-customers-tab" data-toggle="pill" href="#pills-customers" role="tab" aria-controls="pills-customers" aria-selected="false">
                Defaulters
            </a>
        </li>
        {{-- <li class="nav-item mr-5" role="presentation">
            <a class="nav-link" id="pills-blacklist-tab" data-toggle="pill" href="#pills-blacklist" role="tab" aria-controls="pills-blacklist" aria-selected="false">
                Blacklist
            </a>
        </li> --}}
        <li class="nav-item mr-2" role="presentation">
            <a class="nav-link" id="pills-asset_providers-tab" data-toggle="pill" href="#pills-asset_providers" role="tab" aria-controls="pills-asset_providers" aria-selected="false">
                Asset Providers
            </a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-merchants" role="tabpanel" aria-labelledby="pills-merchants-tab" style="">
            <div class="row">
                <div class="col mb-4 text-left">
                    <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bx bx-link-external mr-2"></i>  Export Information
                    </a>
                </div>
                <div class="collapse col-12 mb-4" id="collapseExample">
                    <span class="text-uppercase font-weight-bold">
                        Select Method :
                    </span>
                    <br class="mb-2">
                    <a nowrap href="" class="mr-2  nyayomat-blue mx-3">
                        <i class="bx bxs-file-pdf"></i> Portable Document Format <code>(PDF)</code>
                    </a>
                    <a nowrap href="" class="mr-2 nyayomat-blue mx-3">
                        <i class="bx bx-spreadsheet"></i> Excel
                    </a>

                    <a nowrap href="" class="mr-2 nyayomat-blue mx-3">
                        <i class="bx bx-spreadsheet"></i> Comma Separated Values <code>(CSV)</code>
                    </a>

                    <a nowrap href="" class="mr-2 nyayomat-blue mx-3">
                        <i class="bx bx-printer"></i> Print
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th class="font-weight-normal">
                                    Name
                                </th>
                                <th class="font-weight-normal">
                                    Assets Engaged
                                </th>
                                <th nowrap class="font-weight-normal">
                                    T. Due <sub>Ksh</sub>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    T. Pending <sub>Ksh</sub>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    T. Overdue <sub>Ksh</sub>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    T. Past Overdue <sub>Ksh</sub>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    T. Defaulted <sub>Ksh</sub>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    Phone
                                </th>
                                <th nowrap class="font-weight-normal">
                                    Rating
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products_engaged as $products_engage)
                            @php
                                $today_date = Carbon\Carbon::now("Africa/Nairobi")->toDateString();
                               
                                $transactions = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                ->wherenull("paid_on")
                                ->groupBy("asset_id")
                                ->selectRaw("asset_id, count(*) as total_due_count")
                                ->where("due_date", "<=", $today_date)
                                ->get();

                                $total_due_id = array();
                                foreach ($transactions as $transaction) {
                                    if($transaction->total_due_count == 1){
                                        $total_due_id[] = $transaction->asset_id;
                                    }
                                }            
                                $total_due_amount = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_due_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");


                                $total_pending_id = array();
                                foreach ($transactions as $transaction) {
                                    if($transaction->total_due_count >= 1){
                                        $total_pending_id[] = $transaction->asset_id;
                                    }
                                }            
                                $total_pending_amount = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_pending_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");
                                
                                $total_over_due_id = array();
                                foreach ($transactions as $transaction) {
                                    if($transaction->total_due_count >= 2){
                                        $total_over_due_id[] = $transaction->asset_id;
                                    }
                                }            
                                $total_over_due_amount = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_over_due_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");

                                $total_past_over_due_id = array();
                                foreach ($transactions as $transaction) {
                                    if($transaction->total_due_count >= 3){
                                        $total_past_over_due_id[] = $transaction->asset_id;
                                    }
                                }            
                                $total_past_over_due_amount = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_past_over_due_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");


                                $total_defaulted_id = array();
                                foreach ($transactions as $transaction) {
                                    if($transaction->total_due_count >= 4){
                                        $total_defaulted_id[] = $transaction->asset_id;
                                    }
                                }            
                                $total_defaulted_amount =  App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_defaulted_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");
                            @endphp
                            <tr class="accordion" id="accordionExample2">
                                    <td nowrap class="text-uppercase">
                                        <a href="{{route('superadmin.redirect.merchant', $products_engage->merchant_id)}}" class="">
                                            {{$products_engage->name}}
                                        </a>
                                    </td>
                                    <td nowrap>
                                        {{$products_engage->total_engaged}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($total_due_amount,2)}}
                                    </td>
                                    
                                    <td nowrap>
                                        {{number_format($total_pending_amount,2)}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($total_over_due_amount,2)}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($total_past_over_due_amount,2)}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($total_defaulted_amount,2)}}
                                    </td>        
                                    <td nowrap>
                                        {{$products_engage->mobile}}
                                    </td>
                                    {{-- @if ($rank % 9 == 0)
                                        <td nowrap class="font-weight-light bg-warning">
                                            {{
                                                $rank
                                            }}
                                        </td>
                                    @endif
                                    @if ($rank % 11 == 0)
                                        <td nowrap class="font-weight-light bg-danger">
                                            {{
                                                $rank
                                            }}
                                        </td>
                                        @endif --}}
                                        <td nowrap class="font-weight-light">
                                            0
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="pills-asset_providers" role="tabpanel" aria-labelledby="pills-asset_providers-tab">
            
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-listed" role="tabpanel" aria-labelledby="pills-listed-tab" style="">
                    <div class="row mb-4">
                        <div class="col-md-7 col-0 d-none d-md-block">
                            <input type="text" id="myInput" class="form-control col-12" onkeyup="myFunction()" placeholder="Find Asset Provider.." title="Type in a name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal">
                                            Name
                                        </th>
                                        {{-- <th nowrap class="font-weight-normal">
                                            Location(s)
                                        </th> --}}
                                        <th nowrap class="font-weight-normal">
                                            Assets
                                        </th>
                                        <th nowrap class="font-weight-normal">
                                            T. Assets Value
                                            <sub class="">
                                                Ksh
                                            </sub>
                                        </th>
                                        <th nowrap class="font-weight-normal">
                                            Engaged Assets
                                        </th>
                                        <th nowrap class="font-weight-normal">
                                            T. Engaged Assets Value
                                            <sub class="">
                                                Ksh
                                            </sub>
                                        </th>
                                        <th class="font-weight-normal">
                                            Rating
                                        </th>
                                        <th class="font-weight-normal">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset_providers as $key => $asset_provider)
                                        @php
                                            $total_assets = App\Models\Asset::where("asset_provider_id", $asset_provider->id)->count();
                                            $total_assets_value = App\Models\Asset::where("asset_provider_id", $asset_provider->id)
                                                                                ->selectRaw("asset_provider_id,sum(units*unit_cost) as total")
                                                                                ->first();
                                            $asset_engaged = App\Models\MerchantAssetOrder::where("asset_provider_id", $asset_provider->id)
                                                ->where("status", "delivered")
                                                ->groupBy("asset_id")
                                                ->get();

                                            $total_engaged_asset_value = App\Models\Asset::where("tbl_acp_assets.asset_provider_id", $asset_provider->id)
                                                ->join("tbl_acp_merchant_asset_order","tbl_acp_merchant_asset_order.asset_id","tbl_acp_assets.id")
                                                ->where("tbl_acp_merchant_asset_order.status", "delivered")
                                                ->selectRaw("tbl_acp_assets.asset_provider_id,sum(tbl_acp_merchant_asset_order.units*tbl_acp_assets.unit_cost) as total")
                                                ->first();
                                        @endphp
                                        <tr class="accordion" id="accordionExample2">
                                            <td nowrap class="text-uppercase">
                                                <a href="{{route('superadmin.redirect.assetprovider', $asset_provider->id)}}" class="">
                                                    {{$asset_provider->shop_name}}
                                                </a>
                                               
                                            </td>
                                            {{-- <td>
                                                {{$total_assets}}
                                            </td> --}}
                                            <td nowrap>
                                                {{$total_assets}}
                                            </td>
                                            <td nowrap>
                                                {{number_format($total_assets_value->total,2)}}
                                            </td>
                                            <td nowrap>
                                                {{count($asset_engaged)}}
                                            </td>

                                            <td nowrap>
                                                {{number_format($total_engaged_asset_value->total,2)}}
                                            </td>
                
                                            <td nowrap class="font-weight-light">
                                                {{
                                                    5
                                                }}
                                            </td>
                                            <td nowrap>
                                                <a href="#providerModal{{$key}}" data-toggle="modal" class="btn btn-sm btn-warning">
                                                    Suspend A / C
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
        </div>

        <div class="tab-pane fade" id="pills-customers" role="tabpanel" aria-labelledby="pills-customers-tab">
            <div class="row mb-4">
                <div class="col-md-7 col-0 d-none d-md-block">
                    <input type="text" id="myInput" class="form-control col-12" onkeyup="myFunction()" placeholder="Find Customer.." title="Type in a name">
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    Merchant Name  
                                </th>
                                <th nowrap>
                                    Merchant Phone
                                </th>
                                <th nowrap>
                                    Merchant Mail
                                </th>
                                <th nowrap>
                                    Engaged Assets
                                </th>
                                <th nowrap>
                                    Defaulted Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products_engaged as $products_engage)
                                    @php
                                    $today_date = Carbon\Carbon::now("Africa/Nairobi")->toDateString();
                                    $transactions = App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                    ->wherenull("paid_on")
                                    ->groupBy("asset_id")
                                    ->selectRaw("asset_id,merchant_id, count(*) as total_due_count")
                                    ->where("due_date", "<=", $today_date)
                                    ->get();
                                    
                                    $isDefaulted = false;
                                    $total_defaulted_id = array();
                                    foreach ($transactions as $transaction) {
                                        if($transaction->total_due_count >= 1){
                                            $total_defaulted_id[] = $transaction->asset_id;
                                            $isDefaulted = true;
                                        }
                                    }            
                                    $merchant = App\Models\User::where("id", $products_engage->merchant_id)->first();

                                    $products_engaged = App\Models\MerchantAssetOrder::where("merchant_id",$products_engage->merchant_id)
                                                            ->where("status", "delivered")
                                                            ->groupBy("asset_id")
                                                            ->get();
                                    $total_defaulted_amount =  App\Models\MerchantTransaction::where("merchant_id", $products_engage->merchant_id)
                                                                        ->whereIn("asset_id", $total_defaulted_id)
                                                                        ->where("due_date", "<=", $today_date)
                                                                        ->wherenull("paid_on")
                                                                        ->sum("amount");

                                    
                                @endphp
                                @if($isDefaulted)
                                    <tr>
                                        <td>
                                            <a href="">
                                                <ul class="list-unstyled">
                                                    <li class="font-weight-bold">
                                                        <a href="{{route('superadmin.defaulter.merchant', $products_engage->merchant_id)}}" class="">
                                                            {{$merchant->name}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </a>
                                        </td>
                                        <td>
                                            {{$merchant->mobile}}
                                        </td>
                                        <td>
                                            {{$merchant->email}}
                                        </td>
                                        <td>
                                            {{count($products_engaged)}}
                                        </td>
                                        <td>
                                            {{number_format($total_defaulted_amount,2)}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="modal fade" id="merchanModal" data-backdrop="" data-keyboard="false" tabindex="-1" aria-labelledby="merchanModalLabel" aria-hidden="true" style="width: 100%">
        <div class="modal-dialog modal-dialog-centered " style="width: 100%">
            <div class="modal-content border-0 shadow-lg bg-nyayomat-blue">
                <div class="modal-header border-0 text-white">
                    <h5 class="modal-title font-weight-bold text-warning" id="merchanModalLabel">
                        Verification Requried
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="bx bx-x text-white "></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <div class="row">
                        <p class="col-12">
                            You're about to suspend this account.
                            <br>
                            Do you wish to proceed ?
                        </p>
                        <div class="col-12 text-right font-weight-bolder shadow-md">
                            <a href="" class="btn btn-sm btn-warning nyayomat-blue font-weight-bold text-uppercase">
                                Confirm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @foreach ($asset_providers as $key => $asset_provider)
    <div class="modal fade" id="providerModal{{$key}}" data-backdrop="" data-keyboard="false" tabindex="-1" aria-labelledby="providerModalLabel" aria-hidden="true" style="width: 100%">
        <div class="modal-dialog modal-dialog-centered " style="width: 100%">
            <div class="modal-content border-0 shadow-lg bg-nyayomat-blue">
                <div class="modal-header border-0 text-white">
                    <h5 class="modal-title font-weight-bold text-warning" id="providerModalLabel">
                        Verification Requried
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="bx bx-x text-white"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <div class="row">
                        <p class="col-12">
                            You're about to suspend this account.
                            <br>
                            Do you wish to proceed ?
                        </p>
                        <div class="col-12 text-right font-weight-bolder shadow-md">
                            <a href="{{route('superadmin.update.assetprovider.status',["id" => $asset_provider->id, "status" => "suspend"])}}" class="btn btn-sm btn-warning nyayomat-blue font-weight-bold text-uppercase">
                                Confirm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
@endpush
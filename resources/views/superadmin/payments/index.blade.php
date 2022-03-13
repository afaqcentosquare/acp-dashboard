@extends('superadmin.master', 
                        [
                            'title' => __("Payment Manager"),
                            'page_name' => 'Payment Manager',
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <link href="{{asset('css/graphs.css')}}" rel="stylesheet">

    @verbatim
        <style>
            /* test Graphs */
            .nav {
                height: 100%;
                display: flex;
                flex-direction: row;
                justify-content: start;
                overflow: hidden;
            }
            .nyayomat-blue{
                color: #036CB1
            }
            .bg-nyayomat-blue{
                background-color: #036CB1
            }

            .bg-danger{
                background-color: #dc3546 !important;             
            }

            .bg-success{
                background-color: #28a746e2 !important;                  
            }
            @media (max-width: 768px) { 
                .chart-height{
                    min-height: 25vh ;
                }
            }
            @media (min-width: 768px) { 
                .chart-height{
                    min-height: 35vh ;
                }
            }
        </style>
    @endverbatim
@endpush

@push('link-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
@endpush

@push('navs')
@include('superadmin.nav') 
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
                Payment Manager
            </a>  
        </div>
    </div>
    
        {{-- Cards --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="progress">
                    @php
                    $covered_payment_per = 0;
                    $fullfilled_payment_per = 0;
                    $fullfilled_payment = 0;
                    if($total_covered != 0 && $total_covered != null && $provider_asset_value->total_assets_value != 0 && $provider_asset_value->total_assets_value != null){
                        $covered_payment_per = ($total_covered/$provider_asset_value->total_assets_value)*100;
                    }
                    if($total_fullfilled != 0 && $total_fullfilled != null && $merchant_asset_value->total_assets_value != 0 && $merchant_asset_value->total_assets_value != null){
                        $fullfilled_payment_per = ($total_fullfilled/$merchant_asset_value->total_assets_value)*100;
                    }
                    @endphp
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{$covered_payment_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        Covered Payments
                    </div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$fullfilled_payment_per}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        Fulfilled Payments
                    </div>
                </div>
            </div>
            <div class="col-6 text-center text-danger mt-3">
                <div class="row">
                    <h6 class="col-12" style="font-size: 15px">
                        Covered Payments
                    </h6>
                    <h3 class="col-12">
                        <sub>
                            Ksh.
                        </sub>
                        {{number_format($total_covered,2)}}
                    </h3>
                </div>
            </div>
            <div class="col-6 text-center text-success mt-3 ">
                <div class="row">
                    <h6 class="col-12" style="font-size: 15px">
                        Fulfilled  Payments
                    </h6>
                    <h3 class="col-12">
                        <sub>
                            Ksh.
                        </sub>
                        {{number_format($total_fullfilled,2)}}
                    </h3>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-3">
            <div class="col-12 table-responsive">
                <table class="table custom-radius">
                    <thead>
                        <tr>
                            <th nowrap>
                                
                            </th>
                            <th nowrap>
                                Jan
                            </th>
                            <th nowrap>
                                Feb 
                            </th>
                            <th nowrap>
                                Mar
                            </th>
                            <th nowrap>
                                Apr
                            </th>
                            <th nowrap>
                                May
                            </th>
                            <th nowrap>
                                Jun
                            </th>
                            <th nowrap>
                                Jul
                            </th>
                            <th nowrap>
                                Aug
                            </th>
                            <th nowrap>
                                Sep
                            </th>
                            <th nowrap>
                                Oct
                            </th>
                            <th nowrap>
                                Nov
                            </th>
                            <th nowrap>
                                Dec
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr style="color: #3daf59">
                            <td nowrap>
                                <span>
                                    Fulfilled
                                </span>
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_jan,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_feb,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_march,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_april,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_may,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_june,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_july,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_aug,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_sep,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_oct,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_nov,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($fullfilled_dec,2)}}
                            </td>
                        </tr>
                        <tr style="color: #dc3546">
                            <td nowrap>
                                <span>
                                    Covered
                                </span>
                            </td>
                            <td nowrap>
                                {{number_format($covered_jan,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_feb,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_march,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_april,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_may,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_june,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_july,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_aug,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_sep,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_oct,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_nov,2)}}
                            </td>
                            <td nowrap>
                                {{number_format($covered_dec,2)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row mt-4">  
            <h5 class="col-12 nyayomat-blue">
                Payments
            </h5>
        </div>
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                    Fulfilled Payments
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                    Covered Payments
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row mt-4">
                    <div class="col-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th nowrap>
                                        Merchant Name
                                    </th>
                                    <th nowrap >
                                        Transaction ID
                                    </th>
                                    <th nowrap>
                                        Date
                                    </th>
                                    <th nowrap>
                                        Product Name
                                    </th>
                                    <th nowrap>
                                        Type
                                    </th>
                                    <th nowrap>
                                        Amount <small>Ksh</small>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fullfilled_payments as $fullfilled_payment)
                                <tr>
                                    <td nowrap>
                                        <ul class="list-unstyled">
                                            <li class="font-weight-bold">
                                                {{$fullfilled_payment->name}}
                                            </li>
                                        </ul>
                                    </td>
                                    <td nowrap>
                                        {{$fullfilled_payment->id}}
                                    </td>
                                    <td nowrap>
                                        {{Carbon\Carbon::parse($fullfilled_payment->paid_on)->format('D , d - M - Y')}}
                                    </td>
                                    <td nowrap>
                                        {{$fullfilled_payment->asset_name}}
                                    </td>
                                    <td nowrap>
                                        {{$fullfilled_payment->type}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($fullfilled_payment->amount,2)}}
                                    </td>
                                    
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row mt-4">
                    <div class="col-6 nyayomat-blue">
                        Due Today : <small class="ml-3">Ksh</small> <span class="h5">{{number_format($due_today,2)}}</span>
                    </div>
                    {{-- <div class="col-6 mb-4 text-right">
                        <a href="" class="btn btn-sm shadow bg-nyayomat-blue text-white">
                            Make Payment
                        </a>
                    </div> --}}
                    <div class="col-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th nowrap>
                                        Asset Provider
                                    </th>
                                    <th nowrap >
                                        Transaction ID
                                    </th>
                                    <th nowrap>
                                        Date
                                    </th>
                                    <th nowrap>
                                        Product
                                    </th>
                                    <th nowrap>
                                        Type
                                    </th>
                                    <th nowrap>
                                        Amount <small>Ksh</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($covered_payments as $covered_payment)
                                <tr>
                                    <td nowrap>
                                        <ul class="list-unstyled">
                                            <li class="font-weight-bold">
                                                {{$covered_payment->shop_name}}
                                            </li>
                                        </ul>
                                    </td>
                                    <td nowrap>
                                        {{$covered_payment->id}}
                                    </td>
                                    <td nowrap>
                                        {{Carbon\Carbon::parse($covered_payment->paid_on)->format('D , d - M - Y')}}
                                    </td>
                                    <td nowrap>
                                        {{$covered_payment->asset_name}}
                                    </td>
                                    <td nowrap>
                                        {{$covered_payment->type}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($covered_payment->amount,2)}}
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
          

@endsection
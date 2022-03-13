@extends('superadmin.master', 
                        [
                            'title' => __("Asset Providers"),
                            'page_name' => 'Asset Providers',
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
            <a href="" class="text-muted ml-1">
                Dashboard
            </a>  /
            <a href="" class="text-primary ml-1">
                Asset Providers
            </a>  
        </div>
    </div>
    <div class="row mt-3">
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
    {{-- <div class="row mt-3 mb-5">
        <div class="col-12">
            <div class=" shadow custom-radius p-2 py-4">
                <canvas id="myChart" class="chart-height" ></canvas>
            </div>
        </div>
    </div> --}}
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="true">
                Approved
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="applications-tab" data-toggle="tab" href="#applications" role="tab" aria-controls="applications" aria-selected="false">
                Applications
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="shortlist-tab" data-toggle="tab" href="#shortlist" role="tab" aria-controls="shortlist" aria-selected="false">
                Shortlist
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="suspend-tab" data-toggle="tab" href="#suspend" role="tab" aria-controls="suspend" aria-selected="false">
                Suspended
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="approved" role="tabpanel" aria-labelledby="approved-tab">        
            <div class="row">
                <div class="col my-2 text-left">
                    <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExampleApproved" role="button" aria-expanded="false" aria-controls="collapseExampleApproved">
                        <i class="bx bx-link-external mr-2"></i>  Export Information
                    </a>
                </div>
                <div class="collapse col-12 mb-1 text-dark" id="collapseExampleApproved">
                    <span class="text-uppercase font-weight-bold">
                        Select Method :
                    </span>
                    <br class="mb-2">
                    <a nowrap href="" class="mr-2  nyayomat-blue mr-3">
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
            <div class="row mt-4">
                <div class="col-12 table-responsive">
                    <table id="mytableID" class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    
                                </th>
                                <th nowrap>
                                    @sortablelink('name',"Name",['filter' => 'active, visible'],['class' => 'text-dark font-weight-normal'])<i class='bx bx-sort ml-1' style="font-size:.7rem" ></i>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    Contacts
                                </th>
                                <th nowrap class="font-weight-normal">
                                    Assets
                                </th>
                                <th nowrap>
                                    @sortablelink('county',"County",['filter' => 'active, visible'],['class' => 'text-dark font-weight-normal']) <i class='bx bx-sort ml-1' style="font-size:.7rem" ></i>
                                </th>
                                <th nowrap>
                                    @sortablelink('sub_county', "Sub County",['filter' => 'active, visible'],['class' => 'text-dark font-weight-normal'])<i class='bx bx-sort ml-1' style="font-size:.7rem" ></i>
                                </th>
                                <th nowrap>
                                    @sortablelink('location',"Location",['filter' => 'active, visible'],['class' => 'text-dark font-weight-normal'])<i class='bx bx-sort ml-1' style="font-size:.7rem" ></i>
                                </th>
                                <th nowrap>
                                    @sortablelink('created_at',"Joined",['filter' => 'active, visible'],['class' => 'text-dark font-weight-normal'])<i class='bx bx-sort ml-1' style="font-size:.7rem" ></i>
                                </th>
                                <th nowrap class="font-weight-normal">
                                    Last Modified
                                </th>
                                <th nowrap>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="approve_accordion">
                            @foreach ($approves as $key => $provider)                                                                                        
                                <tr>
                                    @if ($provider->password != null)
                                    <td>
                                        <i class="bx bx-star text-success"></i>
                                    </td>
                                    @else
                                    <td></td>
                                    @endif
                                    
                                    <td nowrap>
                                        <ul class="list-unstyled">
                                            <li class="font-weight-normal">
                                                <a href="{{route('superadmin.redirect.assetprovider', $provider->id)}}" class="">
                                                    {{Str::title($provider->shop_name)}}
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="tel:{{$provider->phone}}" target="_blank" class="mr-2">
                                            <i class="bx bx-phone"></i>
                                        </a>
                                        <a href="mailto:{{$provider->email}}" target="_blank" class="mr-2">
                                            <i class="bx bx-mail-send"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="nyayomat-blue font-weight-bolder">
                                            {{$provider->assets->count()}}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-decoration-none">
                                            {{Str::title($provider->county)}}
                                        </a>
                                    </td>
                                    <td>
                                        <a  class="text-decoration-none">
                                            {{Str::title($provider->sub_county)}}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-decoration-none">
                                            {{Str::title($provider->location)}}
                                        </a>
                                    </td>
                                    <td nowrap>
                                        {{Carbon\Carbon::create($provider->created_at)->format('d - M - Y')}}
                                    </td>
                                    <td nowrap>
                                        {{Carbon\Carbon::create($provider->updated_at)->format('d - M - Y')}}
                                    </td>
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#approve_info{{$key}}" aria-expanded="false" aria-controls="approve_info{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary">
                                            <i class="bx bx-info-circle"  mr-1></i> Info
                                        </a>
                                        <a  data-toggle="collapse" href="#approve_suspend{{$key}}" aria-expanded="false" aria-controls="approve_suspend{{$key}}" class="badge badge-pill shadow text-white h4 py-2 text-uppercase px-3 badge-warning">
                                            <i class="bx bx-minus mr-1"></i>  Suspend
                                        </a>
                                        <a  data-toggle="collapse" href="#approve_add_asset{{$key}}" aria-expanded="false" aria-controls="approve_add_asset{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-info">
                                            <i class="bx bx-plus mr-1" ></i> Add Asset
                                        </a>
                                    </td>
                                </tr>
        
                                <tr id="approve_info{{$key}}" class="collapse" aria-labelledby="approve_info{{$key}}" data-parent="#approve_accordion">
                                    <td colspan="9">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-dark custom-radius">
                                                
                                                <thead class="nyayomat-blue">
                                                    <tr>
                                                        <th colspan="6">
                                                            <div class="row">
                                                                <div class="col-12 font-weight-bold">
                                                                    <span class="text-info mr-4">
                                                                        @php
                                                                        $total_assets = 0;
                                                                         foreach ($total_assets_value as $total_asset_value)
                                                                         if ($total_asset_value->asset_provider_id == $provider->id){
                                                                            $total_assets = $total_asset_value->total_asset;
                                                                            break;
                                                                         }
                                                                        $total_engaged_asset_value = App\Models\Asset::where("tbl_acp_assets.asset_provider_id", $provider->id)
                                                                                                       ->join("tbl_acp_merchant_asset_order", "tbl_acp_merchant_asset_order.asset_id","tbl_acp_assets.id")
                                                                                                       ->selectRaw("tbl_acp_assets.id,sum(tbl_acp_merchant_asset_order.units * tbl_acp_assets.unit_cost) as total")
                                                                                                       ->first();
                                                                        @endphp
                                                                        Total Asset Value : <small class="ml-2">Ksh </small>{{number_format($total_assets,2)}}
                                                                    </span>
                                                                
                                                                    <span class="text-success">
                                                                        Total Engaged Asset Value : <small class="ml-2">Ksh</small> {{number_format($total_engaged_asset_value->total,2)}}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th nowrap>
                                                            Asset Name
                                                        </th>
                                                        <th>
                                                            Code
                                                        </th>
                                                        <th>
                                                            Units
                                                        </th>
                                                        <th nowrap>
                                                            Price <small>Ksh</small>
                                                        </th>
                                                        <th nowrap>
                                                            Payment Duration <small>Days</small>
                                                        </th>
                                                        <th nowrap>
                                                            Payment Holiday <small>Days</small>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($provider->assets as $asset)    
                                                        <tr>
                                                            <td>
                                                                <ul class="list-unstyled">
                                                                    <li class="font-weight-bold">
                                                                        {{$asset->asset_name}}
                                                                    </li>
                                                                    {{-- <li>
                                                                        @if ($w %5 != 0)
                                                                            <span class="text-success border-0">
                                                                                <small style="font-size: 10px">
                                                                                    <i class="bx bxs-circle mr-1"></i> 
                                                                                    Engaged
                                                                                </small>
                                                                            </span>
                                                                            @else     
                                                                            <span class="text-muted border-0">
                                                                                <small style="font-size: 10px">
                                                                                    <i class="bx bxs-circle mr-1"></i> 
                                                                                    Idle
                                                                                </small>
                                                                            </span>
                                                                        @endif
                                                                    </li> --}}
                                                                </ul>
                                                            </td>
                                                            <td nowrap>
                                                                {{$asset->id}}
                                                            </td>
                                                            <td nowrap>
                                                                {{$asset->units}}
                                                            </td>
                                                            <td nowrap>
                                                                {{$asset->unit_cost}}
                                                            </td>
                                                            <td nowrap>
                                                                {{$asset->payment_frequency}}
                                                            </td>
                                                            <td nowrap>
                                                                {{$asset->holiday_provision}}
                                                            </td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                              
                                <tr id="approve_suspend{{$key}}" class="collapse" aria-labelledby="approve_suspend{{$key}}" data-parent="#approve_accordion">
                                    <td colspan="9">
                                        <p class="">
                                            You are about to suspend this <b>{{Str::title($provider->name)}}</b> account, proceed ?
                                        </p>
                                        <a href="{{route('superadmin.update.assetprovider.status',["id" => $provider->id, "status" => "suspend"])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('approve_suspend{{$key}}')" class="btn btn-sm btn-outline-danger">
                                            No
                                        </a>
                                    </td>
                                </tr>
                                <tr id="approve_add_asset{{$key}}" class="collapse" aria-labelledby="approve_add_asset{{$key}}" data-parent="#approve_accordion">
                                    <td colspan="9">
                                        <form id="asset_form{{$key}}" action="{{route('superadmin.asset.store')}}" method="post" class="row" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-4 mb-4">
                                                <p class="col-12 px-0">
                                                    Asset Name :
                                                </p>
                                                <input type="text" name="asset_name" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <p class="col-12 px-0">
                                                    Units :
                                                </p>
                                                <input type="number" name="units" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <p class="col-12 px-0">
                                                    Unit Cost :
                                                </p>
                                                <input type="number" name="unit_cost" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <p class="col-12 px-0">
                                                    Holiday Provision : <span class="text-muted">Days</span>
                                                </p>
                                                <input type="number" name="holiday_provision" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Deposit Amount  (Single Unit):
                                                </p>
                                                <input type="number" name="deposit_amount" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    No of Installments (Single Unit):
                                                </p>
                                                <input type="number" name="installment" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Payment Frequency :
                                                </p>
                                                <select name="payment_frequency" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                                    <option value="">
                                                       -- Set Frequency -- 
                                                    </option>
                                                    <option value="Daily">
                                                        Daily
                                                    </option>
                                                    <option value="Weekly">
                                                        Weekly
                                                    </option>
                                                    <option value="Monthly">
                                                        Monthly
                                                    </option>
                                                </select>
                                            </div>                       
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Payment Method :
                                                </p>
                                                <select name="payment_method" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                                    <option value="">
                                                       -- Set Method -- 
                                                    </option>
                                                    <option value="Mpesa">
                                                        Mpesa
                                                    </option>
                                                    <option value="Bank">
                                                        Bank
                                                    </option>
                                                </select>
                                            </div> 
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Group :
                                                </p>
                                                <select name="group_id" id="group_id{{$key}}" onchange="getGroups([this.value,'group_id{{$key}}','sub_group_id{{$key}}','category_id{{$key}}']);" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                                    <option value="">
                                                       -- Select Group -- 
                                                    </option>
                                                    @foreach ($groups as $group)
                                                        <option value="{{$group->id}}">{{$group->group_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>          
                                            
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Sub Group :
                                                </p>

                                                <select name="sub_group_id" id="sub_group_id{{$key}}" onchange="getCategories([this.value,'group_id{{$key}}','sub_group_id{{$key}}','category_id{{$key}}']);" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                                    
                                                </select>
                                            </div>          

                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Category :
                                                </p>
                                               
                                                <select name="category_id" id="category_id{{$key}}" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-6 mb-4">
                                                <p class="col-12 px-0">
                                                    Asset Image:
                                                </p>
                                                <input type="file" name="image" class="col-12 py-2 rounded shadow-sm border-0">
                                            </div>       
                                            <input type="hidden" name="asset_provider_id" value="{{$provider->id}}">                      
                                            <div class="col-12 text-center">
                                                <button type="submit"  class="btn btn-primary col-12">
                                                    Submit
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                              
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="applications" role="tabpanel" aria-labelledby="applications-tab">
            <div class="row">
                <div class="col my-2 text-left">
                    <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExampleApplications" role="button" aria-expanded="false" aria-controls="collapseExampleApplications">
                        <i class="bx bx-link-external mr-2"></i>  Export Information
                    </a>
                </div>
                <div class="collapse col-12 mb-1 text-dark" id="collapseExampleApplications">
                    <span class="text-uppercase font-weight-bold">
                        Select Method :
                    </span>
                    <br class="mb-2">
                    <a nowrap href="" class="mr-2  nyayomat-blue mr-3">
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
                {{-- <div class="col-12 text-right">
                    <a href="#application" data-toggle="modal" class="badge badge-pill shadow h4 py-1 px-2 badge-primary" style="font-size: .8rem">
                        New Application
                    </a>
                </div> --}}
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {{Str::title('applicant name')}}
                                </th>
                                <th>
                                    {{Str::title('shop name')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('county')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('sub county')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('location')}}
                                </th>
                                <th nowrap>
                                    Contact
                                </th>
                                <th nowrap>
                                    {{Str::title('application date')}}

                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="application_accordion">
                            @foreach ($applications as $key => $applicant)
                                <tr>
                                    <td>
                                        {{Str::title($applicant->applicant_name)}}
                                    </td>
                                    <td>
                                        {{Str::title($applicant->shop_name)}}
                                    </td>
                                    <td>
                                        {{Str::title($applicant->county)}}
                                    </td>
                                    <td>
                                        {{Str::title($applicant->sub_county)}}
                                    </td>
                                    <td>
                                        {{Str::title($applicant->location)}}
                                    </td>
                                    <td nowrap>
                                        <a href="tel:{{$applicant->phone}}" class="text-decoration-none mx-2" style="font-size: 1.2rem">
                                            <i class="bx bx-phone mr-2"></i>
                                        </a>
                                        
                                        <a href="mailto:{{$applicant->email}}" class="text-decoration-none mx-2" style="font-size: 1.2rem">
                                            <i class="bx bx-envelope"></i>
                                        </a>
                                    </td>
                                    <td nowrap>
                                        {{$joined = Carbon\Carbon::create($applicant->created_at, 'Africa/Nairobi')->format('d - M - Y @ h:i A')}}
                                    </td>
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#approve{{$key}}" aria-expanded="false" aria-controls="approve{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success">
                                            <i class="bx bx-check mr-1"></i> Approve
                                        </a>
                                        <a  data-toggle="collapse" href="#shortlist{{$key}}" aria-expanded="false" aria-controls="shortlist{{$key}}" class="badge mx-2 badge-pill shadow h4 py-2 text-uppercase px-3 badge-warning">
                                            <i class="bx bx-minus mr-1"></i> Shortlist
                                        </a>
                                        <a  data-toggle="collapse" href="#decline{{$key}}" aria-expanded="false" aria-controls="decline{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-danger">
                                            <i class="bx bx-x mr-1"></i> Decline
                                        </a>
                                    </td>
                                </tr>
                                <tr id="approve{{$key}}" class="collapse" aria-labelledby="approve{{$key}}" data-parent="#application_accordion">
                                    <td colspan="9">
                                        <p class="">
                                            You are about to approve this <b>{{Str::title($applicant->shop_name)}}</b> application, proceed ?
                                        </p>
                                        <a href="{{route('superadmin.update.assetprovider.status',["id" => $applicant->id, "status" => "approved"])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('approve{{$key}}')" class="btn btn-sm btn-outline-danger">
                                            No
                                        </a>
                                    </td>
                                </tr>
                                <tr id="shortlist{{$key}}" class="collapse" aria-labelledby="shortlist{{$key}}" data-parent="#application_accordion">
                                        <td colspan="9">
                                            <p class="">
                                                You are about to shortlist this <b>{{Str::title($applicant->shop_name)}}</b> account, proceed ?
                                            </p>
                                            <a href="{{route('superadmin.update.assetprovider.status',["id" => $applicant->id, "status" => "shortlist"])}}" class="btn btn-sm btn-outline-success">
                                                Yes
                                            </a>
            
                                            <a onclick="closeAccordion('shortlist{{$key}}')" class="btn btn-sm btn-outline-danger">
                                                No
                                            </a>
                                        </td>
                                </tr>
                                <tr id="decline{{$key}}" class="collapse" aria-labelledby="decline{{$key}}" data-parent="#application_accordion">
                                    <td colspan="9">
                                        <p class="">
                                            You are about to decline this <b>{{Str::title($applicant->shop_name)}}</b> application, proceed ?
                                        </p>
                                        <a href="{{route('superadmin.update.assetprovider.status',["id" => $applicant->id, "status" => "decline"])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('decline{{$key}}')" class="btn btn-sm btn-outline-danger">
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
       
        <div class="tab-pane fade" id="shortlist" role="tabpanel" aria-labelledby="shortlist-tab">
            <div class="row">
                <div class="col my-2 text-left">
                    <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExampleSuspended" role="button" aria-expanded="false" aria-controls="collapseExampleSuspended">
                        <i class="bx bx-link-external mr-2"></i>  Export Information
                    </a>
                </div>
                <div class="collapse col-12 mb-1 text-dark" id="collapseExampleSuspended">
                    <span class="text-uppercase font-weight-bold">
                        Select Method :
                    </span>
                    <br class="mb-2">
                    <a nowrap href="" class="mr-2  nyayomat-blue mr-3">
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
                {{-- <div class="col-12 text-right">
                    <a href="#application" data-toggle="modal" class="badge badge-pill shadow h4 py-1 px-2 badge-primary" style="font-size: .8rem">
                        New Application
                    </a>
                </div> --}}
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {{Str::title('applicant name')}}
                                </th>
                                <th>
                                    {{Str::title('shop name')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('county')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('sub county')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('location')}}
                                </th>
                                <th nowrap>
                                    Contact
                                </th>
                                <th nowrap>
                                    {{Str::title('application date')}}

                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="accordion_shortlist">
                            @foreach ($shortlisted as $key => $shortlist)
                                <tr>
                                    <td>
                                        {{Str::title($shortlist->applicant_name)}}
                                    </td>
                                    <td>
                                        {{Str::title($shortlist->shop_name)}}
                                    </td>
                                    <td>
                                        {{Str::title($shortlist->county)}}
                                    </td>
                                    <td>
                                        {{Str::title($shortlist->sub_county)}}
                                    </td>
                                    <td>
                                        {{Str::title($shortlist->location)}}
                                    </td>
                                    <td nowrap>
                                        <a href="tel:{{$shortlist->phone}}" class="text-decoration-none mx-2" style="font-size: 1.2rem">
                                            <i class="bx bx-phone mr-2"></i>
                                        </a>
                                        
                                        <a href="mailto:{{$shortlist->email}}" class="text-decoration-none mx-2" style="font-size: 1.2rem">
                                            <i class="bx bx-envelope"></i>
                                        </a>
                                    </td>
                                    <td nowrap>
                                        {{$joined = Carbon\Carbon::create($shortlist->created_at, 'Africa/Nairobi')->format('d - M - Y @ h:i A')}} ..
                                    </td>
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#shortlist_approve{{$key}}" aria-expanded="false" aria-controls="shortlist_approve{{$key}}" class="badge mx-2 badge-pill shadow h4 py-2 text-uppercase px-3 badge-success">
                                            <i class="bx bx-check"  mr-1></i> Approve
                                        </a>

                                        <a  data-toggle="collapse" href="#shortlist_decline{{$key}}" aria-expanded="false" aria-controls="shortlist_decline{{$key}}" class="badge mx-2 badge-pill shadow h4 py-2 text-uppercase px-3 badge-danger">
                                            <i class="bx bx-trash"  mr-1></i> Decline
                                        </a>
                                    </td>
                                </tr>
                                <tr id="shortlist_approve{{$key}}" class="collapse" aria-labelledby="shortlist_approve{{$key}}" data-parent="#accordion_shortlist">
                                    <td colspan="9">
                                        {{-- <div class="row"> --}}
                                            <p class="">
                                                You are about to approve <b>{{Str::title($shortlist->shop_name)}}'s</b> application, proceed ?
                                            </p>
                                            <a href="{{route('superadmin.update.assetprovider.status',["id" => $shortlist->id, "status" => "approved"])}}" class="btn btn-sm btn-outline-success">
                                                Yes
                                            </a>
            
                                            <a onclick="closeAccordion('shortlist_approve{{$key}}')" class="btn btn-sm btn-outline-danger">
                                                No
                                            </a>
                                        {{-- </div> --}}
                                    </td>
                                </tr>
                                <tr id="shortlist_decline{{$key}}" class="collapse" aria-labelledby="shortlist_decline{{$key}}" data-parent="#accordion_shortlist">
                                    <td colspan="9">
                                        <p class="">
                                            You are about to decline <b>{{Str::title($shortlist->shop_name)}}'s</b> application, proceed ?
                                        </p>
                                        <a href="{{route('superadmin.update.assetprovider.status',["id" => $shortlist->id, "status" => "decline"])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('shortlist_decline{{$key}}')" class="btn btn-sm btn-outline-danger">
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

        <div class="tab-pane fade" id="suspend" role="tabpanel" aria-labelledby="suspend-tab">
            <div class="row">
                <div class="col my-2 text-left">
                    <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExampleShortlist" role="button" aria-expanded="false" aria-controls="collapseExampleShortlist">
                        <i class="bx bx-link-external mr-2"></i>  Export Information
                    </a>
                </div>
                <div class="collapse col-12 mb-1 text-dark" id="collapseExampleShortlist">
                    <span class="text-uppercase font-weight-bold">
                        Select Method :
                    </span>
                    <br class="mb-2">
                    <a nowrap href="" class="mr-2  nyayomat-blue mr-3">
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
            <div class="row mt-4">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    Name
                                </th>
                                <th nowrap>
                                    Contacts
                                </th>
                                <th nowrap>
                                    Assets
                                </th>
                                <th nowrap>
                                    County 
                                </th>
                                <th nowrap>
                                    Sub County
                                </th>
                                <th nowrap>
                                    Location
                                </th>
                                <th nowrap>
                                    Joined 
                                </th>
                                <th nowrap>
                                    Last Modified
                                </th>
                                <th nowrap>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="suspend_accordion">
                            @foreach ($suspended as $key => $suspend)
                                <tr>
                                    <td nowrap>
                                        <ul class="list-unstyled">
                                            <li class="font-weight-bold">
                                                {{Str::title($suspend->shop_name)}}
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="tel:{{$suspend->phone}}" target="_blank" class="mr-2">
                                            <i class="bx bx-phone"></i>
                                        </a>
                                        <a href="mailto:{{$suspend->email}}" target="_blank" class="mr-2">
                                            <i class="bx bx-mail-send"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="nyayomat-blue font-weight-bolder">
                                            0
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-decoration-none">
                                            {{$suspend->county}}
                                        </a>
                                    </td>
                                    <td>
                                        <a  class="text-decoration-none">
                                            {{$suspend->sub_county}}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-decoration-none">
                                            {{$suspend->location}}
                                        </a>
                                    </td>
                                    <td nowrap>
                                        {{$suspend->created_at}}
                                    </td>
                                    <td nowrap>
                                        {{$suspend->updated_at}}
                                    </td>
                                    <td nowrap>
                                        <a  data-toggle="collapse" href="#suspend_reinstate{{$key}}" aria-expanded="false" aria-controls="suspend_reinstate{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success">
                                            <i class="bx bx-reset"  mr-1></i> Reinstate
                                        </a>
                                    </td>
                                </tr>

                                <tr id="suspend_reinstate{{$key}}" class="collapse" aria-labelledby="suspend_reinstate{{$key}}" data-parent="#suspend_accordion">
                                    <td colspan="9">
                                        <p class="">
                                            You are about to reinstate  <b>{{Str::title($suspend->shop_name)}}</b> as an active account, proceed ?
                                        </p>
                                        <a href="{{route('superadmin.update.assetprovider.status',["id" => $suspend->id, "status" => "approved"])}}" class="btn btn-sm btn-outline-success">
                                            Yes
                                        </a>
        
                                        <a onclick="closeAccordion('suspend_reinstate{{$key}}')" class="btn btn-sm btn-outline-danger">
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
                    <h5 class="modal-title" id="staticBackdropLabel">Asset Provider Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="inputEmail4">
                                    Applicant Name
                                </label>
                                <input type="text" class="form-control" name="name" id="inputEmail4" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="inputEmail4">
                                    Shop Name
                                </label>
                                <input type="text" class="form-control" name="shop_name" id="inputEmail4" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Phone">Phone</label>
                                <input type="text" name="phone" onkeypress="return onlyNumberKey(event)" class="form-control" id="Phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="county">County</label>
                                <select id="county" name="county" class="form-control" required>
                                    <option value="">
                                        {{__('- Select County -')}}
                                    </option>
                                    <option value="Mombasa">
                                        {{__('Mombasa')}}
                                    </option>
                                    <option value="Kwale">
                                        {{__('Kwale')}}
                                    </option>
                                    <option value="Kilifi">
                                        {{__('Kilifi')}}
                                    </option>
                                    <option value="Tana River">
                                        {{__('Tana River')}}
                                    </option>
                                    <option value="Lamu">
                                        {{__('Lamu')}}
                                    </option>
                                    <option value="Taita Taveta">
                                        {{__('Taita Taveta')}}
                                    </option>
                                    <option value="Garissa">
                                        {{__('Garissa')}}
                                    </option>
                                    <option value="Wajir">
                                        {{__('Wajir')}}
                                    </option>
                                    <option value="Mandera">
                                        {{__('Mandera')}}
                                    </option>
                                    <option value="Marsabit">
                                        {{__('Marsabit')}}
                                    </option>
                                    <option value="Turkana">
                                        {{__('Turkana')}}
                                    </option>
                                    <option value="Isiolo">
                                        {{__('Isiolo')}}
                                    </option>
                                    <option value="Meru">
                                        {{__('Meru')}}
                                    </option>
                                    <option value="Tharaka-Nithi">
                                        {{__('Tharaka-Nithi')}}
                                    </option>
                                    <option value="Embu">
                                        {{__('Embu')}}
                                    </option>
                                    <option value="Kitui">
                                        {{__('Kitui')}}
                                    </option>
                                    <option value="Machakos">
                                        {{__('Machakos')}}
                                    </option>
                                    <option value="Makueni">
                                        {{__('Makueni')}}
                                    </option>
                                    <option value="Nyandarua">
                                        {{__('Nyandarua')}}
                                    </option>
                                    <option value="Nyeri">
                                        {{__('Nyeri')}}
                                    </option>
                                    <option value="Kirinyaga">
                                        {{__('Kirinyaga')}}
                                    </option>
                                    <option value="Muranga">
                                        {{__('Muranga')}}
                                    </option>
                                    <option value="Kiambu">
                                        {{__('Kiambu')}}
                                    </option>
                                    <option value="West Pokot">
                                        {{__('West Pokot')}}
                                    </option>
                                    <option value="Samburu">
                                        {{__('Samburu')}}
                                    </option>
                                    <option value="Trans Nzoia">
                                        {{__('Trans Nzoia')}}
                                    </option>
                                    <option value="Usain Gishu">
                                        {{__('Usain Gishu')}}
                                    </option>
                                    <option value="Elgeyo Marakwet">
                                        {{__('Elgeyo Marakwet')}}
                                    </option>
                                    <option value="Nandi">
                                        {{__('Nandi')}}
                                    </option>
                                    <option value="Baringo">
                                        {{__('Baringo')}}
                                    </option>
                                    <option value="Laikipia">
                                        {{__('Laikipia')}}
                                    </option>
                                    <option value="Nakuru">
                                        {{__('Nakuru')}}
                                    </option>
                                    <option value="Narok">
                                        {{__('Narok')}}
                                    </option>
                                    <option value="Kajiado">
                                        {{__('Kajiado')}}
                                    </option>
                                    <option value="Kericho">
                                        {{__('Kericho')}}
                                    </option>
                                    <option value="Bomet">
                                        {{__('Bomet')}}
                                    </option>
                                    <option value="Kakamega">
                                        {{__('Kakamega')}}
                                    </option>
                                    <option value="Vihiga">
                                        {{__('Vihiga')}}
                                    </option>
                                    <option value="Bungoma">
                                        {{__('Bungoma')}}
                                    </option>
                                    <option value="Busia">
                                        {{__('Busia')}}
                                    </option>
                                    <option value="Siaya">
                                        {{__('Siaya')}}
                                    </option>
                                    <option value="Kisumu">
                                        {{__('Kisumu')}}
                                    </option>
                                    <option value="Homa Bay">
                                        {{__('Homa Bay')}}
                                    </option>
                                    <option value="Migori">
                                        {{__('Migori')}}
                                    </option>
                                    <option value="Kisii">
                                        {{__('Kisii')}}
                                    </option>
                                    <option value="Nyamira">
                                        {{__('Nyamira')}}
                                    </option>
                                    <option value="Nairobi">
                                        {{__('Nairobi')}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="subCounty">Sub County</label>
                                <input type="text" name="sub_county" class="form-control" id="subCounty" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" id="location" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    I agree with Nyayomat's <a href="">Terms &amp; Conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="form-row">
                            <button type="submit"  disabled class="btn btn-primary col-12">
                                Apply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Application --}}
    
 
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
    <script>
        function closeAccordion(id){
            $("#"+id).collapse('hide');
        }
    </script>
@endpush
@extends('superadmin.master', 
                        [
                            'title' => __("Engaged Assets"),
                            'page_name' => 'Engaged Assets',
                            'bs_version' => 'bootstrap@4.6.0',
                            'left_nav_color' => 'lightseagreen',
                            'nav_icon_color' => '#fff',
                            'active_nav_icon_color' => '#fff',
                            'active_nav_icon_color_border' => 'greenyellow' ,
                            'top_nav_color' => '#F7F6FB',
                            'background_color' => '#F7F6FB',
                        ])

@push('navs')
@include('superadmin.nav') 
@endpush


@section('content')
    {{-- Breadcrumb --}}
    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table id="mytableID" class="table">
                <thead>
                    <tr>
                        <th nowrap>
                            Name
                        </th>
                        <th nowrap class="">
                            Engaged Units
                        </th>
                        <th nowrap class="">
                            Unit Cost
                            <span class="text-muted font-weight-normal">
                                Ksh
                            </span>
                        </th>
                        <th nowrap>
                            Total Value
                            <span class="text-muted font-weight-normal">
                                Ksh
                            </span>
                        </th>
                        <th nowrap>
                            
                        </th>
                    </tr>
                </thead>
                <tbody class="accordion" id="groupDescription">
                    @foreach ($engaged_assets as $key => $engaged_asset)                                                                                        
                        <tr>
                            <td nowrap>
                                {{Str::upper($engaged_asset->asset_name)}}
                            </td>
                            <td>
                                {{$engaged_asset->engaged_units}}
                            </td>
                            <td>
                                {{number_format($engaged_asset->unit_cost,2)}}
                            </td>
                            <td nowrap>
                                <a  data-toggle="collapse" href="#detailscollapse{{$key}}" aria-expanded="false" aria-controls="detailscollapse{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary">
                                    <i class="bx bx-info-circle"  mr-1></i> Details
                                </a>
                            </td>
                        </tr>

                        <tr id="detailscollapse{{$key}}" class="collapse" aria-labelledby="headingOne" data-parent="#groupDescription">
                            <td colspan="9">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-dark custom-radius">
                                        <thead class="nyayomat-blue">
                                            <tr>
                                                <th colspan="6">
                                                    <div class="row">
                                                     @php
                                                        $total_asset_info = App\Models\MerchantAssetOrder::where("asset_id", $engaged_asset->asset_id)
                                                                                                ->selectRaw("id, sum(total_out_standing_amount) as total_out_standing_amount,  sum(units) * unit_cost as cost")
                                                                                                ->first();
                                                    @endphp
                                                        <div class="col-12 font-weight-bold">
                                                            <span class="text-info mr-4">
                                                                Total Paid : <small class="ml-2">Ksh</small> {{number_format($total_asset_info->cost - $total_asset_info->total_out_standing_amount,2)}}
                                                            </span>
                                                        
                                                            <span class="text-success">
                                                                Total Outstanding <small class="ml-2">Ksh</small> {{number_format($total_asset_info->total_out_standing_amount,2)}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th nowrap>
                                                    Merchant Name
                                                </th>
                                                <th>
                                                    Progress
                                                </th>
                                                <th nowrap>
                                                    Total Outstanding
                                                </th>
                                                <th nowrap>
                                                    Total Paid
                                                </th>
                                                <th nowrap>
                                                    Installments
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($engaged_asset->engagedTransaction) > 0)
                                            @foreach ($engaged_asset->engagedTransaction as $engaged_transaction)  
                                            @php
                                                $merchant_info = App\Models\MerchantAssetOrder::where('merchant_id',$engaged_transaction->merchant_id)->where("asset_id", $engaged_transaction->asset_id)
                                                                                                ->join("users", "users.id", "tbl_acp_merchant_asset_order.merchant_id")
                                                                                                ->selectRaw("tbl_acp_merchant_asset_order.id,users.name,sum(total_out_standing_amount) as total_out_standing_amount,(sum(units) * unit_cost) - sum(total_out_standing_amount) as total_paid, sum(installment) as total_installment")
                                                                                                ->first();
                                                $paid_transaction = App\Models\MerchantTransaction::where("asset_id", $engaged_transaction->asset_id)->where("merchant_id", $engaged_transaction->merchant_id)
                                                                                            ->wherenotnull("paid_on")
                                                                                            ->where("type","!=","deposit")
                                                                                            ->count();
                                            @endphp
                                                <tr>
                                                    <td>
                                                        <ul class="list-unstyled">
                                                            <li class="font-weight-bold">
                                                                {{Str::upper($merchant_info->name)}}
                                                            </li>
                                                            <li>
                                                                {{-- @if ($w %7 != 0) --}}
                                                                    <span class="text-success border-0">
                                                                        <small style="font-size: 10px">
                                                                            <i class="bx bxs-circle mr-1"></i> 
                                                                            Active
                                                                        </small>
                                                                    </span>
                                                                    {{-- @else     
                                                                    <span class="text-muted border-0">
                                                                        <small style="font-size: 10px">
                                                                            <i class="bx bxs-circle mr-1"></i> 
                                                                            Defaulted
                                                                        </small>
                                                                    </span>
                                                                @endif --}}
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td nowrap>
                                                        <div class="progress rounded-lg">
                                                            @php
                                                                if($merchant_info->total_out_standing_amount != 0){
                                                                    $progress = ($merchant_info->total_paid/$merchant_info->total_out_standing_amount) * 100;
                                                                }else{
                                                                    $progress = 100;
                                                                }
                                                                
                                                            @endphp
                                                            @if ($progress <= 0)
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                            @elseif ($progress > 0 && $progress <=49)
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            @elseif ($progress >= 50 && $progress <=70)
                                                            <div class="progress-bar bg-success" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                            @elseif ($progress >= 71 && $progress <=100)
                                                            <div class="progress-bar bg-priamry" role="progressbar" style="width:{{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td nowrap>
                                                        {{number_format($merchant_info->total_out_standing_amount,2)}}
                                                    </td>
                                                    <td nowrap>
                                                        {{number_format($merchant_info->total_paid,2)}}
                                                    </td>
                                                    <td nowrap>
                                                        {{$paid_transaction}} /
                                                        {{$merchant_info->total_installment}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
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
@endsection

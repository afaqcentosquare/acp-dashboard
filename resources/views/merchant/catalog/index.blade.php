@extends('merchant.master', 
                        [
                            'title' => __("Merchant Catalog"),
                            'page_name' => 'Merchant Catalog',
                            'bs_version' => 'bootstrap@4.6.0',
                            'left_nav_color' => 'lightseagreen',
                            'nav_icon_color' => '#fff',
                            'active_nav_icon_color' => '#fff',
                            'active_nav_icon_color_border' => 'greenyellow' ,
                            'top_nav_color' => '#F7F6FB',
                            'background_color' => '#F7F6FB',
                        ])

@push('link-css')
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
            
            .modal{
                width: 100vw;
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

@push('link-js')
@endpush



@push('navs')
@include('merchant.nav') 
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
                A C P
            </a>  /
            <a href="" class="text-primary ml-1">
                Product Catalog
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

    <div class="tab-content" id="pills-tabContent">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-nyayomat-tab" data-toggle="tab" href="#nav-nyayomat" role="tab" aria-controls="nav-nyayomat" aria-selected="true">
                    Browse
                </a>
                <a class="nav-link" id="nav-received-tab" data-toggle="tab" href="#nav-received" role="tab" aria-controls="nav-received" aria-selected="false">
                    Requested
                </a>
                <a class="nav-link" id="nav-applications-tab" data-toggle="tab" href="#nav-applications" role="tab" aria-controls="nav-applications" aria-selected="false">
                    Received
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade text-secondary show active" id="nav-nyayomat" role="tabpanel" aria-labelledby="nav-nyayomat-tab">

                <div class="row  mb-3">
                   
                    <p class="col-12">
                        P. = Payment
                    </p>
                    <div class="col-12 d-none d-md-block">
                        <input type="text" id="myInput" class="form-control col-12" onkeyup="myFunction()" placeholder="Find Product.." title="Type in a name">
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>
                                        {{Str::title('Name')}}
                                    </th>
                                    <th>
                                        {{Str::title('Units')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('Unit Cost')}}<br>
                                        <span class="text-muted">
                                            (Ksh)
                                        </span>
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Holiday')}} 
                                        <span class="text-muted">
                                            Days
                                        </span>
                                    </th>
                                    <th nowrap>
                                        Deposit <br> Amount
                                        <span class="text-muted">
                                            Ksh
                                        </span>
                                    </th>
                                    <th nowrap>
                                        Installment <br> Amount 
                                        <span class="text-muted">
                                            (Ksh)
                                        </span>
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Frequency')}}
        
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Method')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Duration')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('provider')}}
                                    </th>
                                    <th>
        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assets as $asset)
                                    <tr>
                                        <td nowrap>
                                            {{Str::title($asset->asset_name)}}
                                        </td>
                                        <td>
                                            {{$asset->units}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->unit_cost),2)}}
                                        </td>
                                        <td>
                                            {{$asset->holiday_provision}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->deposit_amount),2)}}
                                        </td>
                                        <td>
                                            @if($asset->units != 0)
                                            {{number_format((($asset->unit_cost - $asset->deposit_amount)) / ($asset->installment),2)}}
                                            @else
                                            0
                                            @endif
                                            
                                        </td>
                                        <td>
                                            {{Str::title($asset->payment_frequency)}}
                                        </td>
                                        <td>
                                            {{Str::title($asset->payment_method)}}
                                        </td>
                                        <td>
                                            {{
                                               $asset->installment
                                            }}
                                            @if ($asset->payment_frequency == 'Daily')
                                                D
                                            @endif
                                            @if ($asset->payment_frequency == 'Weekly')
                                                W
                                            @endif
                                            @if ($asset->payment_frequency == 'Monthly')
                                                M
                                            @endif
                                        </td>
                                        <td nowrap>
                                            {{$asset->shop_name}}
                                        </td>
                                        <td nowrap>
                                            <a href="#edit{{$asset->id}}" data-toggle="modal" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success" style="font-size: .7rem">
                                                <i class="bx bx-pencil mr-1"></i> Request
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
            <div class="tab-pane fade text-secondary" id="nav-received" role="tabpanel" aria-labelledby="nav-received-tab">
                <div class="row  mb-3">
                   
                    <p class="col-12">
                        P. = Payment
                    </p>
                    <div class="col-12 table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>
                                        {{Str::title('Name')}}
                                    </th>
                                    <th>
                                        {{Str::title('Units')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('Unit Cost')}}<br>
                                        <span class="text-muted">
                                            (Ksh)
                                        </span>
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Holiday')}} 
                                        <span class="text-muted">
                                            Days
                                        </span>
                                    </th>
                                    <th nowrap>
                                        Deposit <br> Amount
                                        <span class="text-muted">
                                            Ksh
                                        </span>
                                    </th>
                                    <th nowrap>
                                        Installment <br> Amount 
                                        <span class="text-muted">
                                            (Ksh)
                                        </span>
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Frequency')}}
        
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Method')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('P. Duration')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('provider')}}
                                    </th>
                                    <th>
        
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="accordion" id="groupDescriptions">
                                @foreach ($asset_request as $key => $asset)
                                    <tr>
                                        <td nowrap>
                                            {{Str::title($asset->asset_name)}}
                                        </td>
                                        <td>
                                            {{$asset->units}}
                                        </td>
                                        <td>
                                            {{$asset->unit_cost}}
                                        </td>
                                        <td>
                                            {{$asset->holiday_provision}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->units * $asset->deposit_amount),2)}}
                                        </td>
                                        <td>
                                            {{-- {{number_format((($asset->units * $asset->unit_cost) - ($asset->units * $asset->deposit_amount))/($asset->units * $asset->installment),2)}}
                                             --}}
                                             {{number_format(($asset->units * ($asset->unit_cost - $asset->deposit_amount)/($asset->installment)),2)}}
                                        </td>
                                        <td>
                                            {{Str::title($asset->payment_frequency)}}
                                        </td>
                                        <td>
                                            {{Str::title($asset->payment_method)}}
                                        </td>
                                        <td>
                                            {{($asset->installment)}} 
                                            @if ($asset->payment_frequency == 'Daily')
                                                D                                                    
                                            @endif
                                            @if ($asset->payment_frequency == 'Weekly')
                                                W
                                            @endif
                                            @if ($asset->payment_frequency == 'Monthly')
                                                M
                                            @endif
                                        </td>
                                        <td nowrap>
                                            {{$asset->shop_name}}
                                        </td>
                                        <td nowrap>
                                            <a data-toggle="collapse" href="#cancel_collapse{{$key}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary" style="font-size: .7rem">
                                                <i class="bx bx-pencil mr-1"></i> Cancel Request
                                            </a>
                                            <a href="{{route('merchant.update.order.status',[$asset->id,"delivered"])}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success" style="font-size: .7rem">
                                                <i class="bx bx-pencil mr-1"></i> Received
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="cancel_collapse{{$key}}" class="collapse" aria-labelledby="cancel_collapse{{$key}}" data-parent="#groupDescriptions">
                                        <td colspan="9">
                                            <p class="">
                                                You are about to cancel this request, proceed ?
                                            </p>
                                            <a href="{{route('merchant.update.order.status',[$asset->id,"cancel"])}}" class="btn btn-sm btn-outline-success">
                                                Yes
                                            </a>
            
                                            <a onclick="closeAccordion('cancel_collapse{{$key}}')" class="btn btn-sm btn-outline-danger">
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
            <div class="tab-pane fade text-secondary" id="nav-applications" role="tabpanel" aria-labelledby="nav-applications-tab">
                <h3 class="display-5 col-12 text-success">
                    Catalog
                </h3>
                <p class="col-12">
                    P. = Payment
                </p>
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {{Str::title('Name')}}
                                </th>
                                <th>
                                    {{Str::title('Units')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('Unit Cost')}}<br>
                                        <span class="text-muted">
                                            (Ksh)
                                    </span>
                                </th>
                                <th nowrap>
                                    {{Str::title('P. Holiday')}} 
                                    <span class="text-muted">
                                        Days
                                    </span>
                                </th>
                                <th nowrap>
                                    {{Str::title('Deposit amount')}}
                                </th>
                                <th nowrap>
                                    Installment Amount
                                </th>
                                <th nowrap>
                                    {{Str::title('P. Frequency')}}
    
                                </th>
                                <th nowrap>
                                    {{Str::title('P. Method')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('P Duration')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset_received as $asset)
                                <tr>
                                    <td nowrap>
                                        {{Str::title($asset->asset_name)}}
                                    </td>
                                    <td>
                                        {{$asset->units}}
                                    </td>
                                    <td>
                                        {{number_format(($asset->unit_cost),2)}}
                                    </td>
                                    <td>
                                        {{$asset->holiday_provision}}
                                    </td>
                                    <td>
                                        {{number_format(($asset->units * $asset->deposit_amount),2)}}
                                    </td>
                                    <td>
                                        {{number_format($asset->units * ($asset->unit_cost - $asset->deposit_amount)/($asset->installment),2)}}
                                    </td>
                                    <td>
                                        {{Str::title($asset->payment_frequency)}}
                                    </td>
                                    <td>
                                        {{Str::title($asset->payment_method)}}
                                    </td>
                                    <td>
                                        {{$asset->installment}}
                                        @if ($asset->payment_frequency == 'Daily')
                                            D                                                    
                                        @endif
                                        @if ($asset->payment_frequency == 'Weekly')
                                            W
                                        @endif
                                        @if ($asset->payment_frequency == 'Monthly')
                                            M
                                        @endif
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
    @foreach ($assets as $key => $asset)
    <div class="modal fade" id="edit{{$asset->id}}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Number of units
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_form{{$key}}" action="{{route('merchant.asset.request')}}" method="POST" class="row">
                        @csrf
                        <input type="hidden" name="asset_id" value="{{$asset->id}}"/>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Units :
                            </p>
                            <input type="number" min="1" name="units" value="{{$asset->units}}" max="{{$asset->units}}" placeholder="Type Here" onkeyup="getUnits([this.value,{{$asset->deposit_amount}},{{$asset->installment}}])" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Unit Cost :
                            </p>
                            <input type="number" name="unit_cost" disabled value="{{$asset->unit_cost}}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Holiday Provision : <span class="text-muted">Days</span>
                            </p>
                            <input type="number" name="holiday_provision" disabled value="{{$asset->holiday_provision }}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Deposit Amount  :
                            </p>
                            <input type="number" name="deposit_amount" disabled value="{{$asset->units * $asset->deposit_amount}}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                No of Installments:
                            </p>
                            <input type="number" name="installment" disabled value="{{$asset->installment}}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Payment Frequency :
                            </p>
                            <select name="payment_frequency" disabled class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off" id="">
                                <option value="{{$asset->payment_frequency}}">
                                    {{Str::title($asset->payment_frequency)}}
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
                            <select name="payment_method" disabled class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off" id="">
                                <option value="{{$asset->payment_method}}">
                                    {{Str::title($asset->payment_method)}}
                                </option>
                                @if ($asset->payment_method != 'mpesa')
                                    <option value="mpesa">
                                        Mpesa
                                    </option>
                                @endif
                                @if ($asset->payment_method != 'mpesa')
                                    <option value="bank">
                                        Bank
                                    </option>
                                @endif
                            </select>
                        </div> 
                        {{-- <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Categories :
                            </p>
                            <select name="category_id" disabled class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off" id="">
                                @foreach (App\Category::get() as $category)
                                    <option value="{{$category -> id}}">
                                        {{Str::title($category -> name)}}
                                        |
                                        {{Str::title($category -> sub_group  -> name)}}
                                        |
                                        {{Str::title($category -> sub_group -> group -> name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>  --}}
                        
                        <div class="col-12 text-center">
                            <button type="submit"  class="btn btn-primary col-12">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="remove{{$asset -> id }}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{-- Remove {{$asset -> type_a -> name}} from <b> {{Str::title($asset -> type_a -> provider -> name)}}</b> --}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h3 class="col-12 mb-5 text-center">
                            Are you sure <br> you want to remove this item ?
                        </h3>
                        <div class="col-6 text-center">
                            <a href="#" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-warning" style="font-size: .7rem">
                                <i class="bx bx-minus mr-2"></i> Suspend Item
                            </a>
                        </div>
                        <div class="col-6 text-center">
                            <a href="#" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-danger" style="font-size: .7rem">
                                <i class="bx bx-trash mr-2"></i>Remove Item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="merchant_request{{$asset->id }}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{Str::title($asset->asset_name)}} Request
                    </h5>
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
                                    Number of Units <span class="text-muted ml-3" style="font-size: .7rem">{{$asset->units }} Units</span>
                                </label>
                                <input type="number" autocomplete="off" class="form-control" name="units" min="1" max="{{$asset -> units }}" id="inputEmail4">
                            </div>
                        </div>
                        <div class="form-row">
                            <input type="hidden" name="asset_id" value="{{$asset -> id}}"> 
                            <input type="hidden" name="merchant_id" value=""> 
                            <button type="submit" class="btn btn-outline-success col-12">
                                Send Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach    
    {{-- @include('jamo.components.bs-4.modal') --}}
    
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
    <script>
        function closeAccordion(id){
            $("#"+id).collapse('hide');
        }
        function getUnits(arr){
            $('input[name="deposit_amount"]').val(arr[0]*arr[1]);
        }
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
@endpush
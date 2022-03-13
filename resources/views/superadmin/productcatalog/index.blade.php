@extends('superadmin.master', 
                        [
                            'title' => __("Catalog"),
                            'page_name' => 'Catalog',
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
@include('superadmin.nav') 
@endpush


{{-- @push('navs')
    <a href="{{route('merchant-overview')}}" class="nav_link"> 
        <i class='bx bx-grid-alt nav_icon'></i> 
        <span class="nav_name">
            Dashboard
        </span>
    </a>

    <a href="{{route('merchant-transactions')}}" class="nav_link">
        <i class='bx bx-money nav_icon'></i>
        <span class="nav_name">
            Transactions    
        </span> 
    </a> 

    <a href="{{route('merchant-stock')}}" class="nav_link active"> 
        <i class='bx bx-coin-stack nav_icon'></i> 
        <span class="nav_name">
            Stock
        </span>
    </a>

    <a href="{{route('merchant-product')}}" class="nav_link">
        <i class='bx bx-package nav_icon'></i>
        <span class="nav_name">
            Products &amp; Catalog
        </span>
    </a>
  
    <a href="" class="nav_link"> 
        <i class='bx bx-alarm-exclamation nav_icon'></i> 
        <span class="nav_name">
            Disputes
        </span>
    </a>
    
    <a href="{{route('merchant-stats')}}" class="nav_link"> 
        <i class='bx bx-doughnut-chart nav_icon'></i>   
        <span class="nav_name">
            Statistics 
        </span> 
    </a> 

    <a href="{{route('merchant-notifications')}}" class="nav_link">
        <i class='bx bx-chat nav_icon'></i>
        <span class="nav_name">
            Notifications 
            <span class="d-md-inline-flex badge nav)n badge-circle mr-2 bg-white nyayomat-blue d-none">
                {{rand(1,10)}}
            </span>   
        </span> 
    </a> 
@endpush --}}

@section('content')
    {{-- Breadcrumb --}}
    <div class="row">
        <div class="col-12 mt-2 mb-3 font-weight-light">
            <i class='bx bx-subdirectory-right mr-2 text-primary' style="font-size: 2.8vh;"></i>
            <a href="" class="text-muted mr-1">
                {{Str::ucfirst(config('app.name'))}}
            </a> /
            <a href="" class="text-primary ml-1">
                Stock Manager
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
                    Prep
                </a>
                <a class="nav-link" id="nav-applications-tab" data-toggle="tab" href="#nav-applications" role="tab" aria-controls="nav-applications" aria-selected="false">
                    Live
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade text-secondary show active" id="nav-nyayomat" role="tabpanel" aria-labelledby="nav-nyayomat-tab">
                <div class="row  mb-3">
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
                                        {{Str::title('Cost')}} 
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
                                        {{Str::title('Deposit amount')}}<br>
                                        {{Str::title('(Per Unit)')}}
                                        <span class="text-muted">
                                            (Ksh)
                                        </span>
                                    </th>
                                    <th nowrap>
                                        {{Str::title('Installment Amount')}}<br>
                                        {{Str::title('(Per Unit)')}}
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
                                        <br>
                                        {{Str::title('(Per Unit)')}}
                                    </th>
                                    <th nowrap>
                                        {{Str::title('provider')}}
                                    </th>
                                    <th>
        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prep_assets as $asset)
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
                                            {{number_format((($asset->unit_cost - $asset->deposit_amount) /$asset->installment),2)}}
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
                                        <td nowrap>
                                            {{-- {{Str::title($asset -> type_a -> provider -> name)}} --}}
                                            {{$asset->shop_name}}
                                        </td>
                                        <td nowrap>
                                            <a href="#edit{{$asset->id}}" data-toggle="modal" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-primary" style="font-size: .7rem">
                                                <i class="bx bx-pencil mr-1"></i> Edit
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
                                    {{Str::title('Cost')}}
                                </th>
                                <th nowrap>
                                    {{Str::title('P. Holiday')}} 
                                    <span class="text-muted">
                                        Days
                                    </span>
                                </th>
                                <th nowrap>
                                    {{Str::title('Deposit amount')}}<br>
                                    {{Str::title('(Per Unit)')}}
                                    <span class="text-muted">
                                        (Ksh)
                                    </span>
                                </th>
                                <th nowrap>
                                    
                                    {{Str::title('Installment Amount')}}<br>
                                    {{Str::title('(Per Unit)')}}
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
                                    {{Str::title('P Duration')}}<br>
                                    {{Str::title('(Per Unit)')}}
                                    
                                </th>
                                <th nowrap>
                                    {{Str::title('provider')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($live_assets as $asset)
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
                                        {{number_format($asset->deposit_amount,2)}}
                                    </td>
                                    <td>
                                        @if($asset->units != 0)
                                        {{number_format((($asset->unit_cost - $asset->deposit_amount) / $asset->installment),2)}}
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
                                    <td nowrap>
                                        {{-- {{Str::title($asset -> type_a -> provider -> name)}} --}}
                                        {{$asset->shop_name}}
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
    @foreach ($prep_assets as $key => $asset)
    <div class="modal fade" id="edit{{$asset->id }}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{-- Edit <b>{{Str::title($asset -> type_a -> name)}}</b> from <b> {{Str::title($asset -> type_a -> provider -> name)}}</b> --}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="send{{$key}}" action="{{route('superadmin.asset.update', $asset->asset_provider_id)}}" method="POST" class="row">
                        @csrf
                        <input type="hidden" name="asset_id" value="{{$asset->id}}"/>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Asset Name :
                            </p>
                            <input type="text" name="asset_name" value="{{$asset->asset_name }}"  placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Units :
                            </p>
                            <input type="number" name="units" value="{{$asset->units }}"  placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Unit Cost :
                            </p>
                            <input type="number" name="unit_cost" value="{{$asset->unit_cost }}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Holiday Provision : <span class="text-muted">Days</span>
                            </p>
                            <input type="number" name="holiday_provision" value="{{$asset->holiday_provision }}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Deposit Amount  (Single Unit):
                            </p>
                            <input type="number" name="deposit_amount" value="{{$asset->deposit_amount }}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                No of Installment (Single Unit):
                            </p>
                            <input type="number" name="installment" step="any" value="{{$asset->installment }}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Payment Frequency :
                            </p>
                            <select name="payment_frequency" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                
                                <option value="Daily" {{ $asset->payment_frequency == "Daily" ? 'selected' : '' }}>
                                    Daily
                                </option>
                                <option value="Weekly" {{ $asset->payment_frequency == "Weekly" ? 'selected' : '' }}>
                                    Weekly
                                </option>
                                <option value="Monthly" {{ $asset->payment_frequency == "Monthly" ? 'selected' : '' }}>
                                    Monthly
                                </option>
                            </select>
                        </div>                       
                        <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Payment Mathod :
                            </p>
                            <select name="payment_method" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                <option value="Mpesa" {{ $asset->payment_method == "Mpesa" ? 'selected' : '' }}>
                                    Mpesa
                                </option>
                                <option value="Bank" {{ $asset->payment_method == "Bank" ? 'selected' : '' }}>
                                    Bank
                                </option>
                            </select>
                        </div> 
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Group :
                            </p>
                            <input type="text" value="{{$asset->group_name }}" class="col-12 py-2 rounded shadow-sm border-0" disabled>
                        </div>
                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Sub Group :
                            </p>
                            <input type="text" value="{{$asset->sub_group_name }}" class="col-12 py-2 rounded shadow-sm border-0" disabled>
                        </div>

                        <div class="col-md-4 mb-4">
                            <p class="col-12 px-0">
                                Category :
                            </p>
                            <input type="text" value="{{$asset->category_name }}" class="col-12 py-2 rounded shadow-sm border-0" disabled>
                        </div>
                        {{-- <div class="col-md-4 col-6 mb-4">
                            <p class="col-12 px-0">
                                Categories :
                            </p>
                            <select name="category_id" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off" id="">
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
@endpush
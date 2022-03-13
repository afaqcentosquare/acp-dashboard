@extends('assetprovider.master', 
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
                    Confirmed
                </a>
                <a class="nav-link" id="nav-applications-tab" data-toggle="tab" href="#nav-applications" role="tab" aria-controls="nav-applications" aria-selected="false">
                    Delivered
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
                                        {{Str::title('Deposit amount')}}
                                        <span class="text-muted">
                                            Ksh
                                        </span>
                                    </th>
                                    <th nowrap>
                                        Installment Amount 
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
                                    {{-- <th nowrap>
                                        {{Str::title('merchant')}}
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assets as $asset)
                                    <tr>
                                        <td nowrap>
                                            {{Str::title($asset->asset_name)}}
                                        </td>
                                        <td>
                                            {{$asset->order_units}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->unit_cost),2)}}
                                        </td>
                                        <td>
                                            {{$asset->holiday_provision}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->order_units * $asset->deposit_amount),2)}}
                                        </td>
                                        <td>
                                            {{number_format(($asset->order_units * ($asset->unit_cost - $asset->deposit_amount) / ($asset->installment)),2)}}
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
                                        {{-- <td nowrap>
                                            {{$asset->applicant_name}}
                                        </td> --}}
                                      
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
                                {{-- <th nowrap>
                                    {{Str::title('provider')}}
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivered_assets as $asset)
                                <tr>
                                    <td nowrap>
                                        {{Str::title($asset->asset_name)}}
                                    </td>
                                    <td>
                                        {{$asset->order_units}}
                                    </td>
                                    <td>
                                        {{number_format(($asset->unit_cost),2)}}
                                    </td>
                                    <td>
                                        {{$asset->holiday_provision}}
                                    </td>
                                    <td>
                                        {{number_format(($asset->order_units * $asset->deposit_amount),2)}}
                                    </td>
                                    <td>
                                        {{number_format(($asset->order_units * ($asset->unit_cost - $asset->deposit_amount) / ($asset->installment)),2)}}
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
                                    {{-- <td nowrap>
                                        {{$asset->applicant_name}}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </div>  

    
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
@endpush
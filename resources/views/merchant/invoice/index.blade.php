@extends('merchant.master', 
                        [
                            'title' => __("Invoices"),
                            'page_name' => 'Invoices',
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
            <a href="" class="text-primary ml-1">
                Invoices
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
                {{$merchant->name}}
            </h2>
            <span class="col-12">
                @if(!empty($merchant->location))
                    {{$merchant->location}}
                @endif
                @if (!empty($merchant->region))
                    , {{$merchant->region}}   
                @endif
                @if (!empty($merchant->city))
                    , {{$merchant->city}}   
                @endif
            </span>
            <p class="col-12 mt-3">
                <span class="text-muted mr-2 font-weight-bold">
                    Contacts :
                </span>
                <a href="tel:+" class="mr-4">
                    <i class="bx bx-phone mr-1"></i> {{$merchant->mobile}}
                </a>
                <a href="mailto:+" class="">
                    <i class="bx bx-at mr-1"></i> {{$merchant->email}}
                </a>
            </p>
            <p class="col-12">
                <span class="font-weight-bold text-muted mr-4">
                    Products Engaged : {{$calculation->asset_engaged}}
                </span>
            </p>
            <p class="col-12">
                <span class="font-weight-bold text-muted mr-4">
                    Number of Transactions : {{count($paid)}}
                </span>
            </p>
            <br>
        </div>
        <div class="col-md-6 text-md-right row">
            <h3 class="font-weight-bold text-muted col-12 mr-4">
                Account Details
            </h3>
            <div class="dropdown col-12">
       
                {{-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div> --}}
                <ul class="list-unstyled">
                    <li>
                        Total Assets Value : &nbsp;
                        Ksh.
                        <span class="mr-3">
                            {{number_format($calculation->total_assets_value,2)}}
                        </span>
                    </li>
                    <li>
                        Total Paid : &nbsp;
                        Ksh.
                        <span class="mr-3">
                            {{number_format($calculation->total_assets_value - $calculation->total_out_standing_amount,2)}}
                        </span>
                    </li>
                    <li>
                        Total Outstanding : &nbsp;
                        Ksh.
                        <span class="mr-3">
                            {{number_format($calculation->total_out_standing_amount,2)}}
                        </span>
                    </li>
                    <li>
                        {{-- <ul class="list-unstyled">
                            <li>
                                Next Payment
                                <span class="mr-3">
                                    {{Carbon\Carbon::now("Africa/Nairobi")-> addDays(rand(10,20))->format('D , d - M - Y')}}
                                </span>
                                Ksh.
                                <span class="mr-3">
                                    {{number_format(rand(100,50000),2)}}
                                </span>
                            </li> --}}
                            <li>
                                Account Balance : &nbsp;
                                Ksh.
                                <span class="mr-3">
                                    {{number_format($merchant->account_balance,2)}}
                                </span>
                            </li>
                           
                        </ul>
                        <a data-toggle="modal" href="#deposit_cash" class="btn btn-sm btn-outline-info mr-3 mt-2">
                            <i class="bx bx-money mr-1"></i> Deposit Cash
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="unpaid-tab" data-toggle="tab" href="#unpaid" role="tab" aria-controls="unpaid" aria-selected="true">
                UnPaid
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid" aria-selected="true">
                Paid
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">        
            <div class="row mt-4">
                <div class="col-12 mb-4">
                    <span class="font-weight-bold text-success mr-4">
                        @if($calculation->total_assets_value != null && $calculation->total_assets_value != 0 && $calculation->total_out_standing_amount != null && $calculation->total_out_standing_amount != 0)
                        Total Paid : {{number_format(((($calculation->total_assets_value - $calculation->total_out_standing_amount)/$calculation->total_assets_value)) * 100,2)}} %
                        @else
                        Total Paid : 0 %
                        @endif
                    </span>
                    <span class="font-weight-bold text-danger mr-4">
                        Products Defaulted  : {{$product_defaulted}}
                    </span>
                    <span class="font-weight-bold text-primary mr-4">
                        Products Owned  : {{$product_owned}}
                    </span>
                </div>
                <div class="col-12 table-responsive">
                    <table id="mytableID" class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    Transaction Id
                                </th>
                                <th nowrap>
                                    Asset Name
                                </th>
                                <th nowrap>
                                    Due Date
                                </th>
                                <th nowrap class="">
                                    Amount (Ksh)
                                </th>
                                
                                <th nowrap>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="groupDescription">
                            @foreach ($unpaid as $key => $unpaid_invoice)
                                <tr class="" style="">
                                    <td nowrap>
                                        {{$unpaid_invoice->id}}
                                    </td>
                                    <td nowrap>
                                        {{$unpaid_invoice->asset_name}}
                                    </td>
                                    <td nowrap>
                                        {{date('d-m-y', strtotime($unpaid_invoice->due_date))}}
                                    </td>
                                    <td nowrap>
                                        {{number_format($unpaid_invoice->amount,2)}}
                                    </td>
                                    <td nowrap>
                                        <a href="{{route('merchant.pay.now', $unpaid_invoice->id)}}" class="badge badge-pill shadow h4 py-2 text-uppercase px-3 badge-success" style="font-size: .7rem">
                                           Pay Now
                                        </a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">        
            <div class="row mt-4">
                <div class="col-12 table-responsive">
                    <table id="mytableID" class="table">
                        <thead>
                            <tr>
                                <th nowrap>
                                    Transaction Id
                                </th>
                                <th nowrap>
                                    Asset Name
                                </th>
                                <th nowrap>
                                    Paid On
                                </th>
                                <th nowrap>
                                    Type
                                </th>
                                <th nowrap class="">
                                    Amount (Ksh)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="accordion" id="groupDescription">
                            @foreach ($paid as $key => $paid_invoice)
                            <tr class="" style="">
                                <td nowrap>
                                    {{$paid_invoice->id}}
                                </td>
                                <td nowrap>
                                    {{$paid_invoice->asset_name}}
                                </td>
                                <td nowrap>
                                    {{date('d-m-y', strtotime($paid_invoice->paid_on))}}
                                </td>
                                <td nowrap>
                                    {{$paid_invoice->type}}
                                </td>
                                <td nowrap>
                                    {{number_format($paid_invoice->amount,2)}}
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
    {{-- Deposit Cash Start --}}
    <div class="modal fade" id="deposit_cash"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
           
            <div class="modal-content border-0 shadow-lg">
                <form method="post" action="{{route('merchant.deposit.amount')}}">
                    @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">
                        Deposit Cash
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                   <div class="row">
                        <div class="col-12">
                            <input type="number" name="deposit_amount" class="form-control" placeholder="Enter deposit amount here..."/>
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
    {{-- Deposit Cash --}}
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

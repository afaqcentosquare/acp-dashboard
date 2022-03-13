@extends('merchant.master', 
                        [
                            'title' => __("Merchant  Transactions"),
                            'page_name' => 'Merchant  Transactions',
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

@push('link-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
                Transactions
            </a>  
        </div>
    </div>
    <div class="row">
        <p class="col-12 mb-0">
            <span class="font-weight-bold text-muted h6 ">
                Number of Transactions :
                <span class="font-weight-light ml-4">{{number_format(rand(50,150),0)}}</span>
            </span>
        </p>
        <p class="col-12">
            <span class="font-weight-bold text-muted h6 ">
                Sum of Transactions : <span class="font-weight-light ml-4">Ksh. {{number_format(rand(5000,10000),2)}}</span>
            </span>
        </p>
    </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="accordion" id="accordionExample">
            <div class="row">
                @for ($i = 0; $i < 10; $i++)
                    <div class="col-12">
                        <div class="card mb-2 rounded shadow-sm border-0">
                            <div class="card-header border-0 my-0" id="headingOne">
                                <div class="row">
                                    <h2 class="col-7 mb-0">
                                        <a class="btn text-primary btn-link btn-block mt-0 text-left" type="button" data-toggle="collapse" href="#asset{{$asset = Str::random(10)}}" aria-expanded="false" aria-controls="collapseOne">
                                            Deposit
                                        </a>
                                    </h2>
                                    <p class="col-5 text-right nyayomat-blue">
                                        Ksh. {{number_format(rand(5000,10000),2)}}
                                    </p>
                                </div>
                            </div>
                            <div id="asset{{$asset}}" class="collapse border-0 text-black-50" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <span class="small-text nyayomat-blue font-weight-light mr-3">
                                                Total 
                                            </span> 
                                            
                                            <span class="text-muted mr-3">
                                                <span class="d-none">
                                                    {{$total_trans = rand(100000,1000000)}}
                                                </span>
                                                <sub>Ksh.</sub> 
                                                {{number_format($total_trans,2)}}  <i class="bx bx-minus"></i>
                                            </span>
                                        </div>
                                        <div class="col-12 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            {{__('Order ID')}}
                                                        </th>
                                                        <th>
                                                            {{__('Transaction Date')}}
                                                        </th>   
                                                        <th>
                                                            {{__('Amount')}}
                                                        </th>   
                                                        <th>
                                                            {{__('Payment Method')}}
                                                        </th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                @endfor
            </div>
        </div>
    </div>

        
        
    </div>
@endsection

@push('scripts')
<script>
    $('.filter').change(function() {
        filter_function();
        //calling filter function each select box value change
    });
    $('table tbody tr').show(); //intially all rows will be shown
        function filter_function() {
            $('table tbody tr').hide(); //hide all rows
            var companyFlag = 0;
            var companyValue = $('#filter-company').val();
            var contactFlag = 0;
            var contactValue = $('#filter-contact').val();
            var rangeFlag = 0;
            var rangeValue = $('#filter-range').val();
            var rangeminValue = $('#filter-range').find(':selected').attr('data-min');
            var rangemaxValue = $('#filter-range').find(':selected').attr('data-max');
            //setting intial values and flags needed
            //traversing each row one by one
            $('table tr').each(function() {  
                if(companyValue == 0) {   //if no value then display row
                    companyFlag = 1;
                }
                else if(companyValue == $(this).find('td.company').data('company')) { 
                    companyFlag = 1;       //if value is same display row
                }
                else {
                    companyFlag = 0;
                }
                if(contactValue == 0){
                    contactFlag = 1;
                }
                else if(contactValue == $(this).find('td.contact').data('contact')){
                    contactFlag = 1;
                }
                else{
                    contactFlag = 0;
                }
                if(rangeValue == 0){
                    rangeFlag = 1;
                }
                //condition to display rows for a range
                else if((rangeminValue <= $(this).find('td.range').data('min') && rangemaxValue >  $(this).find('td.range').data('min')) ||  (
                    rangeminValue < $(this).find('td.range').data('max') &&
                    rangemaxValue >= $(this).find('td.range').data('max'))){
                    rangeFlag = 1;
                }
                else{
                    rangeFlag = 0;
                }
                console.log(rangeminValue +' '+rangemaxValue);
                console.log($(this).find('td.range').data('min') +' '+$(this).find('td.range').data('max'));
                if(companyFlag && contactFlag && rangeFlag){
                    $(this).show();  //displaying row which satisfies all conditions
                }
            }
        );
    }
</script>
@endpush

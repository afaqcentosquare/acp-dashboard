@extends('assetprovider.master', 
                        [
                            'title' => __("Asset Provider  Transactions"),
                            'page_name' => 'Asset Provider  Transactions',
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
                Transactions
            </a>  
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="accordion" id="accordionExample">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>   
                                <th>
                                    {{__('Asset Name')}}
                                </th>
                                <th>
                                    {{__('Transaction ID')}}
                                </th>
                                <th>
                                    {{__('Payment Due Date')}}
                                </th>
                                <th>
                                    {{__('Type')}}
                                </th>
                                <th>
                                    {{__('Amount')}} (Ksh)
                                </th>   
                                <th>
                                    {{__('Transaction Date')}}
                                </th>   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{$transaction->asset_name}}
                                    </td>
                                    <td>
                                        {{$transaction->id}}
                                    </td>
                                    <td>
                                        {{Carbon\Carbon::parse($transaction->paid_on)->format('D , d - M - Y')}}
                                    </td>
                                    <td>
                                        {{$transaction->type}}
                                    </td>
                                    <td>
                                        {{number_format($transaction->amount, 2)}}
                                    </td>
                                    <td>
                                        {{Carbon\Carbon::parse($transaction->paid_on)->format('D , d - M - Y')}}
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

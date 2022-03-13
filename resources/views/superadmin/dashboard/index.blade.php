@extends('superadmin.master', 
                        [
                            'title' => __("Alternative Credit Platform Dashboard"),
                            'page_name' => 'Alternative Credit Platform Dashboard',
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
    <link href="{{asset('assets/css/graphs.css')}}" rel="stylesheet">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.3.0/snap.svg-min.js"></script>
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
            </a> 
            <a href="" class="text-primary ml-1">
                Alternative Credit Platform
            </a>  
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 mb-4">
            <a href="" class="badge badge-pill shadow py-1 px-2 badge-primary">
                Switch to Ecommerce
            </a>
        </div>
    </div>
      
    <div class="row mb-4">
        <div class="col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
            <div class="card col-12 px-0 shadow-sm border-0">
                <div class="card-body">
                    <div class="">
                        <h5 class="text-primary text-uppercase" style="font-weight: 800;opacity: .4;letter-spacing: .5px">
                            <span class="badge shadow-sm text-white bg-success">
                                Asset Providers
                            </span> 
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-success display-5  d-none d-md-inline-flex">
                                {{$total_asset_provider}}
                            </h3>
                            {{-- Stubborn-Mobile --}}
                            <h3 class="d-md-none d-sm-inline-flex mt-3 text-success" style="font-size: 4.4vh">
                                {{$total_asset_provider}}
                            </h3>
                            <p class="mb-0 mt-3 text-muted font-weight-light">
                                Listed asset providers to date
                            </p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-user pt-0 text-success icon-size"></i>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <a href="{{route('superadmin.assetprovider')}}" class="btn btn-sm btn-success" style="letter-spacing: .5px">
                                View List<i class="bx bx-right-arrow-alt font-weight-bold" style="font-size: 12px"></i> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
            <div class="card col-12 px-0 shadow-sm border-0">
                <div class="card-body">
                    <div class="">
                        <h5 class="text-primary text-uppercase" style="font-weight: 800;opacity: .4;letter-spacing: .5px">
                            <span class="badge shadow-sm text-white bg-warning">
                                Merchants
                            </span> 
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-warning display-5  d-none d-md-inline-flex">
                               {{$total_merchants}}
                            </h3>
                            {{-- Stubborn-Mobile --}}
                            <h3 class="d-md-none d-sm-inline-flex mt-3 text-warning" style="font-size: 4.4vh">
                                {{$total_merchants}}
                            </h3>
                            <p class="mb-0 mt-3 text-muted font-weight-light">
                                Listed merchants to date
                            </p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-user pt-0 text-warning icon-size"></i>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <a href="{{route('superadmin.performance')}}" class="btn btn-sm btn-warning" style="letter-spacing: .5px">
                                View List<i class="bx bx-right-arrow-alt font-weight-bold" style="font-size: 12px"></i> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
            <div class="card col-12 px-0 shadow-sm border-0">
                <div class="card-body">
                    <div class="">
                        <h5 class="text-primary text-uppercase" style="font-weight: 800;opacity: .4;letter-spacing: .5px">
                            <span class="badge shadow-sm text-white bg-primary">
                                Assets Coverage
                            </span> 
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-primary display-5  d-none d-md-inline-flex">
                                <small class="mr-2">Ksh</small> {{number_format($merchant_transaction,2)}}
                            </h3>
                            {{-- Stubborn-Mobile --}}
                            <h3 class="d-md-none d-sm-inline-flex mt-3 text-success" style="font-size: 4.4vh">
                                {{number_format($merchant_transaction,2)}}
                            </h3>
                            <p class="mb-0 mt-3 text-muted font-weight-light">
                                Assets to date
                            </p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-money pt-0 text-primary icon-size"></i>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <a href="{{route('superadmin.assets')}}" class="btn btn-sm btn-primary" style="letter-spacing: .5px">
                                View List<i class="bx bx-right-arrow-alt font-weight-bold" style="font-size: 12px"></i> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock  Outs  --}}
        <div class="col-md-4 col-lg-3 mb-3 d-flex align-items-stretch">
            <div class="card col-12 px-0 shadow-sm border-0">
                <div class="card-body">
                    <div class="">
                        <h5 class="text-warning text-uppercase" style="font-weight: 800;opacity: .4;letter-spacing: .5px">
                            <span class="badge text-white bg-info">
                                Locations
                            </span> 
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-info display-5  d-none d-md-inline-flex">
                                
                                {{0}}
                            </h3>
                            {{-- Stubborn-Mobile --}}
                            <h3 class="d-md-none d-sm-inline-flex mt-3 text-warning" style="font-size: 4.4vh">
                                {{0}}
                            </h3>
                            <p class="mb-0 mt-3 text-muted font-weight-light" >
                                Currently serving this number of of locations
                            </p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-map text-info icon-size"></i>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <a href="{{route('superadmin.locations')}}" class="btn btn-sm btn-info text-white" style="letter-spacing: .5px">
                                view <i class="bx bx-right-arrow-alt font-weight-bold" style="font-size: 12px"></i> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
      
    </div> 
@endsection

@push('scripts')
    <script> 
        var active_users = [...Array(14)].map(() => Math.floor(Math.random() * 95));       
        var sales_values = [...Array(14)].map(() => Math.floor(Math.random() * 95));       
        var stock_outs_value = [...Array(14)].map(() => Math.floor(Math.random() * 95)); 
        var rating =  Math.floor(Math.random() * 100);
        var performance =  Math.floor(Math.random() * 100);
              
        var chart_h = 40;
        var chart_w = 80;
        var stepX = 77 / 14;

        // y - axis values

        // Shop
        var active_users_chart = active_users;
        var shop_sales_chart = sales_values;
        var shop_stock_out_chart = stock_outs_value;

        function point(x, y) {
            x: 0;
            y: 0;
        }
        /* DRAW GRID */
        function drawGrid(graph) {
            var graph = Snap(graph);
            var g = graph.g();
            g.attr('id', 'grid');
            for (i = 0; i <= stepX + 2; i++) {
                var horizontalLine = graph.path(
                    "M" + 0 + "," + stepX * i + " " +
                    "L" + 77 + "," + stepX * i);
                horizontalLine.attr('class', 'horizontal');
                g.add(horizontalLine);
            };
            for (i = 0; i <= 14; i++) {
                var horizontalLine = graph.path(
                    "M" + stepX * i + "," + 38.7 + " " +
                    "L" + stepX * i + "," + 0)
                horizontalLine.attr('class', 'vertical');
                g.add(horizontalLine);
            };
        }
        drawGrid('#chart-3');
        drawGrid('#chart-2');
        drawGrid('#chart-1');

        function drawLineGraph(graph, points, container, id) {
            var graph = Snap(graph);
            /*END DRAW GRID*/
            /* PARSE POINTS */
            var myPoints = [];
            var shadowPoints = [];
            function parseData(points) {
                for (i = 0; i < points.length; i++) {
                    var p = new point();
                    var pv = points[i] / 100 * 40;
                    p.x = 83.7 / points.length * i + 1;
                    p.y = 40 - pv;
                    if (p.x > 78) {
                        p.x = 78;
                    }
                    myPoints.push(p);
                }
            }

            var segments = [];

            function createSegments(p_array) {
                for (i = 0; i < p_array.length; i++) {
                    var seg = "L" + p_array[i].x + "," + p_array[i].y;
                    if (i === 0) {
                        seg = "M" + p_array[i].x + "," + p_array[i].y;
                    }
                    segments.push(seg);
                }
            }

            function joinLine(segments_array, id) {
                var line = segments_array.join(" ");
                var line = graph.path(line);
                line.attr('id', 'graph-' + id);
                var lineLength = line.getTotalLength();

                line.attr({
                    'stroke-dasharray': lineLength,
                        'stroke-dashoffset': lineLength
                });
            }

            function calculatePercentage(points, graph) {
                var initValue = points[0];
                var endValue = points[points.length - 1];
                var sum = endValue - initValue;
                var prefix;
                var percentageGain;
                var stepCount = 1300 / sum;
                function findPrefix() {
                    if (sum > 0) {
                        prefix = "+";
                    } else {
                        prefix = "";
                    }
                }
                var percentagePrefix = "";

                function percentageChange() {
                    percentageGain = initValue / endValue * 100;
                    
                    if(percentageGain > 100){
                    console.log('over100');
                    percentageGain = Math.round(percentageGain * 100*10) / 100;
                    }else if(percentageGain < 100){
                    console.log('under100');
                    percentageGain = Math.round(percentageGain * 10) / 10;
                    }
                    if (initValue > endValue) {
                    
                        percentageGain = endValue/initValue*100-100;
                        percentageGain = percentageGain.toFixed(2);
                    
                        percentagePrefix = "";
                        $(graph).find('.percentage-value').addClass('negative');
                    } else {
                        percentagePrefix = "+";
                    }
                if(endValue > initValue){
                    percentageGain = endValue/initValue*100;
                    percentageGain = Math.round(percentageGain);
                }
                };
                percentageChange();
                findPrefix();

                var percentage = $(graph).find('.percentage-value');
                var totalGain = $(graph).find('.total-gain');
                var hVal = $(graph).find('.h-value');

                function count(graph, sum) {
                    var totalGain = $(graph).find('.total-gain');
                    var i = 0;
                    var time = 1300;
                    var intervalTime = Math.abs(time / sum);
                    var timerID = 0;
                    if (sum > 0) {
                        var timerID = setInterval(function () {
                            i++;
                            totalGain.text(percentagePrefix + i);
                            if (i === sum) clearInterval(timerID);
                        }, intervalTime);
                    } else if (sum < 0) {
                        var timerID = setInterval(function () {
                            i--;
                            totalGain.text(percentagePrefix + i);
                            if (i === sum) clearInterval(timerID);
                        }, intervalTime);
                    }
                }
                count(graph, sum);

                percentage.text(percentagePrefix + percentageGain + "%");
                totalGain.text("0%");
                setTimeout(function () {
                    percentage.addClass('visible');
                    hVal.addClass('visible');
                }, 1300);

            }


            function showValues() {
                var val1 = $(graph).find('.h-value');
                var val2 = $(graph).find('.percentage-value');
                val1.addClass('visible');
                val2.addClass('visible');
            }

            function drawPolygon(segments, id) {
                var lastel = segments[segments.length - 1];
                var polySeg = segments.slice();
                polySeg.push([78, 38.4], [1, 38.4]);
                var polyLine = polySeg.join(' ').toString();
                var replacedString = polyLine.replace(/L/g, '').replace(/M/g, "");

                var poly = graph.polygon(replacedString);
                var clip = graph.rect(-80, 0, 80, 40);
                poly.attr({
                    'id': 'poly-' + id,
                    /*'clipPath':'url(#clip)'*/
                        'clipPath': clip
                });
                clip.animate({
                    transform: 't80,0'
                }, 1300, mina.linear);
            }

            parseData(points);
            
            createSegments(myPoints);
            calculatePercentage(points, container);
            joinLine(segments,id);
        
            drawPolygon(segments, id);
            

            /*$('#poly-'+id).attr('class','show');*/

            /* function drawPolygon(segments,id){
            var polySeg = segments;
            polySeg.push([80,40],[0,40]);
            var polyLine = segments.join(' ').toString();
            var replacedString = polyLine.replace(/L/g,'').replace(/M/g,"");
            var poly = graph.polygon(replacedString);
            poly.attr('id','poly-'+id)
            }
            drawPolygon(segments,id);*/
        }
        function drawCircle(container,id,progress,parent){
        var paper = Snap(container);
        var prog = paper.path("M5,50 A45,45,0 1 1 95,50 A45,45,0 1 1 5,50");
        var lineL = prog.getTotalLength();
        var oneUnit = lineL/100;
        var toOffset = lineL - oneUnit * progress;
        var myID = 'circle-graph-'+id;
        prog.attr({
            'stroke-dashoffset':lineL,
            'stroke-dasharray':lineL,
            'id':myID
        });
        
        var animTime = 1300/*progress / 100*/
        
        prog.animate({
            'stroke-dashoffset':toOffset
        },animTime,mina.easein);
        
        function countCircle(animtime,parent,progress){
            var textContainer = $(parent).find('.circle-percentage');
            var i = 0;
            var time = 1300;
            var intervalTime = Math.abs(time / progress);
            var timerID = setInterval(function () {
            i++;
            textContainer.text(i+"%");
            if (i === progress) clearInterval(timerID);
            }, intervalTime);           
        }
        countCircle(animTime,parent,progress);
        }

        $(window).on('load',function(){
            // Shop
            //      -> Circle Charts
            drawCircle('#shop-rating-chart',1,rating,'#shop-rating-card');
            drawCircle('#shop-performance-chart',2,performance,'#shop-performance-card');
            //      -> Line Charts
            drawLineGraph('#chart-1', shop_sales_chart, '#graph-1-container', 1);
            drawLineGraph('#chart-2', shop_stock_out_chart, '#graph-2-container', 2);
            drawLineGraph('#chart-3', active_users_chart, '#graph-3-container', 3);
        });

    </script>
@endpush
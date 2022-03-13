@extends('superadmin.master', 
                        [
                            'title' => __("Asset Categories"),
                            'page_name' => 'Asset Categories',
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
            
            .nyayomat-blue{
                color: #036CB1
            }
            .bg-nyayomat-blue{
                background-color: #036CB1
            }
            .header-center {
                font-size: 2rem;
                display: grid;
                grid-template-columns: 1fr max-content 1fr;
                grid-column-gap: 1.2rem;
                align-items: center;
                opacity: 0.8;
                
            }
            .header-left {
                font-size: 2rem;
                display: grid;
                grid-template-columns: 0fr max-content 1fr;
                grid-column-gap: 1.2rem;
                align-items: center;
                opacity: 0.8;
                margin-left: -20px;
            }
            .header-right {
                font-size: 2rem;
                display: grid;
                grid-template-columns: 1fr max-content 0fr;
                grid-column-gap: 1.2rem;
                align-items: center;
                opacity: 0.8;
                
            }

            .header-right::before,
            .header-right::after {
                content: "";
                display: block;
                height: 1px;
                background-color: #000;
            }
            .header-left::before,
            .header-left::after {
                content: "";
                display: block;
                height: 1px;
                background-color: #000;
            }
            .header-center::before,
            .header-center::after {
                content: "";
                display: block;
                height: 1px;
                background-color: #000;
            }
            .card{
                border-top: 0 !important;
                margin-top: 15px !important;
            }
            .collapse{
                width: 100%
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
            <a href="" class="text-muted mr-1">
                {{Str::ucfirst("Super Admin")}}
            </a> /
            <a href="" class="text-primary ml-1">
                Groups
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

           
        {{-- Groups --}}
        <div class="col px-0 mx-auto shadow-sm rounded">
            <div class="accordion" id="groups">
                <div id="showgroups" class="collapse px-3 show" aria-labelledby="headingOne" data-parent="#groups"> 
                    <div class="header-left px-0">
                        Groups
                    </div> 
                    <div class="row">
                        <div class="col-12 text-right">
                            <a class="badge badge-pill badge-success py-2 shadow rounded collapsed"  data-toggle="collapse" href="#newgroup" aria-expanded="false" aria-controls="newgroup">
                                NEW GROUP
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col mb-4 text-left">
                            <a class="nyayomat-blue" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-link-external mr-2"></i>  Export Information
                            </a>
                        </div>
                        <div class="collapse col-12 mb-4" id="collapseExample">
                            <span class="text-uppercase font-weight-bold">
                                Select Method :
                            </span>
                            <br class="mb-2">
                            <a nowrap href="" class="mr-2  nyayomat-blue mx-3">
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
                        <div class="col-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Name  
                                        </th>
                                        <th nowrap>
                                            Sub Groups
                                        </th>
                                        <th nowrap>
                                            Categories
                                        </th>
                                        <th nowrap>
                                            Products
                                        </th>
                                        <th>
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="accordion" id="groupDescription">
                                    @foreach ($groups as $key => $group)
                                        @php
                                        $sub_groups = App\Models\SubGroup::where("group_id", $group->id)->pluck("id");
                                            $products = App\Models\Asset::where("status", "approved")
                                                                           ->whereIn("sub_group_id", $sub_groups)
                                                                           ->where("group_id", $group->id)
                                                                           ->count();
                                        @endphp
                                        <tr>
                                            <td nowrap>
                                                <a  data-toggle="collapse" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" class="mr-1 nyayomat-blue">
                                                    <i class="bx bx-info-circle"  style="font-size: 14px"></i>
                                                </a>
                                               {{$group->group_name}}
                                            </td>
                                            <td>
                                                <a href="{{route('superadmin.subgroup.view',$group->id)}}" class="nyayomat-blue font-weight-bolder">
                                                    {{$group->sub_group_count}}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('superadmin.categories.show',[$group->id,"group"])}}" class="nyayomat-blue font-weight-bolder">
                                                    {{$group->categories_count}}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" class="nyayomat-blue font-weight-bolder">
                                                    {{$products}}
                                                </a>
                                            </td>
                                            <td nowrap>
                                                <a  data-toggle="collapse" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}" class="btn btn-sm shadow-sm font-weight-bold btn-outline-success">
                                                    Add Sub  Group
                                                </a>
                                            </td>
                                        </tr>
                                        {{-- <tr id="collapse{{$key}}" class="collapse" aria-labelledby="collapse{{$key}}" data-parent="#groupDescription">
                                            <td colspan="5">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam nulla impedit sunt culpa, fuga ullam possimus voluptatum eum quos, ipsum molestias excepturi omnis dolore voluptatem blanditiis sequi aspernatur suscipit maxime.
                                                <br class="my-2">
                                                <a class="btn btn-sm shadow-sm btn-success mr-2">
                                                    <i class="bx bx-edit mr-1" style="font-size: 14px"></i> Edit
                                                </a>
                                                <a  data-toggle="collapse" href="#{{$trash = Str::random(8)}}" aria-expanded="false" aria-controls="{{Str::random(8)}}" class="mr-1 btn btn-sm shadow-sm btn-outline-danger">
                                                        <i class="bx bx-trash mr-1" style="font-size: 14px"></i> Delete
                                                </a>
                                            </td>
                                        </tr> --}}
                                        <tr id="collapse{{$key}}" class="collapse" aria-labelledby="collapse{{$key}}" data-parent="#groupDescription">
                                            <td colspan="6">
                                                <form id="sub_group_form{{$key}}" method="post" action="{{route('superadmin.subgroup.store')}}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-4 mb-3 px-4">
                                                        <div class="row">
                                                            <h6 class="col-12 px-0">
                                                                Name
                                                            </h6>
                                                            <input name="sub_group_name" type="text" class="col-12 py-2 bg-white shadow-sm rounded border-0" placeholder="Type" autocomplete="off">
                                                        </div>
                                                    </div>                                
                                                    <div class="col-md-4 mb-3 px-4">
                                                        <div class="row">
                                                            <h6 class="col-12 px-0">
                                                                Status
                                                            </h6>
                                                            <select name="status" class="col-12 py-2 bg-white shadow-sm rounded border-0">
                                                                <option value="">
                                                                    -- Status --
                                                                </option>
                                                                <option value="active">
                                                                    Active                                                                        
                                                                </option>
                                                                <option value="inactive">
                                                                    Inactive                                                                    
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>   
                                                    
                                                    <div class="col-md-2 mb-3 px-4">
                                                        <input name="group_id" value="{{$group->id}}" hidden/>
                                                        <button type="submit" class="btn col-12 mx-0 py-2 btn-success btn-sm shadow-sm">
                                                            Add  <i class="bx ml-1 bx-plus"></i>
                                                        </button>
                                                    </div>
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
                <div class="card border-0">
                    <div id="newgroup" class="collapse" aria-labelledby="headingTwo" data-parent="#groups">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="nyayomat-blue font-weight-bold "  data-toggle="collapse" href="#showgroups" aria-expanded="true" aria-controls="showgroups">
                                        Back
                                    </a>
                                </div>

                                <h5 class="col-12 text-center font-weight-bold nyayomat-blue mt-3">
                                    NEW GROUP
                                </h5>
                            </div>
                            
                            <form action="{{route('superadmin.group.store')}}" class="row" method="post">
                                @csrf
                                <div class="col-md-6 mb-4">
                                    <p class="col-12 px-0">
                                        Name :
                                    </p>
                                    <input type="text" name="group_name" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <p class="col-12 px-0">
                                        Status :
                                    </p>
                                    <select name="status" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                        <option value="">
                                           -- Set Status -- 
                                        </option>
                                        <option value="active">
                                            Active
                                        </option>
                                        <option value="inactive">
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Description :
                                    </p>
                                    <textarea name="description" placeholder="Type here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0"></textarea>
                                </div>                                
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-sm shadow-sm bg-nyayomat-blue text-white">
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
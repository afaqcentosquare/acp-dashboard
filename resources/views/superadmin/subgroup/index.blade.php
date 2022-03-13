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


@push('navs')
@include('superadmin.nav') 
@endpush


@push('link-js')
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
                Sub-groups
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
        {{-- Sub-groups --}}
        <div class="col px-0 mx-auto shadow-sm rounded">
            <div class="accordion" id="sub-groups">
                <div id="showsub-groups" class="collapse px-4 show" aria-labelledby="headingOne" data-parent="#sub-groups"> 
                    <div class="header-left px-0">
                        SUB-GROUPS
                    </div> 
                    <span class="">
                        <span class="ml-1 font-weight-bold mr-2">Group</span> 
                        <a href="">
                            {{$sub_groups->group_name}}
                        </a>
                    </span>
                    <div class="row">
                        <div class="col-12 text-right">
                            <a class="badge badge-pill badge-success py-2 shadow rounded collapsed"  data-toggle="collapse" href="#newsub-group" aria-expanded="false" aria-controls="newsub-group">
                                NEW SUB-GROUP
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
                        <input type="text" id="myInput" class="form-control col-11 ml-4 border-0 mb-3 shadow-sm" onkeyup="myFunction()" placeholder="Find By Name ..." title="Type in a name">
                        <div class="col-12 table-responsive">
                            <table class="table"  id="myTable">
                                <thead>
                                    <tr>
                                        <th>
                                            Name  
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
                                    @foreach ($sub_groups->subGroup as $key => $sub_group)
                                         @php
                                        $products = App\Models\Asset::where("status", "approved")
                                                                      ->where("sub_group_id", $sub_group->id)
                                                                      ->count();
                                        @endphp
                                        <tr>
                                            <td>
                                                <a  data-toggle="collapse" href="#subgroup_collapse{{$key}}" aria-expanded="false" aria-controls="subgroup_collapse{{$key}}" class="mr-1 nyayomat-blue">
                                                    <i class="bx bx-info-circle"  style="font-size: 14px"></i>
                                                </a>
                                                {{$sub_group->sub_group_name}}
                                            </td>
                                            <td>
                                                <a href="{{route('superadmin.categories.show',[$sub_groups->id,$sub_group->id])}}" class="nyayomat-blue font-weight-bolder">
                                                    {{$sub_group->categories_count}}
                                                </a>
                                            </td>
                                            <td>
                                                {{-- <a class="nyayomat-blue font-weight-bolder"> --}}
                                                    {{$products}}
                                                {{-- </a> --}}
                                            </td>
                                            <td>
                                                <a data-toggle="collapse" href="#subgroup_collapse{{$key}}" class="btn btn-sm mr-3 shadow-sm font-weight-bold btn-outline-success">
                                                    Add Category
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="subgroup_collapse{{$key}}" class="collapse" aria-labelledby="subgroup_collapse{{$key}}" data-parent="#groupDescription">
                                            <td colspan="5">
                                                <form action="{{route('superadmin.categories.store')}}" class="row" method="post">
                                                    @csrf
                                                    <div class="col-md-12 mb-4">
                                                        <p class="col-12 px-0">
                                                            Category Name :
                                                        </p>
                                                        <input type="text" name="category_name" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <p class="col-12 px-0">
                                                            Description :
                                                        </p>
                                                        <textarea placeholder="Type here" name="description" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0"></textarea>
                                                    </div>                                
                                                    <div class="col-12 text-center">
                                                        <input name="group_id" value="{{$sub_group->group_id}}" hidden/>
                                                        <input name="sub_group_id" value="{{$sub_group->id}}" hidden/>
                                                        <button class="btn btn-sm shadow-sm bg-nyayomat-blue text-white">
                                                            <i class="bx bx-plus mr-1"></i>Add
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
                <div class="card border-0">
                    <div id="newsub-group" class="collapse" aria-labelledby="headingTwo" data-parent="#sub-groups">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="nyayomat-blue font-weight-bold "  data-toggle="collapse" href="#showsub-groups" aria-expanded="true" aria-controls="showsub-groups">
                                        Back
                                    </a>
                                </div>

                                <h5 class="col-12 text-center font-weight-bold nyayomat-blue mt-3">
                                    NEW SUB-GROUP
                                </h5>
                            </div>
                            <form action="{{route('superadmin.subgroup.store')}}" class="row" method="post">
                                @csrf
                                <div class="col-12 mb-4">
                                    <p class="text-muted col-12 px-0">
                                        <b style="font-size: 14px">
                                            Sub Grp Name :
                                        </b>
                                    </p>
                                    <input type="text" name="sub_group_name" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                </div>
                                <div class="col-12 mb-4">
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
                                    <p class="text-muted col-12 px-0">
                                        <b style="font-size: 14px">
                                            Description :
                                        </b>
                                    </p>
                                    <textarea name="description" placeholder="Type here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0"></textarea>
                                </div>                                
                                <div class="col-12 text-center">
                                    <input name="group_id" value="{{$sub_groups->id}}" hidden/>
                                    <button type="submit" class="btn btn-sm shadow-sm bg-nyayomat-blue text-white">
                                        <i class="bx bx-plus mr-1"></i>Add
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
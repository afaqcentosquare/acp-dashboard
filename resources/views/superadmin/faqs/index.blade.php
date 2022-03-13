@extends('superadmin.master', 
                        [
                            'title' => __("Frequently Asked Questions"),
                            'page_name' => 'Frequently Asked Questions',
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
                Frequently Asked Questions
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
      
    <div class="row">
        {{-- Topics --}}
        <div class="col-md-3">
            <div class="accordion" id="topics">
                    <div id="showTopics" class="collapse show" aria-labelledby="headingOne" data-parent="#topics">
                        <div class="header-left px-0">
                            Topics
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3 text-right">
                                <a class="badge badge-pill badge-success py-2 shadow rounded collapsed"  data-toggle="collapse" href="#newTopic" aria-expanded="false" aria-controls="newTopic">
                                    Add Topic
                                </a>
                            </div>
                            <div class="col-12 mt-2">
                                <table class="table">
                                    <tbody>
                                        @foreach ($topics as $key => $topic)
                                            <tr>
                                                <td nowrap>
                                                    {{$topic->topic_name}}
                                                </td>
                                                <td nowrap>
                                                    {{$topic->target_group}}
                                                </td>
                                                <td nowrap>
                                                    <a href="#editfaqtopic{{$key}}" class="mr-2" data-toggle="modal">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="#deletefaq" class="mr-2" data-toggle="modal">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="col-12 px-4 text-muted font-weight-bold">
                                Tips
                            </h6>
                            <ul class="col-12 px-4 text-muted list-unstyled">
                                <li class="">
                                    <i class="bx bx-check mr-2"></i> 
                                    Click on topic item to filter the FAQ's
                                </li>
                            </ul>
                        </div>
                    </div>
                <div class="card rounded">
                    <div id="newTopic" class="collapse" aria-labelledby="headingTwo" data-parent="#topics">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="nyayomat-blue font-weight-bold rounded"  data-toggle="collapse" href="#showTopics" aria-expanded="true" aria-controls="showTopics">
                                        Back
                                    </a>
                                </div>

                                <h5 class="col-12 text-center font-weight-bold nyayomat-blue mt-3">
                                    NEW TOPIC
                                </h5>
                            </div>
                            <form action="{{route('superadmin.faqs.topic.store')}}" class="row" method="post">
                                @csrf
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Topic Title :
                                    </p>
                                    <input type="text" name="topic_name" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                </div>
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Target Group :
                                    </p>
                                    <select name="target_group" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                        <option value="">
                                            -- Select One --
                                        </option>
                                        <option value="Customer">
                                            Customer
                                        </option>
                                        <option value="Merchant">
                                            Merchant
                                        </option>
                                        <option value="Asset Provider">
                                             Asset Provider 
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <button  class="btn btn-sm shadow-sm bg-nyayomat-blue text-white">
                                        <i class="bx bx-plus mr-1"></i>Add
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- FAQs --}}
        <div class="col-md-9 shadow-sm rounded">
            <div class="accordion" id="faqs">
                <div id="showfaqs" class="collapse show" aria-labelledby="headingOne" data-parent="#faqs"> 
                    <div class="header-left px-0">
                        FAQ's
                    </div> 
                    <div class="row">
                        <div class="col-12 text-right">
                            <a class="badge badge-pill badge-success py-2 shadow rounded collapsed"  data-toggle="collapse" href="#newfaq" aria-expanded="false" aria-controls="newfaq">
                                ADD FAQ
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

                        @foreach ($faqs as $key => $faq)
                        <div class="col-12">
                            <div class="media">
                                <span class="bg-nyayomat-blue p-1 pb-0  rounded shadow-lg text-white" style="opacity: 0.5">
                                    <i class="bx bx-question-mark mb-0"></i>
                                </span>
                                <div class="media-body">
                                    <div class="row px-2">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="mt-0 mx-auto font-weight-bold text-uppercase">
                                                        {{$faq->question}}
                                                    </h6>
                                                </div>
                                                <div class="col mr-3 pr-4 text-right">
                                                    <a href="#editfaq{{$key}}" class="mr-2" data-toggle="modal">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="#deletefaq" class="mr-2" data-toggle="modal">
                                                        <i class="bx bx-trash text-danger"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <p>{{$faq->answer}}</p>
                                        </div>
                                        <div class="col-6 text-muted">
                                            <span class="font-weight-bold">
                                                Topic Name
                                            </span> <span class="ml-2">{{$faq->topic_name}}</span>
                                        </div>
                                        <div class="col-6 pr-lg-5 text-right text-muted">
                                            <span class="font-weight-bold ">
                                                Last Updated
                                            </span> <span class="ml-2">{{$faq->updated_at}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-10 mx-auto border-bottom my-3 shadow-lg"></div>
                        @endforeach
                    </div>
                    
                </div>
                <div class="card">
                    <div id="newfaq" class="collapse" aria-labelledby="headingTwo" data-parent="#faqs">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="nyayomat-blue font-weight-bold "  data-toggle="collapse" href="#showfaqs" aria-expanded="true" aria-controls="showfaqs">
                                        Back
                                    </a>
                                </div>

                                <h5 class="col-12 text-center font-weight-bold nyayomat-blue mt-3">
                                    NEW FAQ
                                </h5>
                            </div>
                            <form action="{{route('superadmin.faqs.store')}}" class="row" method="post">
                                @csrf
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Topic :
                                    </p>
                                    <select name="topic_id" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                        <option value="">
                                            -- Select Topic --
                                        </option>
                                        @foreach ($topics as $topic)
                                            <option value="{{$topic->id}}">
                                                {{$topic->topic_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Question :
                                    </p>
                                    <input type="text" name="question" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                </div>
                                <div class="col-12 mb-4">
                                    <p class="col-12 px-0">
                                        Answer :
                                    </p>
                                    <textarea name="answer" placeholder="Type here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0"></textarea>
                                </div>
                                <div class="col-12 text-center">
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
    
    @foreach ($topics as $key => $topic)
    <div class="modal fade" id="editfaqtopic{{$key}}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{-- Edit <b>{{Str::title($asset -> type_a -> name)}}</b> from <b> {{Str::title($asset -> type_a -> provider -> name)}}</b> --}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_faq_form{{$key}}" action="{{route('superadmin.faqs.topic.update', $topic->id)}}"  method="POST" class="row">
                        @csrf
                            <div class="col-md-6 mb-4">
                                <p class="col-12 px-0">
                                    Topic Name :
                                </p>
                                <input type="text" name="topic_name" value="{{$topic->topic_name}}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                            </div>
                            <div class="col-md-6 mb-4">
                                <p class="col-12 px-0">
                                    
                                    Target Group :
                                </p>
                                <select name="target_group" class="col-12 bg-white shadow-sm py-2 rounded border-0 mx-auto" autocomplete="off">
                                    <option value="Customer" {{ $topic->target_group == "Customer" ? 'selected' : '' }}>
                                        Customer
                                    </option>
                                    <option value="Merchant" {{ $topic->target_group == "Merchant" ? 'selected' : '' }}>
                                        Merchant
                                    </option>
                                    <option value="Asset Provider" {{ $topic->target_group == "Asset Provider" ? 'selected' : '' }}>
                                        Asset Provider
                                    </option>
                                </select>
                            </div> 
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

    @foreach ($faqs as $key => $faq)
    <div class="modal fade" id="editfaq{{$key}}"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{-- Edit <b>{{Str::title($asset -> type_a -> name)}}</b> from <b> {{Str::title($asset -> type_a -> provider -> name)}}</b> --}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_faq_form{{$key}}" action="{{route('superadmin.faqs.update',$faq->id)}}" class="row" method="post">
                        @csrf
                        <div class="col-12 mb-4">
                            <p class="col-12 px-0">
                                Topic :
                            </p>
                            <select name="topic_id" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                                <option value="">
                                    -- Select Topic --
                                </option>
                                @foreach ($topics as $topic)
                                    <option value="{{$topic->id}}" {{ $faq->id == $topic->id ? 'selected' : '' }}>
                                        {{$topic->topic_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-4">
                            <p class="col-12 px-0">
                                Question :
                            </p>
                            <input type="text" name="question" value="{{$faq->question}}" placeholder="Type Here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">
                        </div>
                        <div class="col-12 mb-4">
                            <p class="col-12 px-0">
                                Answer :
                            </p>
                            <textarea name="answer"  placeholder="Type here" autocomplete="off" class="col-12 py-2 rounded shadow-sm border-0">{{$faq->answer}}</textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-sm shadow-sm bg-nyayomat-blue text-white">
                                <i class="bx bx-plus mr-1"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <div class="modal fade" id="deletefaq"  data-keyboard="false"  data-backdrop="false" tabindex="-1" aria-hidden="true">
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
                    <form id="send"  method="POST" class="row">
                        @csrf
                        @method('PATCH')
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">
                                    Title
                                </label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">
                                    Audience
                                </label>
                                <select multiple class="form-control" id="exampleFormControlSelect2">
                                    <option>
                                        Merchant
                                    </option>
                                    <option>
                                        Asset Providers
                                    </option>
                                </select>
                              </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">
                                    Body
                                </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </form>
                       
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
@endsection

@push('scripts')
@endpush

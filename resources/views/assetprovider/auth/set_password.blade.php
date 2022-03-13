<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{-- {{Str::title($title)}} -  --}}
            {{ config('app.name') }}
        </title>
        <!-- Favicon -->
        <!-- <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png"> -->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->
        <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100;200;300;800&display=swap" rel="stylesheet"> 
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/joash/css/custom-dashboard.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="{{asset('css/aos.css')}}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        @stack('header_items')
    </head>
    <body class="bg-white" style="background-image: url('{{ asset('uploads/landscape.jpg')}}');">
        <div class="wrapper pt-5">
            <div class="card" style="border-radius: 20px;">
                <div class="row">
                    <div class="col-md-12 px-md-5 mt-4">
                            <p class="login-card-description">
                                Set Password for Your Account
                            </p>
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
                            <form action="{{route('assetprovider.set.password', encrypt($asset_provider->id))}}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="inputEmail4">
                                            Applicant Name
                                        </label>
                                        <input type="text" class="form-control" name="applicant_name" placeholder="Enter applicant name here...." value="{{old("applicant_name", $asset_provider->applicant_name)}}" disabled>
                                        @if($errors->has('applicant_name'))
                                            <span class="form-text">{{ $errors->first('applicant_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label>
                                            Shop Name
                                        </label>
                                        <input type="text" class="form-control" name="shop_name" placeholder="Enter shop name here...." value="{{old("shop_name", $asset_provider->shop_name)}}" disabled>
                                        @if($errors->has('shop_name'))
                                            <span class="form-text">{{ $errors->first('shop_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Phone">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number here...." value="{{old("phone", $asset_provider->phone)}}" disabled>
                                        @if($errors->has('phone'))
                                            <span class="form-text">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter email here...." value="{{old("email", $asset_provider->email)}}" disabled>
                                        @if($errors->has('email'))
                                        <span class="form-text">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter password here....">
                                        @if($errors->has('password'))
                                            <span class="form-text">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Enter confirm password here....">
                                        @if($errors->has('password_confirmation'))
                                        <span class="form-text">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>
                               
                                <div class="form-row">
                                    <button type="submit" class="btn btn-primary col-12">
                                        Submit
                                    </button>
                                </div>
                            </form>
                            
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        
      
        <script src="{{asset('js/aos.js')}}"></script>
    </body>
</html>

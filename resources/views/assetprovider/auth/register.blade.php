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
                                Sign Up to your account
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
                            <form action="{{route('assetprovider.register.request')}}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="inputEmail4">
                                            Applicant Name
                                        </label>
                                        <input type="text" class="form-control" name="applicant_name" placeholder="Enter applicant name here...." value="{{old("applicant_name")}}">
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
                                        <input type="text" class="form-control" name="shop_name" placeholder="Enter shop name here...." value="{{old("shop_name")}}">
                                        @if($errors->has('shop_name'))
                                            <span class="form-text">{{ $errors->first('shop_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Phone">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number here...." value="{{old("phone")}}">
                                        @if($errors->has('phone'))
                                            <span class="form-text">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter email here...." value="{{old("email")}}">
                                        @if($errors->has('email'))
                                        <span class="form-text">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="county">County</label>
                                        <select id="county" name="county" class="form-control" value="{{old("county")}}">
                                            <option value="">
                                                {{__('- Select County -')}}
                                            </option>
                                            <option value="Mombasa">
                                                {{__('Mombasa')}}
                                            </option>
                                            <option value="Kwale">
                                                {{__('Kwale')}}
                                            </option>
                                            <option value="Kilifi">
                                                {{__('Kilifi')}}
                                            </option>
                                            <option value="Tana River">
                                                {{__('Tana River')}}
                                            </option>
                                            <option value="Lamu">
                                                {{__('Lamu')}}
                                            </option>
                                            <option value="Taita Taveta">
                                                {{__('Taita Taveta')}}
                                            </option>
                                            <option value="Garissa">
                                                {{__('Garissa')}}
                                            </option>
                                            <option value="Wajir">
                                                {{__('Wajir')}}
                                            </option>
                                            <option value="Mandera">
                                                {{__('Mandera')}}
                                            </option>
                                            <option value="Marsabit">
                                                {{__('Marsabit')}}
                                            </option>
                                            <option value="Turkana">
                                                {{__('Turkana')}}
                                            </option>
                                            <option value="Isiolo">
                                                {{__('Isiolo')}}
                                            </option>
                                            <option value="Meru">
                                                {{__('Meru')}}
                                            </option>
                                            <option value="Tharaka-Nithi">
                                                {{__('Tharaka-Nithi')}}
                                            </option>
                                            <option value="Embu">
                                                {{__('Embu')}}
                                            </option>
                                            <option value="Kitui">
                                                {{__('Kitui')}}
                                            </option>
                                            <option value="Machakos">
                                                {{__('Machakos')}}
                                            </option>
                                            <option value="Makueni">
                                                {{__('Makueni')}}
                                            </option>
                                            <option value="Nyandarua">
                                                {{__('Nyandarua')}}
                                            </option>
                                            <option value="Nyeri">
                                                {{__('Nyeri')}}
                                            </option>
                                            <option value="Kirinyaga">
                                                {{__('Kirinyaga')}}
                                            </option>
                                            <option value="Muranga">
                                                {{__('Muranga')}}
                                            </option>
                                            <option value="Kiambu">
                                                {{__('Kiambu')}}
                                            </option>
                                            <option value="West Pokot">
                                                {{__('West Pokot')}}
                                            </option>
                                            <option value="Samburu">
                                                {{__('Samburu')}}
                                            </option>
                                            <option value="Trans Nzoia">
                                                {{__('Trans Nzoia')}}
                                            </option>
                                            <option value="Usain Gishu">
                                                {{__('Usain Gishu')}}
                                            </option>
                                            <option value="Elgeyo Marakwet">
                                                {{__('Elgeyo Marakwet')}}
                                            </option>
                                            <option value="Nandi">
                                                {{__('Nandi')}}
                                            </option>
                                            <option value="Baringo">
                                                {{__('Baringo')}}
                                            </option>
                                            <option value="Laikipia">
                                                {{__('Laikipia')}}
                                            </option>
                                            <option value="Nakuru">
                                                {{__('Nakuru')}}
                                            </option>
                                            <option value="Narok">
                                                {{__('Narok')}}
                                            </option>
                                            <option value="Kajiado">
                                                {{__('Kajiado')}}
                                            </option>
                                            <option value="Kericho">
                                                {{__('Kericho')}}
                                            </option>
                                            <option value="Bomet">
                                                {{__('Bomet')}}
                                            </option>
                                            <option value="Kakamega">
                                                {{__('Kakamega')}}
                                            </option>
                                            <option value="Vihiga">
                                                {{__('Vihiga')}}
                                            </option>
                                            <option value="Bungoma">
                                                {{__('Bungoma')}}
                                            </option>
                                            <option value="Busia">
                                                {{__('Busia')}}
                                            </option>
                                            <option value="Siaya">
                                                {{__('Siaya')}}
                                            </option>
                                            <option value="Kisumu">
                                                {{__('Kisumu')}}
                                            </option>
                                            <option value="Homa Bay">
                                                {{__('Homa Bay')}}
                                            </option>
                                            <option value="Migori">
                                                {{__('Migori')}}
                                            </option>
                                            <option value="Kisii">
                                                {{__('Kisii')}}
                                            </option>
                                            <option value="Nyamira">
                                                {{__('Nyamira')}}
                                            </option>
                                            <option value="Nairobi">
                                                {{__('Nairobi')}}
                                            </option>
                                        </select>
                                        @if($errors->has('county'))
                                        <span class="form-text">{{ $errors->first('county') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="sub_county">Sub County</label>
                                        <input type="text" name="sub_county" class="form-control" placeholder="Enter sub county here...." value="{{old("sub_county")}}">
                                        @if($errors->has('sub_county'))
                                        <span class="form-text">{{ $errors->first('sub_county') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" class="form-control" placeholder="Enter location here...." value="{{old("location")}}">
                                        @if($errors->has('location'))
                                        <span class="form-text">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label>Operating Days</label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="monday" id="monday" type="checkbox" {{ old('monday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="monday">
                                                Monday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="tuesday" id="tuesday" type="checkbox" {{ old('tuesday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="tuesday">
                                                Tuesday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="wednesday" id="wednesday" type="checkbox" {{ old('wednesday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="wednesday">
                                                Wednesday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="thursday" id="thursday" type="checkbox" {{ old('thursday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="thursday">
                                                Thursday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="friday" id="friday" type="checkbox" {{ old('friday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="friday">
                                                Friday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="saturday" id="saturday" type="checkbox" {{ old('saturday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="saturday">
                                                Saturday
                                            </label>
                                        </div>
                                        <div class="custom-control-alternative custom-checkbox form-check-inline" style="padding-left: 1.75rem;">
                                            <input class="custom-control-input" name="sunday" id="sunday" type="checkbox" {{ old('sunday') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="sunday">
                                                Sunday
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-primary col-12">
                                        Submit
                                    </button>
                                </div>
                            </form>
                            <p class="login-card-footer-text">
                                <br>
                                Already have an account ? 
                                <a href="#" class="text-reset">
                                    Sign In here
                                </a>
                            </p>
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

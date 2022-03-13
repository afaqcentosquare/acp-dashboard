<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>
            Defaulter Profiles
        </title>
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    </head>
<body>
<!-- ******HEADER****** -->
  <header class="header">
    <div class="container">
      <div class="teacher-name" style="padding-top:20px;">
        <div class="row" style="margin-top:0px;">
        <div class="col-md-9">
          <h2 style="font-size:38px">
            <strong>
                Merchant / Defaulter
            </strong></h2>
        </div>
        <div class="col-md-3">
          <div class="button" style="float:right;">
            <a href="{{route("superadmin.performance")}}" class="btn btn-outline-success btn-sm">
                Back
            </a>
          </div>
        </div>
        </div>
      </div>

      <div class="row" style="margin-top:20px;">
        <div class="col-md-6"> <!-- Rank & Qualifications -->
          <h5 class="">
            Owner : 
            <small class="text-info">{{$merchant->name}}</small>
        </h5>
        <p>
           Owner  Contacts : 
            <span class="ml-3">
                <a href="tel:{{$merchant->mobile}}" class="btn btn-md btn-info">
                    <i class="fas fa-mobile"></i> Phone
                </a>
            </span> 
            <span class="ml-3">
                <a href="mailto:{{$merchant->email}}" class="btn btn-outline-info">
                    <i class="fas fa-envelope"></i> E mail
                </a>
            </span> 
        </p>
            <p>
              @if ($merchant->location != null)
              Address:
              {{$merchant->location}}
              @endif
              @if ($merchant->region != null)
              ,{{$merchant->region}}
              @endif
              @if ($merchant->city != null)
              ,{{$merchant->city}}
              @endif
            </p>
        </div>

        {{-- <div class="col-md-3 text-center"> <!-- Phone & Social -->
            <span class="number" style="font-size:18px">
                <a href="tel:" class="btn btn-block btn-md btn-success">
                    <i class="fas fa-mobile"></i> Call Merchant
                </a>
            </span>
          <div class="button" style="padding-top:18px">
            <a href="mailto:ahmkctg@yahoo.com" class="btn btn-outline-success btn-block">
                <i class="fas fa-envelope"></i> Mail Merchant
            </a>
          </div>
        </div> --}}
      </div>
    </div>
  </header>
    <!--End of Header-->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-block border-0">
                   
                    <table class="table table-bordered">
                    <thead class="thead-default">
                        <tr>
                            <th>Asset</th>
                            <th>Status</th>
                            <th>Last Payment</th>
                            <th>Pending Installments</th>
                            <th>Total Outstanding</th>
                            <th>Total Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($merchant->orderAssets as $asset)
                        @php
                            $asset_name = App\Models\Asset::select("asset_name as name")->where('id', $asset->asset_id)->first();
                            $total = App\Models\MerchantAssetOrder::where("asset_id", $asset->asset_id)
                                                    ->where("merchant_id", $merchant->id)
                                                    ->selectRaw("asset_id,sum(total_out_standing_amount) as total_out_standing_amount, sum(units * unit_cost) as total_cost")
                                                    ->groupBy("asset_id")
                                                    ->first();

                            $total_pending_installments = App\Models\MerchantTransaction::where("asset_id", $asset->asset_id)
                                                    ->where("merchant_id", $merchant->id)
                                                    ->wherenull("paid_on")                            
                                                    ->count();
                        @endphp
                        <tr>
                            <td>
                                {{Str::upper($asset_name->name)}} 
                            </td>
                            <td nowrap>
                                <div class="progress">
                                    @php
                                        $progress = 0 ;
                                        if($total->total_out_standing_amount != null && $total->total_out_standing_amount != 0 && $total->total_cost != null && $total->total_cost != 0){
                                            $progress = (($total->total_cost - $total->total_out_standing_amount)/$total->total_cost) * 100;
                                        }
                                    @endphp
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{Carbon\Carbon::now()->subMonths(rand(1, 55))->subDays(rand(1, 32))->format('D - d , M - Y')}}
                            </td>
                            <td>
                                {{$total_pending_installments}}
                            </td>
                            <td>
                                <span class="text-danger">
                                    {{number_format($total->total_out_standing_amount,2)}} 
                                </span> 
                            </td>
                            <td>
                                <span class="text-success">
                                    {{number_format($total->total_cost - $total->total_out_standing_amount,2)}} 
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>
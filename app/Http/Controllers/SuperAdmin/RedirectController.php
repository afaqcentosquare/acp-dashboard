<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectMerchant($id)
    {
        session([
            "merchant_id" => $id
        ]);

        return redirect()->route("merchant.dashboard");
    }

    public function assetProviderRedirect($id)
    {
        session([
            "asset_provider_id" => $id
        ]);

        return redirect()->route("assetprovider.dashboard");
    }
}

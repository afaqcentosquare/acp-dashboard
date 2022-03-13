<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_acp_assets';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function orderAssets()
    {
        return $this->hasmany(MerchantAssetOrder::class, 'asset_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(AssetProviderTransaction::class, 'asset_id', 'id');
    }

    public function nextReceipt()
    {
        return $this->hasone(AssetProviderTransaction::class, 'asset_id', 'id');
    }

}

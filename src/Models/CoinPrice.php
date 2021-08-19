<?php

namespace Nidavellir\CryptoCube\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'current_price' => 'decimal:4',
        'market_cap' => 'decimal:0',
        'high_24h' => 'decimal:4',
        'low_24h' => 'decimal:4',
        'price_change_24h' => 'decimal:4',
        'price_change_percentage_24h' => 'decimal:4',
        'market_cap_change_24h' => 'decimal:0',
        'market_cap_change_percentage_24h' => 'decimal:4',
        'circulating_supply' => 'decimal:4',
        'total_supply' => 'decimal:4',
        'max_supply' => 'decimal:4',
        'ath' => 'decimal:4',
        'ath_change_percentage' => 'decimal:4',
        'atl' => 'decimal:4',
        'atl_change_percentage' => 'decimal:4',

        'market_cap_rank' => 'integer',
        'total_volume' => 'integer',

        'ath_date' => 'datetime',
        'atl_date' => 'datetime',
        'last_updated' => 'datetime',
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}

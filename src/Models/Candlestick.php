<?php

namespace Nidavellir\CryptoCube\Models;

use IgnorableObservers\IgnorableObservers;
use Illuminate\Database\Eloquent\Model;

class Candlestick extends Model
{
    use IgnorableObservers;

    protected $guarded = [];

    protected $table = 'candlesticks';

    public $timestamps = false;

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',

        'open' => 'decimal:5',
        'high' => 'decimal:5',
        'low' => 'decimal:5',
        'close' => 'decimal:5',
        'base_asset_volume' => 'decimal:4',
        'quote_asset_volume' => 'decimal:4',
        'taker_buy_base_asset_volume' => 'decimal:4',
        'taker_buy_quote_asset_volume' => 'decimal:4',
        'vwma' => 'decimal:4',
        'perc_price_variance' => 'decimal:4',
        'perc_volume_variance' => 'decimal:4',

        'trades' => 'integer',
        'opened_at_milliseconds' => 'integer',
        'closed_at_milliseconds' => 'integer',
    ];

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }
}

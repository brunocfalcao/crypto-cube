<?php

namespace Nidavellir\CryptoCube\Models;

use IgnorableObservers\IgnorableObservers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Symbol extends Model
{
    use HasFactory;
    use SoftDeletes;
    use IgnorableObservers;

    protected $guarded = [];

    protected $casts = [
        'is_crawling_prices' => 'boolean',
        'market_cap_rank' => 'integer',
    ];

    public function candlesticks()
    {
        return $this->hasMany(Candlestick::class);
    }
}

<?php

namespace Nidavellir\CryptoCube\Models;

use IgnorableObservers\IgnorableObservers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Token extends Model
{
    use HasFactory;
    use SoftDeletes;
    use IgnorableObservers;
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'market_cap_rank' => 'integer',
    ];

    public function candlesticks()
    {
        return $this->hasMany(Candlestick::class);
    }
}

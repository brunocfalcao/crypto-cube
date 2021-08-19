<?php

namespace Nidavellir\CryptoCube\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'genesis_date' => 'date',
        'alexa_rank' => 'integer',
    ];

    public function prices()
    {
        return $this->hasMany(CoinPrice::class);
    }
}

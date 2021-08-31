<?php

namespace Nidavellir\CryptoCube\Models;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'is_live' => 'boolean',
        'cooldown_until' => 'datetime',
    ];
}

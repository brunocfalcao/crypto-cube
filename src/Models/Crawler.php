<?php

namespace Nidavellir\CryptoCube\Models;

use IgnorableObservers\IgnorableObservers;
use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    use IgnorableObservers;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'is_live' => 'boolean',
        'cooldown_until' => 'datetime',
    ];
}

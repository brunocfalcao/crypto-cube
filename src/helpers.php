<?php

use Nidavellir\CryptoCube\Models\Candlestick;

function milliseconds(int $milliseconds = null, string $date = null)
{
    // Returns the datetime given the milliseconds.
    if ($milliseconds) {
        return date('Y-m-d H:i:s', $milliseconds / 1000);
    }

    // Returns the milliseconds given the datetime.
    if ($date) {
        return 1000 * strtotime($date);
    }

    // Returns the milliseconds of now.
    return (int) (now()->timestamp.str_pad(now()->milli, 3, '0', STR_PAD_LEFT));
}

/**
 * Returns N previous candlesticks from the refered candlestick
 * If it can't find the N, then returns as much candlesticks as possible.
 *
 * @param  int    $number Total candlesticks to return.
 *
 * @return Eloquent collection
 */

/**
 * Returns N previous candlesticks from the refered candlestick
 * If it can't find the N, then returns as much candlesticks as possible.
 *
 * @param  Candlestick $candlestick
 * @param  int         $number
 *
 * @return Eloquent\Collection
 */
function previous_candlesticks_absolute(Candlestick $candlestick, int $number = 1)
{
    return Candlestick
        ::where('closed_at_milliseconds', '<', $candlestick->closed_at_milliseconds)
        ->where('symbol_id', $candlestick->symbol_id)
        ->where('id', '<>', $candlestick->id)
        ->orderBy('closed_at_milliseconds', 'desc')
        ->take($number)
        ->get();
}

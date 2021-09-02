<?php

namespace Nidavellir\CryptoCube\Observers;

use Nidavellir\CryptoCube\Models\Candlestick;

class CandlestickObserver
{
    /**
     * Handle the Candlestick "created" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function created(Candlestick $candlestick)
    {
        //
    }

    /**
     * Handle the Candlestick "updated" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function updated(Candlestick $candlestick)
    {
        //
    }

    /**
     * Handle the Candlestick "deleted" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function deleted(Candlestick $candlestick)
    {
        //
    }

    /**
     * Handle the Candlestick "restored" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function restored(Candlestick $candlestick)
    {
        //
    }

    /**
     * Handle the Candlestick "force deleted" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function forceDeleted(Candlestick $candlestick)
    {
        //
    }

    /**
     * Handle the Candlestick "saved" event.
     *
     * @param  \App\Models\Candlestick  $candlestick
     * @return void
     */
    public function saved(Candlestick $candlestick)
    {
        Candlestick::ignoreObservableEvents();

        /**
         * Indicators that are calculated each time a new candlestick
         * is added to a canonical.
         */

        /**
         * VWMA - Volume-weighted moving average.
         * https://therobusttrader.com/volume-weighted-moving-average/.
         *
         * VWMA= (Current close*volume + previous close*volume)
         *       ----------------------------------------------- (divided)
         *       (Volume of current bar + volume of last bar)
         */
        $previousCandlesticks = previous_candlesticks_absolute($candlestick, 3);

        if ($previousCandlesticks->count() > 0) {
            $numerator = $candlestick->close * $candlestick->volume;
            $denominator = $candlestick->volume;

            foreach ($previousCandlesticks as $pivot) {
                $numerator += ($pivot->close * $pivot->volume);
                $denominator += $pivot->volume;
            }

            $candlestick->update(['vwma' => $numerator / $denominator]);
        }

        // Grab the previous 2 candlesticks for computations.
        $previous = previous_candlesticks_absolute($candlestick, 2);

        // calculate volume and price percentages variances.
        if ($previous->count() > 0) {
            $pivot = $previous->first(); // Latest previous candlestick.
            $price_variance = 100 * ($candlestick->close - $pivot->close) / $pivot->close;
            $volume_variance = 100 * ($candlestick->volume - $pivot->volume) / $pivot->volume;
            $candlestick->update([
                'perc_price_variance' => $price_variance,
                'perc_volume_variance' => $volume_variance,
            ]);
        }

        /**
         * Breakout calculations.
         * Check if this close price is breaking out any of the breakout
         * intervals defined (1w, 2w, 1m, 3m, 6m, 1y).
         *
         * Descending order please!
         */
        $intervals = [
            '1 WEEK' => '1W',
            '2 WEEK' => '2W',
            '1 MONTH' => '1M',
            '3 MONTH' => '3M',
            '6 MONTH' => '6M',
            '1 YEAR'  => '1Y',
        ];

        $pivot = $previous->count() > 0 ? $previous->last() : null;

        foreach ($intervals as $key => $value) {
            $maxInterval = Candlestick::whereRaw('closed_at > date_sub(?, interval '.$key.')', [$candlestick->closed_at])
                               ->where('symbol_id', $candlestick->symbol_id)
                               ->where('id', '<>', $candlestick->id)
                               ->where('id', '<>', optional($pivot)->id)
                               ->orderBy('close', 'desc')
                               ->first();

            if ($maxInterval && $maxInterval->close < $candlestick->close) {
                $candlestick->update([
                'breakout' => $value,
                ]);
            }
        }

        /**
         * Mark the candlestick level_type (the previous one)
         * dip (meaning it is surrounded by 2 higher close prices)
         * tip (meaning it is surrounded by 2 lower close prices)
         */

        if ($previous->count() == 2) {
            $previous2ago = $previous->first();
            $previous1ago = $previous->last();

            $previous2ago->update(['level_type' => null]);
            $previous1ago->update(['level_type' => null]);

            if ($previous2ago->close > $previous1ago->close &&
            $candlestick->close > $previous1ago->close) {
                $previous1ago->update(['level_type' => 'dip']);
                $previous2ago->update(['level_type' => null]);
            }

            if ($previous2ago->close < $previous1ago->close &&
            $candlestick->close < $previous1ago->close) {
                $previous1ago->update(['level_type' => 'tip']);
                $previous2ago->update(['level_type' => 'null']);
            }
        }


        /**
         * Record the candlestick type.
         *https://www.ig.com/en/trading-strategies/16-candlestick-patterns-every-trader-should-know-180615.
         */

        /**
         * HAMMER
         * The hammer candlestick pattern is formed of a short body with a long
         * lower wick, and is found at the bottom of a downward trend.
         * A hammer shows that although there were selling pressures during the
         * day, ultimately a strong buying pressure drove the price back up.
         * The colour of the body can vary, but green hammers indicate a
         * stronger bull market than red hammers.
         */
        if ($candlestick->high == $candlestick->open) {
            $candlestick->type = 'hammer';
        }

        Candlestick::unignoreObservableEvents();
    }
}

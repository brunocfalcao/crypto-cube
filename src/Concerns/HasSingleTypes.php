<?php

namespace Nidavellir\CryptoCube\Concerns;

trait HasSingleTypes
{
    public function computeSingleType()
    {
        /**
         * INVERSE-HAMMER
         * A similarly bullish pattern is the inverted hammer. The only
         * difference being that the upper wick is long, while the lower wick
         * is short.
         * It indicates a buying pressure, followed by a selling pressure that
         * was not strong enough to drive the market price down. The inverse
         * hammer suggests that buyers will soon have control of the market.
         *
         * Computation limits:
         * - Low pin size is glued down less than (stype_ih_bottom_perc)%
         * - High pin size is at least (stype_ih_top_perc)% from pin size
         * - Candle size is no more than (stype_ih_candle_perc)% from pin size
         */
        $stype_ih_top_abs = round($this->pin * $this->token->stype_ih_top_percentage / 100, 5);
        $stype_ih_bottom_abs = round($this->pin * $this->token->stype_ih_bottom_percentage / 100, 5);
        $stype_ih_candle_abs = round($this->pin * $this->token->stype_ih_candle_percentage / 100, 5);

        if ($this->candle <= $stype_ih_candle_abs &&
            $this->close - $this->low <= $stype_ih_bottom_abs &&
            $this->high - $this->open >= $stype_ih_top_abs) {
            return 'inverted-hammer';
        }

        /**
         * HAMMER
         * The hammer candlestick pattern is formed of a short body with a long
         * lower wick, and is found at the bottom of a downward trend.A hammer
         * shows that although there were selling pressures during the day,
         * ultimately a strong buying pressure drove the price back up. The
         * colour of the body can vary, but green hammers indicate a
         * stronger bull market than red hammers.
         *
         * Computation limits:
         * - Top pin size is glued up less than (stype_h_top_perc)%
         * - Bottom pin size is at least (stype_h_bottom_perc)% from pin size
         * - Candle size is no more than (stype_h_candle_perc)% from pin size
         */
        $stype_h_top_abs = round($this->pin * $this->token->stype_h_top_percentage / 100, 5);
        $stype_h_bottom_abs = round($this->pin * $this->token->stype_h_bottom_percentage / 100, 5);
        $stype_h_candle_abs = round($this->pin * $this->token->stype_h_candle_percentage / 100, 5);

        if ($this->candle <= $stype_h_candle_abs &&
            $this->close - $this->low <= $stype_h_bottom_abs &&
            $this->high - $this->open >= $stype_h_top_abs) {
            return 'hammer';
        }
    }
}

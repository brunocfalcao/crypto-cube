<?php

namespace Nidavellir\CryptoCube\Concerns;

trait HasLevelTypes
{
    public function computeLevelType()
    {
        /**
         * TIP
         * Basically it's when the price is higher than the previous and
         * next prices.
         *
         * DIP
         * When the price is lower than its brothers.
         */
        $previous = $this->getLatest(2);

        if (! is_null($previous) && $previous->count() == 2) {
            $previous1ago = $previous->first();
            $previous2ago = $previous->last();

            if ($previous2ago->close > $previous1ago->close &&
            $this->close > $previous1ago->close) {
                $previous1ago->update(['level_type' => 'dip']);
            }

            if ($previous2ago->close < $previous1ago->close &&
            $this->close < $previous1ago->close) {
                $previous1ago->update(['level_type' => 'tip']);
            }
        }
    }
}

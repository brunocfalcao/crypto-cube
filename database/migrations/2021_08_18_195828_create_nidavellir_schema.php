<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNidavellirSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candlesticks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('symbol_id')
                  ->constrained();

            $table->unsignedDecimal('opened_at_milliseconds', 20, 0)
                  ->nullable();

            // Candle data.
            $table->timestampTz('opened_at')
                  ->nullable();

            $table->unsignedDecimal('open', 10, 5)
                  ->nullable();

            $table->unsignedDecimal('high', 10, 5)
                  ->nullable();

            $table->unsignedDecimal('low', 10, 5)
                  ->nullable();

            $table->unsignedDecimal('close', 10, 5)
                  ->nullable();

            $table->timestampTz('closed_at')
                  ->nullable();

            $table->unsignedDecimal('closed_at_milliseconds', 20, 0)
                  ->nullable();

            $table->unsignedDecimal('volume', 20);
            $table->unsignedDecimal('quote_asset_volume', 25, 10);
            $table->unsignedDecimal('taker_buy_base_asset_volume', 25, 10);
            $table->unsignedDecimal('taker_buy_quote_asset_volume', 25, 10);
            $table->unsignedInteger('trades');

            $table->unsignedDecimal('vwma', 20, 10)
                  ->comment('Volume-weight moving average (https://patternswizard.com/vwma-indicator/)')
                  ->nullable();

            $table->decimal('perc_price_variance', 10, 3)
                  ->comment('Variance price percentage compared with the previous candlestick ticker')
                  ->nullable();

            $table->decimal('perc_volume_variance', 10, 3)
                  ->comment('Variance volume percentage compared with the previous candlestick ticker')
                  ->nullable();

            $table->string('breakout')
                  ->default(null)
                  ->comment('Breakout type (1W, 2W, 1M, 3M, 6M, 1Y)')
                  ->nullable();

            $table->engine = 'MyISAM';
        });

        Schema::create('crawlers', function (Blueprint $table) {
            $table->id();

            $table->string('acronym')
                  ->unique()
                  ->comment('The crawler acronym, used for specific harcoded queries');

            $table->boolean('is_live')
                  ->default(false)
                  ->comment('Can only be used if the crawler is active');

            $table->timestampTz('cooldown_until')
                  ->nullable()
                  ->comment('No calls on the crawler until this timestamp happens');

            $table->engine = 'MyISAM';
        });

        Schema::create('symbols', function (Blueprint $table) {
            $table->id();

            $table->string('canonical')
                  ->unique()
                  ->comment('The symbol canonical, meaning the base asset concatenated with the quote asset, uppercased');

            $table->string('name')
                  ->nullable()
                  ->comment('The symbol name');

            $table->string('base_asset')
                  ->comment('The currency symbol');

            $table->string('quote_asset')
                  ->comment('The quote currency symbol');

            $table->unsignedInteger('market_cap_rank')
                  ->nullable()
                  ->comment('The market cap rank');

            $table->boolean('is_crawling_prices')
                  ->default(false)
                  ->comment('Symbol being crawled for prices');

            $table->unsignedInteger('strategy_id')
                  ->nullable()
                  ->default(null)
                  ->comment('The current strategy being used to trade this symbol');

            $table->decimal('ath_1w', 25, 10)
                  ->nullable();

            $table->decimal('ath_2w', 25, 10)
                  ->nullable();

            $table->decimal('ath_1m', 25, 10)
                  ->nullable();

            $table->decimal('ath_3m', 25, 10)
                  ->nullable();

            $table->decimal('ath_6m', 25, 10)
                  ->nullable();

            $table->decimal('ath_1y', 25, 10)
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'MyISAM';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

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

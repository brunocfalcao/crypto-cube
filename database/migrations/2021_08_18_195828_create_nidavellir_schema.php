<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nidavellir\CryptoCube\Models\Crawler;

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

        Schema::create('tokens', function (Blueprint $table) {
            $table->id();

            $table->string('canonical')
                  ->unique()
                  ->comment('The token canonical, meaning the base asset concatenated with the quote asset, uppercased');

            $table->string('name')
                  ->nullable()
                  ->comment('The token name');

            $table->string('base_asset')
                  ->comment('The currency token');

            $table->string('quote_asset')
                  ->nullable()
                  ->comment('The quote currency token');

            $table->unsignedInteger('market_cap_rank')
                  ->nullable()
                  ->comment('The market cap rank');

            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'MyISAM';
        });

        /**
         * Create the Binance and CoinGecko crawlers.
         */
        Crawler::create([
            'acronym' => 'binance',
            'is_live' => true,
        ]);

        Crawler::create([
            'acronym' => 'coingecko',
            'is_live' => true,
        ]);
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

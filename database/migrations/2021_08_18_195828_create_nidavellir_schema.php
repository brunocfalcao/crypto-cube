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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();

            $table->string('coin_id')
                  ->unique();

            $table->string('symbol');

            $table->string('name');

            $table->longText('description')
                  ->nullable();

            $table->string('homepage_url')
                  ->nullable();

            $table->string('twitter_username')
                  ->nullable();

            $table->string('subreddit_url')
                  ->nullable();

            $table->string('image_url')
                  ->nullable();

            $table->unsignedInteger('alexa_rank')
                  ->nullable();

            $table->date('genesis_date')
                  ->nullable();

            $table->index('coin_id');

            $table->timestamps();

            $table->softDeletes();

            $table->engine = 'MyISAM';
        });

        Schema::create('coin_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coin_id')
                  ->constrained();

            $table->decimal('current_price', 15, 4)
                  ->nullable();

            $table->decimal('market_cap', 20)
                  ->nullable();

            $table->unsignedBigInteger('market_cap_rank')
                  ->nullable();

            $table->unsignedBigInteger('total_volume')
                  ->nullable();

            $table->decimal('high_24h', 15, 4)
                  ->nullable();

            $table->decimal('low_24h', 15, 4)
                  ->nullable();

            $table->decimal('price_change_24h', 15, 4)
                  ->nullable();

            $table->decimal('price_change_percentage_24h', 15, 4)
                  ->nullable();

            $table->decimal('market_cap_change_24h', 20)
                  ->nullable();

            $table->decimal('market_cap_change_percentage_24h', 15, 4)
                  ->nullable();

            $table->decimal('circulating_supply', 20, 4)
                  ->nullable();

            $table->decimal('total_supply', 20, 4)
                  ->nullable();

            $table->decimal('max_supply', 20, 4)
                  ->nullable();

            $table->decimal('ath', 15, 4)
                  ->nullable();

            $table->decimal('ath_change_percentage', 15, 4)
                  ->nullable();

            $table->timestampTz('ath_date')
                  ->nullable();

            $table->decimal('atl', 15, 4)
                  ->nullable();

            $table->decimal('atl_change_percentage', 15, 4)
                  ->nullable();

            $table->decimal('price_change_percentage_1h', 15, 4)
                  ->nullable();

            $table->timestampTz('atl_date')
                  ->nullable();

            $table->timestampTz('last_updated')
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

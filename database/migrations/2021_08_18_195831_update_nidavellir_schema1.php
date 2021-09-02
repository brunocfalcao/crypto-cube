<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNidavellirSchema1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candlesticks', function (Blueprint $table) {
            $table->string('single_type')
                  ->nullable()
                  ->default(null)
                  ->after('symbol_id')
                  ->comment('https://www.ig.com/en/trading-strategies/16-candlestick-patterns-every-trader-should-know-180615');

            $table->string('trend_type')
                  ->nullable()
                  ->default(null)
                  ->after('single_type')
                  ->comment('https://www.ig.com/en/trading-strategies/16-candlestick-patterns-every-trader-should-know-180615');

            $table->string('level_type')
                  ->nullable()
                  ->default(null)
                  ->after('trend_type')
                  ->comment('https://www.ig.com/en/trading-strategies/16-candlestick-patterns-every-trader-should-know-180615');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candlesticks', function (Blueprint $table) {
            $table->dropColumn('single_type');
        });

        Schema::table('candlesticks', function (Blueprint $table) {
            $table->dropColumn('trend_type');
        });

        Schema::table('candlesticks', function (Blueprint $table) {
            $table->dropColumn('level_type');
        });
    }
}

<?php

namespace Nidavellir\CryptoCube\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nidavellir\Crawler\Binance\BinanceCrawler;
use Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation\ExchangeInformation;

class UpdateTokens implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        BinanceCrawler::onPipeline(ExchangeInformation::class)
                  ->crawl();
    }
}

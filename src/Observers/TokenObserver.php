<?php

namespace Nidavellir\CryptoCube\Observers;

use donatj\Pushover\Pushover;
use Illuminate\Support\Facades\Mail;
use Nidavellir\CryptoCube\Models\Token;

class TokenObserver
{
    /**
     * Handle the Token "created" event. This case when we have a new token
     * we need to send a Pushover notification about the new token pairs.
     *
     * @param  \Nidavellir\CryptoCube\Models\Token  $token
     *
     * @return void
     */
    public function created(Token $token)
    {
        // The token count is just a security message so it doesnt send 1620 msgs.
        if (env('CRYPTO_NOTIFICATIONS') == 'send' && Token::all()->count() > 1620) {
            // Send notification about a new token.
            Mail::send([], [], function ($message) use ($token) {
                $message->from('me@brunofalcao.dev', 'Bruno Falcao');
                $message->to('bruno@nidavellir.trade');
                $message->subject('New token on Binance!');
                $message->setBody('New token: '.$token->canonical, 'text/html');
            });

            $po = new Pushover(env('PUSHOVER_APIKEY'), env('PUSHOVER_USERKEY'));
            $po->send('New Binance token pair: '.$token->canonical);
        }
    }

    /**
     * Handle the Token "updated" event.
     *
     * @param  \App\Models\Token  $token
     * @return void
     */
    public function updated(Token $token)
    {
        //
    }

    /**
     * Handle the Token "deleted" event.
     *
     * @param  \App\Models\Token  $token
     * @return void
     */
    public function deleted(Token $token)
    {
        //
    }

    /**
     * Handle the Token "restored" event.
     *
     * @param  \App\Models\Token  $token
     * @return void
     */
    public function restored(Token $token)
    {
        //
    }

    /**
     * Handle the Token "force deleted" event.
     *
     * @param  \App\Models\Token  $token
     * @return void
     */
    public function forceDeleted(Token $token)
    {
        //
    }
}

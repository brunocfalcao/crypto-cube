<?php

namespace Nidavellir\CryptoCube\Observers;

use Illuminate\Support\Facades\Mail;
use Nidavellir\CryptoCube\Models\Token;

class TokenObserver
{
    /**
     * Handle the Token "created" event.
     *
     * @param  \App\Models\Token  $token
     * @return void
     */
    public function created(Token $token)
    {
        if (env('CRYPTO_NOTIFICATIONS') == 'send') {
            // Send notification about a new token.
            Mail::send([], [], function ($message) use ($token) {
                $message->from('me@brunofalcao.dev', 'Bruno Falcao');
                $message->to('bruno@nidavellir.trade');
                $message->subject('New token on Binance!');
                $message->setBody('New token: ' . $token->canonical, 'text/html');
            });

            Mail::send([], [], function ($message) use ($token) {
                $message->from('me@brunofalcao.dev', 'Bruno Falcao');
                $message->to('dsogb9bvn2@pomail.net');
                $message->subject('New token on Binance!');
                $message->setBody('New token: ' . $token->canonical, 'text/html');
            });
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

<?php

namespace App\Listeners;

use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\UserLogin; 

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function handle(Login $event)
    {
        UserLogin::create([
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'logged_in_at' => now(),
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  \IlluminateAuthEventsLogin  $event
     * @return void
     */
    // public function handle(IlluminateAuthEventsLogin $event)
    // {
    //     //
    // }
}

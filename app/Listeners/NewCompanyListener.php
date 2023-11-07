<?php

namespace App\Listeners;

use App\Events\NewCompanyEvent;
use App\Notifications\NewCompanyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class NewCompanyListener
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

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewCompanyEvent  $event
     * @return void
     */
    public function handle(NewCompanyEvent $event)
    {
        $company = $event->company;

        // Notify via email
        $user = 'malikali_00@hotmail.com';
        $user->notify(new NewCompanyNotification($company));
        $recipient = new Notifiable(['email' => 'malikali_00@hotmail.com']);
        $recipient->notify(new NewCompanyNotification($company));
    }
}

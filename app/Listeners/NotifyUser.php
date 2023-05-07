<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\NewUserCreatedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use function GuzzleHttp\Promise\all;

class NotifyUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewUserCreatedMail($event->user));
        }
    }
}

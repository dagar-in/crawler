<?php

namespace Dagar\Crawler\Observers;

use Dagar\Crawler\Models\EntryModel;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Event;

class EventObserver {

    public static function MailListener()
    {
        Event::listen(Illuminate\Mail\Events\MessageSending::class, function ($event) {
            EntryModel::create([
                'type' => 'mail',
                'content' => $event,
                'family_hash' => 'mailer',
                'request_id' => "ms." . request()->requestId,
            ]);
        });

        Event::listen(Illuminate\Mail\Events\MessageSent::class, function ($event) {
            EntryModel::create([
                'type' => 'critical',
                'content' => $event,
                'family_hash' => 'log',
                'request_id' => "mc." . request()->requestId,
            ]);
        });
    }

    public static function ExceptionListener()
    {

        Event::listen(Illuminate\Foundation\Exceptions\Handler::class, function ($event) {
        // if($level == 'info'){
                EntryModel::create([
                    'type' => 'critical',
                    'content' => $event,
                    'family_hash' => 'log',
                    'request_id' => "l." . request()->requestId,
                ]);
            // }
        });

    }

}

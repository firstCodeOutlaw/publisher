<?php

namespace App\Listeners;

use App\Events\ReceivedMessage;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PublishMessageToSubscribers
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
     * @param  ReceivedMessage  $event
     * @return void
     */
    public function handle(ReceivedMessage $event)
    {
        // publish message to appropriate RabbitMQ queues
        Amqp::publish('notifications', json_encode($event->data), [
            'exchange_type' => 'fanout',
            'exchange' => 'my_exchange'
        ]);
    }
}

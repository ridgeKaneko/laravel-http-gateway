<?php

namespace App\GatewayLib\Events;

use App\GatewayLib\Request\RequestIF;
use App\GatewayLib\Response\ResponseIF;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterReceiveResponse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $response;

    /**
     * Create a new event instance.
     *
     * @param RequestIF $request
     * @param ResponseIF $response
     */
    public function __construct(RequestIF $request,ResponseIF $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

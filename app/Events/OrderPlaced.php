<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPlaced implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $orderDetails;

    public function __construct($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }
}

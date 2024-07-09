<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent2 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender, $message, $receiver, $conversation;
    public function __construct(Doctor $sender, Message $message, Patient $receiver, Conversation $conversation)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->receiver = $receiver;
        $this->conversation = $conversation;
    }

    public function broadcastWith()
    {
        return[
            'sender_email' => $this->sender->email,
            'message' => $this->message->id,
            'receiver_email' => $this->receiver->email,
            'conversation_id' => $this->conversation->id,
        ];
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('chat2.'.$this->receiver->id),
        ];
    }

}

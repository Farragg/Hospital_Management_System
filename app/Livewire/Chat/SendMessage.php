<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Events\MessageSent2;
use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{
    public $body, $auth_email, $receiverUser, $selected_conversation, $sender, $createMessage;

    protected $listeners = ['updateMessage', 'updateMessage2', 'dispatchSentMessage'];

    public function mount()
    {

        if (Auth::guard('patient')->check()) {
            $this->auth_email = Auth::guard('patient')->user()->email;
            $this->sender = Auth::guard('patient')->user();
        } else {
            $this->auth_email = Auth::guard('doctor')->user()->email;
            $this->sender = Auth::guard('doctor')->user();
        }

    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }

    public function updateMessage(Conversation $conversation, Doctor $receiver)
    {

        $this->selected_conversation = $conversation;
        $this->receiverUser = $receiver;
    }

    public function updateMessage2(Conversation $conversation, Patient $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receiverUser = $receiver;
    }

    public function sendMessage()
    {
        if ($this->body == null) {
            return null;
        }

        $this->createMessage = Message::create([
            'conversation_id' => $this->selected_conversation->id,
            'sender_email' => $this->auth_email,
            'receiver_email' => $this->receiverUser,
            'body' => $this->body,
        ]);
        $this->selected_conversation->last_time_message = $this->createMessage->created_at;
        $this->selected_conversation->save();
        $this->reset('body');
        $this->emitTo('chat.chatbox', 'pushMessage', $this->createMessage->id);
        $this->emitTo('chat.chatlist', 'refresh');
        $this->emitSelf('dispatchSentMessage');
    }

    public function dispatchSentMessage()
    {

        if(Auth::guard('patient')->check()){
            broadcast(new MessageSent(
                $this->sender,
                $this->createMessage,
                //doctor
                $this->receiverUser,
                //conversation
                $this->selected_conversation,
            ));
        }else{
            broadcast(new MessageSent2(
                $this->sender,
                $this->createMessage,
                //doctor
                $this->receiverUser,
                //conversation
                $this->selected_conversation,
            ));
        }

    }
}

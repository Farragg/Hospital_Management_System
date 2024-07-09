<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatbox extends Component
{
    public $receiver, $selected_conversation, $receiverUser, $messages, $auth_email, $auth_id;
    public $event_name, $chat_page;

    public function mount(){
        $this->auth_email = auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }

    //protected $listeners = ['load_conversationDoctor', 'load_conversationPatient', 'pushMessage'];

    public function load_conversationDoctor(Conversation $conversation, Doctor $receiver){

        $this->selected_conversation = $conversation;
        $this->receiverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }

    public function load_conversationPatient(Conversation $conversation, Patient $receiver){

        $this->selected_conversation = $conversation;
        $this->receiverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }

    public function pushMessage($messageId){
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
    }

    public function getListeners()
    {
        if (Auth::guard('patient')->check()) {
            $auth_id = Auth::guard('patient')->user()->id;
            $this->event_name = "MessageSent2";
            $this->chat_page = "chat2";
        } else {
            $auth_id = Auth::guard('doctor')->user()->id;
            $this->event_name = "MessageSent";
            $this->chat_page = "chat";
        }

        return[
            "echo-private:$this->chat_page.{$auth_id},$this->event_name" => 'broadcastMessage', 'load_conversationDoctor', 'load_conversationPatient', 'pushMessage',
        ];
    }

    public function broadcastMessage($event){

        $broadcastMessage= Message::find($event['message']);
        $broadcastMessage->read = 1;
        $this->pushMessage($broadcastMessage->id);
    }
}

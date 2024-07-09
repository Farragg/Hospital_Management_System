<div>
    @if($selected_conversation)
        <form wire:submit.prevent="sendMessage">
            @csrf
            <div class="main-chat-footer">
                <input class="form-control" wire:model="body" placeholder="Type your message here..." type="text">
                <button class="main-msg-send" type="submit"><i class="far fa-paper-plane"></i></button>
            </div>
        </form>
    @endif
</div>

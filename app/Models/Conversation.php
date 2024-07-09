<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_email',
        'receiver_email',
        'last_time_message'
    ];

    public function messages(){
        return $this->hasMany(Message::class);
    }
}

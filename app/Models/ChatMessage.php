<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'table_id',
        'sender',
        'message',
        'is_read_by_admin',
        'is_read_by_user'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}

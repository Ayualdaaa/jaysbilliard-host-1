<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Table;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_chat_message()
    {
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $table = Table::create([
            'name' => 'MEJA 01',
            'type' => 'regular',
            'price_per_hour' => 30000,
            'capacity' => 4,
            'status' => 'active',
            'is_available' => true
        ]);

        $response = $this->actingAs($user)->postJson(route('chat.send'), [
            'table_id' => $table->id,
            'message' => 'Hello Admin!'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => [
                'from' => 'user',
                'text' => 'Hello Admin!'
            ]
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'table_id' => $table->id,
            'sender' => 'user',
            'message' => 'Hello Admin!',
            'is_read_by_admin' => false,
            'is_read_by_user' => true
        ]);
    }

    public function test_user_can_sync_messages()
    {
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $table = Table::create([
            'name' => 'MEJA 01',
            'type' => 'regular',
            'price_per_hour' => 30000,
            'capacity' => 4,
            'status' => 'active',
            'is_available' => true
        ]);

        ChatMessage::create([
            'table_id' => $table->id,
            'sender' => 'user',
            'message' => 'Hello from user',
            'is_read_by_admin' => false,
            'is_read_by_user' => true
        ]);

        ChatMessage::create([
            'table_id' => $table->id,
            'sender' => 'admin',
            'message' => 'Hi user!',
            'is_read_by_admin' => true,
            'is_read_by_user' => false
        ]);

        $response = $this->actingAs($user)->postJson(route('chat.sync'));

        $response->assertStatus(200);
        $response->assertJsonPath("history.{$table->id}.messages.0.text", 'Hello from user');
        $response->assertJsonPath("history.{$table->id}.messages.1.text", 'Hi user!');
    }
}

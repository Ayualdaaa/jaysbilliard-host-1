<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sync(Request $request)
    {
        // 1. Fetch all messages from database to build the true source of truth
        $tables = Table::all();
        $syncedHistory = [];

        // Build status map based on active bookings for styling/header
        $todayStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();

        foreach ($tables as $table) {
            $activeBooking = $table->bookings()->where('booking_date', $todayStr)
                ->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas'])
                ->first();

            $statusText = 'TERSEDIA';
            $statusColor = '#00e5ff';
            if ($table->status === 'maintenance') {
                $statusText = 'MAINTENANCE';
                $statusColor = '#ff3b3b';
            } elseif ($activeBooking) {
                $statusLower = strtolower($activeBooking->status);
                if ($statusLower === 'confirmed') {
                    $statusText = 'TERISI';
                    $statusColor = '#ff3b3b';
                } elseif (in_array($statusLower, ['pending', 'booked', 'dipesan', 'paid', 'lunas'])) {
                    $statusText = 'DIPESAN';
                    $statusColor = '#ffab00';
                }
            }

            // Retrieve all messages for this table
            $dbMessages = ChatMessage::where('table_id', $table->id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'from' => $msg->sender,
                        'text' => $msg->message,
                        'time' => $msg->created_at->timezone('Asia/Jakarta')->format('H:i')
                    ];
                })->toArray();

            // Check if there are unread messages
            $hasUnreadForAdmin = ChatMessage::where('table_id', $table->id)
                ->where('sender', 'user')
                ->where('is_read_by_admin', false)
                ->exists();

            $hasUnreadForUser = ChatMessage::where('table_id', $table->id)
                ->where('sender', 'admin')
                ->where('is_read_by_user', false)
                ->exists();

            // Find current active user name on this table
            $currentUserName = 'Customer';
            if ($activeBooking) {
                $currentUserName = $activeBooking->customer_name;
            } else {
                // Fallback to latest booking
                $latest = $table->bookings()->latest('updated_at')->first();
                if ($latest) {
                    $currentUserName = $latest->customer_name;
                }
            }

            $syncedHistory[$table->id] = [
                'table' => strtoupper($table->name),
                'status' => $statusText,
                'statusColor' => $statusColor,
                'user' => $currentUserName,
                'messages' => $dbMessages,
                'hasUnreadForAdmin' => $hasUnreadForAdmin,
                'hasUnreadForUser' => $hasUnreadForUser
            ];
        }

        return response()->json([
            'success' => true,
            'history' => $syncedHistory
        ]);
    }

    public function markAsRead(Request $request, $tableId)
    {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            ChatMessage::where('table_id', $tableId)
                ->where('sender', 'user')
                ->update(['is_read_by_admin' => true]);
        } else {
            ChatMessage::where('table_id', $tableId)
                ->where('sender', 'admin')
                ->update(['is_read_by_user' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'message' => 'required|string',
        ]);

        $tableId = $request->input('table_id');
        $messageText = $request->input('message');
        
        $role = Auth::user()->role;
        $sender = ($role === 'admin') ? 'admin' : 'user';

        $msg = ChatMessage::create([
            'table_id' => $tableId,
            'sender' => $sender,
            'message' => $messageText,
            'is_read_by_admin' => ($sender === 'admin'),
            'is_read_by_user' => ($sender === 'user'),
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'from' => $msg->sender,
                'text' => $msg->message,
                'time' => $msg->created_at->timezone('Asia/Jakarta')->format('H:i')
            ]
        ]);
    }
}

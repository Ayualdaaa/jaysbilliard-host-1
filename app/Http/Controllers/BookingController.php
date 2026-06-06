<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;
use Midtrans\CoreApi;

class BookingController extends Controller
{
    public function create()
    {
        $tables = collect();
        $rates = collect();

        if (Schema::hasTable('tables')) {
            $tables = Table::where('is_available', true)->get();
        }
        if (Schema::hasTable('rates')) {
            $rates = Rate::all();
        }

        return view('dashboard_admin.pemesanan', compact('tables', 'rates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_ids' => 'required|array',
            'table_ids.*' => 'exists:tables,id',
            'customer_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'total_price' => 'required|numeric',
        ]);

        // Check for time overlaps for each selected table
        foreach ($validated['table_ids'] as $table_id) {
            $overlap = Booking::where('table_id', $table_id)
                ->where('booking_date', $validated['booking_date'])
                ->whereIn('status', ['pending', 'booked', 'dipesan', 'confirmed', 'paid', 'lunas', 'completed'])
                ->where(function ($query) use ($validated) {
                    $newStart = $validated['start_time'];
                    $newEnd = $validated['end_time'];

                    if ($newStart > $newEnd) {
                        $query->where(function($q) use ($newStart, $newEnd) {
                            $q->where('start_time', '<', $newEnd)
                              ->orWhere('end_time', '>', $newStart);
                        });
                    } else {
                        $query->where(function ($q) use ($newStart, $newEnd) {
                            $q->whereRaw('start_time < end_time')
                              ->where('start_time', '<', $newEnd)
                              ->where('end_time', '>', $newStart);
                        })->orWhere(function ($q) use ($newStart, $newEnd) {
                            $q->whereRaw('start_time > end_time')
                              ->where(function($q2) use ($newStart, $newEnd) {
                                  $q2->where('start_time', '<', $newEnd)
                                     ->orWhere('end_time', '>', $newStart);
                              });
                        });
                    }
                })
                ->exists();

            if ($overlap) {
                $table = Table::find($table_id);
                $tableName = $table ? $table->name : 'Meja';
                return response()->json([
                    'success' => false,
                    'message' => 'Meja ' . $tableName . ' sudah dipesan pada tanggal dan jam tersebut. Silakan pilih meja atau waktu lain.'
                ], 422);
            }
        }

        $bookings = [];
        foreach ($validated['table_ids'] as $table_id) {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'table_id' => $table_id,
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'] ?? (auth()->user()->phone ?? '-'),
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'total_price' => $validated['total_price'] / count($validated['table_ids']), // distribute price
                'status' => 'pending',
            ]);
            $bookings[] = $booking;
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey = trim(config('services.midtrans.server_key'));
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'ORDER-' . uniqid() . '-' . time();
        
        $bookingIds = collect($bookings)->pluck('id')->implode(',');

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $request->total_price,
            ),
            'customer_details' => array(
                'first_name' => $request->customer_name,
                'phone' => $request->phone,
            ),
            'custom_field1' => $bookingIds,
        );

        try {
            $snapToken = Snap::getSnapToken($params);
            
            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function selectTable()
    {
        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
        $tables = Table::with(['bookings' => function($query) use ($today) {
            $query->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas', 'completed'])
                  ->where('booking_date', '>=', $today)
                  ->orderBy('booking_date', 'asc')
                  ->orderBy('start_time', 'asc');
        }])->get();
        return view('dashboard_admin.meja', compact('tables'));
    }

    public function bookingSuccess(Request $request)
    {
        $orderId = $request->order_id;
        
        Config::$serverKey = trim(config('services.midtrans.server_key'));
        Config::$isProduction = (bool) config('services.midtrans.is_production');

        try {
            $status = Transaction::status($orderId);
            $transactionStatus = $status->transaction_status;
            $paymentType = $status->payment_type ?? null;

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $bookingIds = explode(',', $status->custom_field1);
                $updateData = ['status' => 'booked'];
                if ($paymentType) {
                    $updateData['payment_method'] = $paymentType;
                }
                Booking::whereIn('id', $bookingIds)->update($updateData);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
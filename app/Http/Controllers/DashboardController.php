<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Snap;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = \Carbon\Carbon::now()->toDateString();

        // Get total bookings (all time) for the logged-in user
        $totalBookings = Booking::where('customer_name', $user->name)->count();
        
        // Calculate total hours played from DB
        $dbBookings = Booking::where('customer_name', $user->name)->get();
        $totalHours = 0;
        foreach ($dbBookings as $booking) {
            $start = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->start_time);
            $end = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
            if ($end->lt($start)) {
                $end->addDay();
            }
            $totalHours += $start->diffInHours($end);
        }
        
        $tables = Table::with(['bookings' => function($query) use ($today) {
            $query->where('booking_date', $today)
                  ->where('status', 'confirmed');
        }])->get();

        $activeBookingsCount = Booking::where('booking_date', $today)
                                ->where('customer_name', $user->name)
                                ->count();

        // Get recent activities from DB (last 5 bookings)
        $recentActivities = Booking::where('customer_name', $user->name)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        $topbar_title = "User Dashboard";
        $topbar_sub = "Selamat datang kembali, " . $user->name . ". Pantau pesanan dan poin Anda di sini.";
        
        return view('dashboard_user.dashboard', compact('user', 'totalBookings', 'totalHours', 'tables', 'topbar_title', 'topbar_sub', 'activeBookingsCount', 'recentActivities'));
    }

    public function meja()
    {
        $user = Auth::user();
        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
        // Load all tables with all active bookings to support dynamic date selection on frontend
        $tables = Table::with(['bookings' => function($query) {
            $query->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas', 'completed'])
                  ->where('booking_date', '>=', \Carbon\Carbon::now('Asia/Jakarta')->subDays(1))
                  ->orderBy('start_time', 'asc');
        }])->get();
        
        $topbar_title = "Meja";
        $topbar_sub = "Pilih meja favorit Anda dan tentukan waktu bermain";

        return view('dashboard_user.meja', compact('user', 'tables', 'topbar_title', 'topbar_sub'));
    }

    public function konfirmasi()
    {
        $user = Auth::user();
        $topbar_title = "Konfirmasi Pembayaran Meja";
        $topbar_sub = "Selesaikan pembayaran untuk mengamankan pesanan Anda";

        return view('dashboard_user.konfirmasi_pembayaran', compact('user', 'topbar_title', 'topbar_sub'));
    }

    public function fnb()
    {
        $user = Auth::user();
        $menus = Menu::all();
        $tables = Table::all();
        
        $topbar_title = "Makanan dan Minuman";
        $topbar_sub = "Pilih menu favorit Anda dan nikmati saat bermain";

        return view('dashboard_user.fnb', compact('user', 'menus', 'tables', 'topbar_title', 'topbar_sub'));
    }

    public function fnbKonfirmasi()
    {
        $user = Auth::user();
        $topbar_title = "Konfirmasi Pembayaran Makanan & Minuman";
        $topbar_sub = "Selesaikan pesanan untuk makanan & minuman Anda";

        return view('dashboard_user.fnb_konfirmasi', compact('user', 'topbar_title', 'topbar_sub'));
    }

    public function fnbCheckout(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'nullable|integer|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
        ]);

        $orderId = 'FNB-' . uniqid() . '-' . time();
        $user = Auth::user();
        $menuIds = collect($validated['items'])->pluck('id')->all();
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');
        $subtotal = 0;
        $itemDetails = [];

        // Calculate subtotal and prepare items
        foreach ($validated['items'] as $item) {
            $menu = $menus->get($item['id']);
            $quantity = (int) $item['quantity'];
            $price = (int) $menu->price;
            $subtotal += $price * $quantity;

            $itemDetails[] = [
                'id' => (string) $menu->id,
                'price' => $price,
                'quantity' => $quantity,
                'name' => substr($menu->name, 0, 50),
            ];
        }

        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $tax;

        // Find active or scheduled booking for the table and user to associate the F&B order
        $bookingId = null;
        if ($validated['table_id']) {
            $todayStr = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            
            // 1. Try to find an active confirmed booking playing right now on this table
            $activeBooking = Booking::where('table_id', $validated['table_id'])
                                    ->where('booking_date', $todayStr)
                                    ->where('status', 'confirmed')
                                    ->first();
                                    
            // 2. If not found, try to find any active/upcoming booking by this user on this table today
            if (!$activeBooking) {
                $activeBooking = Booking::where('table_id', $validated['table_id'])
                                        ->where('user_id', auth()->id())
                                        ->where('booking_date', $todayStr)
                                        ->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas'])
                                        ->first();
            }
            
            // 3. If still not found, fallback to the user's closest booking on this table (historical or future)
            if (!$activeBooking) {
                $activeBooking = Booking::where('table_id', $validated['table_id'])
                                        ->where('user_id', auth()->id())
                                        ->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan', 'paid', 'lunas'])
                                        ->orderByRaw("ABS(TIMESTAMPDIFF(SECOND, created_at, NOW()))")
                                        ->first();
            }
            
            $bookingId = $activeBooking ? $activeBooking->id : null;
        }

        // Save Order to DB
        $order = \App\Models\Order::create([
            'booking_id' => $bookingId, // Will be null if no active booking
            'order_id' => $orderId,
            'total_price_fnb' => $total,
            'status' => 'pending',
        ]);

        // Save Order Details
        foreach ($validated['items'] as $item) {
            $menu = $menus->get($item['id']);
            \App\Models\OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
            ]);
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey = trim(config('services.midtrans.server_key'));
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        if ($tax > 0) {
            $itemDetails[] = [
                'id' => 'SERVICE-TAX',
                'price' => $tax,
                'quantity' => 1,
                'name' => 'Service & Tax',
            ];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $total,
            ),
            'item_details' => $itemDetails,
            'customer_details' => array(
                'first_name' => $user->name,
                'phone' => $user->phone ?? '-',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function fnbSuccess(Request $request)
    {
        $orderId = $request->order_id;
        
        // Setup Midtrans
        Config::$serverKey = trim(config('services.midtrans.server_key'));
        Config::$isProduction = (bool) config('services.midtrans.is_production');

        try {
            $status = Transaction::status($orderId);
            $transactionStatus = $status->transaction_status;

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $order = Order::with('details.menu')->where('order_id', $orderId)->first();
                
                if ($order && $order->status !== 'paid') {
                    $order->update(['status' => 'paid']);
                    
                    foreach ($order->details as $detail) {
                        $menu = $detail->menu;
                        if ($menu) {
                            $menu->decrement('stock', $detail->quantity);
                            
                            StockTransaction::create([
                                'menu_id' => $menu->id,
                                'type' => 'out',
                                'quantity' => $detail->quantity,
                                'note' => 'Penjualan (Order: ' . $orderId . ')',
                            ]);
                        }
                    }
                    return response()->json(['success' => true, 'message' => 'Stok berhasil dikurangi']);
                }
            }
            
            return response()->json(['success' => false, 'message' => 'Pembayaran belum lunas atau sudah diproses']);
        } catch (\Exception $e) {
            Log::error('FnB Success Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function history()
    {
        $user = Auth::user();
        $bookings = Booking::with('table')
                            ->where('customer_name', $user->name)
                            ->orderBy('booking_date', 'desc')
                            ->orderBy('start_time', 'desc')
                            ->get();
                            
        $fnbOrders = \App\Models\Order::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('customer_name', $user->name);
        })
        ->with(['details.menu', 'booking.table'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        $topbar_title = "Riwayat Pesanan";
        $topbar_sub = "Lihat daftar pesanan dan riwayat bermain Anda";

        return view('dashboard_user.history', compact('user', 'bookings', 'fnbOrders', 'topbar_title', 'topbar_sub'));
    }

    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Set topbar parameters
        $topbar_title = "Profile Settings";
        $topbar_sub = "Kelola data profil dan setelan keamanan akun Anda";

        return view('dashboard_user.profile_settings', compact('user', 'topbar_title', 'topbar_sub'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        // Determine if updating password or personal info
        if ($request->has('current_password') || $request->has('new_password')) {
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
            ]);

            if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Kata sandi saat ini salah.'], 422);
            }

            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Kata sandi berhasil diperbarui.']);
        } else {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:20',
            ]);

            $user->name = $request->full_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui.']);
        }
    }

    public function checkNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'notifications' => []], 401);
        }

        // Get 5 latest bookings of this user sorted by updated_at
        $bookings = Booking::with('table')
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function($b) {
                $b->type = 'booking';
                $b->time_ago = $b->updated_at->diffForHumans();
                return $b;
            });

        // Get 5 latest F&B orders of this user (associated with user's bookings)
        $orders = Order::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['details.menu', 'booking.table'])
        ->latest('updated_at')
        ->take(5)
        ->get()
        ->map(function($o) {
            $o->type = 'order';
            $o->time_ago = $o->updated_at->diffForHumans();
            // Format items string
            $o->items_summary = $o->details->map(function($d) {
                return ($d->menu->name ?? 'Menu') . ' (x' . $d->quantity . ')';
            })->implode(', ');
            return $o;
        });

        // Combine and Sort by updated_at desc
        $combined = $bookings->concat($orders)->sortByDesc('updated_at')->values();

        return response()->json([
            'success' => true,
            'notifications' => $combined
        ]);
    }
}

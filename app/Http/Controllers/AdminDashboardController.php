<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Table;
use App\Models\Menu;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
        
        // Load tables with relevant bookings from today onwards to determine current table status
        $tables = Table::with(['bookings' => function($query) use ($today) {
            $query->where('booking_date', '>=', $today)
                  ->whereIn('status', ['confirmed', 'booked', 'pending', 'dipesan'])
                  ->orderBy('booking_date', 'asc')
                  ->orderBy('start_time', 'asc');
        }])->get();

        $menus = Menu::latest()->get();

        // Calculate dynamic stats for today
        $pendapatanHariIni = \App\Models\Booking::where('booking_date', $today)
                                ->whereIn('status', ['booked', 'confirmed', 'completed'])
                                ->sum('total_price');
                                
        $totalPemesanan = \App\Models\Booking::where('booking_date', $today)->count();

        return view('dashboard_admin.dashboard', compact('tables', 'menus', 'pendapatanHariIni', 'totalPemesanan'));

    }

    public function history()
    {
        // Get all bookings with nested F&B relations
        $bookings = \App\Models\Booking::with(['table', 'user', 'orders.details.menu'])->latest()->get();
        
        // Basic stats calculations
        $totalBookings = $bookings->count();
        // Since F&B items details are not fully relational yet, we'll just mock it or count orders.
        $totalOrders = $bookings->sum(function ($booking) {
            return $booking->orders->count(); 
        });

        return view('dashboard_admin.pemesanan', compact('bookings', 'totalBookings', 'totalOrders'));
    }

    public function exportPdf()
    {
        $bookings = \App\Models\Booking::with(['table', 'user', 'orders.details.menu'])->latest()->get();
        
        $pdf = Pdf::loadView('dashboard_admin.history_pdf', compact('bookings'))
                  ->setPaper('a4', 'landscape');
                  
        return $pdf->download('history_pemesanan_' . date('Y-m-d') . '.pdf');
    }

    public function checkNotifications()
    {
        // Get 5 latest pending bookings
        $latestBookings = \App\Models\Booking::with('table')
                                          ->where('status', 'pending')
                                          ->latest()
                                          ->take(5)
                                          ->get()
                                          ->map(function($b) {
                                              $b->type = 'booking';
                                              return $b;
                                          });

        // Get 5 latest pending F&B orders with details
        $latestOrders = \App\Models\Order::with(['booking.table', 'details.menu'])
                                      ->where('status', 'pending')
                                      ->latest()
                                      ->take(5)
                                      ->get()
                                      ->map(function($o) {
                                          $o->type = 'order';
                                          // Format items string
                                          $o->items_summary = $o->details->map(function($d) {
                                              return ($d->menu->name ?? 'Menu') . ' (x' . $d->quantity . ')';
                                          })->implode(', ');
                                          return $o;
                                      });

        // Combine and Sort by created_at desc
        $combined = $latestBookings->concat($latestOrders)->sortByDesc('created_at')->values();

        $newBookingsCount = \App\Models\Booking::where('created_at', '>=', now()->subSeconds(60))
                                          ->where('status', 'pending')
                                          ->count();

        $newOrdersCount = \App\Models\Order::where('created_at', '>=', now()->subSeconds(60))
                                      ->where('status', 'pending')
                                      ->count();

        return response()->json([
            'new_bookings' => $newBookingsCount,
            'new_orders' => $newOrdersCount,
            'total_new' => $newBookingsCount + $newOrdersCount,
            'notifications' => $combined
        ]);
    }

    public function transaksi()
    {
        $transactions = \App\Models\Booking::with(['table', 'user', 'orders'])->latest()->get();
        return view('dashboard_admin.transaksi', compact('transactions'));
    }

    public function laporan(Request $request)
    {
        $query = \App\Models\Booking::with(['table', 'user', 'orders.details.menu'])->latest();
        
        $m = request('month', date('m'));
        $y = request('year', date('Y'));
        
        $query->whereMonth('booking_date', $m)->whereYear('booking_date', $y);
        
        $transactions = $query->get();
        return view('dashboard_admin.laporan', compact('transactions'));
    }

    public function exportLaporanPdf(Request $request)
    {
        $query = \App\Models\Booking::with(['table', 'user', 'orders.details.menu'])->latest();
        
        $m = request('month', date('m'));
        $y = request('year', date('Y'));
        
        $query->whereMonth('booking_date', $m)->whereYear('booking_date', $y);
        
        $bookings = $query->get();
        
        $totalPendapatan = $bookings->whereIn('status', ['paid', 'completed', 'confirmed', 'booked', 'payment', 'lunas', 'selesai'])->sum('total_price');
        
        $months = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
        $monthName = $months[$m] ?? $m;
        
        $pdf = Pdf::loadView('dashboard_admin.laporan_pdf', compact('bookings', 'totalPendapatan', 'monthName', 'y'))
                  ->setPaper('a4', 'landscape');
                  
        return $pdf->download('laporan_penghasilan_' . $m . '_' . $y . '.pdf');
    }

    public function confirmBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        // Allow confirming if status is booked, pending, dipesan, paid, or lunas
        if (in_array(strtolower($booking->status), ['booked', 'pending', 'dipesan', 'paid', 'lunas'])) {
            $booking->status = 'confirmed';
            $booking->save();
        }

        return back()->with('success', 'Booking berhasil dikonfirmasi! Sesi permainan dimulai.');
    }

    public function cancelBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        // Allow cancelling if status is booked, pending, dipesan, paid, or lunas
        if (in_array(strtolower($booking->status), ['booked', 'pending', 'dipesan', 'paid', 'lunas'])) {
            $booking->status = 'cancelled';
            $booking->save();
        }

        return back()->with('success', 'Booking berhasil dibatalkan. Meja kini tersedia kembali.');
    }

    public function endSession($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();

        return back()->with('success', 'Sesi permainan telah diakhiri.');
    }

    public function deleteBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Riwayat pemesanan berhasil dihapus secara permanen.');
    }

    public function completeBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();

        return back()->with('success', 'Pesanan telah diselesaikan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Status pemesanan berhasil diperbarui menjadi ' . $request->status);
    }

    public function profile()
    {
        // Get authenticated user or redirect to login if not authenticated
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return view('dashboard_admin.profile_settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
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
}

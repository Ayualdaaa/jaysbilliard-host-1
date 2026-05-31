<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;
use App\Models\StockTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::orderBy('name')->get();
        
        $query = StockTransaction::with('menu')->latest();
        if ($request->has('month') && $request->month) {
            $month = $request->month;
            $year = $request->has('year') ? $request->year : date('Y');
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        }
        $transactions = $query->paginate(10)->withQueryString();
        
        return view('dashboard_admin.stock.index', compact('menus', 'transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);
        
        if ($validated['type'] === 'out' && $menu->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi untuk pengeluaran ini.');
        }

        StockTransaction::create($validated);

        if ($validated['type'] === 'in') {
            $menu->increment('stock', $validated['quantity']);
        } else {
            $menu->decrement('stock', $validated['quantity']);
        }

        return back()->with('success', 'Transaksi stok berhasil dicatat.');
    }

    public function exportPdf(Request $request)
    {
        $menus = Menu::orderBy('name')->get();
        
        $query = StockTransaction::with('menu')->latest();
        if ($request->has('month') && $request->month) {
            $month = $request->month;
            $year = $request->has('year') ? $request->year : date('Y');
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        }
        $transactions = $query->get();
        
        $pdf = Pdf::loadView('dashboard_admin.stock.pdf', compact('menus', 'transactions'));
        
        return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
    }
}

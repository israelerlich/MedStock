<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\Hospital;
use App\Enums\MovementType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Dashboard com relatórios principais
     */
    public function dashboard(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        // Produtos vencidos
        $expiredProducts = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->whereNotNull('expires_at')
            ->whereDate('expires_at', '<', now())
            ->where('current_stock', '>', 0)
            ->with('supplier', 'hospital')
            ->get();

        // Produtos próximos ao vencimento (30 dias)
        $nearExpiryProducts = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->whereNotNull('expires_at')
            ->whereDate('expires_at', '>=', now())
            ->whereDate('expires_at', '<=', now()->addDays(30))
            ->where('current_stock', '>', 0)
            ->with('supplier', 'hospital')
            ->get();

        // Produtos com estoque baixo
        $lowStockProducts = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->whereColumn('current_stock', '<=', 'min_stock')
            ->with('supplier', 'hospital')
            ->get();

        // Produtos com mais demanda (últimos 30 dias)
        $topDemandProducts = ProductMovement::query()
            ->when($hospitalId, function($q) use ($hospitalId) {
                $q->whereHas('product', fn($pq) => $pq->where('hospital_id', $hospitalId));
            })
            ->where('type', MovementType::EXIT)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total_price) as total_spent')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product.supplier')
            ->limit(10)
            ->get();

        $hospitals = Hospital::all();

        return view('reports.dashboard', compact(
            'expiredProducts',
            'nearExpiryProducts',
            'lowStockProducts',
            'topDemandProducts',
            'hospitals'
        ));
    }

    /**
     * Relatório de movimentações
     */
    public function movements(Request $request)
    {
        $query = ProductMovement::with(['product.supplier', 'product.hospital', 'client']);

        if ($request->has('hospital_id') && $request->hospital_id) {
            $query->whereHas('product', fn($q) => $q->where('hospital_id', $request->hospital_id));
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $movements = $query->orderByDesc('created_at')->paginate(50);
        
        // Totais
        $totals = [
            'entries' => ProductMovement::query()
                ->when($request->hospital_id, fn($q) => $q->whereHas('product', fn($pq) => $pq->where('hospital_id', $request->hospital_id)))
                ->where('type', MovementType::ENTRY)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('total_price'),
            'exits' => ProductMovement::query()
                ->when($request->hospital_id, fn($q) => $q->whereHas('product', fn($pq) => $pq->where('hospital_id', $request->hospital_id)))
                ->where('type', MovementType::EXIT)
                ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
                ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
                ->sum('total_price'),
        ];

        $hospitals = Hospital::all();

        return view('reports.movements', compact('movements', 'totals', 'hospitals'));
    }

    /**
     * Relatório de produtos vencidos e próximos ao vencimento
     */
    public function expiry(Request $request)
    {
        $hospitalId = $request->get('hospital_id');

        // Produtos vencidos
        $expiredProducts = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->whereNotNull('expires_at')
            ->whereDate('expires_at', '<', now())
            ->where('current_stock', '>', 0)
            ->with('supplier', 'hospital')
            ->orderBy('expires_at')
            ->get();

        // Produtos próximos ao vencimento (agrupados por período)
        $nearExpiryProducts = [
            '7_days' => Product::query()
                ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
                ->whereNotNull('expires_at')
                ->whereDate('expires_at', '>=', now())
                ->whereDate('expires_at', '<=', now()->addDays(7))
                ->where('current_stock', '>', 0)
                ->with('supplier', 'hospital')
                ->orderBy('expires_at')
                ->get(),
            '15_days' => Product::query()
                ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
                ->whereNotNull('expires_at')
                ->whereDate('expires_at', '>', now()->addDays(7))
                ->whereDate('expires_at', '<=', now()->addDays(15))
                ->where('current_stock', '>', 0)
                ->with('supplier', 'hospital')
                ->orderBy('expires_at')
                ->get(),
            '30_days' => Product::query()
                ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
                ->whereNotNull('expires_at')
                ->whereDate('expires_at', '>', now()->addDays(15))
                ->whereDate('expires_at', '<=', now()->addDays(30))
                ->where('current_stock', '>', 0)
                ->with('supplier', 'hospital')
                ->orderBy('expires_at')
                ->get(),
        ];

        $hospitals = Hospital::all();

        return view('reports.expiry', compact('expiredProducts', 'nearExpiryProducts', 'hospitals'));
    }

    /**
     * Relatório de demanda de produtos
     */
    public function demand(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        $period = $request->get('period', 30); // dias

        // Produtos mais consumidos
        $topProducts = ProductMovement::query()
            ->when($hospitalId, function($q) use ($hospitalId) {
                $q->whereHas('product', fn($pq) => $pq->where('hospital_id', $hospitalId));
            })
            ->where('type', MovementType::EXIT)
            ->where('created_at', '>=', now()->subDays($period))
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(total_price) as total_spent, COUNT(*) as movement_count')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product.supplier', 'product.hospital')
            ->get();

        // Produtos sem movimento
        $noMovementProducts = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->whereDoesntHave('productMovements', function($q) use ($period) {
                $q->where('type', MovementType::EXIT)
                  ->where('created_at', '>=', now()->subDays($period));
            })
            ->where('current_stock', '>', 0)
            ->with('supplier', 'hospital')
            ->get();

        $hospitals = Hospital::all();

        return view('reports.demand', compact('topProducts', 'noMovementProducts', 'hospitals', 'period'));
    }

    /**
     * Relatório de estoque
     */
    public function stock(Request $request)
    {
        $hospitalId = $request->get('hospital_id');

        $products = Product::query()
            ->when($hospitalId, fn($q) => $q->where('hospital_id', $hospitalId))
            ->with('supplier', 'hospital')
            ->orderBy('current_stock')
            ->get();

        $summary = [
            'total_products' => $products->count(),
            'low_stock' => $products->filter(fn($p) => $p->current_stock <= $p->min_stock)->count(),
            'out_of_stock' => $products->where('current_stock', 0)->count(),
            'total_value' => $products->sum(fn($p) => $p->price * $p->current_stock),
        ];

        $hospitals = Hospital::all();

        return view('reports.stock', compact('products', 'summary', 'hospitals'));
    }
}


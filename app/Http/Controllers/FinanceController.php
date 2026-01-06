<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\ProductMovement;
use App\Enums\MovementType;
use App\Enums\ProductType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Dashboard financeiro do hospital
     */
    public function dashboard(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        if (!$hospitalId) {
            $hospitals = Hospital::all();
            return view('finance.select-hospital', compact('hospitals'));
        }

        $hospital = Hospital::findOrFail($hospitalId);

        // Orçamento atual
        $budget = $hospital->budget;
        $currentBalance = $hospital->current_balance;

        // Gastos do mês atual
        $currentMonthExpenses = $hospital->getTotalExpenses(
            now()->startOfMonth(),
            now()->endOfMonth()
        );

        // Gastos por categoria (mês atual)
        $expensesByCategory = $hospital->getExpensesByCategory(
            now()->startOfMonth(),
            now()->endOfMonth()
        );

        // Comparação com mês anterior
        $lastMonthExpenses = $hospital->getTotalExpenses(
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        );

        // Gastos dos últimos 12 meses
        $monthlyExpenses = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyExpenses[$date->format('M/Y')] = $hospital->getTotalExpenses(
                $date->startOfMonth(),
                $date->endOfMonth()
            );
        }

        // Gastos sazonais (por trimestre)
        $seasonalExpenses = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $startMonth = ($quarter - 1) * 3 + 1;
            $seasonalExpenses["Q{$quarter}"] = $hospital->getTotalExpenses(
                Carbon::create(now()->year, $startMonth, 1)->startOfMonth(),
                Carbon::create(now()->year, $startMonth, 1)->addMonths(2)->endOfMonth()
            );
        }

        return view('finance.dashboard', compact(
            'hospital',
            'budget',
            'currentBalance',
            'currentMonthExpenses',
            'expensesByCategory',
            'lastMonthExpenses',
            'monthlyExpenses',
            'seasonalExpenses'
        ));
    }

    /**
     * Despesas por categoria
     */
    public function expensesByCategory(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        if (!$hospitalId) {
            return redirect()->route('finance.dashboard');
        }

        $hospital = Hospital::findOrFail($hospitalId);

        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        // Gastos detalhados por categoria
        $categoryExpenses = ProductMovement::with('product')
            ->whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::EXIT)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get()
            ->groupBy('product.type')
            ->map(function ($movements, $type) {
                return [
                    'type' => $type,
                    'label' => $type ? $type->label() : 'Sem categoria',
                    'total' => $movements->sum('total_price'),
                    'quantity' => $movements->sum('quantity'),
                    'movements_count' => $movements->count(),
                    'details' => $movements->groupBy('product.name')->map(function ($productMovements) {
                        return [
                            'product' => $productMovements->first()->product->name,
                            'total' => $productMovements->sum('total_price'),
                            'quantity' => $productMovements->sum('quantity'),
                        ];
                    })->values()
                ];
            });

        return view('finance.expenses-by-category', compact(
            'hospital',
            'categoryExpenses',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Relatório mensal
     */
    public function monthlyReport(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        if (!$hospitalId) {
            return redirect()->route('finance.dashboard');
        }

        $hospital = Hospital::findOrFail($hospitalId);
        
        $month = $request->get('month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $month);

        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        // Total de entradas
        $totalEntries = ProductMovement::whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::ENTRY)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_price');

        // Total de saídas
        $totalExits = ProductMovement::whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::EXIT)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_price');

        // Gastos por dia
        $dailyExpenses = ProductMovement::whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::EXIT)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Gastos por categoria
        $categoryExpenses = $hospital->getExpensesByCategory($startDate, $endDate);

        return view('finance.monthly-report', compact(
            'hospital',
            'month',
            'totalEntries',
            'totalExits',
            'dailyExpenses',
            'categoryExpenses'
        ));
    }

    /**
     * Atualizar orçamento do hospital
     */
    public function updateBudget(Request $request, Hospital $hospital)
    {
        $request->validate([
            'budget' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric',
        ]);

        $hospital->update([
            'budget' => $request->budget,
            'current_balance' => $request->current_balance,
        ]);

        return redirect()
            ->route('finance.dashboard', ['hospital_id' => $hospital->id])
            ->with('success', 'Orçamento atualizado com sucesso!');
    }
}


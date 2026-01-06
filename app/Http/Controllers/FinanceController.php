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
    public function dashboard(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        if (!$hospitalId) {
            $hospitals = Hospital::all();
            return view('finance.select-hospital', compact('hospitals'));
        }

        $hospital = Hospital::findOrFail($hospitalId);

        $budget = $hospital->budget;
        $currentBalance = $hospital->current_balance;

        $currentMonthExpenses = $hospital->getTotalExpenses(
            now()->startOfMonth(),
            now()->endOfMonth()
        );

        $expensesByCategory = $hospital->getExpensesByCategory(
            now()->startOfMonth(),
            now()->endOfMonth()
        );

        $lastMonthExpenses = $hospital->getTotalExpenses(
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        );

        $monthlyExpenses = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyExpenses[$date->format('M/Y')] = $hospital->getTotalExpenses(
                $date->startOfMonth(),
                $date->endOfMonth()
            );
        }

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

    public function expensesByCategory(Request $request)
    {
        $hospitalId = $request->get('hospital_id');
        
        if (!$hospitalId) {
            return redirect()->route('finance.dashboard');
        }

        $hospital = Hospital::findOrFail($hospitalId);

        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

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
                $typeEnum = is_int($type) ? ProductType::from($type) : null;
                return [
                    'type' => $type,
                    'label' => $typeEnum ? $typeEnum->label() : 'Sem categoria',
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

        $totalEntries = ProductMovement::whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::ENTRY)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_price');

        $totalExits = ProductMovement::whereHas('product', function ($q) use ($hospitalId) {
                $q->where('hospital_id', $hospitalId);
            })
            ->where('type', MovementType::EXIT)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_price');

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


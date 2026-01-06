@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📊 Relatório Mensal Detalhado</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $hospital->name }} - {{ $month }}</p>
                </div>
                <a href="{{ route('finance.dashboard', ['hospital_id' => $hospital->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    ← Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Resumo do Mês -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-green-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Total de Entradas</h6>
                <h3 class="text-3xl font-bold text-green-600 mt-2">R$ {{ number_format($totalEntries, 2, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-red-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Total de Saídas</h6>
                <h3 class="text-3xl font-bold text-red-600 mt-2">R$ {{ number_format($totalExits, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Despesas por Categoria -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">💰 Despesas por Categoria</h5>
        </div>
        <div class="border-t border-gray-200">
            @if($categoryExpenses->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Porcentagem</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $total = $categoryExpenses->sum(); @endphp
                        @foreach($categoryExpenses as $type => $amount)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $type ? $type->label() : 'Sem categoria' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-4 mr-2">
                                        <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $total > 0 ? ($amount / $total) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-700 font-medium">{{ $total > 0 ? number_format(($amount / $total) * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-50 font-medium">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($total, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-4 py-5 sm:p-6">
                <p class="text-gray-500 text-sm">Nenhuma despesa registrada neste mês.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Gastos Diários -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">📅 Despesas Diárias</h5>
        </div>
        <div class="border-t border-gray-200">
            @if($dailyExpenses->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gráfico</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $maxExpense = $dailyExpenses->max(); @endphp
                        @foreach($dailyExpenses as $date => $expense)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($expense, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $maxExpense > 0 ? ($expense / $maxExpense) * 100 : 0 }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-4 py-5 sm:p-6">
                <p class="text-gray-500 text-sm">Nenhuma despesa registrada neste período.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Ações -->
    <div class="flex gap-4">
        <a href="{{ route('finance.dashboard', ['hospital_id' => $hospital->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            ← Voltar ao Dashboard Financeiro
        </a>
        <a href="{{ route('reports.movements', ['hospital_id' => $hospital->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            Ver Movimentações Detalhadas
        </a>
    </div>
</div>
@endsection

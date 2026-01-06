@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho e Seletor de Hospital -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">💰 Gestão Financeira</h1>
            
            <form method="GET" class="mt-4">
                <div class="flex items-end gap-4">
                    <div class="flex-1 max-w-md">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selecione o Hospital:</label>
                        <select name="hospital_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Selecione um hospital...</option>
                            @foreach(\App\Models\Hospital::all() as $h)
                                <option value="{{ $h->id }}" {{ request('hospital_id') == $h->id ? 'selected' : '' }}>
                                    {{ $h->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Consultar
                    </button>
                </div>
            </form>

            @if(!request('hospital_id'))
                <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Por favor, selecione um hospital para visualizar os dados financeiros.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(isset($hospital))
    <!-- Resumo Financeiro -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-blue-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Orçamento Total</h6>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">R$ {{ number_format($budget, 2, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-green-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Saldo Atual</h6>
                <h3 class="text-3xl font-bold text-green-600 mt-2">R$ {{ number_format($currentBalance, 2, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-red-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Gasto Mês Atual</h6>
                <h3 class="text-3xl font-bold text-red-600 mt-2">R$ {{ number_format($currentMonthExpenses, 2, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-yellow-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Comparação Mês Anterior</h6>
                @php
                    $diff = $currentMonthExpenses - $lastMonthExpenses;
                    $percentChange = $lastMonthExpenses > 0 ? ($diff / $lastMonthExpenses) * 100 : 0;
                @endphp
                <h3 class="text-3xl font-bold {{ $diff > 0 ? 'text-red-600' : 'text-green-600' }} mt-2">
                    {{ $diff > 0 ? '+' : '' }}{{ number_format($percentChange, 1) }}%
                </h3>
            </div>
        </div>
    </div>

    <!-- Atualizar Orçamento -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">💵 Atualizar Orçamento</h5>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('finance.update-budget', $hospital) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orçamento Total</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="budget" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $budget }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Saldo Atual</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="current_balance" class="block w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $currentBalance }}" required>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Atualizar Orçamento
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Gastos por Categoria -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">📊 Despesas por Categoria (Mês Atual)</h5>
        </div>
        <div class="border-t border-gray-200">
            @if($expensesByCategory->count() > 0)
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
                        @php $total = $expensesByCategory->sum(); @endphp
                        @foreach($expensesByCategory as $type => $amount)
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
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('finance.expenses-by-category', ['hospital_id' => $hospital->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Ver Detalhes por Categoria
                </a>
            </div>
            @else
            <div class="px-4 py-5 sm:p-6">
                <p class="text-gray-500 text-sm">Nenhuma despesa registrada neste mês.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Gastos Mensais (Últimos 12 Meses) -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">📈 Histórico de Gastos Mensais</h5>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mês</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gráfico</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $maxExpense = max(array_values($monthlyExpenses)); @endphp
                        @foreach($monthlyExpenses as $month => $expense)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month }}</td>
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
        </div>
    </div>

    <!-- Gastos Sazonais (Por Trimestre) -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">🗓️ Gastos Sazonais por Trimestre</h5>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($seasonalExpenses as $quarter => $expense)
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 text-center border border-blue-200">
                    <h6 class="text-sm font-medium text-blue-900 mb-2">{{ $quarter }}</h6>
                    <h4 class="text-2xl font-bold text-blue-700">R$ {{ number_format($expense, 2, ',', '.') }}</h4>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Links para Outros Relatórios -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">📋 Relatórios Financeiros</h5>
        </div>
        <div class="border-t border-gray-200">
            <div class="divide-y divide-gray-200">
                <a href="{{ route('finance.monthly-report', ['hospital_id' => $hospital->id]) }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📊</span>
                            <span class="text-sm font-medium text-gray-900">Relatório Mensal Detalhado</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('reports.movements', ['hospital_id' => $hospital->id]) }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📋</span>
                            <span class="text-sm font-medium text-gray-900">Histórico de Movimentações</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('reports.dashboard') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📊</span>
                            <span class="text-sm font-medium text-gray-900">Dashboard de Relatórios</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

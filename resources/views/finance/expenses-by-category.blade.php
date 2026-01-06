@extends('layouts.app')

@section('title', 'Despesas por Categoria')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">📊 Despesas por Categoria - {{ $hospital->name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalhamento das despesas por tipo de produto</p>
                </div>
                <a href="{{ route('finance.dashboard', ['hospital_id' => $hospital->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    ← Voltar ao Dashboard
                </a>
            </div>

            <!-- Filtro de Data -->
            <form method="GET" class="mt-6">
                <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Início:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Fim:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Despesas por Categoria -->
    @if($categoryExpenses->count() > 0)
        @php $grandTotal = $categoryExpenses->sum('total'); @endphp
        
        @foreach($categoryExpenses as $category)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $category['label'] }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ $category['movements_count'] }} movimentos • {{ $category['quantity'] }} unidades</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900">R$ {{ number_format($category['total'], 2, ',', '.') }}</div>
                        <div class="text-sm text-gray-500">{{ $grandTotal > 0 ? number_format(($category['total'] / $grandTotal) * 100, 1) : 0 }}% do total</div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gasto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% da Categoria</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category['details'] as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail['product'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail['quantity'] }} unidades</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($detail['total'], 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $category['total'] > 0 ? ($detail['total'] / $category['total']) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $category['total'] > 0 ? number_format(($detail['total'] / $category['total']) * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        <!-- Total Geral -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-medium text-gray-900">Total Geral</h4>
                    <div class="text-2xl font-bold text-gray-900">R$ {{ number_format($grandTotal, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma despesa encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Não há despesas registradas no período selecionado.</p>
            </div>
        </div>
    @endif
</div>
@endsection

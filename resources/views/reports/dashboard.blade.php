@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho e Filtro -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">📊 Dashboard de Relatórios</h1>
            
            <form method="GET" class="mt-4">
                <div class="flex items-end gap-4">
                    <div class="flex-1 max-w-md">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Hospital:</label>
                        <select name="hospital_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                            <option value="">Todos os Hospitais</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                    {{ $hospital->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alertas Críticos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-red-500">
            <div class="px-4 py-5 sm:p-6">
                <h5 class="text-lg font-medium text-red-600">⚠️ Produtos Vencidos</h5>
                <h2 class="text-4xl font-bold text-red-600 my-2">{{ $expiredProducts->count() }}</h2>
                <p class="text-sm text-gray-500 mb-4">produtos vencidos em estoque</p>
                <a href="{{ route('reports.expiry') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Ver Detalhes
                </a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-yellow-500">
            <div class="px-4 py-5 sm:p-6">
                <h5 class="text-lg font-medium text-yellow-600">⏰ Próximos ao Vencimento</h5>
                <h2 class="text-4xl font-bold text-yellow-600 my-2">{{ $nearExpiryProducts->count() }}</h2>
                <p class="text-sm text-gray-500 mb-4">vencem nos próximos 30 dias</p>
                <a href="{{ route('reports.expiry') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                    Ver Detalhes
                </a>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-blue-500">
            <div class="px-4 py-5 sm:p-6">
                <h5 class="text-lg font-medium text-blue-600">📦 Estoque Baixo</h5>
                <h2 class="text-4xl font-bold text-blue-600 my-2">{{ $lowStockProducts->count() }}</h2>
                <p class="text-sm text-gray-500 mb-4">produtos com estoque mínimo</p>
                <a href="{{ route('reports.stock') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Ver Detalhes
                </a>
            </div>
        </div>
    </div>

    <!-- Produtos Vencidos -->
    @if($expiredProducts->count() > 0)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-red-600">
            <h5 class="text-lg font-medium text-white">⚠️ Produtos Vencidos - AÇÃO NECESSÁRIA!</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dias Vencido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expiredProducts->take(10) as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->hospital->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->supplier->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->current_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->expires_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">{{ $product->expires_at->diffInDays(now()) }} dias</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a href="{{ route('reports.expiry') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                Ver Todos os Produtos Vencidos
            </a>
        </div>
    </div>
    @endif

    <!-- Produtos com Mais Demanda -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-blue-600">
            <h5 class="text-lg font-medium text-white">📊 Top 10 Produtos com Mais Demanda (Últimos 30 Dias)</h5>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if($topDemandProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade Consumida</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total Gasto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topDemandProducts as $index => $movement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}º</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->product->supplier->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $movement->total_quantity }} unidades</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($movement->total_spent, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('products.show', $movement->product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                <a href="{{ route('reports.demand', ['product_id' => $movement->product->id]) }}" class="text-indigo-600 hover:text-indigo-900">Análise</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('reports.demand') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Ver Relatório Completo de Demanda
                </a>
            </div>
            @else
            <p class="text-gray-500 text-sm">Nenhuma movimentação de saída nos últimos 30 dias.</p>
            @endif
        </div>
    </div>

    <!-- Links Rápidos -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h5 class="text-lg font-medium text-gray-900">📋 Relatórios Disponíveis</h5>
        </div>
        <div class="border-t border-gray-200">
            <div class="divide-y divide-gray-200">
                <a href="{{ route('reports.movements') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📋</span>
                            <span class="text-sm font-medium text-gray-900">Relatório de Movimentações (Entradas e Saídas)</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('reports.expiry') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">⏰</span>
                            <span class="text-sm font-medium text-gray-900">Relatório de Produtos Vencidos e Próximos ao Vencimento</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('reports.demand') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📊</span>
                            <span class="text-sm font-medium text-gray-900">Relatório de Demanda de Produtos</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('reports.stock') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">📦</span>
                            <span class="text-sm font-medium text-gray-900">Relatório de Estoque</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="{{ route('finance.dashboard') }}" class="block px-4 py-4 hover:bg-gray-50 transition duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">💰</span>
                            <span class="text-sm font-medium text-gray-900">Dashboard Financeiro</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

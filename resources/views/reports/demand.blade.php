@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Cabeçalho e Filtros -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">📊 Análise de Demanda de Produtos</h1>
            
            <form method="GET" class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Hospital:</label>
                        <select name="hospital_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos os Hospitais</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                    {{ $hospital->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Período:</label>
                        <select name="period" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="7" {{ $period == 7 ? 'selected' : '' }}>Últimos 7 dias</option>
                            <option value="15" {{ $period == 15 ? 'selected' : '' }}>Últimos 15 dias</option>
                            <option value="30" {{ $period == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                            <option value="60" {{ $period == 60 ? 'selected' : '' }}>Últimos 60 dias</option>
                            <option value="90" {{ $period == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        Atualizar Análise
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Produtos com Mais Demanda -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 bg-blue-600">
            <h5 class="text-lg font-medium text-white">Produtos com Maior Demanda (Últimos {{ $period }} dias)</h5>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if($topProducts->count() > 0)
            <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700"><strong>Total de produtos analisados:</strong> {{ $topProducts->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posição</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd. Consumida</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Movimentações</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Média/Mov</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topProducts as $index => $movement)
                        @if($movement->product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($index < 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $index + 1 }}º</span>
                                @else
                                    <span class="text-sm font-medium text-gray-900">{{ $index + 1 }}º</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $movement->product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($movement->product->hospital)->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->product->supplier->commercial_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $movement->total_quantity }} un</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">R$ {{ number_format($movement->total_spent, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->movement_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($movement->total_quantity / $movement->movement_count, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('products.show', $movement->product) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr class="bg-gray-50 font-medium">
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TOTAIS</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">{{ $topProducts->sum('total_quantity') }} un</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">R$ {{ number_format($topProducts->sum('total_spent'), 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $topProducts->sum('movement_count') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h6 class="text-sm font-medium text-gray-900 mb-3">📈 Insights:</h6>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li><strong>Produto com maior demanda:</strong> {{ $topProducts->first() && $topProducts->first()->product ? $topProducts->first()->product->name . ' (' . $topProducts->first()->total_quantity . ' unidades)' : 'N/A' }}</li>
                    <li><strong>Maior gasto:</strong> R$ {{ number_format($topProducts->max('total_spent'), 2, ',', '.') }}</li>
                    <li><strong>Média de consumo:</strong> {{ number_format($topProducts->avg('total_quantity'), 2, ',', '.') }} unidades por produto</li>
                </ul>
            </div>
            @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">Nenhuma movimentação de saída foi registrada nos últimos {{ $period }} dias.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Produtos Sem Movimento -->
    @if($noMovementProducts->count() > 0)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6 border-l-4 border-yellow-500">
        <div class="px-4 py-5 sm:px-6 bg-yellow-50">
            <h5 class="text-lg font-medium text-yellow-900">⚠️ Produtos Sem Movimento (Últimos {{ $period }} dias)</h5>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <p class="text-sm text-gray-700 mb-2"><strong>{{ $noMovementProducts->count() }} produtos</strong> não tiveram nenhuma movimentação de saída nos últimos {{ $period }} dias.</p>
            <p class="text-sm text-gray-500 mb-4">Estes produtos podem estar com excesso de estoque ou com baixa demanda.</p>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor em Estoque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($noMovementProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($product->hospital)->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->supplier->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->current_stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($product->price * $product->current_stock, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($product->expires_at)
                                    {{ $product->expires_at->format('d/m/Y') }}
                                    @if($product->isExpired())
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">VENCIDO</span>
                                    @elseif($product->isNearExpiry())
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">PRÓXIMO</span>
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-900">
                    <strong>Valor total parado em estoque:</strong> 
                    R$ {{ number_format($noMovementProducts->sum(fn($p) => $p->price * $p->current_stock), 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('reports.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            ← Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection

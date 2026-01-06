@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-bold text-gray-900">📦 Relatório de Estoque</h1>
            
            <form method="GET" class="mt-4">
                <div class="flex items-end gap-4">
                    <div class="flex-1 max-w-md">
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
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-gray-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Total de Produtos</h6>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $summary['total_products'] }}</h3>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-yellow-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Estoque Baixo</h6>
                <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{ $summary['low_stock'] }}</h3>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-red-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Sem Estoque</h6>
                <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $summary['out_of_stock'] }}</h3>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border-l-4 border-green-500">
            <div class="px-4 py-5 sm:p-6">
                <h6 class="text-sm font-medium text-gray-500 uppercase">Valor Total</h6>
                <h3 class="text-3xl font-bold text-green-600 mt-2">R$ {{ number_format($summary['total_value'], 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Atual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque Mínimo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 {{ $product->current_stock == 0 ? 'bg-red-50' : ($product->current_stock <= $product->min_stock ? 'bg-yellow-50' : '') }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($product->hospital)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($product->supplier)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->type->label() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->current_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->min_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">R$ {{ number_format($product->price * $product->current_stock, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->current_stock == 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">SEM ESTOQUE</span>
                            @elseif($product->current_stock <= $product->min_stock)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">ESTOQUE BAIXO</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">OK</span>
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
    </div>

    <div class="mt-6">
        <a href="{{ route('reports.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            ← Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Nova Movimentação')

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Cadastrar Nova Movimentação</h3>
        
        <form action="{{ route('product-movements.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Produto *</label>
                    <select name="product_id" id="product_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('product_id') input-error @enderror">
                        <option value="">Selecione um produto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}@if($product->supplier) - {{ $product->supplier->commercial_name }}@endif
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Movimentação *</label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('type') input-error @enderror">
                        <option value="">Selecione um tipo</option>
                        @foreach(\App\Enums\MovementType::cases() as $type)
                            <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantidade *</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required min="1"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('quantity') input-error @enderror">
                    @error('quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">Preço Unitário *</label>
                    <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" required min="0" step="0.01"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('unit_price') input-error @enderror">
                    @error('unit_price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="total_price" class="block text-sm font-medium text-gray-700 mb-2">Preço Total *</label>
                    <input type="number" name="total_price" id="total_price" value="{{ old('total_price') }}" required min="0" step="0.01" readonly
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('total_price') input-error @enderror">
                    @error('total_price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Cliente (opcional - apenas para Saída)</label>
                    <select name="client_id" id="client_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('client_id') input-error @enderror">
                        <option value="">Nenhum (Entrada/Devolução)</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} - {{ $client->cpf }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <script>
                // Preços dos produtos
                const productPrices = {
                    @foreach($products as $product)
                        {{ $product->id }}: {{ $product->price }},
                    @endforeach
                };

                // Preencher preço unitário quando selecionar produto
                document.getElementById('product_id').addEventListener('change', function() {
                    const productId = this.value;
                    if (productId && productPrices[productId]) {
                        document.getElementById('unit_price').value = productPrices[productId];
                        calculateTotal();
                    }
                });

                // Calcular preço total automaticamente
                document.getElementById('quantity').addEventListener('input', calculateTotal);
                document.getElementById('unit_price').addEventListener('input', calculateTotal);

                function calculateTotal() {
                    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
                    const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
                    const total = quantity * unitPrice;
                    document.getElementById('total_price').value = total.toFixed(2);
                }
            </script>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('product-movements.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

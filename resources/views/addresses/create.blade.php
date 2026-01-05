@extends('layouts.app')

@section('title', 'Novo Endereço')

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Cadastrar Novo Endereço</h3>
        
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="referring_type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Referência *</label>
                    <select name="referring_type" id="referring_type" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('referring_type') input-error @enderror">
                        <option value="">Selecione um tipo</option>
                        <option value="App\Models\Client" {{ old('referring_type') == 'App\Models\Client' ? 'selected' : '' }}>Cliente</option>
                        <option value="App\Models\Hospital" {{ old('referring_type') == 'App\Models\Hospital' ? 'selected' : '' }}>Hospital</option>
                        <option value="App\Models\Supplier" {{ old('referring_type') == 'App\Models\Supplier' ? 'selected' : '' }}>Fornecedor</option>
                    </select>
                    @error('referring_type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="referring_id" class="block text-sm font-medium text-gray-700 mb-2">ID da Referência *</label>
                    <input type="number" name="referring_id" id="referring_id" value="{{ old('referring_id') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('referring_id') input-error @enderror">
                    @error('referring_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">CEP *</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep') }}" required
                        placeholder="00000-000"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('cep') input-error @enderror">
                    @error('cep')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="street" class="block text-sm font-medium text-gray-700 mb-2">Rua *</label>
                    <input type="text" name="street" id="street" value="{{ old('street') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('street') input-error @enderror">
                    @error('street')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address_number" class="block text-sm font-medium text-gray-700 mb-2">Número *</label>
                    <input type="text" name="address_number" id="address_number" value="{{ old('address_number') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address_number') input-error @enderror">
                    @error('address_number')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="complement_number" class="block text-sm font-medium text-gray-700 mb-2">Complemento</label>
                    <input type="text" name="complement_number" id="complement_number" value="{{ old('complement_number') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('complement_number') input-error @enderror">
                    @error('complement_number')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                    <input type="text" name="district" id="district" value="{{ old('district') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('district') input-error @enderror">
                    @error('district')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('city') input-error @enderror">
                    @error('city')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                    <input type="text" name="state" id="state" value="{{ old('state') }}" required
                        maxlength="2" placeholder="SP"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('state') input-error @enderror">
                    @error('state')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">País *</label>
                    <select name="country" id="country" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('country') input-error @enderror">
                        <option value="">Selecione um país</option>
                        @foreach(\App\Enums\Country::cases() as $country)
                            <option value="{{ $country->value }}" {{ old('country') == $country->value ? 'selected' : '' }}>
                                {{ $country->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('country')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('addresses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

@extends('layouts.app')

@section('title', 'Novo Fornecedor')

@section('content')
<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Cadastrar Novo Fornecedor</h3>
        
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Razão Social *</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('company_name') input-error @enderror">
                    @error('company_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="commercial_name" class="block text-sm font-medium text-gray-700 mb-2">Nome Comercial *</label>
                    <input type="text" name="commercial_name" id="commercial_name" value="{{ old('commercial_name') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('commercial_name') input-error @enderror">
                    @error('commercial_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cnpj" class="block text-sm font-medium text-gray-700 mb-2">CNPJ *</label>
                    <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}" required
                        placeholder="00.000.000/0000-00"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('cnpj') input-error @enderror">
                    @error('cnpj')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                        placeholder="(00) 0000-0000"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone_number') input-error @enderror">
                    @error('phone_number')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') input-error @enderror">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Seção de Endereço -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h4 class="text-md leading-6 font-medium text-gray-900 mb-4">Endereço</h4>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="cep" class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                        <input type="text" name="cep" id="cep" value="{{ old('cep') }}"
                            placeholder="00000-000"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('cep') input-error @enderror">
                        @error('cep')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('city') input-error @enderror">
                        @error('city')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <input type="text" name="state" id="state" value="{{ old('state') }}"
                            placeholder="SP"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('state') input-error @enderror">
                        @error('state')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">Bairro</label>
                        <input type="text" name="district" id="district" value="{{ old('district') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('district') input-error @enderror">
                        @error('district')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="street" class="block text-sm font-medium text-gray-700 mb-2">Rua</label>
                        <input type="text" name="street" id="street" value="{{ old('street') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('street') input-error @enderror">
                        @error('street')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address_number" class="block text-sm font-medium text-gray-700 mb-2">Número</label>
                        <input type="text" name="address_number" id="address_number" value="{{ old('address_number') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address_number') input-error @enderror">
                        @error('address_number')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="complement_number" class="block text-sm font-medium text-gray-700 mb-2">Complemento</label>
                        <input type="text" name="complement_number" id="complement_number" value="{{ old('complement_number') }}"
                            placeholder="Apto, Sala, etc."
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('complement_number') input-error @enderror">
                        @error('complement_number')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">País</label>
                        <select name="country" id="country"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('country') input-error @enderror">
                            <option value="br" {{ old('country') == 'br' ? 'selected' : '' }}>Brasil</option>
                            <option value="us" {{ old('country') == 'us' ? 'selected' : '' }}>Estados Unidos</option>
                            <option value="ca" {{ old('country') == 'ca' ? 'selected' : '' }}>Canadá</option>
                        </select>
                        @error('country')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('suppliers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

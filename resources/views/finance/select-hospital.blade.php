@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h1 class="text-3xl font-bold text-gray-900">💰 Gestão Financeira</h1>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Selecione um hospital para visualizar as informações financeiras
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
        <form method="GET" action="{{ route('finance.dashboard') }}">
            <div class="mb-4">
                <label for="hospital_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Selecione o Hospital
                </label>
                <select 
                    name="hospital_id" 
                    id="hospital_id"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                    required
                >
                    <option value="">-- Selecione um hospital --</option>
                    @foreach($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <button 
                    type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Visualizar Finanças
                </button>
            </div>
        </form>

        @if($hospitals->count() === 0)
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Nenhum hospital cadastrado. 
                            <a href="{{ route('hospitals.create') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">
                                Cadastre um hospital primeiro.
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            O que você pode fazer aqui
        </h3>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    💰 Orçamento
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Visualize e gerencie o orçamento total e saldo atual do hospital
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    📊 Despesas por Categoria
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Análise detalhada de gastos divididos por categoria de produtos
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    📅 Histórico Mensal
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Acompanhe os gastos dos últimos 12 meses
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    📈 Análise Sazonal
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    Visualize gastos por trimestre para identificar padrões
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection

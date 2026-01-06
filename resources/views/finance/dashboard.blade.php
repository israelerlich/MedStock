@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>💰 Gestão Financeira</h1>
            
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <label>Selecione o Hospital:</label>
                        <select name="hospital_id" class="form-control" onchange="this.form.submit()" required>
                            <option value="">Selecione um hospital...</option>
                            @foreach(\App\Models\Hospital::all() as $h)
                                <option value="{{ $h->id }}" {{ request('hospital_id') == $h->id ? 'selected' : '' }}>
                                    {{ $h->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            @if(!request('hospital_id'))
                <div class="alert alert-info">
                    Por favor, selecione um hospital para visualizar os dados financeiros.
                </div>
            @endif
        </div>
    </div>

    @if(isset($hospital))
    <!-- Resumo Financeiro -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Orçamento Total</h6>
                    <h3 class="text-primary">R$ {{ number_format($budget, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="card-title text-muted">Saldo Atual</h6>
                    <h3 class="text-success">R$ {{ number_format($currentBalance, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="card-title text-muted">Gasto Mês Atual</h6>
                    <h3 class="text-danger">R$ {{ number_format($currentMonthExpenses, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="card-title text-muted">Comparação com Mês Anterior</h6>
                    @php
                        $diff = $currentMonthExpenses - $lastMonthExpenses;
                        $percentChange = $lastMonthExpenses > 0 ? ($diff / $lastMonthExpenses) * 100 : 0;
                    @endphp
                    <h3 class="{{ $diff > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $diff > 0 ? '+' : '' }}{{ number_format($percentChange, 1) }}%
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Atualizar Orçamento -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Atualizar Orçamento</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('finance.update-budget', $hospital) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Orçamento Total</label>
                                    <input type="number" step="0.01" name="budget" class="form-control" value="{{ $budget }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Saldo Atual</label>
                                    <input type="number" step="0.01" name="current_balance" class="form-control" value="{{ $currentBalance }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Gastos por Categoria -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Despesas por Categoria (Mês Atual)</h5>
                </div>
                <div class="card-body">
                    @if($expensesByCategory->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Porcentagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = $expensesByCategory->sum(); @endphp
                            @foreach($expensesByCategory as $type => $amount)
                            <tr>
                                <td>{{ $type ? $type->label() : 'Sem categoria' }}</td>
                                <td>R$ {{ number_format($amount, 2, ',', '.') }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $total > 0 ? ($amount / $total) * 100 : 0 }}%">
                                            {{ $total > 0 ? number_format(($amount / $total) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="font-weight-bold">
                                <td>TOTAL</td>
                                <td>R$ {{ number_format($total, 2, ',', '.') }}</td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('finance.expenses-by-category', ['hospital_id' => $hospital->id]) }}" class="btn btn-primary">
                        Ver Detalhes por Categoria
                    </a>
                    @else
                    <p class="text-muted">Nenhuma despesa registrada neste mês.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Gastos Mensais (Últimos 12 Meses) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Histórico de Gastos Mensais</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Mês</th>
                                <th>Valor</th>
                                <th>Gráfico</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $maxExpense = max(array_values($monthlyExpenses)); @endphp
                            @foreach($monthlyExpenses as $month => $expense)
                            <tr>
                                <td>{{ $month }}</td>
                                <td>R$ {{ number_format($expense, 2, ',', '.') }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: {{ $maxExpense > 0 ? ($expense / $maxExpense) * 100 : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Gastos Sazonais (Por Trimestre) -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gastos Sazonais por Trimestre</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($seasonalExpenses as $quarter => $expense)
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>{{ $quarter }}</h6>
                                    <h4>R$ {{ number_format($expense, 2, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Links para Outros Relatórios -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Relatórios Financeiros</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('finance.monthly-report', ['hospital_id' => $hospital->id]) }}" class="list-group-item list-group-item-action">
                            📊 Relatório Mensal Detalhado
                        </a>
                        <a href="{{ route('reports.movements', ['hospital_id' => $hospital->id]) }}" class="list-group-item list-group-item-action">
                            📋 Histórico de Movimentações
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

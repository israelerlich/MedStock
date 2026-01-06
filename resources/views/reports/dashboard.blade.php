@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Dashboard de Relatórios</h1>
            
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <label>Filtrar por Hospital:</label>
                        <select name="hospital_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Todos os Hospitais</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                    {{ $hospital->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Alertas Críticos -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">⚠️ Produtos Vencidos</h5>
                    <h2 class="text-danger">{{ $expiredProducts->count() }}</h2>
                    <p class="mb-0">produtos vencidos em estoque</p>
                    <a href="{{ route('reports.expiry') }}" class="btn btn-danger btn-sm mt-2">Ver Detalhes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">⏰ Próximos ao Vencimento</h5>
                    <h2 class="text-warning">{{ $nearExpiryProducts->count() }}</h2>
                    <p class="mb-0">vencem nos próximos 30 dias</p>
                    <a href="{{ route('reports.expiry') }}" class="btn btn-warning btn-sm mt-2">Ver Detalhes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title text-info">📦 Estoque Baixo</h5>
                    <h2 class="text-info">{{ $lowStockProducts->count() }}</h2>
                    <p class="mb-0">produtos com estoque mínimo</p>
                    <a href="{{ route('reports.stock') }}" class="btn btn-info btn-sm mt-2">Ver Detalhes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Vencidos -->
    @if($expiredProducts->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Produtos Vencidos - AÇÃO NECESSÁRIA!</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Fornecedor</th>
                                <th>Estoque</th>
                                <th>Vencimento</th>
                                <th>Dias Vencido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiredProducts->take(10) as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>{{ $product->expires_at->format('d/m/Y') }}</td>
                                <td class="text-danger">{{ $product->expires_at->diffInDays(now()) }} dias</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Produtos com Mais Demanda -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📊 Top 10 Produtos com Mais Demanda (Últimos 30 Dias)</h5>
                </div>
                <div class="card-body">
                    @if($topDemandProducts->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Posição</th>
                                <th>Produto</th>
                                <th>Fornecedor</th>
                                <th>Quantidade Consumida</th>
                                <th>Valor Total Gasto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topDemandProducts as $index => $movement)
                            <tr>
                                <td>{{ $index + 1 }}º</td>
                                <td>{{ $movement->product->name }}</td>
                                <td>{{ $movement->product->supplier->name }}</td>
                                <td><strong>{{ $movement->total_quantity }}</strong> unidades</td>
                                <td>R$ {{ number_format($movement->total_spent, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <a href="{{ route('reports.demand') }}" class="btn btn-primary">Ver Relatório Completo de Demanda</a>
                    </div>
                    @else
                    <p class="text-muted">Nenhuma movimentação de saída nos últimos 30 dias.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Links Rápidos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Relatórios Disponíveis</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('reports.movements') }}" class="list-group-item list-group-item-action">
                            📋 Relatório de Movimentações (Entradas e Saídas)
                        </a>
                        <a href="{{ route('reports.expiry') }}" class="list-group-item list-group-item-action">
                            ⏰ Relatório de Produtos Vencidos e Próximos ao Vencimento
                        </a>
                        <a href="{{ route('reports.demand') }}" class="list-group-item list-group-item-action">
                            📊 Relatório de Demanda de Produtos
                        </a>
                        <a href="{{ route('reports.stock') }}" class="list-group-item list-group-item-action">
                            📦 Relatório de Estoque
                        </a>
                        <a href="{{ route('finance.dashboard') }}" class="list-group-item list-group-item-action">
                            💰 Dashboard Financeiro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

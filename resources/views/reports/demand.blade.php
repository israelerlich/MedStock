@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>📊 Análise de Demanda de Produtos</h1>
            
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <label>Período:</label>
                        <select name="period" class="form-control" onchange="this.form.submit()">
                            <option value="7" {{ $period == 7 ? 'selected' : '' }}>Últimos 7 dias</option>
                            <option value="15" {{ $period == 15 ? 'selected' : '' }}>Últimos 15 dias</option>
                            <option value="30" {{ $period == 30 ? 'selected' : '' }}>Últimos 30 dias</option>
                            <option value="60" {{ $period == 60 ? 'selected' : '' }}>Últimos 60 dias</option>
                            <option value="90" {{ $period == 90 ? 'selected' : '' }}>Últimos 90 dias</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Produtos com Mais Demanda -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Produtos com Maior Demanda (Últimos {{ $period }} dias)</h5>
                </div>
                <div class="card-body">
                    @if($topProducts->count() > 0)
                    <div class="alert alert-info">
                        <strong>Total de produtos analisados:</strong> {{ $topProducts->count() }}
                    </div>
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Posição</th>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Fornecedor</th>
                                <th>Quantidade Consumida</th>
                                <th>Valor Total Gasto</th>
                                <th>Nº de Movimentações</th>
                                <th>Média por Movimentação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $index => $movement)
                            <tr>
                                <td>
                                    @if($index < 3)
                                        <span class="badge badge-warning">{{ $index + 1 }}º</span>
                                    @else
                                        {{ $index + 1 }}º
                                    @endif
                                </td>
                                <td><strong>{{ $movement->product->name }}</strong></td>
                                <td>{{ $movement->product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $movement->product->supplier->name }}</td>
                                <td class="text-primary"><strong>{{ $movement->total_quantity }}</strong> unidades</td>
                                <td class="text-danger"><strong>R$ {{ number_format($movement->total_spent, 2, ',', '.') }}</strong></td>
                                <td>{{ $movement->movement_count }} movimentações</td>
                                <td>{{ number_format($movement->total_quantity / $movement->movement_count, 2, ',', '.') }} un/mov</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="4">TOTAIS</td>
                                <td class="text-primary">{{ $topProducts->sum('total_quantity') }} unidades</td>
                                <td class="text-danger">R$ {{ number_format($topProducts->sum('total_spent'), 2, ',', '.') }}</td>
                                <td>{{ $topProducts->sum('movement_count') }} movimentações</td>
                                <td>-</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-3">
                        <h6>Insights:</h6>
                        <ul>
                            <li>Produto com maior demanda: <strong>{{ $topProducts->first()->product->name }}</strong> ({{ $topProducts->first()->total_quantity }} unidades)</li>
                            <li>Maior gasto: <strong>R$ {{ number_format($topProducts->max('total_spent'), 2, ',', '.') }}</strong></li>
                            <li>Média de consumo: <strong>{{ number_format($topProducts->avg('total_quantity'), 2, ',', '.') }}</strong> unidades por produto</li>
                        </ul>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        Nenhuma movimentação de saída foi registrada nos últimos {{ $period }} dias.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Sem Movimento -->
    @if($noMovementProducts->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-warning">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">⚠️ Produtos Sem Movimento (Últimos {{ $period }} dias)</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ $noMovementProducts->count() }} produtos</strong> não tiveram nenhuma movimentação de saída nos últimos {{ $period }} dias.</p>
                    <p class="text-muted">Estes produtos podem estar com excesso de estoque ou com baixa demanda.</p>
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Fornecedor</th>
                                <th>Estoque Atual</th>
                                <th>Valor em Estoque</th>
                                <th>Vencimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($noMovementProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>R$ {{ number_format($product->price * $product->current_stock, 2, ',', '.') }}</td>
                                <td>
                                    @if($product->expires_at)
                                        {{ $product->expires_at->format('d/m/Y') }}
                                        @if($product->isExpired())
                                            <span class="badge badge-danger">VENCIDO</span>
                                        @elseif($product->isNearExpiry())
                                            <span class="badge badge-warning">PRÓXIMO</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <strong>Valor total parado em estoque:</strong> 
                        R$ {{ number_format($noMovementProducts->sum(fn($p) => $p->price * $p->current_stock), 2, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">← Voltar ao Dashboard</a>
        </div>
    </div>
</div>
@endsection

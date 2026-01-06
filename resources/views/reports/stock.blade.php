@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📦 Relatório de Estoque</h1>
    
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

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total de Produtos</h6>
                    <h3>{{ $summary['total_products'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Estoque Baixo</h6>
                    <h3 class="text-warning">{{ $summary['low_stock'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted">Sem Estoque</h6>
                    <h3 class="text-danger">{{ $summary['out_of_stock'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted">Valor Total</h6>
                    <h3 class="text-success">R$ {{ number_format($summary['total_value'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Hospital</th>
                        <th>Fornecedor</th>
                        <th>Tipo</th>
                        <th>Estoque Atual</th>
                        <th>Estoque Mínimo</th>
                        <th>Preço Unit.</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="{{ $product->current_stock == 0 ? 'table-danger' : ($product->current_stock <= $product->min_stock ? 'table-warning' : '') }}">
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                        <td>{{ $product->supplier->name }}</td>
                        <td>{{ $product->type->label() }}</td>
                        <td><strong>{{ $product->current_stock }}</strong></td>
                        <td>{{ $product->min_stock }}</td>
                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($product->price * $product->current_stock, 2, ',', '.') }}</td>
                        <td>
                            @if($product->current_stock == 0)
                                <span class="badge badge-danger">SEM ESTOQUE</span>
                            @elseif($product->current_stock <= $product->min_stock)
                                <span class="badge badge-warning">ESTOQUE BAIXO</span>
                            @else
                                <span class="badge badge-success">OK</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">← Voltar</a>
    </div>
</div>
@endsection

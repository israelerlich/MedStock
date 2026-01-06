@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📋 Relatório de Movimentações</h1>
    
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Hospital:</label>
                <select name="hospital_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($hospitals as $hospital)
                        <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                            {{ $hospital->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Tipo:</label>
                <select name="type" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>Entrada</option>
                    <option value="2" {{ request('type') == 2 ? 'selected' : '' }}>Saída</option>
                    <option value="3" {{ request('type') == 3 ? 'selected' : '' }}>Devolução</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>Data Início:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label>Data Fim:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Entradas</h6>
                    <h3>R$ {{ number_format($totals['entries'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Total Saídas</h6>
                    <h3>R$ {{ number_format($totals['exits'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Produto</th>
                        <th>Hospital</th>
                        <th>Cliente</th>
                        <th>Quantidade</th>
                        <th>Valor Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge badge-{{ $movement->type->value == 1 ? 'success' : ($movement->type->value == 2 ? 'danger' : 'info') }}">
                                {{ $movement->type->label() }}
                            </span>
                        </td>
                        <td>{{ $movement->product->name }}</td>
                        <td>{{ $movement->product->hospital->name ?? 'N/A' }}</td>
                        <td>{{ $movement->client->name }}</td>
                        <td>{{ $movement->quantity }}</td>
                        <td>R$ {{ number_format($movement->unit_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($movement->total_price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $movements->links() }}
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('reports.dashboard') }}" class="btn btn-secondary">← Voltar</a>
    </div>
</div>
@endsection

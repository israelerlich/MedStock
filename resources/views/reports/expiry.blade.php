@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>⏰ Gestão de Produtos Vencidos</h1>
            <p class="lead">Controle de produtos vencidos e próximos ao vencimento para garantir a segurança do paciente</p>
            
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

    <!-- ALERTA CRÍTICO: Produtos Vencidos -->
    @if($expiredProducts->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <h4 class="alert-heading">⚠️ ATENÇÃO: Produtos Vencidos em Estoque!</h4>
                <p><strong>{{ $expiredProducts->count() }} produtos vencidos</strong> foram encontrados no estoque. 
                Estes produtos NÃO devem ser utilizados e devem ser retirados imediatamente para garantir a segurança dos pacientes.</p>
            </div>

            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Produtos Vencidos - REMOVER IMEDIATAMENTE</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Fornecedor</th>
                                <th>Tipo</th>
                                <th>Estoque</th>
                                <th>Data de Vencimento</th>
                                <th>Dias Vencido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiredProducts as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->type->label() }}</td>
                                <td class="text-danger"><strong>{{ $product->current_stock }}</strong> unidades</td>
                                <td>{{ $product->expires_at->format('d/m/Y') }}</td>
                                <td class="text-danger"><strong>{{ now()->diffInDays($product->expires_at) }} dias</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-success">
        ✅ Excelente! Não há produtos vencidos em estoque no momento.
    </div>
    @endif

    <!-- Produtos Próximos ao Vencimento - 7 dias -->
    @if($nearExpiryProducts['7_days']->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-danger">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">🚨 URGENTE: Vencimento em até 7 dias</h5>
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
                                <th>Dias Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nearExpiryProducts['7_days'] as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>{{ $product->expires_at->format('d/m/Y') }}</td>
                                <td class="text-warning"><strong>{{ $product->expires_at->diffInDays(now()) }} dias</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Produtos Próximos ao Vencimento - 8 a 15 dias -->
    @if($nearExpiryProducts['15_days']->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-warning">
                <div class="card-header bg-light">
                    <h5 class="mb-0">⚠️ Atenção: Vencimento em 8 a 15 dias</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Estoque</th>
                                <th>Vencimento</th>
                                <th>Dias Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nearExpiryProducts['15_days'] as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>{{ $product->expires_at->format('d/m/Y') }}</td>
                                <td>{{ $product->expires_at->diffInDays(now()) }} dias</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Produtos Próximos ao Vencimento - 16 a 30 dias -->
    @if($nearExpiryProducts['30_days']->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header">
                    <h5 class="mb-0">ℹ️ Informação: Vencimento em 16 a 30 dias</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Hospital</th>
                                <th>Estoque</th>
                                <th>Vencimento</th>
                                <th>Dias Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nearExpiryProducts['30_days'] as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->hospital->name ?? 'N/A' }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>{{ $product->expires_at->format('d/m/Y') }}</td>
                                <td>{{ $product->expires_at->diffInDays(now()) }} dias</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

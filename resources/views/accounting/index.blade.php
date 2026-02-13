<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Contable | NominaSV</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            background: #f1f5f9; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .bg-dark-sidebar { background-color: #1e293b; color: white; }
        .card-custom { 
            border-radius: 16px; 
            border: none; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
            background: white;
        }
        .table-catalogo th { font-size: 0.8rem; text-transform: uppercase; color: #64748b; }
        .btn-action { background: #4f46e5; color: white; border: none; }
        .btn-action:hover { background: #3730a3; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark-sidebar py-3 shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="fa-solid fa-calculator me-2"></i>Contabilidad <span class="badge bg-warning text-dark ms-1">Práctica</span>
        </a>
        <a href="/" class="btn btn-sm btn-outline-light opacity-75">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver a Nómina
        </a>
    </div>
</nav>

<div class="container pb-5">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check fs-4 me-3"></i>
            <div>
                <h6 class="fw-bold mb-0">¡Excelente!</h6>
                <small>{{ session('success') }}</small>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-lg-4">
            
            <div class="card card-custom bg-dark-sidebar text-white mb-4 p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-10 p-2 rounded me-3">
                        <span class="fw-bold">01</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Partida de Apertura</h6>
                        <small class="opacity-75">Inicio de Operaciones</small>
                    </div>
                </div>
                <p class="small opacity-75 mb-3 border-top border-white border-opacity-10 pt-3">
                    "Se inicia la empresa con un aporte de socios de $50,000 en efectivo."
                </p>
                
                <form action="{{ route('accounting.opening') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-dark shadow-lg">
                        <i class="fa-solid fa-bolt me-2"></i> Ejecutar Partida
                    </button>
                </form>
            </div>

            <div class="card card-custom p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Catálogo de Cuentas</h6>
                    <span class="badge bg-light text-secondary">{{ $accounts->count() }} Cuentas</span>
                </div>
                
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle table-catalogo mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Cód</th>
                                <th>Nombre</th>
                                <th class="text-end">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $acc)
                            <tr>
                                <td class="fw-bold text-primary font-monospace small">{{ $acc->code }}</td>
                                <td class="small fw-bold text-secondary">{{ $acc->name }}</td>
                                <td class="text-end">
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $acc->type }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom p-4 min-vh-100">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Libro Diario</h5>
                        <p class="text-muted small mb-0">Registro cronológico de transacciones</p>
                    </div>
                    <div class="bg-light p-2 rounded">
                        <i class="fa-solid fa-book-open text-primary fs-4"></i>
                    </div>
                </div>

                @forelse($entries as $entry)
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-top border border-bottom-0">
                            <div>
                                <span class="badge bg-dark me-2">Partida #{{ $entry->id }}</span>
                                <span class="fw-bold text-secondary small">{{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</span>
                            </div>
                            <span class="badge bg-white text-dark border">{{ $entry->concept }}</span>
                        </div>

                        <div class="border rounded-bottom overflow-hidden">
                            <table class="table table-sm mb-0">
                                <thead class="table-light border-bottom">
                                    <tr class="text-uppercase small text-muted">
                                        <th class="ps-3" style="width: 50%">Cuenta y Detalle</th>
                                        <th class="text-end">Debe</th>
                                        <th class="text-end pe-3">Haber</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($entry->details as $detail)
                                    <tr>
                                        <td class="ps-3 py-2">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-light text-secondary border me-2 font-monospace">{{ $detail->account->code }}</span>
                                                <span class="fw-bold text-dark small">{{ $detail->account->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end py-2 {{ $detail->debit > 0 ? 'fw-bold text-dark' : 'text-muted opacity-25' }}">
                                            {{ $detail->debit > 0 ? '$'.number_format($detail->debit, 2) : '-' }}
                                        </td>
                                        <td class="text-end pe-3 py-2 {{ $detail->credit > 0 ? 'fw-bold text-dark' : 'text-muted opacity-25' }}">
                                            {{ $detail->credit > 0 ? '$'.number_format($detail->credit, 2) : '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-light border-top">
                                        <td class="text-end fw-bold small text-uppercase py-2 pe-3">Totales:</td>
                                        <td class="text-end fw-bold py-2 border-top border-dark border-2">${{ number_format($entry->details->sum('debit'), 2) }}</td>
                                        <td class="text-end fw-bold py-2 pe-3 border-top border-dark border-2">${{ number_format($entry->details->sum('credit'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 my-5">
                        <div class="mb-3 opacity-25">
                            <i class="fa-solid fa-folder-open display-1"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Sin movimientos</h5>
                        <p class="text-muted small">Usa el panel izquierdo para registrar tu primera partida.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

</body>
</html>
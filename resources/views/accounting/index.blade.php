<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Libro Diario </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #1e293b;
            --accent-green: #10b981;
            --accent-gold: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a; 
            background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #334155;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 15px;
        }

        .main-app-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 100%;
            max-width: 1200px;
            min-height: 680px; 
            display: flex;
        }

        .panel-left {
            background-color: var(--secondary);
            color: white;
            padding: 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.05;
            pointer-events: none;
            z-index: -1;
        }

        .form-label {
            color: #94a3b8;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        
        .custom-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .custom-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.25);
            color: white;
            outline: none;
        }
        
        .custom-input::placeholder { color: #64748b; }
        
        select.custom-input option {
            background-color: var(--secondary);
            color: white;
        }

        .btn-brand {
            background: var(--primary);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }
        
        .btn-brand:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.5);
            color: white;
        }

        .panel-right {
            background: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .dark-box {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        .table-dark-custom {
            --bs-table-bg: transparent; 
            --bs-table-color: #cbd5e1;
            font-size: 0.85rem;
        }
        .table-dark-custom th { color: #94a3b8; font-weight: 700; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.1) !important; background: transparent !important; }
        .table-dark-custom td { border-bottom: 1px solid rgba(255,255,255,0.05) !important; padding: 8px 4px; background: transparent !important; }

        .journal-entry-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .journal-header {
            background: #f8fafc;
            padding: 12px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .journal-table th { background: white; font-size: 0.75rem; color: #64748b; text-transform: uppercase; }
        .journal-table td { font-size: 0.9rem; vertical-align: middle; }
        
        .btn-delete {
            background: none;
            border: none;
            color: #ef4444;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .btn-delete:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        div:where(.swal2-container) { z-index: 9999; }

        @media (max-width: 991px) {
            body { padding: 10px; }
            .main-app-container { flex-direction: column; min-height: auto; margin-bottom: 20px; }
            .panel-left, .panel-right { padding: 25px 20px; width: 100%; }
        }
    </style>
</head>
<body>

<div class="main-app-container animate__animated animate__fadeIn">
    <div class="row g-0 w-100">
        
        <div class="col-lg-5 col-md-12 panel-left">
            
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold text-white mb-1">Módulo Contable</h4>
                    <p class="text-white-50 small opacity-75">Sistema de Partidas Automatizado</p>
                </div>
                <a href="/" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: white; border-radius: 10px;">
                    <i class="fa-solid fa-arrow-left"></i> Nómina
                </a>
            </div>

            <div class="dark-box">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-warning text-dark me-2">Ejercicio 1</span>
                    <h6 class="fw-bold text-white mb-0">Partida de Apertura</h6>
                </div>
                <p class="small text-white-50 mb-3">"Se inicia la empresa con un aporte de socios de $50,000 en efectivo."</p>
                
                <form action="{{ route('accounting.opening') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-dark shadow-sm" style="border-radius: 10px;">
                        <i class="fa-solid fa-bolt me-2"></i> Ejecutar Apertura
                    </button>
                </form>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-white mb-3"><i class="fa-solid fa-calculator text-primary me-2"></i>Registrar Operación</h6>
                
                <form action="{{ route('accounting.transaction') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Tipo de Transacción</label>
                        <select name="type" class="form-select custom-input" required>
                            <option value="" disabled selected>Seleccione una operación...</option>
                            <option value="compra_mobiliario_contado">Compra Mobiliario (Contado)</option>
                            <option value="compra_mercancia_credito">Compra Mercancía (Crédito)</option>
                            <option value="venta_contado">Venta de Mercancía (Contado)</option>
                            <option value="venta_credito">Venta de Mercancía (Crédito)</option>
                            <option value="pago_alquiler">Pago de Alquiler local</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 translate-middle-y ms-3 text-white-50">$</span>
                            <input type="number" step="0.01" name="amount" class="form-control custom-input ps-5" required placeholder="0.00">
                        </div>
                        <small class="text-success mt-1 d-block" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> + 13% IVA automático
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Concepto de la Partida</label>
                        <input type="text" name="concept" class="form-control custom-input" required placeholder="Ej: Compra de mercadería s/Fac">
                    </div>

                    <button type="submit" class="btn-brand">
                        <i class="fa-solid fa-plus me-2"></i> Generar Partida
                    </button>
                </form>
            </div>

            <div class="dark-box mt-auto mb-0" style="padding: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="form-label mb-0">Catálogo de Cuentas</span>
                    <span class="badge bg-primary rounded-pill">{{ $accounts->count() }}</span>
                </div>
                <div class="table-responsive custom-scrollbar" style="max-height: 180px; overflow-y: auto; overflow-x: hidden;">
                    <table class="table table-borderless table-dark-custom w-100 mb-0">
                        <thead style="position: sticky; top: 0; background: #1a2333; z-index: 1;">
                            <tr>
                                <th style="background: transparent;">Cód</th>
                                <th style="background: transparent;">Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $acc)
                            <tr>
                                <td class="font-monospace text-primary" style="background: transparent;">{{ $acc->code }}</td>
                                <td style="background: transparent;">{{ $acc->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-4 text-center opacity-25 small d-none d-lg-block">
                &copy; 2026 Sistema Empresarial | José Jiménez
            </div>
        </div>

        <div class="col-lg-7 col-md-12 panel-right">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center animate__animated animate__fadeInDown">
                    <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">¡Éxito!</h6>
                        <small>{{ session('success') }}</small>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 animate__animated animate__shakeX">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fa-solid fa-book-open text-primary fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0">Libro Diario</h4>
                        <p class="text-muted small mb-0">Registro cronológico de movimientos</p>
                    </div>
                </div>
            </div>

            @forelse($entries as $entry)
                <div class="journal-entry-card animate__animated animate__fadeInUp">
                    <div class="journal-header">
                        <div>
                            <span class="badge bg-dark me-2">Partida #{{ $entry->id }}</span>
                            <span class="fw-bold text-secondary small"><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark border shadow-sm">{{ $entry->concept }}</span>
                            
                            <form action="{{ route('accounting.destroy', $entry->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Borrar Partida">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <table class="table journal-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 50%">Cuenta y Detalle</th>
                                <th class="text-end">Debe</th>
                                <th class="text-end pe-3">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entry->details as $detail)
                            <tr>
                                <td class="ps-3 py-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-secondary border me-2 font-monospace">{{ $detail->account->code }}</span>
                                        <span class="fw-bold text-dark">{{ $detail->account->name }}</span>
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
                            <tr class="bg-light">
                                <td class="text-end fw-bold text-uppercase py-2 pe-3" style="font-size: 0.75rem; color: #64748b;">Total Partida:</td>
                                <td class="text-end fw-bold text-dark py-2 border-top border-secondary border-2">${{ number_format($entry->details->sum('debit'), 2) }}</td>
                                <td class="text-end fw-bold text-dark py-2 pe-3 border-top border-secondary border-2">${{ number_format($entry->details->sum('credit'), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="text-center py-5 my-5 d-flex flex-column align-items-center justify-content-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3201/3201484.png" width="80" class="mb-3 opacity-25 grayscale" alt="Empty">
                    <h5 class="fw-bold text-muted">Libro Diario Vacío</h5>
                    <p class="text-muted small">Registra tu primera operación en el panel izquierdo.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará el registro. ¡No podrás revertirlo!",
                    icon: 'warning',
                    background: '#1e293b', 
                    color: '#ffffff', 
                    iconColor: '#f59e0b', 
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#4f46e5', 
                    confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> Sí, borrar',
                    cancelButtonText: '<i class="fa-solid fa-ban me-1"></i> Cancelar',
                    customClass: {
                        popup: 'rounded-4' 
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });
    });
</script>

</body>
</html>
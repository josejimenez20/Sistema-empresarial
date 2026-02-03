<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Calculadora Salarial</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary: #4f46e5;       /* Indigo moderno */
            --primary-dark: #3730a3;
            --secondary: #1e293b;     /* Slate Dark */
            --accent-green: #10b981;  /* Emerald */
            --accent-gold: #f59e0b;   /* Amber */
            --bg-gradient: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a; /* Fondo base oscuro por si falla el gradiente */
            background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px; /* Padding para que no pegue a los bordes en celular */
        }

        /* Contenedor Principal Flotante */
        .main-app-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); /* Sombra más profunda */
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            /* Altura mínima solo en PC para que se vea elegante */
            min-height: 680px; 
            display: flex;
        }

        /* COLUMNA IZQUIERDA (OSCURA) */
        .panel-left {
            background-color: var(--secondary);
            color: white;
            padding: 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
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

        /* Inputs Oscuros */
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
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 1rem;
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

        /* Botón Principal */
        .btn-brand {
            background: var(--primary);
            color: white;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            width: 100%;
            margin-top: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
            font-size: 1rem;
        }
        
        .btn-brand:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.5);
        }

        /* COLUMNA DERECHA (CLARA) */
        .panel-right {
            background: #fff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Elementos de la Boleta */
        .avatar-section {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .avatar-initial {
            width: 60px;
            height: 60px;
            min-width: 60px; /* Evita que se aplaste en móvil */
            background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%);
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2);
        }

        .bill-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.95rem;
        }
        .bill-item:last-of-type { border-bottom: none; }
        .amount-negative { color: #ef4444; font-weight: 600; }
        .amount-positive { color: var(--secondary); font-weight: 700; }

        /* Tarjetas de Totales */
        .net-salary-card {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            margin-top: 10px;
            height: 100%; /* Para que tengan la misma altura */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Tarjeta Dorada */
        .gold-card {
            background: linear-gradient(135deg, #fffbeb 0%, #fcd34d 100%);
            border: 1px solid #fcd34d;
            border-radius: 16px;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.2);
            transition: transform 0.3s;
        }
        .gold-card:hover { transform: translateY(-3px); }
        .gold-tag {
            position: absolute;
            top: 12px; right: 12px;
            background: #b45309;
            color: white;
            font-size: 0.65rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 800;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Botón PDF */
        .btn-pdf-modern {
            background: #ef4444;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
        }
        .btn-pdf-modern:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
        }

        /* --- RESPONSIVE DESIGN (LA MAGIA) --- */
        @media (max-width: 991px) {
            body {
                align-items: flex-start; /* En móvil, alinear arriba para poder scrollear */
                padding: 10px;
                height: auto;
                min-height: 100vh;
            }
            
            .main-app-container {
                flex-direction: column; /* Apilar columnas */
                min-height: auto; /* Altura automática */
                height: auto;
                margin-top: 10px;
                margin-bottom: 20px;
            }
            
            .panel-left, .panel-right {
                padding: 30px 20px; /* Menos padding en móvil */
                width: 100%;
            }

            .panel-left {
                padding-bottom: 40px; /* Espacio extra abajo del botón */
            }

            .display-6 {
                font-size: 2rem; /* Texto un poco más pequeño en móvil */
            }
        }
    </style>
</head>
<body>

<div class="main-app-container">
    <div class="row g-0 w-100">
        
        <div class="col-lg-5 col-md-12 panel-left">
            
            <div class="mb-5 d-none d-lg-block"> <h4 class="fw-bold text-white mb-1">Calculadora Salarial SV</h4>
                <p class="text-white-50 small opacity-75">Calculadora Automatizada de Deducciones Fiscales y Beneficios de la Ley Quincena 25</p>
            </div>

            <div class="mb-4 d-lg-none text-center"> <h4 class="fw-bold text-white">Calculadora Salarial SV</h4>
            </div>

            <div class="mb-4">
                <i class="fa-solid fa-layer-group fs-2 text-primary mb-3"></i>
                <h3 class="fw-bold">Datos del Colaborador</h3>
                <p class="text-secondary opacity-75 small">Ingresa los datos para generar la boleta fiscal automatizada.</p>
            </div>

            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nombre del Colaborador</label>
                    <input type="text" name="employee_name" class="form-control custom-input" required placeholder="Nombre Completo" value="{{ old('employee_name', $employee ?? '') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Salario Base Mensual</label>
                    <div class="input-group">
                        <span class="position-absolute ps-3 pt-3 text-white-50" style="z-index: 5;"></span>
                        <input type="number" step="0.01" name="base_salary" class="form-control custom-input ps-4" required placeholder="0.00" value="{{ old('base_salary', isset($data) ? $data['base_salary'] : '') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-brand">
                    <i class="fa-solid fa-bolt me-2"></i> Calcular Ahora
                </button>
                
                <div class="text-center mt-3">
                    <a href="/" class="text-white-50 text-decoration-none small hover-white">
                        <i class="fa-solid fa-rotate-left me-1"></i> Limpiar Campos
                    </a>
                </div>
            </form>
            
            <div class="mt-auto pt-4 text-center opacity-25 small d-none d-lg-block">
                &copy; 2026 Sistema Empresarial | José Jiménez
            </div>
        </div>

        <div class="col-lg-7 col-md-12 panel-right">
            
            @if(isset($data))
                <div class="animate__animated animate__fadeIn">
                    
                    <div class="avatar-section">
                        <div class="avatar-initial">
                            {{ substr($employee, 0, 1) }}
                        </div>
                        <div class="overflow-hidden"> <h5 class="fw-bold mb-0 text-dark text-truncate">{{ $employee }}</h5>
                            <span class="badge bg-light text-secondary border">Colaborador Activo</span>
                        </div>
                        <div class="ms-auto text-end d-none d-sm-block">
                            <small class="text-muted d-block">Periodo</small>
                            <span class="fw-bold text-primary">
                                {{ ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'][date('n')] }} {{ date('Y') }}
                            </span>
                        </div>
                    </div>

                    <h6 class="text-uppercase text-muted small fw-bold mb-3 border-bottom pb-2">Desglose de Retenciones</h6>
                    
                    <div class="bill-item">
                        <span class="text-secondary">Salario Base</span>
                        <span class="amount-positive">${{ $data['base_salary'] }}</span>
                    </div>

                    <div class="bill-item">
                        <span class="text-muted"><i class="fa-solid fa-shield-cat me-2"></i>AFP Aplicando 7.25%</span>
                        <span class="amount-negative">-${{ $data['afp'] }}</span>
                    </div>

                    <div class="bill-item">
                        <span class="text-muted"><i class="fa-solid fa-user-nurse me-2"></i>ISSS Aplicando 3%</span>
                        <span class="amount-negative">-${{ $data['isss'] }}</span>
                    </div>

                    <div class="bill-item bg-light px-2 rounded my-1">
                        <span class="fw-bold text-dark">Renta Imponible</span>
                        <span class="fw-bold text-dark">${{ $data['taxable_income'] }}</span>
                    </div>

                    <div class="bill-item align-items-center">
                        <span class="text-muted"><i class="fa-solid fa-building-columns me-2"></i>ISR</span>
                        @if($data['isr'] > 0)
                            <span class="amount-negative">-${{ $data['isr'] }}</span>
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">¡No pagas renta!</span>
                        @endif
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-6"> <div class="net-salary-card">
                                <small class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem;">Mensual</small>
                                <h3 class="fw-bold text-dark mb-0 fs-4">${{ $data['net_salary'] }}</h3>
                            </div>
                        </div>
                        <div class="col-6"> <div class="net-salary-card" style="background: #ecfeff; border-color: #a5f3fc;">
                                <small class="fw-bold text-uppercase d-block mb-1" style="color: #0891b2; font-size: 0.7rem;">Quincenal</small>
                                <h3 class="fw-bold mb-0 fs-4" style="color: #155e75">${{ $data['net_biweekly'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('payroll.pdf', ['id' => $data['id']]) }}" class="btn-pdf-modern">
                            <i class="fa-solid fa-file-pdf me-2"></i> Descargar Boleta (PDF)
                        </a>
                    </div>

                    @if(isset($data['q25']) && $data['q25']['applies'])
                        <div class="gold-card animate__animated animate__pulse p-4 mt-4"> 
                            <div class="gold-tag shadow-sm">
                                Bono {{ ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'][date('n')] }}
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 d-none d-sm-block"> <div class="bg-white p-3 rounded-circle shadow-sm" style="color: #b45309">
                                            <i class="fa-solid fa-star fs-3"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #78350f; font-size: 1.1rem;">Ley Quincena 25</h6>
                                        <div class="mb-1">
                                            <span class="badge bg-white text-dark border border-warning fw-normal rounded-pill px-2">
                                                <i class="fa-regular fa-calendar me-1 text-warning"></i> 
                                                15-25 {{ ['','Enero'][date('n')] }}
                                            </span>
                                        </div>
                                        <p class="mb-0 small opacity-75 fw-medium" style="color: #92400e">
                                            <i class="fa-solid fa-check-circle me-1"></i> Libre de descuentos
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="text-end ps-2">
                                    <small class="text-uppercase fw-bold opacity-50 d-block" style="color: #78350f; font-size: 0.6rem;">Monto Total</small>
                                    <h2 class="fw-bold mb-0" style="color: #b45309; font-size: 1.8rem;">${{ $data['q25']['amount'] }}</h2>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-3 text-center border rounded p-3 bg-light opacity-50 small">
                            <i class="fa-solid fa-ban me-1"></i> No aplica a Bono Q25
                        </div>
                    @endif

                </div>
            @else
                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center opacity-50 py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/2942/2942544.png" width="80" class="mb-3 opacity-50 grayscale" alt="Calc">
                    <h4 class="fw-bold">Listo para Calcular</h4>
                    <p class="text-muted">Ingresa los datos en el panel izquierdo para ver la magia.</p>
                </div>
            @endif

        </div>

    </div>
</div>

</body>
</html>
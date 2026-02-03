<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        h1 {
            color: #4f46e5;
            margin: 0;
            text-transform: uppercase;
        }
        .info-box {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-box td {
            padding: 5px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-data th, .table-data td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table-data th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-danger { color: #dc2626; }
        .total-row { 
            background-color: #e0e7ff; 
            font-weight: bold; 
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Boleta de Pago</h1>
        <p>Comprobante de Ingresos y Retenciones</p>
    </div>

    <table class="info-box">
        <tr>
            <td><strong>Colaborador:</strong> {{ $payroll->employee_name }}</td>
            <td class="text-right"><strong>Fecha Emisión:</strong> {{ $payroll->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>ID Nómina:</strong> #{{ str_pad($payroll->id, 6, '0', STR_PAD_LEFT) }}</td>
            <td class="text-right"><strong>Periodo:</strong> {{ date('F Y') }}</td>
        </tr>
    </table>

    <table class="table-data">
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salario Base Mensual</td>
                <td class="text-right">${{ number_format($payroll->base_salary, 2) }}</td>
            </tr>
            <tr>
                <td>(-) AFP (7.25%)</td>
                <td class="text-right text-danger">-${{ number_format($payroll->afp, 2) }}</td>
            </tr>
            <tr>
                <td>(-) ISSS (3%)</td>
                <td class="text-right text-danger">-${{ number_format($payroll->isss, 2) }}</td>
            </tr>
            <tr>
                <td>(-) Renta (ISR)</td>
                <td class="text-right text-danger">-${{ number_format($payroll->isr, 2) }}</td>
            </tr>
            
            <tr class="total-row">
                <td>SUELDO LÍQUIDO A RECIBIR</td>
                <td class="text-right">${{ number_format($payroll->net_salary, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>_____________________________</p>
        <p>Firma del Colaborador</p>
        <br>
        <p>Documento generado por Calculadora Salarial SV</p>
    </div>

</body>
</html>
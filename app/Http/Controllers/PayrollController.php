<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Services\PayrollService;
use Barryvdh\DomPDF\Facade\Pdf; 

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index()
    {
        return view('payroll');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string',
            'base_salary' => 'required|numeric|min:0',
        ]);

        $result = $this->payrollService->calculate($request->base_salary);

        // Guardamos en BD
        $payroll = Payroll::create([
            'employee_name' => $request->employee_name,
            'base_salary' => $result['base_salary'],
            'isss' => $result['isss'],
            'afp' => $result['afp'],
            'taxable_income' => $result['taxable_income'],
            'isr' => $result['isr'],
            'net_salary' => $result['net_salary'],
        ]);

        // Agregamos el ID al resultado para que la vista pueda crear el link del PDF
        $result['id'] = $payroll->id;

        return view('payroll', ['data' => $result, 'employee' => $request->employee_name]);
    }

    // --- FUNCIÓN PARA DESCARGAR EL PDF ---
    public function downloadPdf($id)
    {
        $payroll = Payroll::findOrFail($id);
        
        // Carga la vista 'pdf.invoice' y le pasa los datos
        $pdf = Pdf::loadView('invoice', ['payroll' => $payroll]);
        
        return $pdf->download('Boleta_Pago_'.$payroll->employee_name.'.pdf');
    }
}
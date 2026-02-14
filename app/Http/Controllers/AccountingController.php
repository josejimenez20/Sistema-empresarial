<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryDetail;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index()
    {
        // Traemos todas las cuentas y las partidas registradas
        $accounts = Account::all();
        $entries = JournalEntry::with('details.account')->orderBy('date', 'desc')->get();
        
        return view('accounting.index', compact('accounts', 'entries'));
    }

    public function storeOpening()
    {
        // Lógica para la Partida #1: Apertura
        // Se inicia la empresa con $50,000 en efectivo.
        
        try {
            DB::transaction(function () {
                // 1. Crear el Encabezado de la Partida
                $entry = JournalEntry::create([
                    'date' => now(),
                    'concept' => 'Partida #1: Inicio de operaciones (Aporte de Socios)',
                ]);

                // 2. Buscar IDs de las cuentas (Efectivo y Capital)
                $cashAccount = Account::where('code', '1101')->first()->id;
                $capitalAccount = Account::where('code', '3101')->first()->id;

                // 3. Registrar el DEBE (Entra Dinero)
                JournalEntryDetail::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $cashAccount,
                    'debit' => 50000.00,
                    'credit' => 0.00,
                ]);

                // 4. Registrar el HABER (Sale Acción/Capital)
                JournalEntryDetail::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $capitalAccount,
                    'debit' => 0.00,
                    'credit' => 50000.00,
                ]);
            });

            return redirect()->back()->with('success', '¡Partida de Apertura registrada correctamente!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear partida: ' . $e->getMessage());
        }
    }


    public function storeTransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'concept' => 'required|string'
        ]);

        $montoBase = $request->amount;
        $iva = $montoBase * 0.13; // Calculamos el 13% de IVA de El Salvador
        $total = $montoBase + $iva;

        try {
            DB::transaction(function () use ($request, $montoBase, $iva, $total) {
                // 1. Crear encabezado de la partida
                $entry = JournalEntry::create([
                    'date' => now(),
                    'concept' => $request->concept,
                ]);

                // 2. Traer IDs de las cuentas frecuentes
                $efectivo = Account::where('code', '1101')->first()->id;
                $cuentasCobrar = Account::where('code', '1103')->first()->id;
                $ivaCredito = Account::where('code', '1104')->first()->id;
                $ivaDebito = Account::where('code', '2102')->first()->id;
                $proveedores = Account::where('code', '2101')->first()->id;
                $ventas = Account::where('code', '4101')->first()->id;
                $compras = Account::where('code', '5101')->first()->id;
                $gastosVenta = Account::where('code', '5102')->first()->id;
                $mobiliario = Account::where('code', '1201')->first()->id;

                // 3. Lógica automática según lo que elijas en el formulario
                switch ($request->type) {
                    case 'compra_mercancia_credito': // Ejercicio 3
                        $this->addDetail($entry->id, $compras, $montoBase, 0); // Compras (Debe)
                        $this->addDetail($entry->id, $ivaCredito, $iva, 0);    // IVA CF (Debe)
                        $this->addDetail($entry->id, $proveedores, 0, $total); // Proveedores (Haber)
                        break;

                    case 'venta_contado': // Ejercicio 4
                        $this->addDetail($entry->id, $efectivo, $total, 0);  // Efectivo (Debe)
                        $this->addDetail($entry->id, $ventas, 0, $montoBase); // Ventas (Haber)
                        $this->addDetail($entry->id, $ivaDebito, 0, $iva);    // IVA DF (Haber)
                        break;

                    case 'venta_credito': // Ejercicio 5
                        $this->addDetail($entry->id, $cuentasCobrar, $total, 0); // Cuentas x Cobrar (Debe)
                        $this->addDetail($entry->id, $ventas, 0, $montoBase);    // Ventas (Haber)
                        $this->addDetail($entry->id, $ivaDebito, 0, $iva);       // IVA DF (Haber)
                        break;

                    case 'pago_alquiler': // Ejercicio 8
                        $this->addDetail($entry->id, $gastosVenta, $montoBase, 0); // Gasto (Debe)
                        $this->addDetail($entry->id, $ivaCredito, $iva, 0);        // IVA CF (Debe)
                        $this->addDetail($entry->id, $efectivo, 0, $total);        // Efectivo (Haber)
                        break;
                        
                    case 'compra_mobiliario_contado': // Ejercicio 2
                        $this->addDetail($entry->id, $mobiliario, $montoBase, 0); // Equipo (Debe)
                        $this->addDetail($entry->id, $ivaCredito, $iva, 0);       // IVA CF (Debe)
                        $this->addDetail($entry->id, $efectivo, 0, $total);       // Efectivo (Haber)
                        break;
                }
            });

            return redirect()->back()->with('success', '¡Partida registrada y cuadra a la perfección!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function addDetail($entryId, $accountId, $debit, $credit)
    {
        if ($debit > 0 || $credit > 0) {
            JournalEntryDetail::create([
                'journal_entry_id' => $entryId,
                'account_id' => $accountId,
                'debit' => $debit,
                'credit' => $credit,
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            $entry = JournalEntry::findOrFail($id);
            $entry->delete(); 

            return redirect()->back()->with('success', '¡Partida eliminada correctamente del sistema!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}


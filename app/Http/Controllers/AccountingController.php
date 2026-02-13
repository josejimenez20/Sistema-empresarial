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
}
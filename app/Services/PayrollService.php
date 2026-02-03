<?php

namespace App\Services;

class PayrollService
{
    // Constantes de Ley en El Salvador
    const ISSS_RATE = 0.03;       // 3%
    const AFP_RATE = 0.0725;      // 7.25%
    const ISSS_CAP = 1000.00;     // Techo máximo cotizable ISSS ($30.00 max)

    /**
     * Realiza el cálculo de planilla mensual y el bono Quincena 25
     * @param float $baseSalary
     * @return array
     */
    public function calculate(float $baseSalary)
    {
        // --- CÁLCULOS DE PLANILLA NORMAL ---

        // 1. Cálculos de Ley (ISSS con techo de $30)
        $isss = ($baseSalary >= self::ISSS_CAP) ? 30.00 : $baseSalary * self::ISSS_RATE;
        
        // 2. AFP (7.25%)
        $afp = $baseSalary * self::AFP_RATE;
        
        // 3. Base Imponible (Salario - ISSS - AFP)
        $taxableIncome = $baseSalary - $isss - $afp;
        
        // 4. ISR (Impuesto sobre la Renta)
        $isr = $this->calculateISR($taxableIncome);
        
        // 5. Líquidos
        $netSalary = $taxableIncome - $isr;
        $biweekly = $netSalary / 2; 

        // --- CÁLCULO LEY QUINCENA 25 (NUEVO) ---
        $q25 = $this->calculateQ25($baseSalary);

        // Retornamos todo formateado
        return [
            'base_salary' => number_format($baseSalary, 2, '.', ''),
            'isss' => number_format($isss, 2, '.', ''),
            'afp' => number_format($afp, 2, '.', ''),
            'taxable_income' => number_format($taxableIncome, 2, '.', ''),
            'isr' => number_format($isr, 2, '.', ''),
            'net_salary' => number_format($netSalary, 2, '.', ''),
            'net_biweekly' => number_format($biweekly, 2, '.', ''),
            
            // Datos del Bono Especial
            'q25' => $q25 
        ];
    }

    /**
     * Calcula la "Quincena 25" (Bono de Enero)
     * Reglas: 50% del salario si gana hasta $1,500. Exento de renta.
     */
    private function calculateQ25(float $baseSalary)
    {
        // Regla: Solo aplica si gana hasta $1,500.00
        if ($baseSalary > 1500.00) {
            return [
                'applies' => false,
                'amount' => '0.00',
                'message' => 'No aplica (Salario mayor a $1,500)'
            ];
        }

        // Regla: 50% del salario base
        $amount = $baseSalary * 0.50;

        return [
            'applies' => true,
            'amount' => number_format($amount, 2, '.', ''),
            'message' => 'Bono Exento de Renta y Descuentos'
        ];
    }

    /**
     * Lógica basada en la Tabla de Retención Mensual (Diario Oficial)
     */
    private function calculateISR($income)
    {
        // TRAMO I: $0.01 a $550.00 (Sin Retención)
        if ($income <= 550.00) {
            return 0.00;
        }

        // TRAMO II: $550.01 a $895.24
        // 10% sobre el exceso de $550 + $17.67
        if ($income <= 895.24) {
            return (($income - 550.00) * 0.10) + 17.67;
        }

        // TRAMO III: $895.25 a $2,038.10
        // 20% sobre el exceso de $895.24 + $60.00
        if ($income <= 2038.10) {
            return (($income - 895.24) * 0.20) + 60.00;
        }

        // TRAMO IV: $2,038.11 en adelante
        // 30% sobre el exceso de $2,038.10 + $288.57
        return (($income - 2038.10) * 0.30) + 288.57;
    }
}
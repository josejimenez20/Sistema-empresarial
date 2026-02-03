<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->string('employee_name'); // Nombre del empleado
        
        // Dinero
        $table->decimal('base_salary', 10, 2);    // Sueldo Base
        $table->decimal('isss', 10, 2);           // ISSS (3%)
        $table->decimal('afp', 10, 2);            // AFP (7.25%)
        $table->decimal('taxable_income', 10, 2); // Renta Imponible
        $table->decimal('isr', 10, 2);            // Impuesto S/ Renta
        $table->decimal('net_salary', 10, 2);     // Sueldo
        
        $table->timestamps();
    });
}
};

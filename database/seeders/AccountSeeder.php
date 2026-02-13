<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
/**
 * Run the database seeds.
 */
public function run(): void
{
    $accounts = [
        ['code' => '1101', 'name' => 'Efectivo y Equivalentes', 'type' => 'Activo'],
        ['code' => '1103', 'name' => 'Cuentas por Cobrar Clientes', 'type' => 'Activo'],
        ['code' => '1104', 'name' => 'IVA Crédito Fiscal (13%)', 'type' => 'Activo'],
        ['code' => '1105', 'name' => 'Inventarios', 'type' => 'Activo'],
        ['code' => '1201', 'name' => 'Propiedad, Planta y Equipo', 'type' => 'Activo'],
        ['code' => '2101', 'name' => 'Cuentas por Pagar Proveedores', 'type' => 'Pasivo'],
        ['code' => '2102', 'name' => 'IVA Débito Fiscal (13%)', 'type' => 'Pasivo'],
        ['code' => '3101', 'name' => 'Capital Social', 'type' => 'Patrimonio'],
        ['code' => '4101', 'name' => 'Ventas', 'type' => 'Ingresos'],
        ['code' => '4102', 'name' => 'Rebajas y Devoluciones s/ Ventas', 'type' => 'Ingresos'],
        ['code' => '5101', 'name' => 'Compras', 'type' => 'Gastos'],
        ['code' => '5102', 'name' => 'Gastos de Venta', 'type' => 'Gastos'],
    ];

    foreach ($accounts as $account) {
        \App\Models\Account::create($account);
    }
}
}

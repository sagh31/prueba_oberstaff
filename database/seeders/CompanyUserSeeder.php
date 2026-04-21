<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::create([
            'business_name' => 'Empresa Oberstaff',
            'phone' => '+584126523333',
            'email' => 'contacto@oberstaff.com',
            'iban_para_aeat' => 'ES8595412563548710239910',
            'swift_bic_para_aeat' => 'GHE2S84l4J2',
            'inscrito_registro_devolucion_mensual' => true,
            'volumen_operaciones_modelo_390' => 100000,
        ]);

        User::create([
            'name' => 'Saul Guerrero',
            'email' => 'saul.guerrero2009@gmail.com',
            'password' => Hash::make('password'),
            'company_id' => $company->id,
        ]);
    }
}

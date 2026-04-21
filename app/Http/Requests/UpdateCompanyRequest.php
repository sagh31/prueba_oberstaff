<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return $this->user() && $this->user()->company_id && $this->user()->company_id === (int) $this->route('company')->id;
    }

    
    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'iban_para_aeat' => ['nullable', 'string', 'max:34'],
            'swift_bic_para_aeat' => ['nullable', 'string', 'max:11'],
            'inscrito_registro_devolucion_mensual' => ['nullable', 'boolean'],
            'tributa_exclusivamente_regimen_simplificado' => ['nullable', 'boolean'],
            'autoliquidacion_conjunta' => ['nullable', 'boolean'],
            'declarado_concurso_acreedores' => ['nullable', 'boolean'],
            'fecha_concurso_acreedores' => ['nullable', 'date'],
            'concurso_acreedores_autoliquidacion_preconcursal' => ['nullable', 'boolean'],
            'concurso_acreedores_autoliquidacion_postconcursal' => ['nullable', 'boolean'],
            'regimen_especial_criterio_caja' => ['nullable', 'boolean'],
            'opcion_criterio_caja' => ['nullable', 'boolean'],
            'destinatario_operaciones_regimen_especial_criterio_caja' => ['nullable', 'boolean'],
            'aplicacion_prorrata_especial' => ['nullable', 'boolean'],
            'revocacion_prorrata_especial' => ['nullable', 'boolean'],
            'exonerado_modelo_390' => ['nullable', 'boolean'],
            'volumen_operaciones_modelo_390' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $booleans = [
            'inscrito_registro_devolucion_mensual',
            'tributa_exclusivamente_regimen_simplificado',
            'autoliquidacion_conjunta',
            'declarado_concurso_acreedores',
            'concurso_acreedores_autoliquidacion_preconcursal',
            'concurso_acreedores_autoliquidacion_postconcursal',
            'regimen_especial_criterio_caja',
            'opcion_criterio_caja',
            'destinatario_operaciones_regimen_especial_criterio_caja',
            'aplicacion_prorrata_especial',
            'revocacion_prorrata_especial',
            'exonerado_modelo_390',
        ];

        $data = [];
        foreach ($booleans as $field) {
            $data[$field] = $this->boolean($field);
        }
        $this->merge($data);
    }

    public function messages(): array
    {
        return [
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'email.email' => 'El email de la empresa no es válido.',
            'volumen_operaciones_modelo_390.numeric' => 'El volumen de operaciones debe ser un número.',
        ];
    }
}

@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="m-3">Editar empresa</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('company.update', $company) }}">
                            @csrf
                            @method('PUT')

                            @php
                                $textFields = [
                                    'business_name' => ['Nombre de la empresa', 'text'],
                                    'phone' => ['Teléfono', 'text'],
                                    'email' => ['Email', 'email'],
                                    'iban_para_aeat' => ['IBAN AEAT', 'text'],
                                    'swift_bic_para_aeat' => ['SWIFT/BIC AEAT', 'text'],
                                    'fecha_concurso_acreedores' => ['Fecha concurso acreedores', 'date'],
                                    'volumen_operaciones_modelo_390' => ['Volumen operaciones modelo 390', 'number'],
                                ];

                                $checkboxFields = [
                                    'inscrito_registro_devolucion_mensual' => 'Inscrito registro devolución mensual',
                                    'tributa_exclusivamente_regimen_simplificado' => 'Tributa exclusivamente régimen simplificado',
                                    'autoliquidacion_conjunta' => 'Autoliquidación conjunta',
                                    'declarado_concurso_acreedores' => 'Declarado concurso acreedores',
                                    'concurso_acreedores_autoliquidacion_preconcursal' => 'Concurso - autoliquidación preconcursal',
                                    'concurso_acreedores_autoliquidacion_postconcursal' => 'Concurso - autoliquidación postconcursal',
                                    'regimen_especial_criterio_caja' => 'Régimen especial criterio caja',
                                    'opcion_criterio_caja' => 'Opción criterio caja',
                                    'destinatario_operaciones_regimen_especial_criterio_caja' => 'Destinatario operaciones régimen especial criterio caja',
                                    'aplicacion_prorrata_especial' => 'Aplicación prorrata especial',
                                    'revocacion_prorrata_especial' => 'Revocación prorrata especial',
                                    'exonerado_modelo_390' => 'Exonerado modelo 390',
                                ];
                            @endphp

                            <div class="row g-3">
                                @foreach ($textFields as $name => [$label, $type])
                                    <div class="col-md-6">
                                        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                                        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"  @if($type === 'number') step="0.01" @endif value="{{ old($name, $company->$name instanceof \Illuminate\Support\Carbon ? $company->$name->format('Y-m-d') : $company->$name) }}" class="form-control @error($name) is-invalid @enderror">
                                        @error($name)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Opciones fiscales</h6>
                            <div class="row g-2">
                                @foreach ($checkboxFields as $name => $label)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="{{ $name }}" value="0">
                                            <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="1" @checked(old($name, $company->$name)) class="form-check-input" >
                                            <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('home') }}" class="btn btn-light ">Cancelar</a>
                                <button type="submit" class="btn btn-dark">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
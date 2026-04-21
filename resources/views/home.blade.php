@extends('layouts.app')

@section('content')
    <div class="container py-4">

        @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dashboard</h2>
            @if ($company)
                <div>
                    <a href="{{ route('company.edit', $company) }}" class="btn btn-dark">
                        Editar empresa
                    </a>
                    
                    <button type="button" id="btn-download-pdf" class="btn btn-light">
                        <span class="spinner-border spinner-border-sm d-none" id="pdf-spinner" role="status"></span>
                        <span id="pdf-btn-text">Descargar PDF</span>
                    </button>

                    <form id="pdf-form" method="POST" action="{{ route('company.pdf.images') }}" class="d-none">
                        @csrf
                        <input type="hidden" name="image_user" id="input-image-user">
                        <input type="hidden" name="image_company" id="input-image-company">
                    </form>
                </div>
            @endif
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100" id="card-user">
                    <div class="card-header bg-white fw-bold">
                        <h5 class="card-title m-3">Datos del usuario</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted fw-normal">Nombre</dt>
                            <dd class="col-sm-7 fw-semibold">{{ $user->name }}</dd>

                            <dt class="col-sm-5 text-muted fw-normal">Email</dt>
                            <dd class="col-sm-7 fw-semibold">{{ $user->email }}</dd>

                            <dt class="col-sm-5 text-muted fw-normal">Empresa (business_name)</dt>
                            <dd class="col-sm-7 fw-semibold">
                                {{ $company?->business_name ?? '— Sin empresa asignada —' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100" id="card-company">
                    <div class="card-header  bg-white  fw-bold">
                        
                        <h5 class="card-title m-3">Datos de la empresa</h5>
                    </div>
                    <div class="card-body">
                        @if ($company)
                            @php
                                $fields = [
                                    'business_name' => 'Nombre',
                                    'phone' => 'Teléfono',
                                    'email' => 'Email',
                                    'iban_para_aeat' => 'IBAN AEAT',
                                    'swift_bic_para_aeat' => 'SWIFT/BIC AEAT',
                                    'inscrito_registro_devolucion_mensual' => 'Inscrito registro devolución mensual',
                                    'tributa_exclusivamente_regimen_simplificado' => 'Tributa exclusivamente régimen simplificado',
                                    'autoliquidacion_conjunta' => 'Autoliquidación conjunta',
                                    'declarado_concurso_acreedores' => 'Declarado concurso acreedores',
                                    'fecha_concurso_acreedores' => 'Fecha concurso acreedores',
                                    'concurso_acreedores_autoliquidacion_preconcursal' => 'Concurso - autoliquidación preconcursal',
                                    'concurso_acreedores_autoliquidacion_postconcursal' => 'Concurso - autoliquidación postconcursal',
                                    'regimen_especial_criterio_caja' => 'Régimen especial criterio caja',
                                    'opcion_criterio_caja' => 'Opción criterio caja',
                                    'destinatario_operaciones_regimen_especial_criterio_caja' => 'Destinatario op. régimen especial criterio caja',
                                    'aplicacion_prorrata_especial' => 'Aplicación prorrata especial',
                                    'revocacion_prorrata_especial' => 'Revocación prorrata especial',
                                    'exonerado_modelo_390' => 'Exonerado modelo 390',
                                    'volumen_operaciones_modelo_390' => 'Volumen operaciones modelo 390',
                                ];
                            @endphp

                            <table class="table table-sm mb-0">
                                <tbody>
                                    @foreach ($fields as $key => $label)
                                        <tr>
                                            <td class="text-muted">{{ $label }}</td>
                                            <td class="text-end fw-semibold">
                                                @if (is_bool($company->$key))
                                                    @if ($company->$key)
                                                        <span class="">Sí</span>
                                                    @else
                                                        <span class="">No</span>
                                                    @endif
                                                @elseif ($key === 'fecha_concurso_acreedores' && $company->$key)
                                                    {{ $company->$key->format('d/m/Y') }}
                                                @elseif ($key === 'volumen_operaciones_modelo_390' && $company->$key !== null)
                                                    {{ number_format($company->$key, 2, ',', '.') }} €
                                                @else
                                                    {{ $company->$key ?? '—' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted mb-0">El usuario no esta asignado a ninguna empresa.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('btn-download-pdf');
            if (!btn) return;

            btn.addEventListener('click', async function () {
                const btnText = document.getElementById('pdf-btn-text');
                const spinner = document.getElementById('pdf-spinner');
                const cardUser = document.getElementById('card-user');
                const cardCompany = document.getElementById('card-company');

                if (!cardUser || !cardCompany) {
                    alert('No se encontraron las tarjetas a capturar.');
                    return;
                }

                // Estado: generando
                btn.disabled = true;
                spinner.classList.remove('d-none');
                btnText.textContent = ' Generando PDF...';

                try {
                    const options = {
                        scale: 2,                  // mejor calidad
                        backgroundColor: '#ffffff',
                        useCORS: true,
                        logging: false
                    };

                    // Captura ambas tarjetas en paralelo
                    const [canvasUser, canvasCompany] = await Promise.all([
                        html2canvas(cardUser, options),
                        html2canvas(cardCompany, options),
                    ]);

                    // Rellena el form oculto con los PNG base64
                    document.getElementById('input-image-user').value = canvasUser.toDataURL('image/png');
                    document.getElementById('input-image-company').value = canvasCompany.toDataURL('image/png');

                    // Envía al backend — descarga automática del PDF
                    document.getElementById('pdf-form').submit();

                    // Restablecer el botón tras un pequeño delay (la descarga ya se disparó)
                    setTimeout(() => {
                        btn.disabled = false;
                        spinner.classList.add('d-none');
                        btnText.textContent = 'Descargar PDF';
                    }, 2000);
                } catch (err) {
                    console.error(err);
                    alert('Error al generar el PDF: ' + err.message);
                    btn.disabled = false;
                    spinner.classList.add('d-none');
                    btnText.textContent = 'Descargar PDF';
                }
            });
        });
    </script>

@endsection

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Datos usuario y empresa</title>
        <style>
            * {
                font-family: DejaVu Sans, sans-serif;
            }

            body {
                margin: 0;
                padding: 20px;
                color: #1f2937;
                font-size: 12px;
            }

            h1.title {
                font-size: 18px;
                margin: 0 0 16px;
            }

            .card {
                border: 0.5px solid #a4a4a4;
                border-radius: 6px;
                margin-bottom: 18px;
                overflow: hidden;
                page-break-inside: avoid;
            }

            .card.company {
                border-color: #a4a4a4;
            }

            .card-header {
                background: #ffffff;
                color: #000;
                padding: 8px 14px;
                font-weight: bold;
                font-size: 13px;
            }

            
            .card-body {
                padding: 12px 14px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td {
                padding: 5px 0;
                border-bottom: 1px solid #f1f1f1;
                font-size: 11px;
            }

            td.label {
                color: #6b7280;
                width: 60%;
            }

            td.value {
                color: #111827;
                font-weight: 600;
                text-align: right;
            }

            tr:last-child td {
                border-bottom: none;
            }
        </style>
    </head>
    <body>
        <h1 class="title">Informe — Usuario y Empresa</h1>
        <div class="card">
            <div class="card-header">Datos del usuario</div>
            <div class="card-body">
                <table>
                    <tr>
                        <td class="label">Nombre</td>
                        <td class="value">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Empresa</td>
                        <td class="value">{{ $company?->business_name ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card company">
            <div class="card-header">Datos de la empresa</div>
            <div class="card-body">
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
                        'destinatario_operaciones_regimen_especial_criterio_caja' => 'Destinatario op. régimen especial criterio
                        caja',
                        'aplicacion_prorrata_especial' => 'Aplicación prorrata especial',
                        'revocacion_prorrata_especial' => 'Revocación prorrata especial',
                        'exonerado_modelo_390' => 'Exonerado modelo 390',
                        'volumen_operaciones_modelo_390' => 'Volumen operaciones modelo 390',
                    ];
                @endphp
                <table>
                    @foreach ($fields as $key => $label)
                    <tr>
                        <td class="label">{{ $label }}</td>
                        <td class="value">
                            @if (is_bool($company->$key))
                            {{ $company->$key ? 'Sí' : 'No' }}
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
                </table>
            </div>
        </div>
    </body>

</html>
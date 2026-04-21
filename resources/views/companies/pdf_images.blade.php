<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Datos usuario y empresa</title>
        <style>
            * { font-family: DejaVu Sans, sans-serif; }
            body { margin: 0; padding: 20px; color: #1f2937; }
            h1 { font-size: 16px; margin: 0 0 14px; }
            h2 { font-size: 12px; margin: 14px 0 6px; color: #555; }
            .section { page-break-inside: avoid; margin-bottom: 16px; }
            img { width: 100%; max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; }
        </style>
    </head>
    <body>
        <h1>Informe — Usuario y Empresa</h1>

        <div class="section">
            <h2>Datos del usuario</h2>
            <img src="{{ $imageUser }}" alt="Datos del usuario">
        </div>

        <div class="section">
            <h2>Datos de la empresa</h2>
            <img src="{{ $imageCompany }}" alt="Datos de la empresa">
        </div>
    </body>
</html>
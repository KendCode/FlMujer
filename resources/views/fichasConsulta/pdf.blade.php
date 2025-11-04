<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ficha de Consulta</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm;
            /* Reducimos margen superior */
        }

        body {
            background-color: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .card {
            border-radius: 1rem;
            background-color: #fff;
            padding: 1rem 2rem;
            /* Reducimos padding superior */
            margin-top: 0;
            /* Eliminamos espacio extra arriba */
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            /* Reducimos margen inferior del encabezado */
        }

        .header img {
            width: 90px;
            /* Tamaño un poco más compacto */
            margin-bottom: 5px;
        }

        .header h2 {
            color: #037E8C;
            margin: 2px 0;
            /* Reducimos espacio */
            font-size: 16px;
        }

        .header p {
            color: #555;
            font-size: 12px;
            margin: 0;
        }

        h3 {
            color: #037E8C;
            border-bottom: 3px solid #7EC544;
            padding-bottom: 5px;
            /* Reducido */
            margin-bottom: 15px;
            /* Reducido */
            font-weight: bold;
            text-align: center;
        }


        .info-label {
            color: #037E8C;
            font-weight: bold;
        }

        .info-value {
            color: #333;
        }

        .section-title {
            color: #13C0E5;
            font-weight: bold;
            border-left: 4px solid #7EC544;
            padding-left: 10px;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .data-item {
            margin-bottom: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-6 {
            width: 50%;
            box-sizing: border-box;
            padding-right: 10px;
        }

        p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- ENCABEZADO -->
        <div class="header">
            <img src="{{ public_path('img/flm_color.png') }}" alt="Logo Fundación Levántate Mujer">
            <h2>Fundación Levántate Mujer</h2>
            <p>Ficha de Consulta Psicológica y Legal</p>
        </div>

        <!-- TÍTULO PRINCIPAL -->
        <h3>Detalle de Ficha de Consulta</h3>

        <!-- DATOS PERSONALES -->
        <div class="section-title">Datos Personales</div>
        <div class="row">
            <div class="col-md-6 data-item">
                <span class="info-label">CI:</span>
                <span class="info-value">{{ $ficha->ci }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $ficha->nombre }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Apellido Paterno:</span>
                <span class="info-value">{{ $ficha->apPaterno }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Apellido Materno:</span>
                <span class="info-value">{{ $ficha->apMaterno }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Número de Celular:</span>
                <span class="info-value">{{ $ficha->numCelular }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Fecha:</span>
                <span class="info-value">{{ $ficha->fecha->format('d/m/Y') }}</span>
            </div>
        </div>

        <!-- INFORMACIÓN DE DERIVACIÓN -->
        <div class="section-title">Información de Derivación</div>
        <div class="data-item">
            <span class="info-label">Institución que Deriva:</span>
            <span class="info-value">{{ $ficha->instDeriva ?? 'No especificado' }}</span>
        </div>
        <div class="data-item">
            <span class="info-label">Testimonio:</span>
            <p class="info-value">{{ $ficha->testimonio ?? 'No registrado' }}</p>
        </div>

        <!-- PROBLEMÁTICAS -->
        <div class="section-title">Problemáticas Identificadas</div>
        <div class="data-item">
            <span class="info-label">Problemática Penal:</span>
            <p class="info-value">
                @if (!empty($ficha->Penal))
                    {{ implode(', ', $ficha->Penal) }}
                @else
                    No especificado
                @endif
            </p>
        </div>
        <div class="data-item">
            <span class="info-label">Problemática Familiar:</span>
            <p class="info-value">
                @if (!empty($ficha->Familiar))
                    {{ implode(', ', $ficha->Familiar) }}
                @else
                    No especificado
                @endif
            </p>
        </div>
        <div class="data-item">
            <span class="info-label">Otros Problemas:</span>
            <p class="info-value">{{ $ficha->OtrosProblemas ?? 'No especificado' }}</p>
        </div>

        <!-- ORIENTACIÓN INTERNA -->
        <div class="section-title">Orientación Interna</div>
        <div class="row">
            <div class="col-md-6 data-item">
                <span class="info-label">Legal:</span>
                <span class="info-value">{{ $ficha->legal ? 'Sí' : 'No' }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Social:</span>
                <span class="info-value">{{ $ficha->social ? 'Sí' : 'No' }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Psicológico:</span>
                <span class="info-value">{{ $ficha->psicologico ? 'Sí' : 'No' }}</span>
            </div>
            <div class="col-md-6 data-item">
                <span class="info-label">Espiritual:</span>
                <span class="info-value">{{ $ficha->espiritual ? 'Sí' : 'No' }}</span>
            </div>
        </div>

        <div class="data-item mt-3">
            <span class="info-label">Institución a Derivar:</span>
            <span class="info-value">{{ $ficha->institucion_a_derivar ?? 'No especificado' }}</span>
        </div>

        <!-- PIE DE PÁGINA -->
        <div class="footer">
            Generado automáticamente por el Sistema Web Fundación Levántate Mujer<br>
            Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>

</html>

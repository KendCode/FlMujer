<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Caso - {{ $caso->nro_registro ?? 'N/A' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 15mm 20mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white;
            margin: 0;
            padding: 20px;
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
        }

        .document-container {
            padding: 0;
            max-width: 100%;
        }

        /* Encabezado con logo */
        .print-header {
            border-bottom: 3px solid #037E8C;
            padding-bottom: 10px;
            margin-bottom: 15px;
            position: relative;
            min-height: 80px;
        }

        .header-logo {
            position: absolute;
            top: 0;
            right: 0;
            max-width: 120px;
            max-height: 80px;
        }

        .header-content {
            padding-right: 140px;
        }

        .print-title {
            font-size: 18pt;
            font-weight: bold;
            color: #037E8C;
            margin: 0;
            text-transform: uppercase;
            padding-top: 10px;
        }

        .print-subtitle {
            font-size: 11pt;
            color: #666;
            margin: 5px 0 0 0;
        }

        /* Secciones */
        .section-card {
            page-break-inside: avoid;
            margin-bottom: 12px;
            border: none;
        }

        .section-card-header {
            background-color: #037E8C;
            color: white;
            padding: 8px 12px;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .section-card-body {
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* Grid de información como tabla */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-item {
            display: table;
            width: 100%;
            border-bottom: 1px solid #eee;
        }

        .info-item.full-width {
            width: 100%;
        }

        .info-label {
            display: table-cell;
            width: 35%;
            padding: 4px 6px;
            font-weight: bold;
            color: #037E8C;
            vertical-align: top;
            font-size: 9pt;
        }

        .info-value {
            display: table-cell;
            width: 65%;
            padding: 4px 6px;
            color: #000;
            vertical-align: top;
            font-size: 9pt;
        }

        .info-value strong {
            font-weight: bold;
            color: #037E8C;
        }

        /* Badges para tipos de violencia */
        .badge-violence {
            display: inline-block;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
        }

        .badge-fisica {
            background-color: #ff6b6b;
        }

        .badge-psicologica {
            background-color: #13C0E5;
        }

        .badge-sexual {
            background-color: #9b59b6;
        }

        /* Lista de hijos */
        .children-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .children-list li {
            padding: 5px 10px;
            background: #f8f9fa;
            margin-bottom: 4px;
            font-size: 9pt;
            border-left: 2px solid #7EC544;
        }

        /* Descripción de hechos */
        .description-box {
            background: #f8f9fa;
            padding: 10px;
            font-size: 9pt;
            border-left: 3px solid #037E8C;
            text-align: justify;
            line-height: 1.5;
        }

        /* Footer del documento */
        .document-footer-info {
            background: #f8f9fa;
            padding: 10px;
            margin-top: 15px;
            border-top: 2px solid #7EC544;
            page-break-inside: avoid;
        }

        /* Sección de firmas */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
            border-top: 2px solid #037E8C;
            padding-top: 20px;
        }

        .signature-title {
            font-size: 12pt;
            font-weight: bold;
            color: #037E8C;
            margin-bottom: 30px;
            text-align: center;
        }

        .signature-grid {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .signature-item {
            display: table-cell;
            width: 50%;
            padding: 20px;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 2px solid #333;
            margin-top: 60px;
            padding-top: 8px;
            font-size: 9pt;
            font-weight: bold;
            color: #333;
        }

        .signature-label {
            font-size: 8pt;
            color: #666;
            margin-top: 4px;
        }

        /* Pie de página fijo */
        .fixed-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            padding: 8px 0;
            border-top: 1px solid #ddd;
            background: white;
        }

        .fixed-footer p {
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <div class="document-container">

        <!-- ENCABEZADO CON LOGO -->
        <div class="print-header">
            <!-- Logo en la esquina superior derecha -->
            <img src="{{ public_path('img/flm_color.png') }}" alt="Logo" class="header-logo">

            <div class="header-content">
                <h1 class="print-title">Ficha de Registro de Caso de Violencia</h1>
                <p class="print-subtitle">Sistema de Atención y Seguimiento</p>
            </div>
        </div>

        <!-- INFORMACIÓN GENERAL -->
        <div class="section-card">
            <div class="section-card-header">
                Información del Registro
            </div>
            <div class="section-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Número de Registro</div>
                        <div class="info-value"><strong>{{ $caso->nro_registro ?? 'N/A' }}</strong></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Fecha de Registro</div>
                        <div class="info-value">
                            {{ $caso->regional_fecha ? \Carbon\Carbon::parse($caso->regional_fecha)->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Regional</div>
                        <div class="info-value">{{ $caso->regional_recibe_caso ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Institución Derivante</div>
                        <div class="info-value">{{ $caso->regional_institucion_derivante ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DATOS DEL PACIENTE -->
        <div class="section-card">
            <div class="section-card-header">
                I. Datos del Paciente/Víctima
            </div>
            <div class="section-card-body">
                <div class="info-grid">
                    <div class="info-item full-width">
                        <div class="info-label">Nombre Completo</div>
                        <div class="info-value"><strong>{{ $caso->paciente_nombres }} {{ $caso->paciente_ap_paterno }}
                                {{ $caso->paciente_ap_materno }}</strong></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CI</div>
                        <div class="info-value">{{ $caso->paciente_ci ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Edad</div>
                        <div class="info-value">{{ $caso->paciente_edad ?? 'N/A' }} años
                            ({{ $caso->paciente_edad_rango ?? 'N/A' }})</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Sexo</div>
                        <div class="info-value">{{ $caso->paciente_sexo == 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estado Civil</div>
                        <div class="info-value">{{ ucfirst($caso->paciente_estado_civil ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">Dirección</div>
                        <div class="info-value">
                            {{ $caso->distrito ? 'Distrito ' . $caso->distrito->numero : 'N/A' }} -
                            {{ $caso->paciente_zona ?? '' }}
                            {{ $caso->paciente_calle ? ', ' . $caso->paciente_calle : '' }}
                            {{ $caso->paciente_numero ? ' Nº ' . $caso->paciente_numero : '' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value">{{ $caso->paciente_telefono ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nivel de Instrucción</div>
                        <div class="info-value">{{ ucfirst($caso->paciente_nivel_instruccion ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ocupación</div>
                        <div class="info-value">{{ ucfirst($caso->paciente_ocupacion ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Situación Laboral</div>
                        <div class="info-value">{{ ucfirst($caso->paciente_situacion_ocupacional ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Idioma Principal</div>
                        <div class="info-value">{{ ucfirst($caso->paciente_idioma_mas_hablado ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Lugar de Nacimiento</div>
                        <div class="info-value">{{ $caso->paciente_lugar_nacimiento ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DATOS DE LA PAREJA/AGRESOR -->
        <div class="section-card">
            <div class="section-card-header">
                II. Datos de la Pareja/Agresor
            </div>
            <div class="section-card-body">
                <div class="info-grid">
                    <div class="info-item full-width">
                        <div class="info-label">Nombre Completo</div>
                        <div class="info-value"><strong>{{ $caso->pareja_nombres }} {{ $caso->pareja_ap_paterno }}
                                {{ $caso->pareja_ap_materno }}</strong></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CI</div>
                        <div class="info-value">{{ $caso->pareja_ci ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Edad</div>
                        <div class="info-value">{{ $caso->pareja_edad ?? 'N/A' }} años
                            ({{ $caso->pareja_edad_rango ?? 'N/A' }})</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Sexo</div>
                        <div class="info-value">{{ $caso->pareja_sexo == 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estado Civil</div>
                        <div class="info-value">{{ ucfirst($caso->pareja_estado_civil ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Relación de Parentesco</div>
                        <div class="info-value">{{ ucfirst($caso->pareja_parentesco ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Años de Convivencia</div>
                        <div class="info-value">{{ str_replace('_', ' ', $caso->pareja_anos_convivencia ?? 'N/A') }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ocupación</div>
                        <div class="info-value">{{ ucfirst($caso->pareja_ocupacion_principal ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nivel de Instrucción</div>
                        <div class="info-value">{{ ucfirst($caso->pareja_nivel_instruccion ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value">{{ $caso->pareja_telefono ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Zona/Barrio</div>
                        <div class="info-value">{{ $caso->pareja_zona ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFORMACIÓN DE HIJOS -->
        <div class="section-card">
            <div class="section-card-header">
                III. Información de Hijos
            </div>
            <div class="section-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Número de Hijos</div>
                        <div class="info-value">{{ str_replace('_', ' ', $caso->hijos_num_gestacion ?? 'N/A') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Dependencia Económica</div>
                        <div class="info-value">{{ str_replace('_', ' ', $caso->hijos_dependencia ?? 'N/A') }}</div>
                    </div>
                </div>

                @if ($caso->hijos_menor4_m || $caso->hijos_menor4_f || $caso->hijos_5a10_m || $caso->hijos_5a10_f)
                    <div style="margin-top: 10px;">
                        <strong style="color: #037E8C; font-size: 9pt;">Distribución por edades:</strong>
                        <ul class="children-list">
                            @if ($caso->hijos_menor4_m || $caso->hijos_menor4_f)
                                <li>Menores de 4 años: {{ $caso->hijos_menor4_m ?? 0 }} varones,
                                    {{ $caso->hijos_menor4_f ?? 0 }} mujeres</li>
                            @endif
                            @if ($caso->hijos_5a10_m || $caso->hijos_5a10_f)
                                <li>De 5 a 10 años: {{ $caso->hijos_5a10_m ?? 0 }} varones,
                                    {{ $caso->hijos_5a10_f ?? 0 }} mujeres</li>
                            @endif
                            @if ($caso->hijos_11a15_m || $caso->hijos_11a15_f)
                                <li>De 11 a 15 años: {{ $caso->hijos_11a15_m ?? 0 }} varones,
                                    {{ $caso->hijos_11a15_f ?? 0 }} mujeres</li>
                            @endif
                            @if ($caso->hijos_16a20_m || $caso->hijos_16a20_f)
                                <li>De 16 a 20 años: {{ $caso->hijos_16a20_m ?? 0 }} varones,
                                    {{ $caso->hijos_16a20_f ?? 0 }} mujeres</li>
                            @endif
                            @if ($caso->hijos_21mas_m || $caso->hijos_21mas_f)
                                <li>De 21 años o más: {{ $caso->hijos_21mas_m ?? 0 }} varones,
                                    {{ $caso->hijos_21mas_f ?? 0 }} mujeres</li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- CARACTERIZACIÓN DE LA VIOLENCIA -->
        <div class="section-card">
            <div class="section-card-header">
                IV. Caracterización de la Violencia
            </div>
            <div class="section-card-body">
                <div class="info-item full-width" style="margin-bottom: 10px;">
                    <div class="info-label">Tipos de Violencia</div>
                    <div class="info-value">
                        @if ($caso->violencia_tipo_fisica)
                            <span class="badge-violence badge-fisica">FÍSICA</span>
                        @endif
                        @if ($caso->violencia_tipo_psicologica)
                            <span class="badge-violence badge-psicologica">PSICOLÓGICA</span>
                        @endif
                        @if ($caso->violencia_tipo_sexual)
                            <span class="badge-violence badge-sexual">SEXUAL</span>
                        @endif
                        @if (!$caso->violencia_tipo_fisica && !$caso->violencia_tipo_psicologica && !$caso->violencia_tipo_sexual)
                            N/A
                        @endif
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Clasificación</div>
                        <div class="info-value">{{ ucfirst(str_replace('_', ' ', $caso->violencia_tipo ?? 'N/A')) }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Frecuencia</div>
                        <div class="info-value">
                            {{ ucfirst(str_replace('_', ' ', $caso->violencia_frecuancia_agresion ?? 'N/A')) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Denuncia Previa</div>
                        <div class="info-value">{{ $caso->violencia_denuncia_previa == 'si' ? 'SÍ' : 'NO' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Motivo Principal</div>
                        <div class="info-value">{{ ucfirst($caso->violencia_motivo_agresion ?? 'N/A') }}</div>
                    </div>
                    @if ($caso->violencia_motivo_otros)
                        <div class="info-item full-width">
                            <div class="info-label">Otros Motivos</div>
                            <div class="info-value">{{ $caso->violencia_motivo_otros }}</div>
                        </div>
                    @endif
                    @if (
                        $caso->violencia_no_denuncia_por_amenaza ||
                            $caso->violencia_no_denuncia_por_temor ||
                            $caso->violencia_no_denuncia_por_verguenza)
                        <div class="info-item full-width">
                            <div class="info-label">Razones de No Denuncia</div>
                            <div class="info-value">
                                @php
                                    $razones = [];
                                    if ($caso->violencia_no_denuncia_por_amenaza) {
                                        $razones[] = 'Amenaza';
                                    }
                                    if ($caso->violencia_no_denuncia_por_temor) {
                                        $razones[] = 'Temor';
                                    }
                                    if ($caso->violencia_no_denuncia_por_verguenza) {
                                        $razones[] = 'Vergüenza';
                                    }
                                    if ($caso->violencia_no_denuncia_por_desconocimiento) {
                                        $razones[] = 'Desconocimiento';
                                    }
                                @endphp
                                {{ implode(', ', $razones) }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- DESCRIPCIÓN DE LOS HECHOS -->
        @if ($caso->violencia_descripcion_hechos)
            <div class="section-card">
                <div class="section-card-header">
                    V. Descripción de la Problemática
                </div>
                <div class="section-card-body">
                    <div class="description-box">
                        {{ $caso->violencia_descripcion_hechos }}
                    </div>
                </div>
            </div>
        @endif

        <!-- PLAN DE ATENCIÓN -->
        <div class="section-card">
            <div class="section-card-header">
                VI. Plan de Atención
            </div>
            <div class="section-card-body">
                <div class="info-grid">
                    <div class="info-item full-width">
                        <div class="info-label">Tipo de Atención Demandada</div>
                        <div class="info-value">
                            @php
                                $atencion_map = [
                                    'victima' => 'Apoyo a Víctima',
                                    'pareja' => 'Apoyo a Pareja',
                                    'agresor' => 'Apoyo a Agresor',
                                    'hijos' => 'Apoyo a Hijos',
                                ];
                            @endphp
                            <strong>{{ $atencion_map[$caso->tipo_atencion] ?? ucfirst($caso->tipo_atencion ?? 'N/A') }}</strong>
                        </div>
                    </div>
                    @if ($caso->violencia_medidas_tomar)
                        <div class="info-item full-width">
                            <div class="info-label">Medidas a Tomar</div>
                            <div class="info-value">{{ $caso->violencia_medidas_tomar }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- INFORMACIÓN DEL RESPONSABLE -->
        <div class="document-footer-info">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Responsable del Registro</div>
                    <div class="info-value"><strong>{{ $caso->formulario_responsable_nombre ?? 'N/A' }}</strong></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Fecha de Generación</div>
                    <div class="info-value">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE FIRMAS -->
        <div class="signature-section" style="margin-top: 40px;">
            <div class="signature-grid">
                <div class="signature-item" style="text-align: center;">
                    <div class="signature-title" style="font-weight: bold; margin-bottom: 10px;">FIRMA</div>

                    <!-- Línea un poco más larga que el nombre -->
                    <div class="signature-line"
                        style="display: inline-block; border-bottom: 1px solid #000; padding: 0 5px; min-width: 180px; text-align: center;">
                        {{ $caso->formulario_responsable_nombre ?? '______________' }}
                    </div>
                    <div class="signature-label" style="font-size: 12px; color: #555; margin-top: 5px;">
                        Responsable del Caso<br>
                        Nombre y Firma
                    </div>

                </div>
            </div>
        </div>



    </div>

    <!-- Pie de página fijo -->
    <div class="fixed-footer">
        <p>Documento Confidencial - Sistema de Atención a Casos de Violencia</p>
        <p style="font-size: 7pt;">Registro Nº {{ $caso->nro_registro ?? 'N/A' }} | Generado el
            {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

</body>

</html>

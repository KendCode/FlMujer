@extends('layouts.sidebar')

@section('content')
    <style>
        /* ===== ESTILOS PARA PANTALLA ===== */
        body {
            background: linear-gradient(135deg, #F4F4F2 0%, #e8e8e6 100%);
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Contenedor principal con diseño moderno */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 25px;
        }

        /* Header mejorado */
        .page-header {
            background: linear-gradient(135deg, #037E8C 0%, #13C0E5 100%);
            border-radius: 15px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 8px 20px rgba(3, 126, 140, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h2 {
            color: white;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-header .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 5px;
        }

        /* Botones mejorados */
        .btn-custom {
            background: linear-gradient(135deg, #7EC544 0%, #6ab038 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(126, 197, 68, 0.3);
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #6ab038 0%, #5a9830 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(126, 197, 68, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
        }

        .btn-secondary-custom:hover {
            background: linear-gradient(135deg, #5a6268 0%, #4a5258 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(108, 117, 125, 0.3);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* Contenedor del documento con diseño premium */
        .document-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 210mm;
            margin: 0 auto;
        }

        /* Secciones con diseño card moderno */
        .section-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(3, 126, 140, 0.1);
            transform: translateY(-2px);
        }

        .section-card-header {
            background: linear-gradient(135deg, #037E8C 0%, #13C0E5 100%);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-card-header i {
            font-size: 20px;
        }

        .section-card-body {
            padding: 20px;
        }

        /* Tabla de información mejorada */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
        }

        .info-label {
            color: #037E8C;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #333;
            font-size: 15px;
            padding: 10px;
            background: #F4F4F2;
            border-radius: 8px;
            border-left: 3px solid #7EC544;
        }

        .info-value strong {
            color: #037E8C;
        }

        /* Badge para tipos de violencia */
        .badge-violence {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .badge-fisica {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .badge-psicologica {
            background: linear-gradient(135deg, #13C0E5 0%, #037E8C 100%);
            color: white;
        }

        .badge-sexual {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            color: white;
        }

        /* Lista mejorada */
        .children-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .children-list li {
            padding: 10px 15px;
            background: #F4F4F2;
            border-radius: 8px;
            margin-bottom: 8px;
            border-left: 3px solid #7EC544;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .children-list li i {
            color: #7EC544;
        }

        /* Descripción de hechos */
        .description-box {
            background: #F4F4F2;
            border-radius: 12px;
            padding: 20px;
            border-left: 5px solid #037E8C;
            font-size: 15px;
            line-height: 1.7;
            text-align: justify;
        }

        /* Footer del documento */
        .document-footer-info {
            background: linear-gradient(135deg, #F4F4F2 0%, #e8e8e6 100%);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            border-top: 3px solid #7EC544;
        }

        /* ===== ESTILOS PARA IMPRESIÓN/PDF ===== */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;

            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                background: white;
                margin: 0;
                padding: 0;
                font-family: 'Arial', sans-serif;
                font-size: 10pt;
                line-height: 1.3;
            }

            /* Ocultar elementos no imprimibles */
            .no-print,
            .page-header,
            .action-buttons,
            .sidebar,
            nav,
            .navbar,
            .hamburger-menu,
            #sidebar,
            .menu-toggle,
            button[data-bs-toggle],
            .offcanvas,
            .btn,
            [class*="sidebar"],
            [class*="hamburger"] {
                display: none !important;
            }

            .main-container {
                max-width: 100%;
                padding: 0;
                margin: 0;
            }

            .document-container {
                padding: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }

            /* Encabezado del documento */
            .print-header {
                border-bottom: 3px solid #037E8C;
                padding-bottom: 10px;
                margin-bottom: 15px;
                text-align: center;
            }

            .print-title {
                font-size: 18pt;
                font-weight: bold;
                color: #037E8C;
                margin: 0;
                text-transform: uppercase;
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
                box-shadow: none;
            }

            .section-card-header {
                background-color: #037E8C !important;
                color: white !important;
                padding: 8px 12px;
                font-size: 11pt;
                border-radius: 0;
            }

            .section-card-body {
                padding: 10px;
                border: 1px solid #ddd;
            }

            /* Grid de información */
            .info-grid {
                display: table;
                width: 100%;
                border-collapse: collapse;
            }

            .info-item {
                display: table-row;
            }

            .info-item.full-width {
                display: table-row;
            }

            .info-label,
            .info-value {
                display: table-cell;
                padding: 4px 6px;
                border-bottom: 1px solid #eee;
                font-size: 9pt;
            }

            .info-label {
                width: 35%;
                font-weight: bold;
                color: #037E8C;
                background: transparent;
            }

            .info-value {
                width: 65%;
                color: #000;
                background: transparent;
                border-left: none;
                border-radius: 0;
            }

            /* Badges */
            .badge-violence {
                padding: 3px 8px;
                margin: 2px;
                border-radius: 10px;
                font-size: 8pt;
            }

            .badge-fisica {
                background-color: #ff6b6b !important;
            }

            .badge-psicologica {
                background-color: #13C0E5 !important;
            }

            .badge-sexual {
                background-color: #9b59b6 !important;
            }

            /* Lista de hijos */
            .children-list li {
                padding: 5px 10px;
                background: #f8f9fa;
                margin-bottom: 4px;
                font-size: 9pt;
                border-left: 2px solid #7EC544;
            }

            /* Descripción */
            .description-box {
                background: #f8f9fa;
                padding: 10px;
                font-size: 9pt;
                border-left: 3px solid #037E8C;
            }

            /* Footer */
            .document-footer-info {
                background: #f8f9fa;
                padding: 10px;
                margin-top: 15px;
                border-top: 2px solid #7EC544;
                page-break-inside: avoid;
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
        }
    </style>

    <!-- Header de la página (solo visible en pantalla) -->
    <div class="main-container">
        <div class="page-header no-print">
            <div>
                <h2><i class="fas fa-file-alt"></i> Detalle del Caso de Violencia</h2>
                <div class="subtitle">Registro Nº {{ $caso->nro_registro ?? 'N/A' }}</div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('casos.index') }}" class="btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('caso.pdf', $caso->id) }}" class="btn-custom"
                    style="background: linear-gradient(135deg, #037E8C 0%, #13C0E5 100%);
          box-shadow: 0 4px 12px rgba(3, 126, 140, 0.3);
          color: white;
          text-decoration: none;
          padding: 8px 14px;
          border-radius: 8px;
          display: inline-block;">
                    <i class="fas fa-download"></i> Descargar PDF
                </a>

                <button onclick="window.print()" class="btn-custom">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>

        <!-- Contenedor del documento -->
        <div class="document-container">

            <!-- ENCABEZADO PARA IMPRESIÓN -->
            <div class="print-header" style="display: none;">
                <h1 class="print-title">Ficha de Registro de Caso de Violencia</h1>
                <p class="print-subtitle">Sistema de Atención y Seguimiento</p>
            </div>

            <!-- INFORMACIÓN GENERAL -->
            <div class="section-card">
                <div class="section-card-header">
                    <i class="fas fa-info-circle"></i>
                    <span>Información del Registro</span>
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
                    <i class="fas fa-user"></i>
                    <span>I. Datos del Paciente/Víctima</span>
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
                    <i class="fas fa-user-shield"></i>
                    <span>II. Datos de la Pareja/Agresor</span>
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
                    <i class="fas fa-children"></i>
                    <span>III. Información de Hijos</span>
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
                        <div style="margin-top: 15px;">
                            <div class="info-label" style="margin-bottom: 10px;">Distribución por edades</div>
                            <ul class="children-list">
                                @if ($caso->hijos_menor4_m || $caso->hijos_menor4_f)
                                    <li><i class="fas fa-baby"></i> Menores de 4 años: {{ $caso->hijos_menor4_m ?? 0 }}
                                        varones, {{ $caso->hijos_menor4_f ?? 0 }} mujeres</li>
                                @endif
                                @if ($caso->hijos_5a10_m || $caso->hijos_5a10_f)
                                    <li><i class="fas fa-child"></i> De 5 a 10 años: {{ $caso->hijos_5a10_m ?? 0 }}
                                        varones, {{ $caso->hijos_5a10_f ?? 0 }} mujeres</li>
                                @endif
                                @if ($caso->hijos_11a15_m || $caso->hijos_11a15_f)
                                    <li><i class="fas fa-user-graduate"></i> De 11 a 15 años:
                                        {{ $caso->hijos_11a15_m ?? 0 }} varones, {{ $caso->hijos_11a15_f ?? 0 }} mujeres
                                    </li>
                                @endif
                                @if ($caso->hijos_16a20_m || $caso->hijos_16a20_f)
                                    <li><i class="fas fa-user"></i> De 16 a 20 años: {{ $caso->hijos_16a20_m ?? 0 }}
                                        varones, {{ $caso->hijos_16a20_f ?? 0 }} mujeres</li>
                                @endif
                                @if ($caso->hijos_21mas_m || $caso->hijos_21mas_f)
                                    <li><i class="fas fa-user-tie"></i> De 21 años o más: {{ $caso->hijos_21mas_m ?? 0 }}
                                        varones, {{ $caso->hijos_21mas_f ?? 0 }} mujeres</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CARACTERIZACIÓN DE LA VIOLENCIA -->
            <div class="section-card">
                <div class="section-card-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>IV. Caracterización de la Violencia</span>
                </div>
                <div class="section-card-body">
                    <div class="info-item full-width" style="margin-bottom: 15px;">
                        <div class="info-label">Tipos de Violencia</div>
                        <div style="margin-top: 10px;">
                            @if ($caso->violencia_tipo_fisica)
                                <span class="badge-violence badge-fisica"><i class="fas fa-hand-rock"></i> FÍSICA</span>
                            @endif
                            @if ($caso->violencia_tipo_psicologica)
                                <span class="badge-violence badge-psicologica"><i class="fas fa-brain"></i>
                                    PSICOLÓGICA</span>
                            @endif
                            @if ($caso->violencia_tipo_sexual)
                                <span class="badge-violence badge-sexual"><i class="fas fa-user-slash"></i> SEXUAL</span>
                            @endif
                            @if (!$caso->violencia_tipo_fisica && !$caso->violencia_tipo_psicologica && !$caso->violencia_tipo_sexual)
                                <span style="color: #999;">N/A</span>
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
                        <i class="fas fa-file-alt"></i>
                        <span>V. Descripción de la Problemática</span>
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
                    <i class="fas fa-clipboard-list"></i>
                    <span>VI. Plan de Atención</span>
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
                        <div class="info-label">Fecha de Impresión</div>
                        <div class="info-value">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Pie de página fijo para impresión -->
    <div class="fixed-footer" style="display: none;">
        <p style="margin: 0;">Documento Confidencial - Sistema de Atención a Casos de Violencia</p>
        <p style="margin: 0; font-size: 7pt;">Registro Nº {{ $caso->nro_registro ?? 'N/A' }} | Generado el
            {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>

    <!-- Script para impresión y descarga -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Función para descargar directamente como PDF
        function downloadPDF() {
            // Selecciona el contenedor que quieres exportar (ajústalo si tu clase es distinta)
            const element = document.querySelector('.document-container');
            const header = document.querySelector('.print-header');
            const footer = document.querySelector('.fixed-footer');

            // Mostrar elementos de impresión si están ocultos
            if (header) header.style.display = 'block';
            if (footer) footer.style.display = 'block';

            // Opciones para html2pdf
            const opt = {
                margin: [8, 8, 8, 8], // márgenes (mm)
                filename: 'Ficha_Caso_{{ $caso->nro_registro ?? 'documento' }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    logging: false
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                },
                pagebreak: {
                    mode: ['css', 'legacy', 'avoid-all']
                }
            };

            // Generar y descargar el PDF
            html2pdf().set(opt).from(element).save().then(() => {
                // Ocultar encabezado y pie nuevamente si estaban ocultos
                if (header) header.style.display = 'none';
                if (footer) footer.style.display = 'none';
            });
        }


        // Evento antes de imprimir
        window.addEventListener('beforeprint', function() {
            document.title = 'Caso_{{ $caso->nro_registro }}_{{ \Carbon\Carbon::now()->format('Ymd') }}';
            document.querySelector('.print-header').style.display = 'block';
            document.querySelector('.fixed-footer').style.display = 'block';
        });

        // Evento después de imprimir
        window.addEventListener('afterprint', function() {
            document.title = 'Detalle del Caso';
            document.querySelector('.print-header').style.display = 'none';
            document.querySelector('.fixed-footer').style.display = 'none';
        });
    </script>

    <!-- Estilos adicionales para ocultar menú hamburguesa en impresión -->
    <style>
      
        @media print {
            body {
                background: rgb(255, 255, 255);
                margin: 0;
                padding: 0;
            }

            .document-container {
                page-break-inside: avoid;
            }

            .print-header,
            .fixed-footer {
                display: block !important;
            }
        }

        /* Para PDF */
        .pdf-export {
            transform: scale(0.9);
            transform-origin: top left;
            width: 1280px;
        }
    </style>
@endsection

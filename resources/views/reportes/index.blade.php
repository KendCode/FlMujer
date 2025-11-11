@extends('layouts.sidebar')
@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
        }

        .reportes-header {
            background: linear-gradient(135deg, #7EC544 0%, #13C0E5 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: #037E8C;
            margin-bottom: 20px;
            border-bottom: 3px solid #7EC544;
            padding-bottom: 10px;
        }

        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #037E8C;
        }

        .stats-label {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .export-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .btn-export {
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-export:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-export:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-pdf {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .btn-excel {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .btn-word {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            min-width: 300px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #7EC544;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .format-info {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #27ae60;
        }

        .format-info h4 {
            color: #037E8C;
            margin-bottom: 10px;
        }

        .format-info ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .format-info li {
            margin: 5px 0;
            color: #666;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="reportes-header">
            <h1>📊 Reportes de Casos</h1>
            <p class="lead">Análisis estadístico de los últimos {{ $periodo }} meses</p>
        </div>

        <!-- Estadísticas generales -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $sexo->sum() }}</div>
                    <div class="stats-label">Casos Registrados</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $periodo }}</div>
                    <div class="stats-label">Meses Analizados</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $edad->sum() }}</div>
                    <div class="stats-label">Grupos de Edad</div>
                </div>
            </div>
        </div>

        <!-- Información de formatos -->
        <div class="format-info">
            <h4>💡 ¿Qué formato elegir?</h4>
            <div class="row">
                <div class="col-md-4">
                    <strong>📄 PDF:</strong>
                    <ul>
                        <li>Reportes oficiales</li>
                        <li>Gráficos de alta calidad</li>
                        <li>No editable</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <strong>📊 Excel:</strong>
                    <ul>
                        <li>Análisis de datos</li>
                        <li>Gráficos editables</li>
                        <li>Manipular números</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <strong>📝 Word:</strong>
                    <ul>
                        <li>Informes editables</li>
                        <li>Agregar comentarios</li>
                        <li>Formato flexible</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Botones de exportación -->
        <div class="export-buttons">
            <button type="button" onclick="exportarReporte('pdf')" class="btn-export btn-pdf" id="btnPDF">
                <i class="fas fa-file-pdf fa-2x"></i>
                <span>Exportar a PDF</span>
            </button>
            <button type="button" onclick="exportarReporte('excel')" class="btn-export btn-excel" id="btnExcel">
                <i class="fas fa-file-excel fa-2x"></i>
                <span>Exportar a Excel</span>
            </button>
            <button type="button" onclick="exportarReporte('word')" class="btn-export btn-word" id="btnWord">
                <i class="fas fa-file-word fa-2x"></i>
                <span>Exportar a Word</span>
            </button>
        </div>

        <h3 class="text-center mb-4" style="color: #037E8C;">📈 Visualización de Datos</h3>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Sexo</div>
                    <canvas id="graficoSexo" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Edad</div>
                    <canvas id="graficoEdad" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Violencia</div>
                    <canvas id="graficoViolencia" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Atención</div>
                    <canvas id="graficoAtencion" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Gráfico por Mes</div>
                    <canvas id="graficoMes" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Regional</div>
                    <canvas id="graficoRegional" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Estado Civil</div>
                    <canvas id="graficoEstadoCivil" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Nivel de Instrucción</div>
                    <canvas id="graficoNivelInstruccion" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Ocupación</div>
                    <canvas id="graficoOcupacion" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Casos por Idioma</div>
                    <canvas id="graficoIdioma" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Frecuencia de Violencia</div>
                    <canvas id="graficoFrecuenciaViolencia" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Lugar de los Hechos</div>
                    <canvas id="graficoLugarHechos" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Denuncias Previas</div>
                    <canvas id="graficoDenunciasPrevias" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Motivos de Agresión</div>
                    <canvas id="graficoMotivoAgresion" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Razones para No Denunciar</div>
                    <canvas id="graficoRazonesNoDenuncia" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Instituciones Derivantes</div>
                    <canvas id="graficoInstituciones" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Hijos</div>
                    <canvas id="graficoHijos" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Tipo de Violencia Intrafamiliar</div>
                    <canvas id="graficoTipoViolenciaIntrafamiliar" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Edad Pareja vs Víctima</div>
                    <canvas id="graficoEdadParejaVsVictima" width="400" height="300"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Atención Demandada</div>
                    <canvas id="graficoAtencionDemandada" width="400" height="300"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <h4 style="color: #037E8C;" id="loadingTitle">Generando reporte...</h4>
            <p id="loadingText">Por favor espere, esto puede tomar unos segundos</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sexo = @json($sexo);
        const edad = @json($edad);
        const violencia = @json($tiposViolencia);
        const atencion = @json($atencion);
        const porMes = @json($porMes);
        const regional = @json($regional);
        const estadoCivil = @json($estadoCivil);
        const nivelInstruccion = @json($nivelInstruccion);
        const ocupacion = @json($ocupacion);
        const idioma = @json($idioma);
        const frecuenciaViolencia = @json($frecuenciaViolencia);
        const lugarHechos = @json($lugarHechos);
        const denunciasPrevias = @json($denunciasPrevia);
        const motivoAgresion = @json($motivoAgresion);
        const razonesNoDenuncia = @json($razonesNoDenuncia);
        const instituciones = @json($instituciones);
        const hijos = @json($hijos);
        const tipoViolenciaIntrafamiliar = @json($tipoViolenciaIntrafamiliar);
        const edadParejaVsVictima = @json($edadParejaVsVictima);
        const atencionDemandada = @json($atencionDemandada);


        // Configuración común para todos los gráficos
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                duration: 1000
            }
        };

        // Crear gráficos
        const charts = {

            graficoSexo: new Chart(document.getElementById('graficoSexo'), {
                type: 'pie',
                data: {
                    labels: Object.keys(sexo),
                    datasets: [{
                        data: Object.values(sexo),
                        backgroundColor: ['#ff6384', '#36a2eb'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14
                                },
                                padding: 15
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribución por Sexo',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            }),
            graficoEdad: new Chart(document.getElementById('graficoEdad'), {
                type: 'bar',
                data: {
                    labels: Object.keys(edad),
                    datasets: [{
                        label: 'Casos',
                        data: Object.values(edad),
                        backgroundColor: '#4bc0c0',
                        borderColor: '#36a2a2',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Casos por Rango de Edad',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),
            graficoViolencia: new Chart(document.getElementById('graficoViolencia'), {
                type: 'bar',
                data: {
                    labels: Object.keys(violencia),
                    datasets: [{
                        label: 'Casos',
                        data: Object.values(violencia),
                        backgroundColor: ['#f87171', '#facc15', '#34d399', '#60a5fa', '#a78bfa'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Tipos de Violencia',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),
            graficoAtencion: new Chart(document.getElementById('graficoAtencion'), {
                type: 'bar',
                data: {
                    labels: Object.keys(atencion),
                    datasets: [{
                        label: 'Casos',
                        data: Object.values(atencion),
                        backgroundColor: '#fb923c',
                        borderColor: '#ea580c',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Tipos de Atención',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),
            graficoMes: new Chart(document.getElementById('graficoMes'), {
                type: 'line',
                data: {
                    labels: Object.keys(porMes),
                    datasets: [{
                        label: 'Casos por mes',
                        data: Object.values(porMes),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: '#10b981'
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Evolución Mensual',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),

            // Agregar aquí los demás gráficos siguiendo el mismo patrón
            graficoRegional: new Chart(document.getElementById('graficoRegional'), {
                type: 'bar',
                data: {
                    labels: Object.keys(regional),
                    datasets: [{
                        label: 'Casos',
                        data: Object.values(regional),
                        backgroundColor: '#34d399',
                        borderColor: '#059669',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Casos por Regional',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),
            graficoEstadoCivil: new Chart(document.getElementById('graficoEstadoCivil'), {
                type: 'bar',
                data: {
                    labels: Object.keys(estadoCivil),
                    datasets: [{
                        label: 'Casos',
                        data: Object.values(estadoCivil),
                        backgroundColor: '#fbbf24',
                        borderColor: '#b45309',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Casos por Estado Civil',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }),




        };

        // Función principal de exportación
        async function exportarReporte(formato) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            const loadingTitle = document.getElementById('loadingTitle');
            const loadingText = document.getElementById('loadingText');

            // Deshabilitar botones
            document.querySelectorAll('.btn-export').forEach(btn => btn.disabled = true);

            // Configurar mensajes según formato
            const mensajes = {
                pdf: {
                    titulo: 'Generando PDF...',
                    texto: 'Capturando gráficos y creando documento',
                    ruta: '{{ route('reportes.exportar.pdf') }}',
                    extension: 'pdf',
                    icono: '📄'
                },
                excel: {
                    titulo: 'Generando Excel...',
                    texto: 'Creando hojas de cálculo y gráficos',
                    ruta: '{{ route('reportes.exportar.excel') }}',
                    extension: 'xlsx',
                    icono: '📊'
                },
                word: {
                    titulo: 'Generando Word...',
                    texto: 'Creando documento con tablas e imágenes',
                    ruta: '{{ route('reportes.exportar.word') }}',
                    extension: 'docx',
                    icono: '📝'
                }
            };

            const config = mensajes[formato];
            loadingTitle.textContent = config.titulo;
            loadingText.textContent = config.texto;
            loadingOverlay.style.display = 'flex';

            try {
                console.log(`🔄 Iniciando exportación ${formato.toUpperCase()}...`);

                // Esperar renderizado completo
                await new Promise(resolve => setTimeout(resolve, 500));

                // Capturar gráficos en base64
                const graficosBase64 = {};
                for (const [key, chart] of Object.entries(charts)) {
                    try {
                        const base64Image = chart.toBase64Image('image/png', 1.0);
                        graficosBase64[key] = base64Image;
                        console.log(`✅ ${key} capturado`);
                    } catch (chartError) {
                        console.error(`❌ Error en ${key}:`, chartError);
                    }
                }

                console.log(`📊 ${Object.keys(graficosBase64).length} gráficos capturados`);

                // Preparar datos
                const formData = new FormData();
                formData.append('periodo', {{ $periodo }});
                formData.append('graficos', JSON.stringify(graficosBase64));

                console.log(`📤 Enviando a ${config.ruta}...`);

                // Realizar petición
                const response = await fetch(config.ruta, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                console.log(`📥 Respuesta: ${response.status}`);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ Error servidor:', errorText);
                    throw new Error(`Error ${response.status}: No se pudo generar el archivo`);
                }

                // Descargar archivo
                const blob = await response.blob();
                console.log(`💾 Archivo recibido: ${blob.size} bytes`);

                const downloadUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = downloadUrl;
                a.download =
                    `reporte_violencia_{{ $periodo }}meses_${new Date().toISOString().split('T')[0]}.${config.extension}`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(downloadUrl);

                console.log('✅ Descarga completada');
                alert(`${config.icono} Reporte ${formato.toUpperCase()} generado exitosamente`);

            } catch (error) {
                console.error('❌ Error:', error);
                alert(
                    `❌ Error al generar el reporte ${formato.toUpperCase()}:\n${error.message}\n\nRevisa la consola (F12) para más detalles.`
                );
            } finally {
                loadingOverlay.style.display = 'none';
                // Rehabilitar botones
                document.querySelectorAll('.btn-export').forEach(btn => btn.disabled = false);
            }
        }

        // Verificar carga
        window.addEventListener('load', () => {
            console.log('✅ Sistema de reportes cargado');
            console.log('📊 Gráficos disponibles:', Object.keys(charts));
        });
    </script>
@endsection

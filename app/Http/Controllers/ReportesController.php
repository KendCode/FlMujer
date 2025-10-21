<?php

namespace App\Http\Controllers;

use App\Models\Caso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->get('periodo', 3);
        $fechaInicio = now()->subMonths($periodo);

        $sexo = Caso::where('created_at', '>=', $fechaInicio)
            ->selectRaw('paciente_sexo, COUNT(*) as total')
            ->groupBy('paciente_sexo')
            ->pluck('total', 'paciente_sexo');

        $edad = Caso::where('created_at', '>=', $fechaInicio)
            ->selectRaw('paciente_edad_rango, COUNT(*) as total')
            ->groupBy('paciente_edad_rango')
            ->pluck('total', 'paciente_edad_rango');

        $tiposViolencia = [
            'Física' => Caso::where('violencia_tipo_fisica', true)->where('created_at', '>=', $fechaInicio)->count(),
            'Psicológica' => Caso::where('violencia_tipo_psicologica', true)->where('created_at', '>=', $fechaInicio)->count(),
            'Sexual' => Caso::where('violencia_tipo_sexual', true)->where('created_at', '>=', $fechaInicio)->count(),
            'Patrimonial' => Caso::where('violencia_tipo_patrimonial', true)->where('created_at', '>=', $fechaInicio)->count(),
            'Económica' => Caso::where('violencia_tipo_economica', true)->where('created_at', '>=', $fechaInicio)->count(),
        ];

        $atencion = Caso::where('created_at', '>=', $fechaInicio)
            ->selectRaw('tipo_atencion, COUNT(*) as total')
            ->groupBy('tipo_atencion')
            ->pluck('total', 'tipo_atencion');

        $porMes = Caso::where('created_at', '>=', $fechaInicio)
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->mapWithKeys(fn($item) => [Carbon::create()->month($item->mes)->locale('es')->monthName => $item->total]);

        return view('reportes.index', [
            'periodo' => $periodo,
            'sexo' => $sexo,
            'edad' => $edad,
            'tiposViolencia' => $tiposViolencia,
            'atencion' => $atencion,
            'porMes' => $porMes,
        ]);
    }

    // =============== GUARDAR GRÁFICOS TEMPORALMENTE ===============
    private function guardarGraficos($graficos)
    {
        $graficosRutas = [];

        // Crear directorio si no existe
        $directorioGraficos = storage_path('app/public/graficos');
        if (!file_exists($directorioGraficos)) {
            mkdir($directorioGraficos, 0755, true);
        }

        foreach ($graficos as $key => $base64) {
            try {
                if (empty($base64)) {
                    Log::warning("⚠️ Gráfico vacío: {$key}");
                    continue;
                }

                // Limpiar el base64
                $base64Clean = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
                $imageData = base64_decode($base64Clean);

                if ($imageData === false || strlen($imageData) < 100) {
                    Log::warning("⚠️ No se pudo decodificar: {$key}");
                    continue;
                }

                $fileName = "{$key}_" . time() . "_" . rand(1000, 9999) . ".png";
                $rutaCompleta = $directorioGraficos . '/' . $fileName;

                file_put_contents($rutaCompleta, $imageData);

                if (file_exists($rutaCompleta) && filesize($rutaCompleta) > 0) {
                    $graficosRutas[$key] = $rutaCompleta;
                    Log::info("✅ Gráfico guardado: {$key} ({$rutaCompleta}) - " . filesize($rutaCompleta) . " bytes");
                } else {
                    Log::error("❌ No se pudo guardar: {$key}");
                }
            } catch (\Exception $e) {
                Log::error("❌ Error guardando {$key}: " . $e->getMessage());
            }
        }

        return $graficosRutas;
    }

    // =============== EXPORTAR A PDF ===============
    public function exportarPDF(Request $request)
    {
        try {
            Log::info('🔵 ========== INICIANDO EXPORTACIÓN PDF ==========');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            // Recibir gráficos en base64
            $graficos = json_decode($request->input('graficos', '{}'), true);
            Log::info('📊 Gráficos recibidos: ' . count($graficos));

            // Guardar gráficos temporalmente y obtener rutas
            $graficosRutas = $this->guardarGraficos($graficos);
            Log::info('💾 Gráficos guardados temporalmente: ' . count($graficosRutas));

            // Preparar datos del reporte
            $datosReporte = [
                'periodo' => $periodo,
                'fecha_inicio' => $fechaInicio->format('d/m/Y'),
                'fecha_fin' => Carbon::now()->format('d/m/Y'),
                'total_casos' => Caso::where('created_at', '>=', $fechaInicio)->count(),
                'violencia' => $this->getCasosPorTipoViolencia($fechaInicio),
                'meses' => $this->getCasosPorMes($fechaInicio),
                'sexo' => $this->getCasosPorSexo($fechaInicio),
                'edad' => $this->getCasosPorEdad($fechaInicio),
                'atencion' => $this->getCasosPorTipoAtencion($fechaInicio),
            ];

            Log::info('📄 Generando PDF con DomPDF...');

            // Generar PDF pasando las rutas de los gráficos
            $pdf = Pdf::loadView('reportes.pdf', [
                'datosReporte' => $datosReporte,
                'graficosRutas' => $graficosRutas
            ])->setPaper('letter', 'portrait');

            $nombreArchivo = "reporte_violencia_{$periodo}meses_" . date('Y-m-d') . ".pdf";

            // Descargar PDF y eliminar imágenes temporales
            $response = $pdf->download($nombreArchivo);
            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) unlink($ruta);
            }

            Log::info('✅ PDF generado y temporales eliminados');

            return $response;
        } catch (\Exception $e) {
            Log::error('❌ ERROR EN EXPORTAR PDF: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al generar el PDF',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }



    // =============== EXPORTAR A WORD ===============
    public function exportarWord(Request $request)
    {
        try {
            Log::info('🔵 ========== INICIANDO EXPORTACIÓN WORD ==========');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            // Recibir gráficos
            $graficos = json_decode($request->input('graficos', '{}'), true);
            Log::info('📊 Gráficos recibidos para Word: ' . count($graficos));

            // Guardar gráficos
            $graficosRutas = $this->guardarGraficos($graficos);
            Log::info('💾 Gráficos guardados para Word: ' . count($graficosRutas));

            $phpWord = new PhpWord();
            $section = $phpWord->addSection([
                'marginLeft' => 1000,
                'marginRight' => 1000,
                'marginTop' => 1000,
                'marginBottom' => 1000
            ]);

            // Estilos
            $phpWord->addFontStyle('titulo', ['bold' => true, 'size' => 18, 'color' => '037E8C']);
            $phpWord->addFontStyle('subtitulo', ['bold' => true, 'size' => 14, 'color' => '7EC544']);
            $phpWord->addFontStyle('normal', ['size' => 11]);

            // Encabezado
            $section->addText(
                '📊 REPORTE DE CASOS DE VIOLENCIA',
                'titulo',
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 200]
            );

            $section->addText(
                'Fundación Levántate Mujer',
                'subtitulo',
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100]
            );

            $section->addText(
                "Período: Últimos {$periodo} meses ({$fechaInicio->format('d/m/Y')} - " . Carbon::now()->format('d/m/Y') . ")",
                'normal',
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 400]
            );

            // Resumen
            $totalCasos = Caso::where('created_at', '>=', $fechaInicio)->count();
            $section->addText('RESUMEN EJECUTIVO', 'subtitulo', ['spaceAfter' => 200]);
            $section->addText("Total de casos registrados: {$totalCasos}", 'normal', ['spaceAfter' => 300]);

            // Secciones de datos
            $this->agregarSeccionWord($section, 'CASOS POR TIPO DE VIOLENCIA', $this->getCasosPorTipoViolencia($fechaInicio));
            $this->agregarSeccionWord($section, 'EVOLUCIÓN DE CASOS POR MES', $this->getCasosPorMes($fechaInicio));
            $this->agregarSeccionWord($section, 'CASOS POR RANGO DE EDAD', $this->getCasosPorEdad($fechaInicio));
            $this->agregarSeccionWord($section, 'CASOS POR SEXO', $this->getCasosPorSexo($fechaInicio));
            $this->agregarSeccionWord($section, 'CASOS POR TIPO DE ATENCIÓN', $this->getCasosPorTipoAtencion($fechaInicio));

            // AGREGAR GRÁFICOS
            if (count($graficosRutas) > 0) {
                $section->addPageBreak();
                $section->addText('GRÁFICOS ESTADÍSTICOS', 'subtitulo', ['spaceAfter' => 400]);

                $titulos = [
                    'graficoSexo' => 'Distribución por Sexo',
                    'graficoEdad' => 'Casos por Rango de Edad',
                    'graficoViolencia' => 'Tipos de Violencia',
                    'graficoAtencion' => 'Tipos de Atención',
                    'graficoMes' => 'Evolución Mensual'
                ];

                foreach ($graficosRutas as $key => $rutaImagen) {
                    if (file_exists($rutaImagen)) {
                        $section->addText(
                            $titulos[$key] ?? ucfirst($key),
                            'normal',
                            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100]
                        );

                        $section->addImage($rutaImagen, [
                            'width' => 450,
                            'height' => 300,
                            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
                        ]);

                        $section->addTextBreak(2);
                        Log::info("✅ Gráfico agregado a Word: {$key}");
                    }
                }
            }

            // Guardar
            $fileName = "reporte_violencia_{$periodo}meses_" . date('Y-m-d') . ".docx";
            $tempFile = storage_path("app/public/{$fileName}");

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($tempFile);

            // Limpiar gráficos temporales
            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }

            Log::info('✅ ========== WORD COMPLETADO ==========');

            return response()->download($tempFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('❌ ========== ERROR EN WORD ==========');
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al generar Word',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // =============== EXPORTAR A EXCEL ===============
    public function exportarExcel(Request $request)
    {
        try {
            Log::info('🔵 ========== INICIANDO EXPORTACIÓN EXCEL ==========');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            // Recibir gráficos
            $graficos = json_decode($request->input('graficos', '{}'), true);
            Log::info('📊 Gráficos recibidos para Excel: ' . count($graficos));

            // Guardar gráficos
            $graficosRutas = $this->guardarGraficos($graficos);
            Log::info('💾 Gráficos guardados para Excel: ' . count($graficosRutas));

            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);

            // Hoja 1: Resumen
            $this->crearHojaResumen($spreadsheet, $fechaInicio, $periodo);

            // Hojas con datos
            $this->crearHojaConDatos($spreadsheet, 'Tipos de Violencia', $this->getCasosPorTipoViolencia($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Evolución Mensual', $this->getCasosPorMes($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Por Edad', $this->getCasosPorEdad($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Por Sexo', $this->getCasosPorSexo($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Tipo de Atención', $this->getCasosPorTipoAtencion($fechaInicio));

            // AGREGAR HOJA CON GRÁFICOS
            if (count($graficosRutas) > 0) {
                $sheetGraficos = $spreadsheet->createSheet();
                $sheetGraficos->setTitle('Gráficos');

                $sheetGraficos->setCellValue('A1', 'GRÁFICOS ESTADÍSTICOS');
                $sheetGraficos->mergeCells('A1:E1');
                $sheetGraficos->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheetGraficos->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $fila = 3;

                $titulos = [
                    'graficoSexo' => 'Distribución por Sexo',
                    'graficoEdad' => 'Casos por Rango de Edad',
                    'graficoViolencia' => 'Tipos de Violencia',
                    'graficoAtencion' => 'Tipos de Atención',
                    'graficoMes' => 'Evolución Mensual'
                ];

                foreach ($graficosRutas as $key => $rutaImagen) {
                    if (file_exists($rutaImagen)) {
                        // Título del gráfico
                        $sheetGraficos->setCellValue("A{$fila}", $titulos[$key] ?? ucfirst($key));
                        $sheetGraficos->getStyle("A{$fila}")->getFont()->setBold(true)->setSize(12);
                        $fila++;

                        // Agregar imagen
                        $drawing = new Drawing();
                        $drawing->setName($titulos[$key] ?? $key);
                        $drawing->setDescription($titulos[$key] ?? $key);
                        $drawing->setPath($rutaImagen);
                        $drawing->setHeight(300);
                        $drawing->setCoordinates("A{$fila}");
                        $drawing->setWorksheet($sheetGraficos);

                        $fila += 20; // Espacio para la imagen
                        Log::info("✅ Gráfico agregado a Excel: {$key}");
                    }
                }

                $sheetGraficos->getColumnDimension('A')->setWidth(80);
            }

            // Guardar
            $fileName = "reporte_violencia_{$periodo}meses_" . date('Y-m-d') . ".xlsx";
            $tempFile = storage_path("app/public/{$fileName}");

            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFile);

            // Limpiar gráficos temporales
            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }

            Log::info('✅ ========== EXCEL COMPLETADO ==========');

            return response()->download($tempFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('❌ ========== ERROR EN EXCEL ==========');
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al generar Excel',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // =============== MÉTODOS AUXILIARES ===============

    private function agregarSeccionWord($section, $titulo, $datos)
    {
        $section->addText($titulo, 'subtitulo', ['spaceAfter' => 200]);

        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '7EC544',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'width' => 100 * 50
        ]);

        $table->addRow(400);
        $table->addCell(4000, ['bgColor' => '037E8C'])->addText('Categoría', ['bold' => true, 'color' => 'FFFFFF']);
        $table->addCell(2000, ['bgColor' => '037E8C'])->addText('Cantidad', ['bold' => true, 'color' => 'FFFFFF']);

        if (isset($datos['labels'])) {
            foreach ($datos['labels'] as $index => $label) {
                $table->addRow();
                $table->addCell(4000)->addText($label);
                $table->addCell(2000)->addText($datos['data'][$index] ?? 0);
            }
        } else {
            foreach ($datos as $key => $value) {
                $table->addRow();
                $table->addCell(4000)->addText(ucfirst($key));
                $table->addCell(2000)->addText($value);
            }
        }

        $section->addTextBreak(2);
    }

    private function crearHojaResumen($spreadsheet, $fechaInicio, $periodo)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Resumen');

        $sheet->setCellValue('A1', '📊 REPORTE DE CASOS DE VIOLENCIA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Período:');
        $sheet->setCellValue('B3', "Últimos {$periodo} meses");
        $sheet->getStyle('A3')->getFont()->setBold(true);

        $sheet->setCellValue('A4', 'Fecha Inicio:');
        $sheet->setCellValue('B4', $fechaInicio->format('d/m/Y'));
        $sheet->getStyle('A4')->getFont()->setBold(true);

        $sheet->setCellValue('A5', 'Fecha Fin:');
        $sheet->setCellValue('B5', Carbon::now()->format('d/m/Y'));
        $sheet->getStyle('A5')->getFont()->setBold(true);

        $totalCasos = Caso::where('created_at', '>=', $fechaInicio)->count();
        $sheet->setCellValue('A6', 'Total Casos:');
        $sheet->setCellValue('B6', $totalCasos);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->getStyle('B6')->getFont()->setBold(true)->setSize(14);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
    }

    private function crearHojaConDatos($spreadsheet, $titulo, $datos)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle(substr($titulo, 0, 31));

        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Categoría');
        $sheet->setCellValue('B3', 'Cantidad');
        $sheet->setCellValue('C3', 'Porcentaje');
        $sheet->getStyle('A3:C3')->getFont()->setBold(true);
        $sheet->getStyle('A3:C3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('7EC544');

        $row = 4;
        $total = 0;

        if (isset($datos['labels'])) {
            $total = array_sum($datos['data']);
            foreach ($datos['labels'] as $index => $label) {
                $valor = $datos['data'][$index] ?? 0;
                $porcentaje = $total > 0 ? round(($valor / $total) * 100, 1) : 0;

                $sheet->setCellValue("A{$row}", $label);
                $sheet->setCellValue("B{$row}", $valor);
                $sheet->setCellValue("C{$row}", $porcentaje . '%');
                $row++;
            }
        } else {
            $total = array_sum(array_values($datos));
            foreach ($datos as $key => $value) {
                $porcentaje = $total > 0 ? round(($value / $total) * 100, 1) : 0;

                $sheet->setCellValue("A{$row}", ucfirst($key));
                $sheet->setCellValue("B{$row}", $value);
                $sheet->setCellValue("C{$row}", $porcentaje . '%');
                $row++;
            }
        }

        $sheet->setCellValue("A{$row}", 'TOTAL');
        $sheet->setCellValue("B{$row}", $total);
        $sheet->setCellValue("C{$row}", '100%');
        $sheet->getStyle("A{$row}:C{$row}")->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getStyle("B4:C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function getCasosPorTipoViolencia($fechaInicio)
    {
        return [
            'Física' => Caso::where('created_at', '>=', $fechaInicio)->where('violencia_tipo_fisica', 1)->count(),
            'Psicológica' => Caso::where('created_at', '>=', $fechaInicio)->where('violencia_tipo_psicologica', 1)->count(),
            'Sexual' => Caso::where('created_at', '>=', $fechaInicio)->where('violencia_tipo_sexual', 1)->count(),
            'Patrimonial' => Caso::where('created_at', '>=', $fechaInicio)->where('violencia_tipo_patrimonial', 1)->count(),
            'Económica' => Caso::where('created_at', '>=', $fechaInicio)->where('violencia_tipo_economica', 1)->count(),
        ];
    }

    private function getCasosPorMes($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'), DB::raw('count(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = Carbon::createFromFormat('Y-m', $caso->mes)->locale('es')->isoFormat('MMM YYYY');
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorEdad($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_edad_rango', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_edad_rango')
            ->groupBy('paciente_edad_rango')
            ->orderBy('paciente_edad_rango')
            ->get();

        $labels = [];
        $data = [];

        $etiquetas = [
            'menor15' => 'Menor de 15',
            '16a20' => '16-20 años',
            '21a25' => '21-25 años',
            '26a30' => '26-30 años',
            '31a35' => '31-35 años',
            '36a50' => '36-50 años',
            'mayor50' => 'Más de 50'
        ];

        foreach ($casos as $caso) {
            $labels[] = $etiquetas[$caso->paciente_edad_rango] ?? $caso->paciente_edad_rango;
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorSexo($fechaInicio)
    {
        return [
            'Masculino' => Caso::where('created_at', '>=', $fechaInicio)->where('paciente_sexo', 'M')->count(),
            'Femenino' => Caso::where('created_at', '>=', $fechaInicio)->where('paciente_sexo', 'F')->count(),
        ];
    }

    private function getCasosPorTipoAtencion($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('tipo_atencion', DB::raw('count(*) as total'))
            ->whereNotNull('tipo_atencion')
            ->groupBy('tipo_atencion')
            ->get();

        $labels = [];
        $data = [];

        $etiquetas = [
            'victima' => 'Víctima',
            'pareja' => 'Pareja',
            'agresor' => 'Agresor',
            'hijos' => 'Hijos'
        ];

        foreach ($casos as $caso) {
            $labels[] = $etiquetas[$caso->tipo_atencion] ?? ucfirst($caso->tipo_atencion);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}

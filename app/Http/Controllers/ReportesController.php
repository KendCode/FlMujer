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

class ReportesController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->get('periodo', 3);
        $fechaInicio = now()->subMonths($periodo);

        // Reportes originales
        $sexo = $this->getCasosPorSexo($fechaInicio);
        $edad = $this->getCasosPorEdad($fechaInicio);
        $tiposViolencia = $this->getCasosPorTipoViolencia($fechaInicio);
        $atencion = $this->getCasosPorTipoAtencion($fechaInicio);
        $porMes = $this->getCasosPorMes($fechaInicio);

        // 🆕 NUEVOS REPORTES
        $regional = $this->getCasosPorRegional($fechaInicio);
        $estadoCivil = $this->getCasosPorEstadoCivil($fechaInicio);
        $nivelInstruccion = $this->getCasosPorNivelInstruccion($fechaInicio);
        $ocupacion = $this->getCasosPorOcupacion($fechaInicio);
        $idioma = $this->getCasosPorIdioma($fechaInicio);
        $frecuenciaViolencia = $this->getCasosPorFrecuenciaViolencia($fechaInicio);
        $lugarHechos = $this->getCasosPorLugarHechos($fechaInicio);
        $denunciasPrevia = $this->getCasosPorDenunciasPrevia($fechaInicio);
        $motivoAgresion = $this->getCasosPorMotivoAgresion($fechaInicio);
        $razonesNoDenuncia = $this->getRazonesNoDenuncia($fechaInicio);
        $instituciones = $this->getCasosPorInstitucion($fechaInicio);
        $hijos = $this->getEstadisticasHijos($fechaInicio);
        $tipoViolenciaIntrafamiliar = $this->getCasosPorTipoViolenciaEspecifica($fechaInicio);
        $edadParejaVsVictima = $this->getComparativaEdades($fechaInicio);
        $atencionDemandada = $this->getAtencionDemandada($fechaInicio);

        return view('reportes.index', compact(
            'periodo',
            'sexo',
            'edad',
            'tiposViolencia',
            'atencion',
            'porMes',
            'regional',
            'estadoCivil',
            'nivelInstruccion',
            'ocupacion',
            'idioma',
            'frecuenciaViolencia',
            'lugarHechos',
            'denunciasPrevia',
            'motivoAgresion',
            'razonesNoDenuncia',
            'instituciones',
            'hijos',
            'tipoViolenciaIntrafamiliar',
            'edadParejaVsVictima',
            'atencionDemandada'
        ));
    }

    // =============== MÉTODOS DE OBTENCIÓN DE DATOS ===============

    // REPORTES ORIGINALES
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
    private function getCasosPorEdad($fechaInicio)
    {
        return collect([
            'Menores de 18' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('paciente_edad', '<', 18)
                ->count(),
            '18 a 29' => Caso::where('created_at', '>=', $fechaInicio)
                ->whereBetween('paciente_edad', [18, 29])
                ->count(),
            '30 a 59' => Caso::where('created_at', '>=', $fechaInicio)
                ->whereBetween('paciente_edad', [30, 59])
                ->count(),
            '60 o más' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('paciente_edad', '>=', 60)
                ->count(),
        ]);
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

    private function getCasosPorSexo($fechaInicio)
    {
        return collect([
            'Masculino' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('paciente_sexo', 'M')
                ->count(),
            'Femenino' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('paciente_sexo', 'F')
                ->count(),
        ]);
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

    // 🆕 NUEVOS REPORTES

    private function getCasosPorRegional($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('regional_recibe_caso', DB::raw('count(*) as total'))
            ->whereNotNull('regional_recibe_caso')
            ->groupBy('regional_recibe_caso')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = $caso->regional_recibe_caso;
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorEstadoCivil($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_estado_civil', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_estado_civil')
            ->groupBy('paciente_estado_civil')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->paciente_estado_civil);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorNivelInstruccion($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_nivel_instruccion', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_nivel_instruccion')
            ->groupBy('paciente_nivel_instruccion')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->paciente_nivel_instruccion);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorOcupacion($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_ocupacion', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_ocupacion')
            ->groupBy('paciente_ocupacion')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->paciente_ocupacion);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorIdioma($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_idioma_mas_hablado', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_idioma_mas_hablado')
            ->groupBy('paciente_idioma_mas_hablado')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->paciente_idioma_mas_hablado);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorFrecuenciaViolencia($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('violencia_frecuancia_agresion', DB::raw('count(*) as total'))
            ->whereNotNull('violencia_frecuancia_agresion')
            ->groupBy('violencia_frecuancia_agresion')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->violencia_frecuancia_agresion);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorLugarHechos($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('violencia_lugar_hechos', DB::raw('count(*) as total'))
            ->whereNotNull('violencia_lugar_hechos')
            ->groupBy('violencia_lugar_hechos')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->violencia_lugar_hechos);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getCasosPorDenunciasPrevia($fechaInicio)
    {
        return [
            'Con denuncia previa' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_denuncia_previa', 'si')->count(),
            'Sin denuncia previa' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_denuncia_previa', 'no')->count(),
        ];
    }

    private function getCasosPorMotivoAgresion($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('violencia_motivo_agresion', DB::raw('count(*) as total'))
            ->whereNotNull('violencia_motivo_agresion')
            ->groupBy('violencia_motivo_agresion')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->violencia_motivo_agresion);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getRazonesNoDenuncia($fechaInicio)
    {
        return [
            'Amenaza' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_no_denuncia_por_amenaza', 1)->count(),
            'Temor' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_no_denuncia_por_temor', 1)->count(),
            'Vergüenza' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_no_denuncia_por_verguenza', 1)->count(),
            'Desconocimiento' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_no_denuncia_por_desconocimiento', 1)->count(),
            'No sabe/No responde' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_no_denuncia_no_sabe_no_responde', 1)->count(),
        ];
    }

    private function getCasosPorInstitucion($fechaInicio)
    {
        $derivante = Caso::where('created_at', '>=', $fechaInicio)
            ->select('regional_institucion_derivante', DB::raw('count(*) as total'))
            ->whereNotNull('regional_institucion_derivante')
            ->groupBy('regional_institucion_derivante')
            ->orderBy('total', 'desc')
            ->get();

        $derivar = Caso::where('created_at', '>=', $fechaInicio)
            ->select('violencia_institucion_derivar', DB::raw('count(*) as total'))
            ->whereNotNull('violencia_institucion_derivar')
            ->groupBy('violencia_institucion_derivar')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'derivante' => [
                'labels' => $derivante->pluck('regional_institucion_derivante')->toArray(),
                'data' => $derivante->pluck('total')->toArray()
            ],
            'derivar' => [
                'labels' => $derivar->pluck('violencia_institucion_derivar')->toArray(),
                'data' => $derivar->pluck('total')->toArray()
            ]
        ];
    }

    private function getEstadisticasHijos($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)->get();

        $distribucion = [
            'Menor de 4 años' => 0,
            '5 a 10 años' => 0,
            '11 a 15 años' => 0,
            '16 a 20 años' => 0,
            '21 años o más' => 0,
        ];

        foreach ($casos as $caso) {
            $distribucion['Menor de 4 años'] += ($caso->hijos_menor4_m ?? 0) + ($caso->hijos_menor4_f ?? 0);
            $distribucion['5 a 10 años'] += ($caso->hijos_5a10_m ?? 0) + ($caso->hijos_5a10_f ?? 0);
            $distribucion['11 a 15 años'] += ($caso->hijos_11a15_m ?? 0) + ($caso->hijos_11a15_f ?? 0);
            $distribucion['16 a 20 años'] += ($caso->hijos_16a20_m ?? 0) + ($caso->hijos_16a20_f ?? 0);
            $distribucion['21 años o más'] += ($caso->hijos_21mas_m ?? 0) + ($caso->hijos_21mas_f ?? 0);
        }

        return [
            'labels' => array_keys($distribucion),
            'data' => array_values($distribucion)
        ];
    }

    private function getCasosPorTipoViolenciaEspecifica($fechaInicio)
    {
        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select('violencia_tipo', DB::raw('count(*) as total'))
            ->whereNotNull('violencia_tipo')
            ->groupBy('violencia_tipo')
            ->get();

        $labels = [];
        $data = [];

        foreach ($casos as $caso) {
            $labels[] = ucfirst($caso->violencia_tipo);
            $data[] = $caso->total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getComparativaEdades($fechaInicio)
    {
        $edadPromedioPaciente = Caso::where('created_at', '>=', $fechaInicio)
            ->whereNotNull('paciente_edad')
            ->avg('paciente_edad');

        $edadPromedioPareja = Caso::where('created_at', '>=', $fechaInicio)
            ->whereNotNull('pareja_edad')
            ->avg('pareja_edad');

        return [
            'labels' => ['Víctima', 'Agresor/Pareja'],
            'data' => [round($edadPromedioPaciente ?? 0, 1), round($edadPromedioPareja ?? 0, 1)]
        ];
    }

    private function getAtencionDemandada($fechaInicio)
    {
        return [
            'Apoyo a víctima' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_atencion_apoyo_victima', 1)->count(),
            'Apoyo a pareja' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_atencion_apoyo_pareja', 1)->count(),
            'Apoyo a agresor' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_atencion_apoyo_agresor', 1)->count(),
            'Apoyo a hijos' => Caso::where('created_at', '>=', $fechaInicio)
                ->where('violencia_atencion_apoyo_hijos', 1)->count(),
        ];
    }

    // =============== EXPORTACIONES ===============

    private function guardarGraficos($graficos)
    {
        $graficosRutas = [];
        $directorioGraficos = storage_path('app/public/graficos');

        if (!file_exists($directorioGraficos)) {
            mkdir($directorioGraficos, 0755, true);
        }

        foreach ($graficos as $key => $base64) {
            try {
                if (empty($base64)) continue;

                $base64Clean = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
                $imageData = base64_decode($base64Clean);

                if ($imageData === false || strlen($imageData) < 100) continue;

                $fileName = "{$key}_" . time() . "_" . rand(1000, 9999) . ".png";
                $rutaCompleta = $directorioGraficos . '/' . $fileName;

                file_put_contents($rutaCompleta, $imageData);

                if (file_exists($rutaCompleta) && filesize($rutaCompleta) > 0) {
                    $graficosRutas[$key] = $rutaCompleta;
                    Log::info("✅ Gráfico guardado: {$key}");
                }
            } catch (\Exception $e) {
                Log::error("❌ Error guardando {$key}: " . $e->getMessage());
            }
        }

        return $graficosRutas;
    }

    public function exportarPDF(Request $request)
    {
        try {
            Log::info('🔵 INICIANDO EXPORTACIÓN PDF');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            $graficos = json_decode($request->input('graficos', '{}'), true);
            $graficosRutas = $this->guardarGraficos($graficos);

            $datosReporte = $this->prepararDatosCompletos($fechaInicio, $periodo);

            $pdf = Pdf::loadView('reportes.pdf', [
                'datosReporte' => $datosReporte,
                'graficosRutas' => $graficosRutas
            ])->setPaper('letter', 'portrait');

            $nombreArchivo = "reporte_completo_{$periodo}meses_" . date('Y-m-d') . ".pdf";
            $response = $pdf->download($nombreArchivo);

            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) unlink($ruta);
            }

            Log::info('✅ PDF COMPLETADO');
            return $response;
        } catch (\Exception $e) {
            Log::error('❌ ERROR EN PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar PDF', 'message' => $e->getMessage()], 500);
        }
    }

    public function exportarExcel(Request $request)
    {
        try {
            Log::info('🔵 INICIANDO EXPORTACIÓN EXCEL');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            $graficos = json_decode($request->input('graficos', '{}'), true);
            $graficosRutas = $this->guardarGraficos($graficos);

            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);

            // Crear todas las hojas con los nuevos reportes
            $this->crearHojaResumen($spreadsheet, $fechaInicio, $periodo);
            $this->crearHojaConDatos($spreadsheet, 'Tipos de Violencia', $this->getCasosPorTipoViolencia($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Evolución Mensual', $this->getCasosPorMes($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Por Edad', $this->getCasosPorEdad($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Por Sexo', $this->getCasosPorSexo($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Regional', $this->getCasosPorRegional($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Estado Civil', $this->getCasosPorEstadoCivil($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Nivel Instrucción', $this->getCasosPorNivelInstruccion($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Frecuencia Violencia', $this->getCasosPorFrecuenciaViolencia($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Lugar de Hechos', $this->getCasosPorLugarHechos($fechaInicio));
            $this->crearHojaConDatos($spreadsheet, 'Razones No Denuncia', $this->getRazonesNoDenuncia($fechaInicio));

            // Agregar gráficos
            if (count($graficosRutas) > 0) {
                $this->agregarHojaGraficos($spreadsheet, $graficosRutas);
            }

            $fileName = "reporte_completo_{$periodo}meses_" . date('Y-m-d') . ".xlsx";
            $tempFile = storage_path("app/public/{$fileName}");

            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFile);

            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) unlink($ruta);
            }

            Log::info('✅ EXCEL COMPLETADO');
            return response()->download($tempFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('❌ ERROR EN EXCEL: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar Excel', 'message' => $e->getMessage()], 500);
        }
    }

    public function exportarWord(Request $request)
    {
        try {
            Log::info('🔵 INICIANDO EXPORTACIÓN WORD');

            $periodo = $request->input('periodo', 3);
            $fechaInicio = Carbon::now()->subMonths($periodo);

            $graficos = json_decode($request->input('graficos', '{}'), true);
            $graficosRutas = $this->guardarGraficos($graficos);

            $phpWord = new PhpWord();
            $section = $phpWord->addSection([
                'marginLeft' => 1000,
                'marginRight' => 1000,
                'marginTop' => 1000,
                'marginBottom' => 1000
            ]);

            $phpWord->addFontStyle('titulo', ['bold' => true, 'size' => 18, 'color' => '037E8C']);
            $phpWord->addFontStyle('subtitulo', ['bold' => true, 'size' => 14, 'color' => '7EC544']);
            $phpWord->addFontStyle('normal', ['size' => 11]);

            // Encabezado
            $section->addText(
                '📊 REPORTE COMPLETO DE CASOS DE VIOLENCIA',
                'titulo',
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 200]
            );

            $section->addText(
                'Fundación Levántate Mujer',
                'subtitulo',
                ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100]
            );

            // Agregar todas las secciones
            $totalCasos = Caso::where('created_at', '>=', $fechaInicio)->count();
            $section->addText("Total de casos: {$totalCasos}", 'normal', ['spaceAfter' => 400]);

            $this->agregarSeccionWord($section, 'TIPOS DE VIOLENCIA', $this->getCasosPorTipoViolencia($fechaInicio));
            $this->agregarSeccionWord($section, 'DISTRIBUCIÓN REGIONAL', $this->getCasosPorRegional($fechaInicio));
            $this->agregarSeccionWord($section, 'ESTADO CIVIL', $this->getCasosPorEstadoCivil($fechaInicio));
            $this->agregarSeccionWord($section, 'NIVEL DE INSTRUCCIÓN', $this->getCasosPorNivelInstruccion($fechaInicio));
            $this->agregarSeccionWord($section, 'FRECUENCIA DE VIOLENCIA', $this->getCasosPorFrecuenciaViolencia($fechaInicio));
            $this->agregarSeccionWord($section, 'RAZONES DE NO DENUNCIA', $this->getRazonesNoDenuncia($fechaInicio));

            // Agregar gráficos
            if (count($graficosRutas) > 0) {
                $section->addPageBreak();
                $section->addText('GRÁFICOS ESTADÍSTICOS', 'subtitulo', ['spaceAfter' => 400]);

                foreach ($graficosRutas as $key => $rutaImagen) {
                    if (file_exists($rutaImagen)) {
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

            $fileName = "reporte_completo_{$periodo}meses_" . date('Y-m-d') . ".docx";
            $tempFile = storage_path("app/public/{$fileName}");

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($tempFile);

            foreach ($graficosRutas as $ruta) {
                if (file_exists($ruta)) unlink($ruta);
            }

            Log::info('✅ WORD COMPLETADO');
            return response()->download($tempFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('❌ ERROR EN WORD: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar Word', 'message' => $e->getMessage()], 500);
        }
    }

    // =============== MÉTODOS AUXILIARES ===============

    private function prepararDatosCompletos($fechaInicio, $periodo)
    {
        return [
            'periodo' => $periodo,
            'fecha_inicio' => $fechaInicio->format('d/m/Y'),
            'fecha_fin' => Carbon::now()->format('d/m/Y'),
            'total_casos' => Caso::where('created_at', '>=', $fechaInicio)->count(),
            'violencia' => $this->getCasosPorTipoViolencia($fechaInicio),
            'meses' => $this->getCasosPorMes($fechaInicio),
            'sexo' => $this->getCasosPorSexo($fechaInicio),
            'edad' => $this->getCasosPorEdad($fechaInicio),
            'atencion' => $this->getCasosPorTipoAtencion($fechaInicio),
            'regional' => $this->getCasosPorRegional($fechaInicio),
            'estadoCivil' => $this->getCasosPorEstadoCivil($fechaInicio),
            'nivelInstruccion' => $this->getCasosPorNivelInstruccion($fechaInicio),
            'ocupacion' => $this->getCasosPorOcupacion($fechaInicio),
            'idioma' => $this->getCasosPorIdioma($fechaInicio),
            'frecuenciaViolencia' => $this->getCasosPorFrecuenciaViolencia($fechaInicio),
            'lugarHechos' => $this->getCasosPorLugarHechos($fechaInicio),
            'denunciasPrevia' => $this->getCasosPorDenunciasPrevia($fechaInicio),
            'motivoAgresion' => $this->getCasosPorMotivoAgresion($fechaInicio),
            'razonesNoDenuncia' => $this->getRazonesNoDenuncia($fechaInicio),
            'instituciones' => $this->getCasosPorInstitucion($fechaInicio),
            'hijos' => $this->getEstadisticasHijos($fechaInicio),
            'tipoViolenciaIntrafamiliar' => $this->getCasosPorTipoViolenciaEspecifica($fechaInicio),
            'edadParejaVsVictima' => $this->getComparativaEdades($fechaInicio),
            'atencionDemandada' => $this->getAtencionDemandada($fechaInicio),
        ];
    }

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

        $sheet->setCellValue('A1', '📊 REPORTE COMPLETO DE CASOS DE VIOLENCIA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Fundación Levántate Mujer');
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->getFont()->setSize(14)->setItalic(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A5', 'Período:');
        $sheet->setCellValue('B5', "Últimos {$periodo} meses");
        $sheet->getStyle('A5')->getFont()->setBold(true);

        $sheet->setCellValue('A6', 'Fecha Inicio:');
        $sheet->setCellValue('B6', $fechaInicio->format('d/m/Y'));
        $sheet->getStyle('A6')->getFont()->setBold(true);

        $sheet->setCellValue('A7', 'Fecha Fin:');
        $sheet->setCellValue('B7', Carbon::now()->format('d/m/Y'));
        $sheet->getStyle('A7')->getFont()->setBold(true);

        $totalCasos = Caso::where('created_at', '>=', $fechaInicio)->count();
        $sheet->setCellValue('A9', 'Total Casos Registrados:');
        $sheet->setCellValue('B9', $totalCasos);
        $sheet->getStyle('A9')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('B9')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('7EC544');

        // Estadísticas adicionales
        $conDenuncia = Caso::where('created_at', '>=', $fechaInicio)->where('violencia_denuncia_previa', 'si')->count();
        $sheet->setCellValue('A11', 'Casos con denuncia previa:');
        $sheet->setCellValue('B11', $conDenuncia);
        $sheet->getStyle('A11')->getFont()->setBold(true);

        $sinDenuncia = Caso::where('created_at', '>=', $fechaInicio)->where('violencia_denuncia_previa', 'no')->count();
        $sheet->setCellValue('A12', 'Casos sin denuncia previa:');
        $sheet->setCellValue('B12', $sinDenuncia);
        $sheet->getStyle('A12')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(25);
    }

    private function crearHojaConDatos($spreadsheet, $titulo, $datos)
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle(substr($titulo, 0, 31));

        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('037E8C');
        $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

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
        $sheet->getStyle("A{$row}:C{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');

        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getStyle("B4:C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function agregarHojaGraficos($spreadsheet, $graficosRutas)
    {
        $sheetGraficos = $spreadsheet->createSheet();
        $sheetGraficos->setTitle('Gráficos');

        $sheetGraficos->setCellValue('A1', 'GRÁFICOS ESTADÍSTICOS');
        $sheetGraficos->mergeCells('A1:E1');
        $sheetGraficos->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheetGraficos->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheetGraficos->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('037E8C');
        $sheetGraficos->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

        $fila = 3;

        $titulos = [
            'graficoSexo' => 'Distribución por Sexo',
            'graficoEdad' => 'Casos por Rango de Edad',
            'graficoViolencia' => 'Tipos de Violencia',
            'graficoAtencion' => 'Tipos de Atención',
            'graficoMes' => 'Evolución Mensual',
            'graficoRegional' => 'Distribución Regional',
            'graficoEstadoCivil' => 'Estado Civil',
            'graficoNivelInstruccion' => 'Nivel de Instrucción',
            'graficoFrecuencia' => 'Frecuencia de Violencia',
            'graficoLugar' => 'Lugar de los Hechos',
            'graficoDenuncias' => 'Denuncias Previas',
            'graficoRazonesNoDenuncia' => 'Razones de No Denuncia',
            'graficoHijos' => 'Distribución de Hijos',
            'graficoAtencionDemandada' => 'Atención Demandada',
            'graficoOcupacion' => 'Ocupaciones Principales',
            'graficoIdioma' => 'Idioma Más Hablado',
            'graficoMotivo' => 'Motivos de Agresión'
        ];

        foreach ($graficosRutas as $key => $rutaImagen) {
            if (file_exists($rutaImagen)) {
                $sheetGraficos->setCellValue("A{$fila}", $titulos[$key] ?? ucfirst($key));
                $sheetGraficos->getStyle("A{$fila}")->getFont()->setBold(true)->setSize(12);
                $sheetGraficos->getStyle("A{$fila}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('7EC544');
                $fila++;

                $drawing = new Drawing();
                $drawing->setName($titulos[$key] ?? $key);
                $drawing->setDescription($titulos[$key] ?? $key);
                $drawing->setPath($rutaImagen);
                $drawing->setHeight(300);
                $drawing->setCoordinates("A{$fila}");
                $drawing->setWorksheet($sheetGraficos);

                $fila += 20;
                Log::info("✅ Gráfico agregado a Excel: {$key}");
            }
        }

        $sheetGraficos->getColumnDimension('A')->setWidth(80);
    }

    // =============== REPORTES PERSONALIZADOS ===============

    public function reportePorDistrito(Request $request)
    {
        $periodo = $request->get('periodo', 3);
        $fechaInicio = now()->subMonths($periodo);

        $pacientes = Caso::where('created_at', '>=', $fechaInicio)
            ->select('paciente_id_distrito', DB::raw('count(*) as total'))
            ->whereNotNull('paciente_id_distrito')
            ->groupBy('paciente_id_distrito')
            ->orderBy('total', 'desc')
            ->get();

        $parejas = Caso::where('created_at', '>=', $fechaInicio)
            ->select('pareja_id_distrito', DB::raw('count(*) as total'))
            ->whereNotNull('pareja_id_distrito')
            ->groupBy('pareja_id_distrito')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'pacientes' => $pacientes,
            'parejas' => $parejas
        ]);
    }

    public function reporteCruzado(Request $request)
    {
        $periodo = $request->get('periodo', 3);
        $fechaInicio = now()->subMonths($periodo);

        // Cruce: Tipo de violencia x Edad
        $cruce = Caso::where('created_at', '>=', $fechaInicio)
            ->select(
                'paciente_edad_rango',
                DB::raw('SUM(violencia_tipo_fisica) as fisica'),
                DB::raw('SUM(violencia_tipo_psicologica) as psicologica'),
                DB::raw('SUM(violencia_tipo_sexual) as sexual'),
                DB::raw('SUM(violencia_tipo_patrimonial) as patrimonial'),
                DB::raw('SUM(violencia_tipo_economica) as economica')
            )
            ->whereNotNull('paciente_edad_rango')
            ->groupBy('paciente_edad_rango')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cruce
        ]);
    }

    public function reporteTemporalDetallado(Request $request)
    {
        $periodo = $request->get('periodo', 12);
        $fechaInicio = now()->subMonths($periodo);

        $casos = Caso::where('created_at', '>=', $fechaInicio)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periodo'),
                DB::raw('count(*) as total'),
                DB::raw('SUM(violencia_tipo_fisica) as fisica'),
                DB::raw('SUM(violencia_tipo_psicologica) as psicologica'),
                DB::raw('SUM(violencia_tipo_sexual) as sexual'),
                DB::raw('SUM(CASE WHEN violencia_denuncia_previa = "si" THEN 1 ELSE 0 END) as con_denuncia')
            )
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $casos
        ]);
    }
}

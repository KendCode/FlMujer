<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Caso;
use App\Models\FormaViolencia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pareja;
use App\Models\Hijo;
use App\Models\FichaAgresor;
use App\Models\FichaVictima;
use Barryvdh\DomPDF\Facade\Pdf;

class CasoController extends Controller
{
    /**
     * Muestra la lista de casos registrados.
     */
    public function index(Request $request)
    {
        $query = Caso::query();

        // Búsqueda por nombre, apellido, CI o registro
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('paciente_nombres', 'like', "%{$search}%")
                    ->orWhere('paciente_apellidos', 'like', "%{$search}%")
                    ->orWhere('nro_registro', 'like', "%{$search}%")
                    ->orWhere('paciente_ci', 'like', "%{$search}%");
            });
        }

        // Filtrar por distrito
        if ($request->filled('distrito')) {
            $query->where('paciente_id_distrito', $request->distrito);
        }

        // Filtrar por tipo de violencia
        if ($request->filled('tipo_violencia')) {
            $tipo = $request->tipo_violencia;
            $query->where(function ($q) use ($tipo) {
                if ($tipo == 'violencia_intrafamiliar') {
                    $q->where('violencia_tipo_fisica', 1)
                        ->orWhere('violencia_tipo_psicologica', 1);
                } elseif ($tipo == 'violencia_domestica') {
                    $q->where('violencia_tipo_economica', 1)
                        ->orWhere('violencia_tipo_patrimonial', 1);
                }
            });
        }

        // Filtrar por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('regional_fecha', $request->fecha);
        }

        // Paginación
        $casos = $query->orderBy('regional_fecha', 'desc')->paginate(10);

        // Mantener los filtros en la paginación
        $casos->appends($request->all());

        return view('casos.index', compact('casos'));
    }


    /**
     * Muestra el formulario para crear un nuevo caso.
     */
    public function create()
    {
        // Si tienes catálogos (distritos, etc.) puedes enviarlos aquí
        return view('casos.create');
    }

    /**
     * Guarda un nuevo caso en la base de datos.
     */
    public function store(Request $request)
    {
        // =====================
        // VALIDACIONES
        // =====================
        $validated = $request->validate([
            // ============ REGIONAL ============
            'tipo_atencion' => 'required|string|max:255',
            'regional_recibe_caso' => 'required|string|max:255',
            'regional_fecha' => 'required|date',
            'regional_institucion_derivante' => 'nullable|string|max:255',
            'tipo_registro' => 'required|in:automatico,manual',
            'nro_registro_manual_input' => [
                'required_if:tipo_registro,manual',
                'nullable',
                'regex:/^CT-\d{3}-\d{2}-EA$/',
                'unique:casos,nro_registro',
            ],


            // ============ PACIENTE ============
            'paciente_nombres' => 'required|string|max:255',
            'paciente_ap_materno' => 'nullable|string|max:255',
            'paciente_ap_paterno' => 'nullable|string|max:255',
            'paciente_sexo' => 'required|in:M,F',
            'paciente_edad_rango' => 'required|string',
            'paciente_edad' => 'nullable|integer|min:0|max:120',
            'paciente_ci' => 'nullable|string|max:50',
            'paciente_telefono' => 'nullable|string|max:50',
            'paciente_id_distrito' => 'required|string',
            'paciente_zona' => 'nullable|string|max:255',
            'paciente_calle' => 'nullable|string|max:255',
            'paciente_numero' => 'nullable|string|max:50',
            'paciente_otros' => 'nullable|string',
            'paciente_lugar_nacimiento' => 'nullable|string|max:255',
            'paciente_lugar_nacimiento_op' => 'required|in:dentro,fuera',
            'paciente_lugar_residencia_op' => 'nullable|in:dentro,fuera',
            'paciente_tiempo_residencia_op' => 'nullable|string',
            'paciente_estado_civil' => 'required|string',
            'paciente_nivel_instruccion' => 'required|string',
            'paciente_idioma_mas_hablado' => 'required|string',
            'paciente_idioma_especificar' => 'nullable|string|max:255',
            'paciente_ocupacion' => 'required|string',
            'paciente_situacion_ocupacional' => 'required|string',

            // ============ PAREJA ============
            'pareja_nombres' => 'required|string|max:255',
            'pareja_ap_paterno' => 'nullable|string|max:255',
            'pareja_ap_materno' => 'nullable|string|max:255',
            'pareja_sexo' => 'required|in:M,F',
            'pareja_edad_rango' => 'required|string',
            'pareja_edad' => 'nullable|integer|min:0|max:120',
            'pareja_ci' => 'nullable|string|max:50',
            'pareja_telefono' => 'nullable|string|max:50',
            'pareja_id_distrito' => 'required|string',
            'pareja_zona' => 'nullable|string|max:255',
            'pareja_calle' => 'nullable|string|max:255',
            'pareja_numero' => 'nullable|string|max:50',
            'pareja_otros' => 'nullable|string',
            'pareja_lugar_nacimiento' => 'nullable|string|max:255',
            'pareja_lugar_nacimiento_op' => 'required|in:dentro,fuera',
            'pareja_lugar_residencia_op' => 'nullable|in:dentro,fuera',
            'pareja_tiempo_residencia_op' => 'nullable|string',
            'pareja_residencia' => 'nullable|string',
            'pareja_tiempo_residencia' => 'nullable|string',
            'pareja_estado_civil' => 'nullable|string',
            'pareja_nivel_instruccion' => 'nullable|string',
            'pareja_idioma' => 'required|string',
            'pareja_especificar_idioma' => 'nullable|string|max:255',
            'pareja_ocupacion_principal' => 'required|string',
            'pareja_situacion_ocupacional' => 'required|string',
            'pareja_parentesco' => 'required|string',
            'pareja_anos_convivencia' => 'required|string',

            // ============ HIJOS ============
            'hijos_num_gestacion' => 'nullable|string',
            'hijos_dependencia' => 'nullable|string',
            'hijos_menor4_m' => 'nullable|array',
            'hijos_menor4_f' => 'nullable|array',
            'hijos_5a10_m' => 'nullable|array',
            'hijos_5a10_f' => 'nullable|array',
            'hijos_11a15_m' => 'nullable|array',
            'hijos_11a15_f' => 'nullable|array',
            'hijos_16a20_m' => 'nullable|array',
            'hijos_16a20_f' => 'nullable|array',
            'hijos_21mas_m' => 'nullable|array',
            'hijos_21mas_f' => 'nullable|array',

            // ============ VIOLENCIA - TIPOS (Checkboxes) ============
            'violencia_tipo_fisica' => 'nullable|boolean',
            'violencia_tipo_psicologica' => 'nullable|boolean',
            'violencia_tipo_sexual' => 'nullable|boolean',
            'violencia_tipo_patrimonial' => 'nullable|boolean',
            'violencia_tipo_economica' => 'nullable|boolean',

            // ============ VIOLENCIA - DATOS ============
            'violencia_tipo' => 'nullable|string',
            'violencia_frecuancia_agresion' => 'required|string',
            'violencia_denuncia_previa' => 'required|in:si,no',
            'violencia_motivo_agresion' => 'required|string',
            'violencia_motivo_otros' => 'nullable|string|max:500',
            'violencia_descripcion_hechos' => 'nullable|string',

            // ============ RAZONES NO DENUNCIA (Checkboxes) ============
            'violencia_no_denuncia_por_amenaza' => 'nullable|boolean',
            'violencia_no_denuncia_por_temor' => 'nullable|boolean',
            'violencia_no_denuncia_por_verguenza' => 'nullable|boolean',
            'violencia_no_denuncia_por_desconocimiento' => 'nullable|boolean',
            'violencia_no_denuncia_no_sabe_no_responde' => 'nullable|boolean',

            // ============ ATENCIÓN DEMANDADA (Checkboxes) ============
            'violencia_atencion_apoyo_victima' => 'nullable|boolean',
            'violencia_atencion_apoyo_pareja' => 'nullable|boolean',
            'violencia_atencion_apoyo_agresor' => 'nullable|boolean',
            'violencia_atencion_apoyo_hijos' => 'nullable|boolean',

            // ============ INSTITUCIONES ============
            'violencia_institucion_denuncia' => 'nullable|string|max:500',
            'violencia_institucion_derivar' => 'nullable|string|max:500',

            // ============ RESPONSABLE ============
            'violencia_medidas_tomar' => 'nullable|string|max:500',
            'formulario_responsable_nombre' => 'nullable|string|max:255',

            // ============ CAMPOS LEGACY ============
            'violencia_frecuencia' => 'nullable|string',
            'violencia_lugar_hechos' => 'nullable|string',
            'violencia_tiempo_ocurrencia' => 'nullable|string',

        ], [
            // ============ MENSAJES PERSONALIZADOS ============
            'nro_registro_manual_input.regex' => 'El formato debe ser: CT-EA-001-25',
            'nro_registro_manual_input.unique' => 'Este número de registro ya existe',
            'nro_registro_manual_input.required_if' => 'Debe ingresar un número de registro manual',
            'paciente_nombres.required' => 'El nombre del paciente es obligatorio',
            'paciente_apellidos.required' => 'Los apellidos del paciente son obligatorios',
            'regional_recibe_caso.required' => 'Debe indicar la regional que recibe el caso',
        ]);

        // =====================
        // PREPARAR DATOS
        // =====================
        $data = [];

        $data['tipo_atencion'] = $validated['tipo_atencion'];

        // REGIONAL
        $data['regional_recibe_caso'] = $validated['regional_recibe_caso'];
        $data['regional_fecha'] = $validated['regional_fecha'];
        $data['regional_institucion_derivante'] = $validated['regional_institucion_derivante'] ?? null;

        // NÚMERO DE REGISTRO
        if ($validated['tipo_registro'] === 'manual') {
            $data['nro_registro'] = strtoupper(trim($validated['nro_registro_manual_input']));
            $data['nro_registro_manual'] = true;
        } else {
            $data['nro_registro'] = Caso::generarNumeroRegistro();
            $data['nro_registro_manual'] = false;
        }

        // DATOS DEL PACIENTE
        $data['paciente_nombres'] = $validated['paciente_nombres'];
        $data['paciente_ap_paterno'] = $validated['paciente_ap_paterno'] ?? null;
        $data['paciente_ap_materno'] = $validated['paciente_ap_materno'] ?? null;
        $data['paciente_edad'] = $validated['paciente_edad'] ?? null;
        $data['paciente_ci'] = $validated['paciente_ci'] ?? null;
        $data['paciente_telefono'] = $validated['paciente_telefono'] ?? null;
        $data['paciente_calle'] = $validated['paciente_calle'] ?? null;
        $data['paciente_numero'] = $validated['paciente_numero'] ?? null;
        $data['paciente_zona'] = $validated['paciente_zona'] ?? null;
        $data['paciente_id_distrito'] = $validated['paciente_id_distrito'];
        $data['paciente_estado_civil'] = $validated['paciente_estado_civil'];
        $data['paciente_sexo'] = $validated['paciente_sexo'];
        $data['paciente_lugar_nacimiento'] = $validated['paciente_lugar_nacimiento'] ?? null;
        $data['paciente_lugar_nacimiento_op'] = $validated['paciente_lugar_nacimiento_op'];
        $data['paciente_lugar_residencia_op'] = $validated['paciente_lugar_residencia_op'] ?? null;
        $data['paciente_tiempo_residencia_op'] = $validated['paciente_tiempo_residencia_op'] ?? null;
        $data['paciente_edad_rango'] = $validated['paciente_edad_rango'];
        $data['paciente_nivel_instruccion'] = $validated['paciente_nivel_instruccion'];
        $data['paciente_idioma_mas_hablado'] = $validated['paciente_idioma_mas_hablado'];
        $data['paciente_idioma_especificar'] = $validated['paciente_idioma_especificar'] ?? null;
        $data['paciente_ocupacion'] = $validated['paciente_ocupacion'];
        $data['paciente_situacion_ocupacional'] = $validated['paciente_situacion_ocupacional'];
        $data['paciente_otros'] = $validated['paciente_otros'] ?? null;

        // DATOS DE LA PAREJA
        $data['pareja_nombres'] = $validated['pareja_nombres'];
        $data['pareja_ap_paterno'] = $validated['pareja_ap_paterno'] ?? null;
        $data['pareja_ap_materno'] = $validated['pareja_ap_materno'] ?? null;
        $data['pareja_edad'] = $validated['pareja_edad'] ?? null;
        $data['pareja_ci'] = $validated['pareja_ci'] ?? null;
        $data['pareja_telefono'] = $validated['pareja_telefono'] ?? null;
        $data['pareja_calle'] = $validated['pareja_calle'] ?? null;
        $data['pareja_numero'] = $validated['pareja_numero'] ?? null;
        $data['pareja_zona'] = $validated['pareja_zona'] ?? null;
        $data['pareja_id_distrito'] = $validated['pareja_id_distrito'];
        $data['pareja_estado_civil'] = $validated['pareja_estado_civil'] ?? null;
        $data['pareja_sexo'] = $validated['pareja_sexo'];
        $data['pareja_lugar_nacimiento'] = $validated['pareja_lugar_nacimiento'] ?? null;
        $data['pareja_lugar_nacimiento_op'] = $validated['pareja_lugar_nacimiento_op'];
        $data['pareja_lugar_residencia_op'] = $validated['pareja_lugar_residencia_op'] ?? null;
        $data['pareja_tiempo_residencia_op'] = $validated['pareja_tiempo_residencia_op'] ?? null;
        $data['pareja_edad_rango'] = $validated['pareja_edad_rango'];
        $data['pareja_nivel_instruccion'] = $validated['pareja_nivel_instruccion'] ?? null;
        $data['pareja_ocupacion_principal'] = $validated['pareja_ocupacion_principal'];
        $data['pareja_situacion_ocupacional'] = $validated['pareja_situacion_ocupacional'];
        $data['pareja_parentesco'] = $validated['pareja_parentesco'];
        $data['pareja_residencia'] = $validated['pareja_residencia'] ?? null;
        $data['pareja_tiempo_residencia'] = $validated['pareja_tiempo_residencia'] ?? null;
        $data['pareja_anos_convivencia'] = $validated['pareja_anos_convivencia'];
        $data['pareja_idioma'] = $validated['pareja_idioma'];
        $data['pareja_especificar_idioma'] = $validated['pareja_especificar_idioma'] ?? null;
        $data['pareja_otros'] = $validated['pareja_otros'] ?? null;

        // HIJOS - Datos básicos
        $data['hijos_num_gestacion'] = $validated['hijos_num_gestacion'] ?? null;
        $data['hijos_dependencia'] = $validated['hijos_dependencia'] ?? null;

        // HIJOS - CHECKBOXES (contar los marcados)
        $data['hijos_menor4_m'] = count($validated['hijos_menor4_m'] ?? []);
        $data['hijos_menor4_f'] = count($validated['hijos_menor4_f'] ?? []);
        $data['hijos_5a10_m'] = count($validated['hijos_5a10_m'] ?? []);
        $data['hijos_5a10_f'] = count($validated['hijos_5a10_f'] ?? []);
        $data['hijos_11a15_m'] = count($validated['hijos_11a15_m'] ?? []);
        $data['hijos_11a15_f'] = count($validated['hijos_11a15_f'] ?? []);
        $data['hijos_16a20_m'] = count($validated['hijos_16a20_m'] ?? []);
        $data['hijos_16a20_f'] = count($validated['hijos_16a20_f'] ?? []);
        $data['hijos_21mas_m'] = count($validated['hijos_21mas_m'] ?? []);
        $data['hijos_21mas_f'] = count($validated['hijos_21mas_f'] ?? []);

        // VIOLENCIA - TIPOS (Checkboxes)
        $data['violencia_tipo_fisica'] = $validated['violencia_tipo_fisica'] ?? false;
        $data['violencia_tipo_psicologica'] = $validated['violencia_tipo_psicologica'] ?? false;
        $data['violencia_tipo_sexual'] = $validated['violencia_tipo_sexual'] ?? false;
        $data['violencia_tipo_patrimonial'] = $validated['violencia_tipo_patrimonial'] ?? false;
        $data['violencia_tipo_economica'] = $validated['violencia_tipo_economica'] ?? false;

        // VIOLENCIA - Datos generales
        $data['violencia_tipo'] = $validated['violencia_tipo'] ?? null;
        $data['violencia_frecuancia_agresion'] = $validated['violencia_frecuancia_agresion'];
        $data['violencia_denuncia_previa'] = $validated['violencia_denuncia_previa'];
        $data['violencia_motivo_agresion'] = $validated['violencia_motivo_agresion'];
        $data['violencia_motivo_otros'] = $validated['violencia_motivo_otros'] ?? null;
        $data['violencia_descripcion_hechos'] = $validated['violencia_descripcion_hechos'] ?? null;

        // RAZONES DE NO DENUNCIA (Checkboxes)
        $data['violencia_no_denuncia_por_amenaza'] = $validated['violencia_no_denuncia_por_amenaza'] ?? false;
        $data['violencia_no_denuncia_por_temor'] = $validated['violencia_no_denuncia_por_temor'] ?? false;
        $data['violencia_no_denuncia_por_verguenza'] = $validated['violencia_no_denuncia_por_verguenza'] ?? false;
        $data['violencia_no_denuncia_por_desconocimiento'] = $validated['violencia_no_denuncia_por_desconocimiento'] ?? false;
        $data['violencia_no_denuncia_no_sabe_no_responde'] = $validated['violencia_no_denuncia_no_sabe_no_responde'] ?? false;

        // ATENCIÓN DEMANDADA (Checkboxes)
        $data['violencia_atencion_apoyo_victima'] = $validated['violencia_atencion_apoyo_victima'] ?? false;
        $data['violencia_atencion_apoyo_pareja'] = $validated['violencia_atencion_apoyo_pareja'] ?? false;
        $data['violencia_atencion_apoyo_agresor'] = $validated['violencia_atencion_apoyo_agresor'] ?? false;
        $data['violencia_atencion_apoyo_hijos'] = $validated['violencia_atencion_apoyo_hijos'] ?? false;

        // CAMPOS FINALES
        $data['violencia_institucion_denuncia'] = $validated['violencia_institucion_denuncia'] ?? null;
        $data['violencia_institucion_derivar'] = $validated['violencia_institucion_derivar'] ?? null;
        $data['violencia_medidas_tomar'] = $validated['violencia_medidas_tomar'] ?? null;
        $data['formulario_responsable_nombre'] = $validated['formulario_responsable_nombre'] ?? null;

        // Campos legacy
        $data['violencia_frecuencia'] = $validated['violencia_frecuencia'] ?? null;
        $data['violencia_lugar_hechos'] = $validated['violencia_lugar_hechos'] ?? null;
        $data['violencia_tiempo_ocurrencia'] = $validated['violencia_tiempo_ocurrencia'] ?? null;

        // =====================
        // CREAR CASO
        // =====================
        try {
            $caso = Caso::create($data);

            return redirect()->route('casos.index')
                ->with('success', "Caso registrado exitosamente con número: {$caso->nro_registro}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar el caso: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint para obtener el próximo número de registro (AJAX)
     */
    public function obtenerProximoNumero()
    {
        $anio = date('y'); // Año actual en 2 dígitos

        // Obtener último número secuencial del año actual
        $ultimoCaso = Caso::where('nro_registro', 'like', "CT-%-$anio-EA")
            ->orderBy('nro_registro', 'desc')
            ->first();

        if ($ultimoCaso) {
            preg_match('/^CT-(\d{3})-\d{2}-EA$/', $ultimoCaso->nro_registro, $matches);
            $secuencial = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
        } else {
            $secuencial = 1;
        }

        if ($secuencial > 999) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay números disponibles'
            ]);
        }

        $secuencialFormateado = str_pad($secuencial, 3, '0', STR_PAD_LEFT);
        $numero = "CT-$secuencialFormateado-$anio-EA";

        return response()->json(['success' => true, 'numero' => $numero]);
    }


    /**
     * Validar número de registro manual (AJAX)
     */
    public function validarNumeroRegistro(Request $request)
    {
        $numero = strtoupper(trim($request->input('numero')));

        // Validar formato CT-001-25-EA
        if (!preg_match('/^CT-(\d{3})-(\d{2})-EA$/', $numero, $matches)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Formato incorrecto. Debe ser: CT-001-25-EA'
            ]);
        }

        $numeroSecuencial = (int)$matches[1];
        $anioIngresado = (int)$matches[2];
        $anioActual = (int)date('y');

        // Validar rango de número
        if ($numeroSecuencial < 1 || $numeroSecuencial > 999) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'El número debe estar entre 001 y 999'
            ]);
        }

        // Advertencia si no es del año actual
        if ($anioIngresado !== $anioActual) {
            return response()->json([
                'valido' => false,
                'mensaje' => "El año debe ser $anioActual (año actual)"
            ]);
        }

        // Verificar duplicados
        $existe = Caso::where('nro_registro', $numero)->exists();
        if ($existe) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Este número de registro ya existe en el sistema'
            ]);
        }

        return response()->json([
            'valido' => true,
            'mensaje' => 'Número válido y disponible ✓'
        ]);
    }
    /**
     * Muestra un caso específico.
     */
    public function show(Caso $caso)
    {
        return view('casos.show', compact('caso'));
    }

    /**
     * Muestra el formulario de edición de un caso existente.
     */
    public function edit(Caso $caso)
    {
        // Normalizamos para radios
        if ($caso->violencia_denuncia_previa === 1 || $caso->violencia_denuncia_previa === '1' || $caso->violencia_denuncia_previa === true) {
            $caso->violencia_denuncia_previa = 'si';
        } elseif ($caso->violencia_denuncia_previa === 0 || $caso->violencia_denuncia_previa === '0' || $caso->violencia_denuncia_previa === false) {
            $caso->violencia_denuncia_previa = 'no';
        }

        return view('casos.edit', compact('caso'));
    }


    /**
     * Actualiza los datos de un caso existente.
     */
    public function update(Request $request, Caso $caso)
    {
        // Validaciones básicas
        $request->validate([
            'paciente_nombres' => 'required|string|max:255',
            'paciente_ap_paterno' => 'nullable|string|max:255',
            'paciente_ap_materno' => 'nullable|string|max:255',
        ]);

        // Actualizar todos los campos del caso
        $caso->update([
            // Datos del paciente
            'paciente_nombres' => $request->input('paciente_nombres'),
            'paciente_ap_paterno' => $request->input('paciente_ap_paterno'),
            'paciente_ap_materno' => $request->input('paciente_ap_materno'),
            'paciente_ci' => $request->input('paciente_ci'),
            'paciente_telefono' => $request->input('paciente_telefono'),
            'paciente_calle' => $request->input('paciente_calle'),
            'paciente_numero' => $request->input('paciente_numero'),
            'paciente_zona' => $request->input('paciente_zona'),
            'paciente_id_distrito' => $request->input('paciente_id_distrito'),
            'paciente_estado_civil' => $request->input('paciente_estado_civil'),
            'paciente_sexo' => $request->input('paciente_sexo'),
            'paciente_lugar_nacimiento' => $request->input('paciente_lugar_nacimiento'),
            'paciente_lugar_nacimiento_op' => $request->input('paciente_lugar_nacimiento_op'),
            'paciente_edad_rango' => $request->input('paciente_edad_rango'),
            'paciente_nivel_instruccion' => $request->input('paciente_nivel_instruccion'),
            'paciente_ocupacion' => $request->input('paciente_ocupacion'),
            'paciente_situacion_ocupacional' => $request->input('paciente_situacion_ocupacional'),
            'paciente_otros' => $request->input('paciente_otros'),

            // Datos de la pareja
            'pareja_nombres' => $request->input('pareja_nombres'),
            'pareja_ap_paterno' => $request->input('pareja_ap_paterno'),
            'pareja_ap_materno' => $request->input('pareja_ap_materno'),
            'pareja_ci' => $request->input('pareja_ci'),
            'pareja_telefono' => $request->input('pareja_telefono'),
            'pareja_calle' => $request->input('pareja_calle'),
            'pareja_numero' => $request->input('pareja_numero'),
            'pareja_zona' => $request->input('pareja_zona'),
            'pareja_id_distrito' => $request->input('pareja_id_distrito'),
            'pareja_estado_civil' => $request->input('pareja_estado_civil'),
            'pareja_sexo' => $request->input('pareja_sexo'),
            'pareja_lugar_nacimiento' => $request->input('pareja_lugar_nacimiento'),
            'pareja_lugar_nacimiento_op' => $request->input('pareja_lugar_nacimiento_op'),
            'pareja_edad_rango' => $request->input('pareja_edad_rango'),
            'pareja_nivel_instruccion' => $request->input('pareja_nivel_instruccion'),
            'pareja_ocupacion_principal' => $request->input('pareja_ocupacion_principal'),
            'pareja_situacion_ocupacional' => $request->input('pareja_situacion_ocupacional'),
            'pareja_parentesco' => $request->input('pareja_parentesco'),
            'pareja_residencia' => $request->input('pareja_residencia'),
            'pareja_tiempo_residencia' => $request->input('pareja_tiempo_residencia'),
            'pareja_anos_convivencia' => $request->input('pareja_anos_convivencia'),
            'pareja_idioma' => $request->input('pareja_idioma'),
            'pareja_especificar_idioma' => $request->input('pareja_especificar_idioma'),
            'pareja_otros' => $request->input('pareja_otros'),

            // Hijos
            'hijos_num_gestacion' => $request->input('hijos_num_gestacion'),
            'hijos_dependencia' => $request->input('hijos_dependencia'),
            'hijos_edad_menor4_femenino' => $request->input('hijos_edad_menor4_femenino'),
            'hijos_edad_menor4_masculino' => $request->input('hijos_edad_menor4_masculino'),
            'hijos_edad_5_10_femenino' => $request->input('hijos_edad_5_10_femenino'),
            'hijos_edad_5_10_masculino' => $request->input('hijos_edad_5_10_masculino'),
            'hijos_edad_11_15_femenino' => $request->input('hijos_edad_11_15_femenino'),
            'hijos_edad_11_15_masculino' => $request->input('hijos_edad_11_15_masculino'),
            'hijos_edad_16_20_femenino' => $request->input('hijos_edad_16_20_femenino'),
            'hijos_edad_16_20_masculino' => $request->input('hijos_edad_16_20_masculino'),
            'hijos_edad_21_mas_femenino' => $request->input('hijos_edad_21_mas_femenino'),
            'hijos_edad_21_mas_masculino' => $request->input('hijos_edad_21_mas_masculino'),

            // Violencia
            'violencia_tipo_fisica' => $request->boolean('violencia_tipo_fisica'),
            'violencia_tipo_psicologica' => $request->boolean('violencia_tipo_psicologica'),
            'violencia_tipo_sexual' => $request->boolean('violencia_tipo_sexual'),
            'violencia_tipo_patrimonial' => $request->boolean('violencia_tipo_patrimonial'),
            'violencia_tipo_economica' => $request->boolean('violencia_tipo_economica'),
            'violencia_frecuencia' => $request->input('violencia_frecuencia'),
            'violencia_lugar_hechos' => $request->input('violencia_lugar_hechos'),
            'violencia_tiempo_ocurrencia' => $request->input('violencia_tiempo_ocurrencia'),
            'violencia_descripcion_hechos' => $request->input('violencia_descripcion_hechos'),
            'violencia_frecuancia_agresion' => $request->input('violencia_frecuancia_agresion'),
            'violencia_medidas_tomar' => $request->input('violencia_medidas_tomar'),
            'violencia_denuncia_previa' => $request->boolean('violencia_denuncia_previa'),
            'violencia_institucion_denuncia' => $request->input('violencia_institucion_denuncia'),
        ]);
        // =====================
        // PREPARAR DATOS
        // =====================
        $data = [];
        $data['tipo_atencion'] = $request->input('tipo_atencion');
        // REGIONAL
        $data['regional_recibe_caso'] = $request->input('regional_recibe_caso');
        $data['regional_fecha'] = $request->input('regional_fecha');
        $data['regional_institucion_derivante'] = $request->input('regional_institucion_derivante');

        // NÚMERO DE REGISTRO (manual o automático)
        if ($request->tipo_registro === 'manual') {
            $data['nro_registro'] = $request->input('nro_registro_manual_input');
            $data['nro_registro_manual'] = true;
        } else {
            $data['nro_registro_manual'] = false;
        }

        // DATOS DEL PACIENTE
        $data['paciente_nombres'] = $request->input('paciente_nombres');
        $data['paciente_ap_paterno'] = $request->input('paciente_ap_paterno');
        $data['paciente_ap_materno'] = $request->input('paciente_ap_materno');
        $data['paciente_edad'] = $request->input('paciente_edad');
        $data['paciente_ci'] = $request->input('paciente_ci');
        $data['paciente_telefono'] = $request->input('paciente_telefono');
        $data['paciente_calle'] = $request->input('paciente_calle');
        $data['paciente_numero'] = $request->input('paciente_numero');
        $data['paciente_zona'] = $request->input('paciente_zona');
        $data['paciente_id_distrito'] = $request->input('paciente_id_distrito');
        $data['paciente_estado_civil'] = $request->input('paciente_estado_civil');
        $data['paciente_sexo'] = $request->input('paciente_sexo');
        $data['paciente_lugar_nacimiento'] = $request->input('paciente_lugar_nacimiento');
        $data['paciente_lugar_nacimiento_op'] = $request->input('paciente_lugar_nacimiento_op');
        $data['paciente_lugar_residencia_op'] = $request->input('paciente_lugar_residencia_op');
        $data['paciente_tiempo_residencia_op'] = $request->input('paciente_tiempo_residencia_op');
        $data['paciente_edad_rango'] = $request->input('paciente_edad_rango');
        $data['paciente_nivel_instruccion'] = $request->input('paciente_nivel_instruccion');
        $data['paciente_idioma_mas_hablado'] = $request->input('paciente_idioma_mas_hablado');
        $data['paciente_ocupacion'] = $request->input('paciente_ocupacion');
        $data['paciente_situacion_ocupacional'] = $request->input('paciente_situacion_ocupacional');
        $data['paciente_otros'] = $request->input('paciente_otros');

        // DATOS DE LA PAREJA
        $data['pareja_nombres'] = $request->input('pareja_nombres');
        $data['pareja_ap_paterno'] = $request->input('pareja_ap_paterno');
        $data['pareja_ap_materno'] = $request->input('pareja_ap_materno');
        $data['pareja_ci'] = $request->input('pareja_ci');
        $data['pareja_telefono'] = $request->input('pareja_telefono');
        $data['pareja_calle'] = $request->input('pareja_calle');
        $data['pareja_numero'] = $request->input('pareja_numero');
        $data['pareja_zona'] = $request->input('pareja_zona');
        $data['pareja_id_distrito'] = $request->input('pareja_id_distrito');
        $data['pareja_estado_civil'] = $request->input('pareja_estado_civil');
        $data['pareja_sexo'] = $request->input('pareja_sexo');
        $data['pareja_lugar_nacimiento'] = $request->input('pareja_lugar_nacimiento');
        $data['pareja_lugar_nacimiento_op'] = $request->input('pareja_lugar_nacimiento_op');
        $data['pareja_edad_rango'] = $request->input('pareja_edad_rango');
        $data['pareja_nivel_instruccion'] = $request->input('pareja_nivel_instruccion');
        $data['pareja_ocupacion_principal'] = $request->input('pareja_ocupacion_principal');
        $data['pareja_situacion_ocupacional'] = $request->input('pareja_situacion_ocupacional');
        $data['pareja_parentesco'] = $request->input('pareja_parentesco');
        $data['pareja_residencia'] = $request->input('pareja_residencia');
        $data['pareja_tiempo_residencia'] = $request->input('pareja_tiempo_residencia');
        $data['pareja_anos_convivencia'] = $request->input('pareja_anos_convivencia');
        $data['pareja_idioma'] = $request->input('pareja_idioma');
        $data['pareja_especificar_idioma'] = $request->input('pareja_especificar_idioma');
        $data['pareja_otros'] = $request->input('pareja_otros');

        // HIJOS
        $data['hijos_num_gestacion'] = $request->input('hijos_num_gestacion');
        $data['hijos_dependencia'] = $request->input('hijos_dependencia');
        $data['hijos_menor4_m'] = count($request->input('hijos_menor4_m', []));
        $data['hijos_menor4_f'] = count($request->input('hijos_menor4_f', []));
        $data['hijos_5a10_m'] = count($request->input('hijos_5a10_m', []));
        $data['hijos_5a10_f'] = count($request->input('hijos_5a10_f', []));
        $data['hijos_11a15_m'] = count($request->input('hijos_11a15_m', []));
        $data['hijos_11a15_f'] = count($request->input('hijos_11a15_f', []));
        $data['hijos_16a20_m'] = count($request->input('hijos_16a20_m', []));
        $data['hijos_16a20_f'] = count($request->input('hijos_16a20_f', []));
        $data['hijos_21mas_m'] = count($request->input('hijos_21mas_m', []));
        $data['hijos_21mas_f'] = count($request->input('hijos_21mas_f', []));

        // =====================
        // CHECKBOXES (booleanos)
        // =====================
        $checkboxes = [


            // Tipos de violencia
            'violencia_tipo_fisica',
            'violencia_tipo_psicologica',
            'violencia_tipo_sexual',
            'violencia_tipo_patrimonial',
            'violencia_tipo_economica',

            // Razones de no denuncia
            'violencia_no_denuncia_por_amenaza',
            'violencia_no_denuncia_por_temor',
            'violencia_no_denuncia_por_verguenza',
            'violencia_no_denuncia_por_desconocimiento',
            'violencia_no_denuncia_no_sabe_no_responde',

            // Atención demandada
            'violencia_atencion_apoyo_victima',
            'violencia_atencion_apoyo_pareja',
            'violencia_atencion_apoyo_agresor',
            'violencia_atencion_apoyo_hijos',
        ];

        foreach ($checkboxes as $campo) {
            $data[$campo] = $request->has($campo);
        }

        // RADIOS
        $data['violencia_denuncia_previa'] = $request->input('violencia_denuncia_previa');

        // CAMPOS FINALES
        $data['violencia_tipo'] = $request->input('violencia_tipo');
        $data['violencia_frecuancia_agresion'] = $request->input('violencia_frecuancia_agresion');
        $data['violencia_motivo_agresion'] = $request->input('violencia_motivo_agresion');
        $data['violencia_motivo_otros'] = $request->input('violencia_motivo_otros');
        $data['violencia_descripcion_hechos'] = $request->input('violencia_descripcion_hechos');
        $data['violencia_institucion_denuncia'] = $request->input('violencia_institucion_denuncia');
        $data['violencia_medidas_tomar'] = $request->input('violencia_medidas_tomar');
        $data['formulario_responsable_nombre'] = $request->input('formulario_responsable_nombre');

        try {
            $caso->update($data);

            return redirect()->route('casos.index')
                ->with('success', "Caso actualizado exitosamente con número: {$caso->nro_registro}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el caso: ' . $e->getMessage());
        }
        return redirect()->route('casos.index')
            ->with('success', 'El caso fue actualizado correctamente.');
    }


    /**
     * Elimina un caso.
     */
    public function destroy(Caso $caso)
    {
        $caso->delete();
        return redirect()->route('casos.index')
            ->with('success', 'El caso fue eliminado correctamente.');
    }




    //********FICHA PRELIMINAR hombres - agresor */

    // Guardar ficha
    public function guardarFichaPreliminarHGV(Request $request, $caso_id)
    {
        $caso = Caso::findOrFail($caso_id);

        $validated = $request->validate([
            'nro_registro' => 'nullable|string|max:255',
            'nombre_completo' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string|max:255',
            'telf_emergencia' => 'nullable|string|max:20',
            'relacion_emergencia' => 'nullable|string|max:255',
            'grupo_familiar' => 'nullable|array',
            'fase.primera' => 'nullable|string',
            'fase.segunda' => 'nullable|string',
            'fase.tercera' => 'nullable|string',
            'fase.cuarta' => 'nullable|string',
            'indicadores' => 'nullable|array',
            'observaciones' => 'nullable|string',
            'medidasTomar' => 'nullable|string',
            'recepcionador' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
        ]);

        FichaAgresor::create([
            'caso_id' => $caso_id,
            'nro_registro' => $caso->nro_registro,
            'nombre_completo' => trim($caso->paciente_nombres . ' ' . $caso->paciente_ap_paterno . ' ' . $caso->paciente_ap_materno),
            'contacto_emergencia' => $validated['contacto_emergencia'] ?? null,
            'telf_emergencia' => $validated['telf_emergencia'] ?? null,
            'relacion_emergencia' => $validated['relacion_emergencia'] ?? null,
            'grupo_familiar' => $validated['grupo_familiar'] ?? [],
            'fase_primera' => $validated['fase']['primera'] ?? null,
            'fase_segunda' => $validated['fase']['segunda'] ?? null,
            'fase_tercera' => $validated['fase']['tercera'] ?? null,
            'fase_cuarta' => $validated['fase']['cuarta'] ?? null,
            'indicadores' => $validated['indicadores'] ?? [],
            'observaciones' => $validated['observaciones'] ?? null,
            'medidas_tomar' => $validated['medidasTomar'] ?? null,
            'recepcionador' => $validated['recepcionador'] ?? null,
            'fecha' => $validated['fecha'] ?? now(),
        ]);

        return redirect()
            ->route('casos.fichaPreliminarAgresor', $caso_id)
            ->with('success', 'Ficha de evaluación preliminar guardada correctamente.');
    }
    // Para actualizar PUT
    public function actualizarFichaPreliminarHGV(Request $request, $caso_id, $ficha_id)
    {
        $ficha = FichaAgresor::findOrFail($ficha_id);

        $validated = $request->validate([
            'nro_registro' => 'nullable|string|max:255',
            'nombre_completo' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string|max:255',
            'telf_emergencia' => 'nullable|string|max:20',
            'relacion_emergencia' => 'nullable|string|max:255',
            'grupo_familiar' => 'nullable|array',
            'fase.primera' => 'nullable|string',
            'fase.segunda' => 'nullable|string',
            'fase.tercera' => 'nullable|string',
            'fase.cuarta' => 'nullable|string',
            'indicadores' => 'nullable|array',
            'observaciones' => 'nullable|string',
            'medidasTomar' => 'nullable|string',
            'recepcionador' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
        ]);

        $ficha->update([
            'contacto_emergencia' => $validated['contacto_emergencia'] ?? null,
            'telf_emergencia' => $validated['telf_emergencia'] ?? null,
            'relacion_emergencia' => $validated['relacion_emergencia'] ?? null,
            'grupo_familiar' => $validated['grupo_familiar'] ?? [],
            'fase_primera' => $validated['fase']['primera'] ?? null,
            'fase_segunda' => $validated['fase']['segunda'] ?? null,
            'fase_tercera' => $validated['fase']['tercera'] ?? null,
            'fase_cuarta' => $validated['fase']['cuarta'] ?? null,
            'indicadores' => $validated['indicadores'] ?? [],
            'observaciones' => $validated['observaciones'] ?? null,
            'medidas_tomar' => $validated['medidasTomar'] ?? null,
            'recepcionador' => $validated['recepcionador'] ?? null,
            'fecha' => $validated['fecha'] ?? now(),
        ]);

        return redirect()->route('casos.index', $caso_id)
            ->with('success', 'Ficha actualizada correctamente.');
    }



    // Mostrar ficha guardada
    public function verFichaPreliminarHGV($id)
    {
        $caso = Caso::findOrFail($id);
        $ficha = FichaAgresor::where('caso_id', $id)->latest()->first();

        return view('casos.fichaPreliminarAgresor', compact('caso', 'ficha'));
    }

    public function fichaPreliminarAgresor($caso_id)
    {
        $caso = Caso::findOrFail($caso_id); // Buscar el caso específico
        $ficha = FichaAgresor::where('caso_id', $caso_id)->latest()->first();
        return view('casos.fichaPreliminarAgresor', compact('caso', 'ficha'));
    }
    /**
     * ========================================
     *  FICHA PRELIMINAR - PAREJA
     * ========================================
     */

    // 🔹 Muestra el formulario de ficha preliminar de pareja
    public function fichaPreliminarPareja($id)
    {
        $caso = Caso::findOrFail($id);
        $ficha = \App\Models\FichaPareja::where('caso_id', $caso->id)->first(); // Para edición
        return view('casos.fichaPreliminarPareja', compact('caso', 'ficha'));
    }

    // 🔹 Guarda la ficha de pareja en la base de datos
    public function storeFichaPreliminarPareja(Request $request, $casoId)
    {
        $caso = Caso::findOrFail($casoId);

        $validated = $request->validate([
            'observaciones' => 'nullable|string',
            'grupo_familiar' => 'nullable|array',
            'grupo_familiar.*.nombre' => 'nullable|string',
            'grupo_familiar.*.parentesco' => 'nullable|string',
            'grupo_familiar.*.edad' => 'nullable|integer',
            'grupo_familiar.*.sexo' => 'nullable|string',
            'grupo_familiar.*.grado' => 'nullable|string',
            'grupo_familiar.*.estado_civil' => 'nullable|string',
            'grupo_familiar.*.ocupacion' => 'nullable|string',
            'grupo_familiar.*.lugar' => 'nullable|string',
            'grupo_familiar.*.observacion' => 'nullable|string',
            'indicadores_pareja' => 'nullable|array',
            'indicadores_hijos' => 'nullable|array',
            'fase.primera' => 'nullable|string',
            'fase.segunda' => 'nullable|string',
            'fase.tercera' => 'nullable|string',
            'fase.cuarta' => 'nullable|string',
            'observacion_fase' => 'nullable|string',
            'medidas' => 'nullable|string',
            'fecha' => 'nullable|date',
            'responsable' => 'nullable|string|max:255',
        ]);

        // 🔹 updateOrCreate: actualiza si existe, crea si no
        \App\Models\FichaPareja::updateOrCreate(
            ['caso_id' => $caso->id],
            [
                'nro_caso' => $caso->nro_registro,
                'nombres_apellidos' => trim($caso->paciente_nombres . ' ' . $caso->paciente_apellidos),
                'observaciones' => $validated['observaciones'] ?? null,
                'grupo_familiar' => $validated['grupo_familiar'] ?? null,
                'indicadores_pareja' => $validated['indicadores_pareja'] ?? null,
                'indicadores_hijos' => $validated['indicadores_hijos'] ?? null,
                'fase_primera' => $validated['fase']['primera'] ?? null,
                'fase_segunda' => $validated['fase']['segunda'] ?? null,
                'fase_tercera' => $validated['fase']['tercera'] ?? null,
                'fase_cuarta' => $validated['fase']['cuarta'] ?? null,
                'observacion_fase' => $validated['observacion_fase'] ?? null,
                'medidas' => $validated['medidas'] ?? null,
                'fecha' => $validated['fecha'] ?? now(),
                'responsable' => $validated['responsable'] ?? null,
            ]
        );

        return redirect()->route('casos.index', $caso->id)
            ->with('success', 'Ficha de evaluación preliminar de pareja guardada correctamente.');
    }



    /*?**qe   FICHA PRELIMINAR VICTIMA */
    public function fichaPreliminarVictima($id)
    {
        $caso = Caso::findOrFail($id); // Buscar el caso específico
        $ficha = \App\Models\FichaVictima::where('caso_id', $id)->first();
        return view('casos.fichaPreliminarVictima', compact('caso', 'ficha'));
    }
    // 🔹 Guardar ficha
    public function storeFichaPreliminarVIF(Request $request, $casoId)
    {
        $caso = Caso::findOrFail($casoId);

        $validated = $request->validate([
            'nro_caso' => 'nullable|string|max:50',
            'nombres_apellidos' => 'nullable|string|max:255',
            'emergencia_nombre' => 'nullable|string|max:255',
            'emergencia_telefono' => 'nullable|string|max:50',
            'emergencia_parentesco' => 'nullable|string|max:100',
            'grupo_familiar' => 'nullable|array',
            'grupo_familiar.*.nombre' => 'nullable|string',
            'grupo_familiar.*.parentesco' => 'nullable|string',
            'grupo_familiar.*.edad' => 'nullable|integer',
            'grupo_familiar.*.sexo' => 'nullable|string',
            'grupo_familiar.*.grado' => 'nullable|string',
            'grupo_familiar.*.estado_civil' => 'nullable|string',
            'grupo_familiar.*.ocupacion' => 'nullable|string',
            'grupo_familiar.*.lugar' => 'nullable|string',
            'grupo_familiar.*.observacion' => 'nullable|string',
            'indicadores_decision' => 'nullable|array',
            'indicadores_persona' => 'nullable|array',
            'indicadores_derechos' => 'nullable|array',
            'fases' => 'nullable|array',
            'observaciones' => 'nullable|string',
            'medidas' => 'nullable|string',
            'fecha' => 'nullable|date',
            'recepcion' => 'nullable|string|max:255',
        ]);

        // 🔹 Verificar si ya existe una ficha para este caso
        $ficha = FichaVictima::where('caso_id', $casoId)->first();

        if ($ficha) {
            // Si ya existe, actualizamos
            $ficha->update([
                'nro_caso' => $validated['nro_caso'] ?? $caso->nro_registro,
                'nombres_apellidos' => $validated['nombres_apellidos'] ?? trim($caso->paciente_nombres . ' ' . $caso->paciente_apellidos),
                'emergencia_nombre' => $validated['emergencia_nombre'] ?? null,
                'emergencia_telefono' => $validated['emergencia_telefono'] ?? null,
                'emergencia_parentesco' => $validated['emergencia_parentesco'] ?? null,
                'grupo_familiar' => $validated['grupo_familiar'] ?? null,
                'indicadores_decision' => $validated['indicadores_decision'] ?? null,
                'indicadores_persona' => $validated['indicadores_persona'] ?? null,
                'indicadores_derechos' => $validated['indicadores_derechos'] ?? null,
                'fases' => $validated['fases'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'medidas' => $validated['medidas'] ?? null,
                'fecha' => $validated['fecha'] ?? now(),
                'recepcion' => $validated['recepcion'] ?? null,
            ]);

            $mensaje = 'Ficha actualizada correctamente.';
        } else {
            // Si no existe, creamos una nueva
            FichaVictima::create([
                'caso_id' => $caso->id,
                'nro_caso' => $validated['nro_caso'] ?? $caso->nro_registro,
                'nombres_apellidos' => $validated['nombres_apellidos'] ?? trim($caso->paciente_nombres . ' ' . $caso->paciente_apellidos),
                'emergencia_nombre' => $validated['emergencia_nombre'] ?? null,
                'emergencia_telefono' => $validated['emergencia_telefono'] ?? null,
                'emergencia_parentesco' => $validated['emergencia_parentesco'] ?? null,
                'grupo_familiar' => $validated['grupo_familiar'] ?? null,
                'indicadores_decision' => $validated['indicadores_decision'] ?? null,
                'indicadores_persona' => $validated['indicadores_persona'] ?? null,
                'indicadores_derechos' => $validated['indicadores_derechos'] ?? null,
                'fases' => $validated['fases'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'medidas' => $validated['medidas'] ?? null,
                'fecha' => $validated['fecha'] ?? now(),
                'recepcion' => $validated['recepcion'] ?? null,
            ]);

            $mensaje = 'Ficha de evaluación preliminar guardada correctamente.';
        }

        return redirect()
            ->route('casos.index')
            ->with('success', $mensaje);
    }
    // 🔹 Método separado para actualización directa (si usas PUT)
    public function updateFichaPreliminarVIF(Request $request, $id)
    {
        $ficha = FichaVictima::findOrFail($id);

        $validated = $request->validate([
            'emergencia_nombre' => 'nullable|string|max:255',
            'emergencia_telefono' => 'nullable|string|max:50',
            'emergencia_parentesco' => 'nullable|string|max:100',
            'grupo_familiar' => 'nullable|array',
            'indicadores_decision' => 'nullable|array',
            'indicadores_persona' => 'nullable|array',
            'indicadores_derechos' => 'nullable|array',
            'fases' => 'nullable|array',
            'observaciones' => 'nullable|string',
            'medidas' => 'nullable|string',
            'fecha' => 'nullable|date',
            'recepcion' => 'nullable|string|max:255',
        ]);

        $ficha->update($validated);

        return redirect()
            ->route('casos.index')
            ->with('success', 'Ficha actualizada correctamente.');
    }
    public function exportarPDF($id)
    {
        $caso = Caso::findOrFail($id);
        $pdf = Pdf::loadView('casos.pdf', compact('caso'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('Ficha_Caso_' . $caso->nro_registro . '.pdf');
    }
}

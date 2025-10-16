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
            // REGIONAL
            'regional_recibe_caso' => 'required|string|max:255',
            'regional_fecha' => 'required|date',
            'regional_institucion_derivante' => 'required|string|max:255',
            'tipo_registro' => 'required|in:automatico,manual',
            'nro_registro_manual_input' => [
                'required_if:tipo_registro,manual',
                'nullable',
                'regex:/^FLM-\d{8}$/',
                'unique:casos,nro_registro'
            ],

            // PACIENTE
            'paciente_nombres' => 'required|string|max:255',
            'paciente_apellidos' => 'required|string|max:255',
            'paciente_sexo' => 'required|in:M,F',
            'paciente_edad_rango' => 'required|string',
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
            'paciente_ocupacion' => 'required|string',
            'paciente_situacion_ocupacional' => 'required|string',

            // PAREJA
            'pareja_nombres' => 'required|string|max:255',
            'pareja_apellidos' => 'required|string|max:255',
            'pareja_sexo' => 'required|in:M,F',
            'pareja_edad_rango' => 'required|string',
            'pareja_ci' => 'nullable|string|max:50',
            'pareja_telefono' => 'nullable|string|max:50',
            'pareja_id_distrito' => 'required|string',
            'pareja_zona' => 'nullable|string|max:255',
            'pareja_calle' => 'nullable|string|max:255',
            'pareja_numero' => 'nullable|string|max:50',
            'pareja_otros' => 'nullable|string',
            'pareja_lugar_nacimiento' => 'nullable|string|max:255',
            'pareja_lugar_nacimiento_op' => 'required|in:dentro,fuera',
            'pareja_residencia' => 'required|string',
            'pareja_tiempo_residencia' => 'required|string',
            'pareja_estado_civil' => 'required|string',
            'pareja_nivel_instruccion' => 'required|string',
            'pareja_idioma' => 'required|string',
            'pareja_especificar_idioma' => 'nullable|string|max:255',
            'pareja_ocupacion_principal' => 'required|string',
            'pareja_situacion_ocupacional' => 'required|string',
            'pareja_parentesco' => 'required|string',
            'pareja_anos_convivencia' => 'required|string',

            // HIJOS
            'hijos_num_gestacion' => 'nullable|string',
            'hijos_dependencia' => 'nullable|string',

            // VIOLENCIA
            'violencia_tipo' => 'required|string',
            'violencia_frecuancia_agresion' => 'required|string',
            'violencia_denuncia_previa' => 'required|in:si,no',
            'violencia_motivo_agresion' => 'required|string',
            'violencia_motivo_otros' => 'nullable|string|max:500',
            'violencia_descripcion_hechos' => 'nullable|string',
            'violencia_institucion_denuncia' => 'nullable|string|max:500',
            'formulario_responsable_nombre' => 'nullable|string|max:255',
        ], [
            // MENSAJES PERSONALIZADOS
            'nro_registro_manual_input.regex' => 'El formato debe ser FLM-YYNNNNNN (ej: FLM-23000001)',
            'nro_registro_manual_input.unique' => 'Este número de registro ya existe',
            'nro_registro_manual_input.required_if' => 'Debe ingresar el número de registro manualmente',
            'paciente_nombres.required' => 'El nombre del paciente es obligatorio',
            'paciente_apellidos.required' => 'Los apellidos del paciente son obligatorios',
            'regional_recibe_caso.required' => 'Debe indicar la regional que recibe el caso',
        ]);

        // =====================
        // PREPARAR DATOS
        // =====================
        $data = [];

        // REGIONAL
        $data['regional_recibe_caso'] = $request->input('regional_recibe_caso');
        $data['regional_fecha'] = $request->input('regional_fecha');
        $data['regional_institucion_derivante'] = $request->input('regional_institucion_derivante');

        // NÚMERO DE REGISTRO
        if ($request->tipo_registro === 'manual') {
            $data['nro_registro'] = $request->input('nro_registro_manual_input');
            $data['nro_registro_manual'] = true;
        } else {
            // Se generará automáticamente en el modelo (boot method)
            $data['nro_registro_manual'] = false;
        }

        // DATOS DEL PACIENTE
        $data['paciente_nombres'] = $request->input('paciente_nombres');
        $data['paciente_apellidos'] = $request->input('paciente_apellidos');
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
        $data['pareja_apellidos'] = $request->input('pareja_apellidos');
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

        // HIJOS - Datos básicos
        $data['hijos_num_gestacion'] = $request->input('hijos_num_gestacion');
        $data['hijos_dependencia'] = $request->input('hijos_dependencia');

        // =====================
        // HIJOS - CHECKBOXES (Convertir a booleanos)
        // =====================
        $data['hijos_edad_menor4_masculino'] = $request->has('hijos_edad_menor4_masculino');
        $data['hijos_edad_menor4_femenino'] = $request->has('hijos_edad_menor4_femenino');
        $data['hijos_edad_5_10_masculino'] = $request->has('hijos_edad_5_10_masculino');
        $data['hijos_edad_5_10_femenino'] = $request->has('hijos_edad_5_10_femenino');
        $data['hijos_edad_11_15_masculino'] = $request->has('hijos_edad_11_15_masculino');
        $data['hijos_edad_11_15_femenino'] = $request->has('hijos_edad_11_15_femenino');
        $data['hijos_edad_16_20_masculino'] = $request->has('hijos_edad_16_20_masculino');
        $data['hijos_edad_16_20_femenino'] = $request->has('hijos_edad_16_20_femenino');
        $data['hijos_edad_21_mas_masculino'] = $request->has('hijos_edad_21_mas_masculino');
        $data['hijos_edad_21_mas_femenino'] = $request->has('hijos_edad_21_mas_femenino');

        // =====================
        // VIOLENCIA - TIPOS (Checkboxes)
        // =====================
        $data['violencia_tipo_fisica'] = $request->has('violencia_tipo_fisica');
        $data['violencia_tipo_psicologica'] = $request->has('violencia_tipo_psicologica');
        $data['violencia_tipo_sexual'] = $request->has('violencia_tipo_sexual');
        $data['violencia_tipo_patrimonial'] = $request->has('violencia_tipo_patrimonial');
        $data['violencia_tipo_economica'] = $request->has('violencia_tipo_economica');

        // VIOLENCIA - Datos generales
        $data['violencia_tipo'] = $request->input('violencia_tipo');
        $data['violencia_frecuancia_agresion'] = $request->input('violencia_frecuancia_agresion');
        $data['violencia_denuncia_previa'] = $request->input('violencia_denuncia_previa');
        $data['violencia_motivo_agresion'] = $request->input('violencia_motivo_agresion');
        $data['violencia_motivo_otros'] = $request->input('violencia_motivo_otros');
        $data['violencia_descripcion_hechos'] = $request->input('violencia_descripcion_hechos');

        // =====================
        // RAZONES DE NO DENUNCIA (Checkboxes)
        // =====================
        $data['violencia_no_denuncia_por_amenaza'] = $request->has('violencia_no_denuncia_por_amenaza');
        $data['violencia_no_denuncia_por_temor'] = $request->has('violencia_no_denuncia_por_temor');
        $data['violencia_no_denuncia_por_verguenza'] = $request->has('violencia_no_denuncia_por_verguenza');
        $data['violencia_no_denuncia_por_desconocimiento'] = $request->has('violencia_no_denuncia_por_desconocimiento');
        $data['violencia_no_denuncia_no_sabe_no_responde'] = $request->has('violencia_no_denuncia_no_sabe_no_responde');

        // =====================
        // ATENCIÓN DEMANDADA (Checkboxes)
        // =====================
        $data['violencia_atencion_apoyo_victima'] = $request->has('violencia_atencion_apoyo_victima');
        $data['violencia_atencion_apoyo_pareja'] = $request->has('violencia_atencion_apoyo_pareja');
        $data['violencia_atencion_apoyo_agresor'] = $request->has('violencia_atencion_apoyo_agresor');
        $data['violencia_atencion_apoyo_hijos'] = $request->has('violencia_atencion_apoyo_hijos');

        // CAMPOS FINALES
        $data['violencia_institucion_denuncia'] = $request->input('violencia_institucion_denuncia');
        $data['formulario_responsable_nombre'] = $request->input('formulario_responsable_nombre');

        // Campos legacy (si existen en tu migración)
        $data['violencia_frecuencia'] = $request->input('violencia_frecuencia');
        $data['violencia_lugar_hechos'] = $request->input('violencia_lugar_hechos');
        $data['violencia_tiempo_ocurrencia'] = $request->input('violencia_tiempo_ocurrencia');

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
        $proximoNumero = Caso::generarNumeroRegistro();
        return response()->json(['numero' => $proximoNumero]);
    }

    /**
     * Validar número de registro manual (AJAX)
     */
    public function validarNumeroRegistro(Request $request)
    {
        $numero = $request->input('numero');

        // Validar formato
        if (!Caso::validarFormatoRegistro($numero)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Formato incorrecto. Debe ser FLM-YYNNNNNN'
            ]);
        }

        // Validar si ya existe
        $existe = Caso::where('nro_registro', $numero)->exists();

        if ($existe) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Este número de registro ya existe'
            ]);
        }

        return response()->json([
            'valido' => true,
            'mensaje' => 'Número válido'
        ]);
    }

    /**
     * Muestra un caso específico.
     */
    public function show(Caso $caso)
    {
        //return view('casos.show', compact('caso'));
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
            'paciente_apellidos' => 'required|string|max:255',
        ]);

        // Actualizar todos los campos del caso
        $caso->update([
            // Datos del paciente
            'paciente_nombres' => $request->input('paciente_nombres'),
            'paciente_apellidos' => $request->input('paciente_apellidos'),
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
            'pareja_apellidos' => $request->input('pareja_apellidos'),
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
            'violencia_denuncia_previa' => $request->boolean('violencia_denuncia_previa'),
            'violencia_institucion_denuncia' => $request->input('violencia_institucion_denuncia'),
        ]);
        // =====================
        // PREPARAR DATOS
        // =====================
        $data = [];

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
        $data['paciente_apellidos'] = $request->input('paciente_apellidos');
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
        $data['pareja_apellidos'] = $request->input('pareja_apellidos');
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

        // =====================
        // CHECKBOXES (booleanos)
        // =====================
        $checkboxes = [
            // Hijos
            'hijos_edad_menor4_masculino',
            'hijos_edad_menor4_femenino',
            'hijos_edad_5_10_masculino',
            'hijos_edad_5_10_femenino',
            'hijos_edad_11_15_masculino',
            'hijos_edad_11_15_femenino',
            'hijos_edad_16_20_masculino',
            'hijos_edad_16_20_femenino',
            'hijos_edad_21_mas_masculino',
            'hijos_edad_21_mas_femenino',

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
}

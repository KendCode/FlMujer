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
    public function index()
    {
        $casos = Caso::latest()->paginate(10);
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
        // Validaciones básicas (puedes agregar más según tu necesidad)
        $request->validate([
            'paciente_nombres' => 'required|string|max:255',
            'paciente_apellidos' => 'required|string|max:255',
        ]);

        // Crear el caso con todos los datos enviados desde el formulario
        $caso = Caso::create([
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

        return redirect()->route('casos.index')
            ->with('success', 'El caso fue registrado correctamente.');
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

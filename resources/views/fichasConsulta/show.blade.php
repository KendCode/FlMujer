@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
            font-family: Arial, sans-serif;
        }

        .card {
            border-radius: 1.5rem;
            border: none;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        h3 {
            color: #037E8C;
            border-bottom: 3px solid #7EC544;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: bold;
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

        .btn-back {
            background-color: #037E8C;
            color: #fff;
            border-radius: 1rem;
            padding: 10px 25px;
            border: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #025F66;
        }

        .data-item {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <h3>Detalle de Ficha de Consulta</h3>

            <!-- Datos personales -->
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

            <!-- Institución y Testimonio -->
            <div class="section-title">Información de Derivación</div>
            <div class="data-item">
                <span class="info-label">Institución que Deriva:</span>
                <span class="info-value">{{ $ficha->instDeriva ?? 'No especificado' }}</span>
            </div>
            <div class="data-item">
                <span class="info-label">Testimonio:</span>
                <p class="info-value">{{ $ficha->testimonio ?? 'No registrado' }}</p>
            </div>

            <!-- Problemáticas -->
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

            <!-- Orientación Interna -->
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

            <!-- Botones -->
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('fichasConsulta.index') }}" class="btn btn-back">
                    ← Volver
                </a>

                <a href="{{ route('fichasConsulta.pdf', $ficha->idFicha) }}" target="_blank" class="btn btn-pdf">
                    🖨️ Imprimir PDF
                </a>
            </div>
        </div>
    </div>
@endsection

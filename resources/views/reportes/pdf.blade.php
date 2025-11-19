<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Casos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h3 { color: #037E8C; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #7EC544; padding: 5px; text-align: center; }
        th { background-color: #7EC544; color: #fff; }
        .grafico { margin-bottom: 30px; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📊 REPORTE DE CASOS DE VIOLENCIA</h2>
<p style="text-align:center;">
    Período: Últimos {{ $datosReporte['periodo'] ?? '-' }} meses 
    ({{ $datosReporte['fecha_inicio'] ?? '-' }} - {{ $datosReporte['fecha_fin'] ?? '-' }})
</p>
<p>Total de casos: {{ $datosReporte['total_casos'] ?? 0 }}</p>

@php
    // Función para imprimir arrays de forma segura
    function mostrar($dato) {
        if(is_array($dato)) return json_encode($dato, JSON_UNESCAPED_UNICODE);
        return $dato;
    }
@endphp

{{-- Casos por Tipo de Violencia --}}
<h3>Casos por Tipo de Violencia</h3>
@if(isset($datosReporte['violencia']) && is_array($datosReporte['violencia']))
<table>
    <thead>
        <tr><th>Tipo</th><th>Cantidad</th></tr>
    </thead>
    <tbody>
        @foreach($datosReporte['violencia'] as $tipo => $cantidad)
            <tr>
                <td>{{ mostrar($tipo) }}</td>
                <td>{{ mostrar($cantidad) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Evolución Mensual --}}
<h3>Evolución Mensual</h3>
@if(isset($datosReporte['meses']['labels'], $datosReporte['meses']['data']))
<table>
    <thead>
        <tr><th>Mes</th><th>Cantidad</th></tr>
    </thead>
    <tbody>
        @foreach($datosReporte['meses']['labels'] as $i => $mes)
            <tr>
                <td>{{ mostrar($mes) }}</td>
                <td>{{ mostrar($datosReporte['meses']['data'][$i] ?? 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Casos por Rango de Edad --}}
<h3>Casos por Rango de Edad</h3>
@if(isset($datosReporte['edad']['labels'], $datosReporte['edad']['data']))
<table>
    <thead>
        <tr><th>Rango de Edad</th><th>Cantidad</th></tr>
    </thead>
    <tbody>
        @foreach($datosReporte['edad']['labels'] as $i => $edad)
            <tr>
                <td>{{ mostrar($edad) }}</td>
                <td>{{ mostrar($datosReporte['edad']['data'][$i] ?? 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Casos por Sexo --}}
<h3>Casos por Sexo</h3>
@if(isset($datosReporte['sexo']) && is_array($datosReporte['sexo']))
<table>
    <thead>
        <tr><th>Sexo</th><th>Cantidad</th></tr>
    </thead>
    <tbody>
        @foreach($datosReporte['sexo'] as $sexo => $cantidad)
            <tr>
                <td>{{ mostrar($sexo) }}</td>
                <td>{{ mostrar($cantidad) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Casos por Tipo de Atención --}}
<h3>Casos por Tipo de Atención</h3>
@if(isset($datosReporte['atencion']['labels'], $datosReporte['atencion']['data']))
<table>
    <thead>
        <tr><th>Tipo</th><th>Cantidad</th></tr>
    </thead>
    <tbody>
        @foreach($datosReporte['atencion']['labels'] as $i => $tipo)
            <tr>
                <td>{{ mostrar($tipo) }}</td>
                <td>{{ mostrar($datosReporte['atencion']['data'][$i] ?? 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Gráficos --}}
<h3>Gráficos Estadísticos</h3>
<div class="grafico">
    @if(!empty($graficosRutas) && is_array($graficosRutas))
        @foreach($graficosRutas as $nombre => $ruta)
            @if(file_exists($ruta))
                <p><strong>{{ ucfirst($nombre) }}</strong></p>
                <img src="{{ $ruta }}" style="width:450px; height:300px;" />
            @endif
        @endforeach
    @endif
</div>

</body>
</html>

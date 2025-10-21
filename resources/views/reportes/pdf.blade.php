<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Casos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h3 { color: #037E8C; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #7EC544; padding: 5px; text-align: center; }
        th { background-color: #7EC544; color: #fff; }
        .grafico { margin-bottom: 30px; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">📊 REPORTE DE CASOS DE VIOLENCIA</h2>
<p style="text-align:center;">Período: Últimos {{ $datosReporte['periodo'] }} meses ({{ $datosReporte['fecha_inicio'] }} - {{ $datosReporte['fecha_fin'] }})</p>
<p>Total de casos: {{ $datosReporte['total_casos'] }}</p>

<h3>Casos por Tipo de Violencia</h3>
<table>
    <tr>
        <th>Tipo</th>
        <th>Cantidad</th>
    </tr>
    @foreach($datosReporte['violencia'] as $tipo => $cantidad)
        <tr>
            <td>{{ $tipo }}</td>
            <td>{{ $cantidad }}</td>
        </tr>
    @endforeach
</table>

<h3>Evolución Mensual</h3>
<table>
    <tr>
        <th>Mes</th>
        <th>Cantidad</th>
    </tr>
    @foreach($datosReporte['meses']['labels'] as $index => $mes)
        <tr>
            <td>{{ $mes }}</td>
            <td>{{ $datosReporte['meses']['data'][$index] }}</td>
        </tr>
    @endforeach
</table>

<h3>Casos por Rango de Edad</h3>
<table>
    <tr>
        <th>Rango de Edad</th>
        <th>Cantidad</th>
    </tr>
    @foreach($datosReporte['edad']['labels'] as $index => $edad)
        <tr>
            <td>{{ $edad }}</td>
            <td>{{ $datosReporte['edad']['data'][$index] }}</td>
        </tr>
    @endforeach
</table>

<h3>Casos por Sexo</h3>
<table>
    <tr>
        <th>Sexo</th>
        <th>Cantidad</th>
    </tr>
    @foreach($datosReporte['sexo'] as $sexo => $cantidad)
        <tr>
            <td>{{ $sexo }}</td>
            <td>{{ $cantidad }}</td>
        </tr>
    @endforeach
</table>

<h3>Casos por Tipo de Atención</h3>
<table>
    <tr>
        <th>Tipo</th>
        <th>Cantidad</th>
    </tr>
    @foreach($datosReporte['atencion']['labels'] as $index => $tipo)
        <tr>
            <td>{{ $tipo }}</td>
            <td>{{ $datosReporte['atencion']['data'][$index] }}</td>
        </tr>
    @endforeach
</table>

<h3>Gráficos Estadísticos</h3>
<div class="grafico">
    @if(!empty($graficosRutas['graficoSexo']))
        <img src="{{ $graficosRutas['graficoSexo'] }}" style="width:450px; height:300px;" />
    @endif
    @if(!empty($graficosRutas['graficoEdad']))
        <img src="{{ $graficosRutas['graficoEdad'] }}" style="width:450px; height:300px;" />
    @endif
    @if(!empty($graficosRutas['graficoViolencia']))
        <img src="{{ $graficosRutas['graficoViolencia'] }}" style="width:450px; height:300px;" />
    @endif
    @if(!empty($graficosRutas['graficoAtencion']))
        <img src="{{ $graficosRutas['graficoAtencion'] }}" style="width:450px; height:300px;" />
    @endif
    @if(!empty($graficosRutas['graficoMes']))
        <img src="{{ $graficosRutas['graficoMes'] }}" style="width:450px; height:300px;" />
    @endif
</div>

</body>
</html>

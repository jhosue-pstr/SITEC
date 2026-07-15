<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: letter; margin: 1.5cm 2cm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 9.5pt; color: #000; line-height: 1.4; }

        .header-title {
            font-size: 12pt; font-weight: bold; text-align: center;
            margin-bottom: 12px; padding-bottom: 8px;
            border-bottom: 2px solid #000;
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td, th {
            border: 1.5px solid #000; padding: 5px 8px; vertical-align: top;
            font-size: 9pt;
        }
        th { background-color: #f0f0f0; }

        .center { text-align: center; }
        .bold { font-weight: bold; }
        .label { font-weight: bold; white-space: nowrap; width: 18%; }
        .checkbox { font-size: 12pt; line-height: 1; }

        .section-gap { margin-top: 14px; }
        .subsection-label {
            font-size: 8.5pt; font-weight: bold; color: #444;
            margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .text-box {
            min-height: 65px; vertical-align: top; padding: 6px 8px;
            font-size: 9pt; line-height: 1.5;
        }
        .text-box-large { min-height: 80px; }

        .firmas-table td {
            border: none; width: 50%; text-align: center;
            padding: 0 15px; vertical-align: bottom;
        }
        .firma-img { max-height: 55px; max-width: 180px; margin-bottom: 4px; }
        .firma-line {
            border-bottom: 1px solid #000; margin: 0 10px 4px 10px;
        }
        .firma-label {
            font-size: 8.5pt; font-weight: bold; color: #333;
        }
        .firma-space { height: 55px; }
    </style>
</head>
<body>

<!-- ENCABEZADO -->
<div class="header-title">
    FORMATO: ATENCION EN SOPORTE TECNICO N.° {{ $formato->tarea->codigo ?? '__________' }}
</div>

<!-- DATOS PERSONALES -->
<table>
    <tr>
        <td colspan="4" class="center bold" style="background: #e8e8e8; font-size: 9.5pt;">
            DATOS PERSONALES DEL USUARIO
        </td>
    </tr>
    <tr>
        <td class="label">Nombres:</td>
        <td>{{ $formato->nombres_solicitante ?? '' }}</td>
        <td class="label">D.N.I.:</td>
        <td>{{ $formato->dni_solicitante ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Apellidos:</td>
        <td>{{ $formato->apellidos_solicitante ?? '' }}</td>
        <td class="label">Telefono movil:</td>
        <td>{{ $formato->telefono_movil ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="4" class="bold" style="background: #f5f5f5; font-size: 9pt;">Regimen laboral</td>
    </tr>
    <tr>
        <td colspan="4" style="padding: 6px 10px; line-height: 1.8;">
            <span class="checkbox">{{ in_array($formato->regimen_laboral ?? '', ['Nombrado']) ? '☒' : '☐' }}</span> Nombrado
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ in_array($formato->regimen_laboral ?? '', ['Permanente']) ? '☒' : '☐' }}</span> Permanente
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ in_array($formato->regimen_laboral ?? '', ['CAS', 'CAS Confianza']) ? '☒' : '☐' }}</span> CAS
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ ($formato->regimen_laboral ?? '') === 'CAS Confianza' ? '☒' : '☐' }}</span> CAS Confianza
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ !in_array($formato->regimen_laboral ?? '', ['Nombrado','Permanente','CAS','CAS Confianza','']) ? '☒' : '☐' }}</span> Otros: <span style="border-bottom: 1px solid #999; padding: 0 30px;">{{ !in_array($formato->regimen_laboral ?? '', ['Nombrado','Permanente','CAS','CAS Confianza','']) ? ($formato->regimen_laboral ?? '') : '' }}</span>
        </td>
    </tr>
    <tr>
        <td class="label">Cargo:</td>
        <td>{{ $formato->cargo ?? '' }}</td>
        <td class="label">Unidad de organizacion:</td>
        <td>{{ $formato->unidad_organizacion ?? '' }}</td>
    </tr>
</table>

<!-- DATOS EQUIPO -->
<div class="section-gap">
    <p class="subsection-label">Marcar con una aspa (X) segun la opcion que corresponda.</p>
</div>

<table>
    <tr>
        <td colspan="7" class="center bold" style="background: #e8e8e8; font-size: 9.5pt;">
            DATOS DEL EQUIPO Y TIPO DE SOPORTE INFORMATICO
        </td>
    </tr>
    <tr>
        <td colspan="7" style="padding: 6px 10px; line-height: 1.8;">
            <span class="checkbox">{{ ($formato->tipo_soporte_informatico ?? '') === 'hardware' ? '☒' : '☐' }}</span> Soporte tecnico
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ ($formato->tipo_soporte_informatico ?? '') === 'software' ? '☒' : '☐' }}</span> Soporte de sistemas
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="checkbox">{{ ($formato->tipo_soporte_informatico ?? '') === 'red' ? '☒' : '☐' }}</span> Soporte remoto
        </td>
    </tr>
    <tr>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Tipo de equipo</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Cod. patrimonial</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Numero de serie</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Marca</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Modelo</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Fecha atencion</td>
        <td class="center bold" style="font-size: 8pt; background: #f5f5f5;">Fecha entrega</td>
    </tr>
    <tr>
        <td class="center" style="height: 28px;">{{ $formato->tipo_equipo ?? '' }}</td>
        <td class="center">{{ $formato->codigo_patrimonial ?? '' }}</td>
        <td class="center">{{ $formato->numero_serie ?? '' }}</td>
        <td class="center">{{ $formato->marca ?? '' }}</td>
        <td class="center">{{ $formato->modelo ?? '' }}</td>
        <td class="center">{{ $formato->fecha_atencion ?? '' }}</td>
        <td class="center">{{ $formato->fecha_entrega ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="3" class="center bold" style="background: #f5f5f5; font-size: 9pt;">Reporte de usuario</td>
        <td colspan="4" class="center bold" style="background: #f5f5f5; font-size: 9pt;">Diagnostico tecnico</td>
    </tr>
    <tr>
        <td colspan="3" class="text-box text-box-large">{{ $formato->reporte_usuario ?? '' }}</td>
        <td colspan="4" class="text-box text-box-large">{{ $formato->diagnostico_tecnico ?? '' }}</td>
    </tr>
</table>

<!-- OBSERVACIONES -->
<table>
    <tr>
        <td class="center bold" style="background: #e8e8e8; font-size: 9.5pt;">OBSERVACIONES</td>
    </tr>
    <tr>
        <td class="text-box text-box-large">{{ $formato->observaciones ?? '' }}</td>
    </tr>
</table>

<!-- FIRMAS -->
<table class="firmas-table" style="margin-top: 35px;">
    <tr>
        <td>
            @if($formato->firma_responsable_url && file_exists(public_path('storage/' . $formato->firma_responsable_url)))
                <img src="{{ public_path('storage/' . $formato->firma_responsable_url) }}" class="firma-img">
            @else
                <div class="firma-space"></div>
            @endif
            <div class="firma-line"></div>
            <p class="firma-label">Firma del responsable del procedimiento</p>
        </td>
        <td>
            @if($formato->firma_solicitante_url && file_exists(public_path('storage/' . $formato->firma_solicitante_url)))
                <img src="{{ public_path('storage/' . $formato->firma_solicitante_url) }}" class="firma-img">
            @else
                <div class="firma-space"></div>
            @endif
            <div class="firma-line"></div>
            <p class="firma-label">Firma del solicitante</p>
        </td>
    </tr>
</table>

</body>
</html>

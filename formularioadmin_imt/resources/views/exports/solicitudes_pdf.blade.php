<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Servicios</title>
    <style>
        @page { margin: 10mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111827; }
        h2 { margin: 0 0 10px 0; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #e5e7eb; padding: 5px 6px; font-size: 11px; vertical-align: top; }
        th { background: #f3f4f6; text-align: left; }
        .nowrap { white-space: nowrap; }
        .break { word-break: break-all; overflow-wrap: anywhere; }
    </style>
    </head>
<body>
    <h2>Solicitudes de Servicios</h2>
    <table>
        <colgroup>
            <col style="width:6%" />
            <col style="width:16%" />
            <col style="width:10%" />
            <col style="width:20%" />
            <col style="width:10%" />
            <col style="width:10%" />
            <col style="width:10%" />
            <col style="width:8%" />
            <col style="width:5%" />
            <col style="width:5%" />
        </colgroup>
        <thead>
        <tr>
            <th class="nowrap">ID</th>
            <th>Nombre</th>
            <th class="nowrap">Teléfono</th>
            <th>Correo</th>
            <th>Entidad</th>
            <th>Servicio</th>
            <th>Coordinación</th>
            <th class="nowrap">Estatus</th>
            <th>Fecha de Solicitud</th>
            <th>Fecha atendida</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $s)
            @php
                $nombre = trim(($s->nombres ?? '') . ' ' . ($s->apellido_paterno ?? '') . ' ' . ($s->apellido_materno ?? ''));
                $entidad = $s->entidadProcedencia ? ($s->entidadProcedencia->nombre ?? '') : ($s->entidad_otra ?? '');
                $servicioNombre = $s->servicio ? ($s->servicio->nombre ?? '') : ($s->servicio_otro ?? '');
                $coordinacionNombre = $s->coordinacion ? ($s->coordinacion->nombre ?? '') : '';
                $estatusLabel = match ($s->estatus) {
                    'en_revision' => 'Por atender',
                    'revisado' => 'Atendido',
                    default => $s->estatus,
                };
            @endphp
            <tr>
                <td class="nowrap">{{ $s->id }}</td>
                <td>{{ $nombre }}</td>
                <td class="nowrap">{{ $s->telefono }}</td>
                <td class="break">{{ $s->correo_electronico }}</td>
                <td>{{ $entidad }}</td>
                <td>{{ $servicioNombre }}</td>
                <td>{{ $coordinacionNombre }}</td>
                <td class="nowrap">{{ $estatusLabel }}</td>
                <td>{{ optional($s->fecha_solicitud)->format('Y-m-d H:i') }}</td>
                <td>{{ optional($s->fecha_atendida)->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
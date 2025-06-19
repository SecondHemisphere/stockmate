<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Informe - Ventas</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            color: #333;
            padding: 40px 50px;
            background-color: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 90px;
            height: auto;
            margin-bottom: 12px;
        }

        .header .empresa {
            font-size: 20px;
            font-weight: bold;
            color: #0c68a0;
        }

        .header .titulo {
            font-size: 18px;
            color: #fabc07;
            margin-top: 5px;
        }

        .info {
            text-align: right;
            font-size: 12px;
            margin-top: -20px;
            margin-bottom: 25px;
            color: #555;
        }

        .info .filtros {
            text-align: left;
            margin-top: 10px;
            font-size: 12px;
            color: #0c68a0;
            border: 1px solid #0c68a0;
            padding: 8px 12px;
            border-radius: 6px;
            max-width: 600px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th {
            background-color: #0c68a0;
            color: #fff;
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
        }

        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 12px;
        }

        .footer strong {
            color: #0c68a0;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/logo_empresa.png') }}" alt="Logo Empresa">
        <div class="empresa">Papelería El Lápiz Veloz</div>
        <div class="titulo">Informe de Ventas</div>
    </div>

    <div class="info">
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Usuario:</strong> {{ auth()->user()->nombre ?? 'Sistema' }}</p>

        <div class="filtros">
            <strong>Filtros Aplicados:</strong><br>
            @if (request()->filled('fecha_inicio') && request()->filled('fecha_fin'))
                Rango de Fechas: {{ \Carbon\Carbon::parse(request('fecha_inicio'))->format('d/m/Y') }}
                - {{ \Carbon\Carbon::parse(request('fecha_fin'))->format('d/m/Y') }}<br>
            @else
                Rango de Fechas: <em>Todos</em><br>
            @endif

            @if (request()->filled('cliente_id'))
                Cliente: {{ optional(DB::table('clientes')->find(request('cliente_id')))->nombre ?? 'N/A' }}<br>
            @else
                Cliente: <em>Todos</em><br>
            @endif

            @if (request()->filled('usuario_id'))
                Usuario: {{ optional(DB::table('usuarios')->find(request('usuario_id')))->nombre ?? 'N/A' }}
            @else
                Usuario: <em>Todos</em>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Número Factura</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Monto Total</th>
                <th>Descuento</th>
                <th>Total con IVA</th>
                <th>Método de Pago</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</td>
                    <td style="text-align: center;">{{ $venta->numero_factura }}</td>
                    <td>{{ $venta->cliente_nombre ?? 'N/A' }}</td>
                    <td>{{ $venta->usuario_nombre ?? 'N/A' }}</td>
                    <td>${{ number_format($venta->monto_total, 2) }}</td>
                    <td>${{ number_format($venta->monto_descuento, 2) }}</td>
                    <td>${{ number_format($venta->total_con_iva, 2) }}</td>
                    <td>{{ ucfirst(strtolower(str_replace('_', ' ', $venta->metodo_pago))) }}</td>
                    <td>{{ $venta->observaciones ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Documento generado automáticamente por el sistema de inventario de <strong>El Lápiz Veloz</strong>.<br>
        © {{ date('Y') }} Todos los derechos reservados.
    </div>

</body>

</html>

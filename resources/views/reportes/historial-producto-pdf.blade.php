<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Informe - Historial de Producto</title>
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
        <div class="titulo">Historial de Producto</div>
    </div>

    <div class="info">
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Usuario:</strong> {{ auth()->user()->nombre ?? 'Sistema' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
                <th>Proveedor/Cliente</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $mov)
                <tr>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y H:i') }}</td>
                    <td>{{ $mov->producto_nombre }}</td>
                    <td style="text-align: center;">{{ $mov->tipo_movimiento }}</td>
                    <td style="text-align: center;">{{ $mov->cantidad }}</td>
                    <td style="text-align: right;">${{ number_format($mov->precio_unitario, 2, '.', ',') }}</td>
                    <td style="text-align: right;">${{ number_format($mov->precio_total, 2, '.', ',') }}</td>
                    <td>{{ $mov->relacionado }}</td>
                    <td>{{ $mov->usuario_nombre ?? '-' }}</td>
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

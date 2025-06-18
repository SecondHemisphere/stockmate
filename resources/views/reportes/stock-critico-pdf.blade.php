<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte - Stock Crítico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background-color: #fff;
            color: #333;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #faba08;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo-svg {
            width: 70px;
            height: 70px;
            fill: #0c68a0;
        }

        .title {
            text-align: center;
            color: #d32f2f;
            font-size: 20px;
            flex: 1;
        }

        .info {
            text-align: right;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th {
            background-color: #0c68a0;
            color: white;
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
        }

        td {
            border: 1px solid #e1d6b4;
            padding: 6px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #fdfaf3;
        }

        tr:hover {
            background-color: #f1f8fc;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #d8be55;
            padding-top: 10px;
        }

        .highlight {
            color: #c9a81f;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">
            <strong>Reporte de Productos con Stock Crítico</strong>
        </div>

        <div class="info">
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            <p><strong>Usuario:</strong> {{ auth()->user()->nombre ?? 'Sistema' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Categoría</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $i => $p)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td style="color: #d32f2f; font-weight: bold;">{{ $p->stock_actual }}</td>
                    <td>{{ $p->stock_minimo }}</td>
                    <td>{{ $p->categoria }}</td>
                    <td>{{ $p->proveedor }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Este documento ha sido generado automáticamente por el sistema de inventarios.</p>
        <p class="highlight">Empresa XYZ © {{ date('Y') }} - Todos los derechos reservados</p>
    </div>

</body>

</html>

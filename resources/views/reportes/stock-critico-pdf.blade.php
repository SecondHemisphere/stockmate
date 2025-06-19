<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Informe - Stock Crítico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .header .empresa {
            font-size: 18px;
            font-weight: bold;
            color: #0c68a0;
        }

        .header .titulo {
            font-size: 16px;
            color: #d32f2f;
            margin-top: 5px;
        }

        .info {
            text-align: right;
            font-size: 11px;
            margin-bottom: 20px;
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
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/logo_empresa.png') }}" alt="Logo Empresa">
        <div class="empresa">Papelería El Lápiz Veloz</div>
        <div class="titulo">Informe de Productos con Stock Crítico</div>
    </div>

    <div class="info">
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p><strong>Usuario:</strong> {{ auth()->user()->nombre ?? 'Sistema' }}</p>
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
        Documento generado automáticamente por el sistema de inventario de <strong>El Lápiz Veloz</strong>. <br>
        © {{ date('Y') }} Todos los derechos reservados.
    </div>

</body>

</html>

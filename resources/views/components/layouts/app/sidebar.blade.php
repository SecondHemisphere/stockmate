@php
    $groups = [
        'General' => [
            [
                'name' => 'Inicio',
                'icon' => 'home',
                'url' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
            ],
            [
                'name' => 'Usuarios',
                'icon' => 'user',
                'url' => route('usuarios.index'),
                'current' => request()->routeIs('usuarios.*'),
            ],
        ],
        'Gestión de Productos' => [
            [
                'name' => 'Categorías',
                'icon' => 'funnel',
                'url' => route('categorias.index'),
                'current' => request()->routeIs('categorias.*'),
            ],
            [
                'name' => 'Productos',
                'icon' => 'gift',
                'url' => route('productos.index'),
                'current' => request()->routeIs('productos.*'),
            ],
            [
                'name' => 'Proveedores',
                'icon' => 'truck',
                'url' => route('proveedores.index'),
                'current' => request()->routeIs('proveedores.*'),
            ],
        ],
        'Gestión de Clientes' => [
            [
                'name' => 'Clientes',
                'icon' => 'users',
                'url' => route('clientes.index'),
                'current' => request()->routeIs('clientes.*'),
            ],
        ],
        'Gestión de Existencias' => [
            [
                'name' => 'Entradas / Compras',
                'icon' => 'arrow-down',
                'url' => route('compras.index'),
                'current' => request()->routeIs('compras.*'),
            ],
            [
                'name' => 'Salidas / Facturación',
                'icon' => 'arrow-up',
                'url' => route('ventas.index'),
                'current' => request()->routeIs('ventas.*'),
            ],
        ],
        'Gestión de Reportes' => [
            [
                'name' => 'Reportes',
                'icon' => 'folder',
                'url' => route('reportes.index'),
                'current' => request()->routeIs('reportes.*'),
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        body {
            background-color: #e0f7fa;
        }
        /* === BARRA SUPERIOR === */
        header.topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background-color: #37474f;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 1100;
            user-select: none;
        }

        /* Logo en barra superior */
        header.topbar .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        header.topbar .logo-container svg {
            width: 32px;
            height: 32px;
            fill: #fff;
        }

        header.topbar .logo-container span {
            font-weight: 700;
            font-size: 20px;
            color: #fff;
        }

        /* Widget cuenta dentro barra superior */
        .account-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 15px;
            color: #fff;
            position: relative;
            cursor: pointer;
        }

        .user-initial {
            background-color: #00838f;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            user-select: none;
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            min-width: 160px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            display: none;
            margin-top: 6px;
            z-index: 1200;
        }

        .custom-dropdown-menu a,
        .custom-dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: #263238;
            font-size: 14px;
            white-space: nowrap;
        }

        .custom-dropdown-menu a:hover,
        .custom-dropdown-menu button:hover {
            background-color: #f5f5f5;
        }

        .custom-dropdown.open .custom-dropdown-menu {
            display: block;
        }

        /* === SIDEBAR === */
        .sidebar {
            position: fixed;
            top: 56px;
            /* debajo de la barra superior */
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #37474f;
            color: #cfd8dc;
            padding-top: 20px;
            overflow-y: auto;
            border-right: 1px solid #263238;
            z-index: 1000;
        }

        .sidebar .sidebar-header {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
            padding: 0 20px;
            color: #b0bec5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
            cursor: pointer;
        }

        .sidebar .nav-item {
            margin: 0;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 5px 20px;
            text-decoration: none;
            color: #ffffff;
            font-size: 15px;
            transition: background-color 0.3s ease;
            border-left: 5px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: #263238;
        }

        .sidebar .nav-link.current {
            background-color: #00838f;
            font-weight: 500;
            border-left-color: #ffffff;
        }

        .sidebar .nav-link svg {
            fill: #b0bec5;
            transition: fill 0.3s ease;
            margin-right: 8px;
            width: 18px;
            height: 18px;
        }

        .sidebar .nav-link:hover svg,
        .sidebar .nav-link.current svg {
            fill: #ffffff;
        }

        .sidebar a {
            text-decoration: none;
        }

        .nav-items {
            margin-bottom: 5px;
        }

        .nav-items.hidden-group {
            display: none;
        }

        /* === CONTENIDO PRINCIPAL === */
        .main-content {
            margin-left: 250px;
            margin-top: 50px;
            background-color: #e0f7fa;
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <!-- BARRA SUPERIOR -->
    <header class="topbar">
        <a href="{{ route('dashboard') }}" class="logo-container" title="StockMate">
            <x-app-logo-white />
            <span>StockMate</span>
        </a>

        <div class="account-widget custom-dropdown" id="accountDropdown">
            <div class="user-initial" onclick="toggleAccountDropdown()">
                {{ strtoupper(auth()->user()->nombre[0]) }}
            </div>
            <span class="user-name" onclick="toggleAccountDropdown()">{{ auth()->user()->nombre }}</span>
            <div class="custom-dropdown-menu" aria-label="Menú de usuario">
                <a href="{{ route('settings.profile') }}">Configuración</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <nav>
            @foreach ($groups as $group => $links)
                <div class="sidebar-group">
                    <div class="sidebar-header" onclick="toggleGroup('{{ Str::slug($group) }}')">
                        {{ $group }}
                        <span class="toggle-button" id="toggle-{{ Str::slug($group) }}">+</span>
                    </div>
                    <div class="nav-items {{ Str::slug($group) }} hidden-group">
                        @foreach ($links as $link)
                            <div class="nav-item">
                                <a href="{{ $link['url'] }}"
                                    class="nav-link {{ $link['current'] ? 'current' : '' }}">
                                    <x-icon name="{{ $link['icon'] }}" class="nav-link-icon" />
                                    <span>{{ $link['name'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        {{ $slot }}
    </main>

    <!-- JS -->
    <script>
        function toggleGroup(groupSlug) {
            const group = document.querySelector(`.${groupSlug}`);
            const toggleButton = document.getElementById(`toggle-${groupSlug}`);
            if (group.classList.contains('hidden-group')) {
                group.classList.remove('hidden-group');
                toggleButton.textContent = '-';
            } else {
                group.classList.add('hidden-group');
                toggleButton.textContent = '+';
            }
        }

        function toggleAccountDropdown() {
            document.getElementById('accountDropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('accountDropdown');
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const currentLink = document.querySelector('.nav-link.current');
            if (currentLink) {
                const navItems = currentLink.closest('.nav-items');
                if (navItems) {
                    navItems.classList.remove('hidden-group');

                    const groupSlug = navItems.classList[0];
                    const toggleButton = document.getElementById(`toggle-${groupSlug}`);
                    if (toggleButton) {
                        toggleButton.textContent = '-';
                    }
                }
            }
        });
    </script>
</body>

</html>

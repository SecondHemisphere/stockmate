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
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #e0f7fa; /* Un azul muy claro, casi blanco */
            color: #263238; 
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 250px; 
            background-color: #37474f; 
            color: #cfd8dc; 
            padding-top: 25px;
            overflow-y: auto;
            border-right: 1px solid #263238; 
        }

        .main-content {
            margin-left: 250px;
            padding: 5px; 
            background-color: #e0f7fa;
            flex-grow: 1;
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
        }

        .sidebar .nav-item {
            margin: 0px 0;
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

        .sidebar .nav-link-icon{
            color: #ffffff;
        }

        .sidebar .nav-link:hover {
            background-color: #263238;
            color: #fff;
        }

        .sidebar .nav-link.current {
            background-color: #00838f; 
            color: #fff;
            font-weight: 500;
            border-left-color: #fff;
        }

        .sidebar .nav-link svg {
            fill: #b0bec5; 
            transition: fill 0.3s ease;
        }

        .sidebar .nav-link:hover svg {
            fill: #fff;
        }

        .sidebar .nav-link.current svg {
            fill: #fff;
        }

        .sidebar-settings {
            padding: 20px;
            border-top: 1px solid #263238;
        }

        .custom-dropdown {
            position: relative;
        }

        .custom-dropdown-button {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            padding: 8px 0;
            color: #cfd8dc;
        }

        .user-initial {
            background-color: #00695c; 
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ddd;
            min-width: 180px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: none;
            z-index: 10;
        }

        .custom-dropdown-menu a,
        .custom-dropdown-menu button {
            display: block;
            width: 100%;
            padding: 12px 15px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: #263238;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .custom-dropdown-menu a:hover,
        .custom-dropdown-menu button:hover {
            background-color: #f5f5f5;
        }

        .toggle-button {
            cursor: pointer;
            font-size: 16px;
            color: #b0bec5;
        }

        .nav-items {
            margin-bottom: 5px;
        }

        .nav-items.hidden-group {
            display: none;
        }

        .sidebar a {
            text-decoration: none;
        }

        .sidebar .logo-container {
            display: flex;
            align-items: center;
            padding: 0 20px 25px;
        }

        .sidebar .logo-container svg {
            width: 36px;
            height: 36px;
            fill: #fff;
        }

        .sidebar .logo-container span {
            margin-left: 12px;
            font-weight: bold;
            font-size: 18px;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="logo-container">
            <x-app-logo-white />
            <span>StockMate</span>
        </a>

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
                                    <x-icon name="{{ $link['icon'] }}" style="width: 18px; height: 18px; margin-right: 8px;" class="nav-link-icon" />
                                    <span>{{ $link['name'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="sidebar-settings">
            <div class="custom-dropdown">
                <button class="custom-dropdown-button" onclick="toggleDropdown()">
                    <span class="user-initial">{{ strtoupper(auth()->user()->nombre[0]) }}</span>
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <div class="custom-dropdown-menu" id="userDropdown">
                    <a href="{{ route('settings.profile') }}">Configuración</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        {{ $slot }}
    </div>

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

        function toggleDropdown() {
            const menu = document.getElementById('userDropdown');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function (e) {
            const dropdown = document.querySelector('.custom-dropdown');
            const menu = document.getElementById('userDropdown');
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
        
        document.addEventListener('DOMContentLoaded', function () {
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

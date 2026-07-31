<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Crust & Co.</title>
    <!-- Google Fonts Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eefcf8',
                            100: '#d7f7ed',
                            500: '#0c4a3e',
                            800: '#003229',
                            900: '#00251e',
                        },
                        cream: {
                            50: '#fffbf7',
                            100: '#fff8f5',
                            200: '#f7eee7',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream-100 font-sans text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar Navigation (Fixed) -->
    <aside class="w-64 h-screen bg-brand-800 text-white flex flex-col shrink-0 shadow-2xl z-20">
        <!-- Brand Header -->
        <div class="p-6 border-b border-brand-500/40 flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-xl object-cover bg-white p-0.5 shadow-lg shadow-amber-500/20">
            <div>
                <h1 class="font-heading font-bold text-lg leading-tight tracking-wide text-white">Crust & Co.</h1>
                <p class="text-xs text-emerald-300 font-medium">Owner & Admin Portal</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <div class="px-3 py-2 text-xs font-semibold text-emerald-300 uppercase tracking-wider">Main Navigation</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-brand-900 font-bold shadow-md shadow-amber-500/20' : 'text-emerald-100 hover:bg-brand-500/50 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-base"></i>
                <span>Dashboard Overview</span>
            </a>

            <a href="{{ route('admin.products') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.products*') ? 'bg-amber-500 text-brand-900 font-bold shadow-md shadow-amber-500/20' : 'text-emerald-100 hover:bg-brand-500/50 hover:text-white' }}">
                <i class="fa-solid fa-bread-slice w-5 text-center text-base"></i>
                <span>Kelola Roti (CRUD)</span>
            </a>

            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('admin.orders*') ? 'bg-amber-500 text-brand-900 font-bold shadow-md shadow-amber-500/20' : 'text-emerald-100 hover:bg-brand-500/50 hover:text-white' }}">
                <i class="fa-solid fa-receipt w-5 text-center text-base"></i>
                <span>Kelola Pesanan</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-brand-500/40 space-y-3">
            <div class="bg-brand-900/60 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-emerald-700 flex items-center justify-center text-white font-bold text-sm">
                    {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'A' }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</p>
                    <p class="text-xs text-emerald-300 truncate">{{ Auth::check() ? Auth::user()->email : 'admin@tokoroti.com' }}</p>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-600/80 hover:bg-red-600 text-white font-bold text-xs transition-colors shadow-sm">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200/80 px-8 py-4 flex items-center justify-between shadow-sm">
            <div>
                <h2 class="font-heading font-bold text-2xl text-brand-800">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-gray-500">Kelola katalog produk, stok, dan pesanan masuk secara real-time.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-brand-800 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    System Live
                </span>
            </div>
        </header>

        <!-- Main Body Scrollable -->
        <main class="flex-1 overflow-y-auto p-8">

            <!-- Success Alert Notification -->
            @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-900 px-5 py-4 rounded-xl flex items-center justify-between shadow-sm animate-fade-in" id="alert-box">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('alert-box').remove()" class="text-emerald-700 hover:text-emerald-900 font-bold text-lg">&times;</button>
            </div>
            @endif

            @yield('content')

        </main>
    </div>

    @yield('scripts')
</body>
</html>

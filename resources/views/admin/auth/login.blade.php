<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Crust & Co.</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                            500: '#0c4a3e',
                            800: '#003229',
                            900: '#00251e',
                        },
                        cream: {
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
<body class="bg-linear-to-br from-brand-900 via-brand-800 to-brand-900 font-sans text-gray-800 antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Login Card Container -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-brand-500/20 z-10 animate-fade-in">
        
        <!-- Header Brand Banner -->
        <div class="bg-brand-900 p-8 text-center text-white relative">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Crust & Co." class="w-16 h-16 rounded-2xl object-cover mx-auto shadow-xl shadow-amber-500/20 mb-3 bg-white p-1">
            <h1 class="font-heading font-extrabold text-2xl tracking-wide text-white">Crust & Co.</h1>
            <p class="text-xs text-emerald-300 font-medium mt-1">Portal Login Administrator</p>
        </div>

        <!-- Form Section -->
        <div class="p-8">

            <!-- Alert Notification Messages -->
            @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-xs p-4 rounded-xl space-y-1">
                @foreach($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <span>{{ $error }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@tokoroti.com" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent focus:outline-none transition-all">
                        <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent focus:outline-none transition-all">
                        <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 px-4 bg-amber-500 hover:bg-amber-400 text-brand-900 font-bold text-sm rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

        </div>

        <!-- Footer Info -->
        <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-100 text-xs text-gray-400">
            Crust & Co. Bakery Management System &copy; {{ date('Y') }}
        </div>

    </div>

</body>
</html>

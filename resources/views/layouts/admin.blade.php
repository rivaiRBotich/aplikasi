<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MBC Clinic</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_mbc.jpeg') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex h-screen overflow-hidden">

    <!-- MENU SAMPING / SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col h-full justify-between">
        <div>
            <div class="p-4 border-b border-slate-800 flex items-center space-x-3">
                <img src="{{ asset('images/logo_mbc.jpeg') }}" 
                    alt="MBC Clinic Logo" 
                    class="h-14 w-14 rounded-full object-cover border-2 border-teal-500/30 shrink-0">
                
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white tracking-wide">MBC Clinic</span>
                    <span class="text-[9px] text-teal-400 font-bold tracking-widest uppercase mt-0.5">
                        Panel Admin
                    </span>
                </div>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i> <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.products') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.products') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-box w-5"></i> <span>Manajemen Produk</span>
                </a>
                <a href="{{ route('admin.treatment') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.treatment') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-newspaper w-5"></i> <span>Post Treatment</span>
                </a>
                <a href="{{ route('admin.portfolios') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.portfolios') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-newspaper w-5"></i> <span>Post Portofolio</span>
                </a>
                <a href="{{ route('admin.topups') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.topups') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-wallet w-5"></i> <span>Konfirmasi Saldo</span>
                </a>
                <a href="{{ route('admin.chats') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.chats') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-headset w-5"></i> <span>Takeover Chat</span>
                </a>
                <a href="{{ route('admin.doctors') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.doctors') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-doctor w-5"></i> <span>Manajemen Dokter</span>
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.users') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-injured w-5"></i> <span>Daftar Pasien</span>
                </a>
                <a href="{{ route('admin.doctors.activities') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition font-medium {{ Request::routeIs('admin.doctors.activities') ? 'bg-teal-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-5"></i> <span>Aktivitas & Komisi</span>
                </a>
            </nav>
        </div>
        
        <!-- Bagian Akun Keluar -->
        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm text-rose-400 hover:bg-rose-500/10 transition font-medium">
                    <i class="fa-solid fa-sign-out-alt w-5"></i> <span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Topbar Sederhana -->
        <header class="bg-white border-b border-slate-100 h-16 flex items-center justify-between px-8 shrink-0">
            <h2 class="font-semibold text-slate-800">Dashboard</h2>
            <!-- <div class="text-sm font-medium text-slate-600 flex items-center space-x-2">
                <i class="fa-regular fa-user-circle text-lg"></i>
                <span>{{ Auth::user()->name }}</span>
            </div> -->
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <i class="fa-regular fa-user-circle text-lg me-2"></i>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>

        <!-- Tempat isi konten masing-masing sub menu -->
        <div class="p-8">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @yield('admin_content')
        </div>
    </main>
@stack('scripts')
</body>
</html>
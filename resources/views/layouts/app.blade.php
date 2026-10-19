<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MM Control') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/> --}}

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/> --}}


        {{-- <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

        @livewireStyles

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <script src="{{ asset('js/app.js') }}" defer></script>
        {{-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}



        <style>
            [x-cloak]{display:none!important}
            .accfila{container-type:inline-size;container-name:accfila;width:100%}
            .accfila-inline{gap:8px;display:flex;flex-wrap:nowrap;align-items:center;justify-content:center;white-space:nowrap}
            .accfila-btn{display:none;margin:5px auto;padding:2px 14px;font-size:20px;line-height:26px;font-weight:700;color:#374151;background:#e5e7eb;border-radius:6px;cursor:pointer}
            .accfila-btn:hover{background:#d1d5db}
            .accfila-modal{position:fixed;inset:0;z-index:70;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.4);padding:16px}
            .accfila-panel{background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,.3);width:100%;max-width:340px;max-height:90vh;overflow:auto;padding:12px 14px}
            .accfila-titulo{display:flex;justify-content:space-between;align-items:center;font-weight:700;color:#374151;margin-bottom:8px}
            .accfila-x{color:#6b7280;font-size:16px;padding:0 4px}
            .accfila-grid{display:flex;flex-direction:column;gap:2px}
            .accfila-grid > a,.accfila-grid > *{display:flex!important;align-items:center;gap:12px;width:100%!important;margin:0!important;padding:6px;min-height:38px;border-radius:6px;cursor:pointer;transform:none!important;font-size:14px}
            .accfila-grid > *:hover{background:#f3f4f6}
            .accfila-grid > a > svg{width:22px!important;height:22px!important;flex:none}
            .accfila-grid > a::after{content:attr(title);color:#374151;font-weight:500}
            nav .lg\:ml-20{margin-left:clamp(4px,3vw,5rem)!important}
            @media (max-width:1100px){nav .h-9{height:1.4rem!important}nav button{font-size:.78rem!important}nav .sm\:ml-6{margin-left:.25rem!important}nav .lg\:ml-20{margin-left:2px!important}}
            @media (min-width:640px) and (max-width:900px){nav .sm\:flex{display:none!important}nav .-mr-2.sm\:hidden{display:flex!important}nav > div.sm\:hidden.block{display:block!important}}
            nav .lg\:space-x-8>*+*{margin-left:clamp(4px,2vw,2rem)!important}
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-2 mx-auto sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{-- por npm run watch --}}
                <span class="text-pink-500"></span>
                <span class="text-pink-800"></span>
                {{ $slot }}
            </main>

            <footer>
                <div class="p-2 text-xs">powered by  <a href="mailto:alex.arregui@hotmail.es" class="text-blue-800 underline">alex.arregui@hotmail.es</a></div>
            </footer>

            <x-notification />
            <x-notificationred />

        </div>

        @stack('modals')

        @livewireScripts

        <script>
            window.addEventListener('presupuesto-recargar', () => {
                window.setTimeout(() => window.location.reload(), 1500);
            });
        </script>

        @stack('scripts')

    </body>
</html>

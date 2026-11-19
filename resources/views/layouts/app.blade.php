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
            /* botón duplicar (form > button con texto propio): como los <a>, con su etiqueta */
            .accfila-txt{display:none}
            .accfila-grid .accfila-txt{display:inline;color:#374151;font-weight:500}
            .accfila-grid > form > button{display:flex;align-items:center;gap:12px;width:100%;margin:0!important;transform:none!important}
            .accfila-grid > form > button > svg{width:22px!important;height:22px!important;flex:none}
            /* pantalla estrecha (móvil): iconos en horizontal y sin etiqueta */
            @media (max-width:520px){
                .accfila-grid{flex-direction:row;flex-wrap:wrap;justify-content:center;gap:6px}
                .accfila-grid > a,.accfila-grid > *{width:auto!important;min-height:0}
                .accfila-grid > a::after,.accfila-grid .accfila-txt{display:none!important;content:none}
                .accfila-grid > form > button{width:auto}
            }
            /* Iconos SVG sin tamaño propio (una clase «fa-w-12» de FontAwesome NO es un tamaño: por eso se mira que «w-» sea una clase entera): los navegadores recientes los pintan a todo el ancho de la celda.
               1) sin tamaño en ningún sitio -> 1,5 rem; 2) el contenedor (a, div, span, button) lleva w-N -> el SVG lo rellena */
            svg:not([class^="w-"]):not([class*=" w-"]):not([class^="h-"]):not([class*=" h-"]):not([width]):not([height]):not([style*="width"]){width:1.5rem;height:1.5rem}
            :is(a,div,span,button)[class*="w-"]>svg:not([class^="w-"]):not([class*=" w-"]):not([class^="h-"]):not([class*=" h-"]):not([width]):not([height]):not([style*="width"]){width:100%;height:auto}
            :is(a,span)[class*="w-"]:not(.flex):not(.block):not(.inline-flex):not(.inline-block):has(>svg:not([class^="w-"]):not([class*=" w-"])){display:inline-flex;vertical-align:middle}
            /* Botones-icono (PDF, papelera, ficha...): el preflight de Tailwind pone svg{display:block} y un svg dentro de un <a> en línea lo partía en otra línea (PDF arriba, papelera abajo) */
            a[class*="transform"]:has(>svg){display:inline-flex;vertical-align:middle}
            nav .lg\:ml-20{margin-left:clamp(4px,3vw,5rem)!important}
            @media (max-width:1100px){nav .h-9{height:1.4rem!important}nav button{font-size:.78rem!important}nav .sm\:ml-6{margin-left:.25rem!important}nav .lg\:ml-20{margin-left:2px!important}}
            @media (min-width:640px) and (max-width:900px){nav .sm\:flex{display:none!important}nav .-mr-2.sm\:hidden{display:flex!important}nav > div.sm\:hidden.block{display:block!important}}
            nav .lg\:space-x-8>*+*{margin-left:clamp(4px,2vw,2rem)!important}
        </style>
        <script>
            /* Volver con los mismos filtros: cada página guarda en sessionStorage su URL actual (con filtros, que Livewire/los formularios dejan en la query string)
               y los botones «Volver» usan volverLista(url): van a la última URL que tuvo esa lista, no a la ruta pelada. Sin datos guardados, usan la ruta de siempre. */
            (function () {
                var K = 'lista:';
                function clave(path) { return K + path.replace(/\/ruta\/[^\/]+$/, '/ruta'); }
                function guardar() { try { sessionStorage.setItem(clave(location.pathname), location.pathname + location.search); } catch (e) {} }
                ['pushState', 'replaceState'].forEach(function (m) {
                    var o = history[m];
                    history[m] = function () { var r = o.apply(this, arguments); guardar(); return r; };
                });
                guardar();
                window.addEventListener('pagehide', guardar);
                window.volverLista = function (url) {
                    var destino = url;
                    try {
                        var u = new URL(url, location.origin);
                        var g = sessionStorage.getItem(clave(u.pathname));
                        if (g) destino = g;
                    } catch (e) {}
                    location.href = destino;
                };
            })();
        </script>
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

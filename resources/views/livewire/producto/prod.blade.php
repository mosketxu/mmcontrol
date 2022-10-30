<div class="">
    <div class="flex justify-between mx-2 mt-2 mb-0 space-x-1">
        <div class="flex 6/12" >
            <div class="w-full">
                @if($producto->id)
                <h1 class="text-2xl font-semibold text-gray-900">Producto: {{ $producto->referencia }}</h1>
                @else
                <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
                @endif
            </div>
        </div>
        <div class="flex flex-row-reverse w-2/12 ">
            <div class="">
                <x-button.button  onclick="location.href = '{{ route('producto.create') }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
                <x-button.button  onclick="location.href = '{{ route('producto.select2') }}'" color="blue" >{{ __('select2') }}</x-button.button>
            </div>
        </div>
    </div>

    {{-- zona errores y mensajes --}}
    <div class="px-2 py-1 space-y-4" >
        @include('errores')
    </div>
    {{-- <x-jet-validation-errors/> --}}

    <div class="">
        <div class="flex-col space-y-4 text-gray-500 border border-blue-300 rounded shadow-md">
            @if ($tipo=='1')
                @include('producto.editorial')
            @else
                @include('producto.producto')
            @endif
        </div>
    </div>
</div>
@push('scripts')

    <script>
        $(document).ready(function () {
            $('#formato').select2();
            $('#formato').on('change', function (e) {
                var data = $('#formato').select2("val");
            @this.set('formatoselected', data);
            });

            $('#gramajeinterior').select2();
            $('#gramajeinterior').on('change', function (e) {
                var data = $('#gramajeinterior').select2("val");
            @this.set('gramajeinteriorselected', data);
            });

            $('#tintainterior').select2();
            $('#tintainterior').on('change', function (e) {
                var data = $('#tintainterior').select2("val");
            @this.set('tintainteriorselected', data);
            });

            $('#materialinterior').select2();
            $('#materialinterior').on('change', function (e) {
                var data = $('#materialinterior').select2("val");
            @this.set('materialinteriorselected', data);
            });

            $('#gramajecubierta').select2();
            $('#gramajecubierta').on('change', function (e) {
                var data = $('#gramajecubierta').select2("val");
            @this.set('gramajecubiertaselected', data);
            });

            $('#tintacubierta').select2();
            $('#tintacubierta').on('change', function (e) {
                var data = $('#tintacubierta').select2("val");
            @this.set('tintacubiertaselected', data);
            });

            $('#materialcubierta').select2();
            $('#materialcubierta').on('change', function (e) {
                var data = $('#materialcubierta').select2("val");
            @this.set('materialcubiertaselected', data);
            });

            $('#encuadernado').select2();
            $('#encuadernado').on('change', function (e) {
                var data = $('#encuadernado').select2("val");
            @this.set('encuadernadoselected', data);
            });

            $('#plastificado').select2();
            $('#plastificado').on('change', function (e) {
                var data = $('#plastificado').select2("val");
            @this.set('plastificadoselected', data);
            });

            $('#caja').select2();
            $('#caja').on('change', function (e) {
                var data = $('#caja').select2("val");
            @this.set('cajaselected', data);
            });
        });
    </script>

@endpush

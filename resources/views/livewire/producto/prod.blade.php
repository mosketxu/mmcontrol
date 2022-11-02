<div class="">
    <div class="flex justify-between mx-2 mt-2 mb-0 space-x-1">
        <div class="flex 6/12" >
            <div class="w-full">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
            </div>
        </div>
        <div class="flex flex-row-reverse w-2/12 ">
            <div class="">
                {{-- {{ $tipo }} --}}
                @if($producto->id)
                <x-icon.clipboard-a class="text-pink-500 hover:text-pink-700 " onclick="location.href = '{{route('producto.ficha', [$producto->id,$tipo]) }}'" title="Ficha Producto"/>
                @endif
                <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo ) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
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
                @include('producto.otrosproductos')
            @endif
        </div>
    </div>
</div>
@push('scripts')
@endpush

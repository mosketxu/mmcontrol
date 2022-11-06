<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
    <div class="">
        <div class="flex-col space-y-2 text-gray-500 border border-orange-300 rounded shadow-md">
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

<div class="">
    <div class="">
        @include('errores')
    </div>
    @if($bloqueado=='0')
    {{-- Nuevo detalle --}}
    <form wire:submit.prevent="save">
        <div class="flex w-full py-0 my-0 space-x-1 text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
            {{-- checkbox --}}
            <div class="w-1/12 ">
                <input type="checkbox" wire:model.defer="visible"
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            {{-- orde --}}
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- proceso --}}
            <div class="w-3/12">
                <input type="text" wire:model.defer="proceso"
                class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- descripcion --}}
            <div class="w-3/12">
                <input type="text" wire:model.defer="descripcion"
                class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- cantidad --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="tirada"
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- importe --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="precio_ud"
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- subtotalsiniva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="preciototal"
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            {{-- botones --}}
            <div class="w-1/12 text-right pr-2">
                <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                <x-icon.delete-a wire:click.prevent="delete({{ $pprocesoid }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
            </div>
        </div>
    </form>
    @endif
</div>

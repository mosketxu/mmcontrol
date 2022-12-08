<form wire:submit.prevent="save" class="">
    <div class="px-2 py-1 space-y-2" >
        <div class="">
            @include('errores')
        </div>
    </div>

    <div class="flex w-full py-0 my-0 space-x-1 text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="hidden" wire:model.lazy='fdetalle_id'>
            <input type="checkbox" wire:model.lazy='visible'
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12">
            <input type="number" wire:model.lazy='orden'
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $deshabilitado }}/>
            </div>
        <div class="w-2/12">
            <select wire:model.lazy='pedido_id'
            class="w-full py-1 text-xs font-thin text-gray-500 border-none rounded-md shadow-none focus:border-$color-300 focus:ring focus:ring-$color-200 focus:ring-opacity-50"
            {{ $deshabilitado }}>
                <option value="" >-</option>
                @forelse ($pedidos as $pedido)
                    <option value="{{ $pedido->id }}" >{{ $pedido->id }}</option>
                @empty
                    <option value="">No hay pedidos pendientes</option>
                @endforelse
            </select>
        </div>
        <div class="w-4/12">
            <input type="text" wire:model.lazy='concepto'
            class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-2/12">
            <input type="number" step="any" wire:model.lazy='cantidad'
            class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12">
            <input type="number" step="any" wire:model.lazy='importe'
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotalsiniva,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <select wire:model.lazy='iva'
            class="w-full py-1 text-xs font-thin text-gray-500 border-none rounded-md shadow-none focus:border-$color-300 focus:ring focus:ring-$color-200 focus:ring-opacity-50"
            {{ $deshabilitado }}>
            <option value="0.00" > 0%</option>
            <option value="0.04" > 4%</option>
            <option value="0.1" >10%</option>
            <option value="0.21" >21%</option>
            </select>
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotaliva,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotal,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-3/12">
            <input type="text" wire:model.lazy='observaciones'
            class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12 text-center">
            @if ($deshabilitado=='')
            <x-icon.save-a wire:click.prevent="save()"  title="Guardar detalle"/>
            <x-icon.delete-a wire:click.prevent="delete({{ $fdetalle_id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
            @endif
        </div>
    </div>
</form>


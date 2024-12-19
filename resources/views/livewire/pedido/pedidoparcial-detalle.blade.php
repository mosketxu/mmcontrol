<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    <div class="flex w-full text-sm text-gray-500 bg-blue-100 rounded-t-md">
        <div class="w-5/12 mr-1 font-light text-center rounded-md">{{ __('Conceptos')}} </div>
        <div class="w-2/12 pr-6 mr-1 font-light text-right rounded-md">{{ __('Cantidad')}} </div>
        <div class="w-2/12 pr-6 mr-1 font-light text-right rounded-md">{{ __('€/ud')}} </div>
        <div class="w-2/12 pr-6 mr-1 font-light text-right rounded-md">{{ __('Total')}} </div>
        <div class="w-1/12 mr-1 font-light rounded-md "> </div>
    </div>
    <div>
        @foreach ($detalles as $detalle)
        <div class="flex w-full pb-0.5 text-sm  bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-5/12 mr-1 text-right border-blue-800 rounded-md">
                <input type="text" value="{{ $detalle->concepto }}"
                    class="w-full text-sm font-thin text-left text-gray-500 border-0 rounded-md"
                    wire:change="changeCampo('{{ $detalle->id }}','concepto',$event.target.value)"/>
            </div>
            <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                <input type="number" value="{{ $detalle->cantidad }}"
                    class="w-full text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                    wire:change="changeCampo('{{ $detalle->id }}','cantidad',$event.target.value)"/>
            </div>
            <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                <input type="number" step="any" value="{{ $detalle->precio_ud }}"
                    class="w-full text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                    wire:change="changeCampo('{{ $detalle->id }}','precio_ud',$event.target.value)"/>
            </div>
            <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                <input type="number"  value="{{ $detalle->total }}"
                    class="w-full text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                    disabled/>
            </div>
            <div class="w-1/12 mr-1 text-center border-blue-800 rounded-md">
                <x-icon.delete-a wire:click.prevent="delete({{ $detalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-7"  title="Eliminar detalle"/>
            </div>
        </div>
        @endforeach
        </div>
        <div>
        <form wire:submit.prevent="save">
            <div class="flex w-full text-sm bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                <div class="w-5/12 mr-1 border-blue-800 rounded-md">
                    <input type="text" wire:model.defer="concepto" autofocus
                        class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                    <input type="number" step="any" wire:model.lazy="cantidad"
                        class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                    <input type="number" step="any" wire:model.lazy="precio_ud"
                        class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-2/12 mr-1 border-blue-800 rounded-md">
                    <input type="number" step="any" wire:model.lazy="total"
                        class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" readonly/>
                </div>
                <div class="w-1/12 mr-1 text-center border-blue-800 rounded-md">
                        <button type="submit" class="items-center"><x-icon.save-a class="w-6 text-blue"/></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

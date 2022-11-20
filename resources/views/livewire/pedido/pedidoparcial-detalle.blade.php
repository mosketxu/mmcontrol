<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    <div class="flex pt-2 pb-0 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
        <div class="w-6/12 font-light ">{{ __('Conceptos')}} </div>
        <div class="w-2/12 mr-3 font-light text-right ">{{ __('Cantidad')}} </div>
    </div>
    <div>
        @foreach ($detalles as $detalle)
        <div class="flex w-full py-0 my-0 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-6/12 text-left">
                <input type="text" value="{{ $detalle->concepto }}"
                    wire:change="changeCampo('{{ $detalle->id }}','concepto',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-2/12 mr-3">
                <input type="text" value="{{ $detalle->cantidad }}"
                    wire:change="changeCampo('{{ $detalle->id }}','cantidad',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 pr-2">
                <x-icon.delete-a wire:click.prevent="delete({{ $detalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
            </div>
        </div>
        @endforeach
        </div>
        <div>
        <form wire:submit.prevent="save">
            <div class="flex w-full p-1 text-sm bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                <div class="w-6/12">
                    <input type="text" wire:model.defer="concepto"
                        class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-2/12 mr-3">
                    <input type="number" step="any" wire:model.defer="cantidad"
                        class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                </div>
                <div class="w-1/12 ">
                        <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

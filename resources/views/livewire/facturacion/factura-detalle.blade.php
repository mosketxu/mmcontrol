<div class="py-1 space-y-4">
    <div class="">
        @include('errores')
    </div>
    <div class="flex pt-2 pb-0 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
        <div class="w-10 font-light ">{{ __('Vis.')}} </div>
        <div class="w-10 font-light ">{{ __('Ord.')}} </div>
        <div class="w-1/12 font-light ">{{ __('Pedido')}} </div>
        <div class="w-4/12 font-light ">{{ __('Concepto')}} </div>
        <div class="w-2/12 font-light ">{{ __('Cantidad')}} </div>
        <div class="w-1/12 font-light ">{{ __('Uds')}} </div>
        <div class="w-1/12 font-light ">{{ __('Importe')}} </div>
        <div class="w-1/12 font-light ">{{ __('% Iva')}} </div>
        <div class="w-1/12 font-light ">{{ __('Iva')}} </div>
        <div class="w-1/12 font-light ">{{ __('Total')}} </div>
        <div class="w-3/12 font-light ">{{ __('Observaciones')}} </div>
    </div>
    @forelse ($fdetalles as $fdetalle)
        <div class="flex w-full py-0 my-0 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-1/12 text-left">
                <input type="checbox" value="{{ $fdetalle->visible }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','visible',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-left">
                <input type="text" value="{{ $fdetalle->orden }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','orden',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-left">
                <x-selectcolor wire:model.lazy="fdetalle.pedido_id" selectname="pedido_id" color="blue" class="w-full"
                    wire:change="changeCampo({{ $pedido_id }},'pedido_id',$event.target.value)">
                    @forelse ($pedidos as $pedido)
                        <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                        <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                    @empty
                        <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </x-selectcolor>
            </div>
            <div class="w-4/12 text-left">
                <input type="text" value="{{ $fdetalle->concepto }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','concepto',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-2/12 mr-3">
                <input type="text" value="{{ $fdetalle->cantidad }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','cantidad',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-left">
                <x-selectcolor wire:model.lazy="unidades" selectname="unidades" color="blue" class="w-full">
                    <option value="1">x1</option>
                    <option value="1000">x1000</option>
                </x-selectcolor>
            </div>
            <div class="w-2/12 mr-3">
                <input type="text" value="{{ $fdetalle->importe }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','importe',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-left">
                <x-selectcolor wire:model.lazy="fdetalle.iva" selectname="iva" color="blue" class="w-full"
                    wire:change="changeCampo({{ $fdetalle->iva }},'iva',$event.target.value)">
                        <option value="0.00"> 0%</option>
                        <option value="0.04"> 4%</option>
                        <option value="0.10">10%</option>
                        <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            <div class="w-2/12 mr-3">
                <input type="text" value="{{ $fdetalle->subtotaliva }}"
                    class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                    readonly/>
            </div>
            <div class="w-2/12 mr-3">
                <input type="text" value="{{ $fdetalle->subtotal }}"
                    class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                    readonly/>
            </div>
            <div class="w-4/12 text-left">
                <input type="text" value="{{ $fdetalle->observaciones }}"
                    wire:change="changeCampo('{{ $fdetalle->id }}','observaciones',$event.target.value)"
                    class="w-full pr-2 mr-2 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>

            <div class="w-1/12 pr-2">
                <x-icon.delete-a wire:click.prevent="delete({{ $fdetalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
            </div>
        </div>
        @empty
        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div colspan="10">
                <div class="flex items-center justify-center">
                    <x-icon.inbox class="w-8 h-8 text-gray-300"/>
                    <span class="py-5 text-xl font-medium text-gray-500">
                        No se han encontrado datos...
                    </span>
                </div>
            </div>
        </div>
        @endforelse
    <form wire:submit.prevent="save">
        <div class="flex w-full p-1 text-sm bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
            <div class="w-10 form-item">
                <input type="checkbox" wire:model.lazy="visible"/>
            </div>
            <div class="w-10 form-item">
                <input type="number" wire:model.defer="orden"
                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-1/12 text-left form-item">
                <x-selectcolor wire:model.lazy="pedido_id" selectname="pedido_id" color="blue" class="w-full py-4">
                    <option value="">Selecciona</option>
                    @forelse ($pedidos as $pedido)
                        <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                        <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                    @empty
                        <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </x-selectcolor>
            </div>
            <div class="w-4/12 form-item">
                <input type="text" wire:model.defer="concepto"
                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-1/12 form-item">
                <input type="number" step="any" wire:model.defer="cantidad"
                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-1/12 form-item">
                <x-selectcolor wire:model.lazy="unidad" selectname="unidad" color="blue" class="w-full">
                    <option value="1">x1</option>
                    <option value="1000">x1000</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12 form-item">
                <input type="number" step="any" wire:model.defer="importe"
                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-1/12 form-item">
                <x-selectcolor wire:model.lazy="iva" selectname="iva" color="blue" class="w-full my-1"
                    wire:change="changeCampo({{ $iva }},'iva',$event.target.value)">
                    <option value="0.00"> 0%</option>
                    <option value="0.04"> 4%</option>
                    <option value="0.10">10%</option>
                    <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12 form-item">
                <input type="number" step="any"value="{{ $cantidad * $iva * $importe}}"
                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-4/12 form-item">
                <input type="text"  wire:model.defer="observaciones"
                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>

            <div class="w-1/12 ">
                    <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                </div>
            </div>
        </div>
    </form>
</div>



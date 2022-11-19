<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    <div class="flex w-full py-0 my-0 text-gray-500 text-left bg-blue-100 space-x-1 rounded-t-md" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="text" value="Vis."
            class="w-full bg-blue-100 py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Orden"
            class="w-full bg-blue-100 py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Pedido"
            class="w-full bg-blue-100 py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-4/12 ">
            <input type="text" value="Concepto"
            class="w-full bg-blue-100 py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Cantidad"
            class="w-full bg-blue-100 py-1 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Uds"
            class="w-full bg-blue-100 py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Importe"
            class="w-full bg-blue-100 py-1 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="SubTot."
            class="w-full bg-blue-100 py-1 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="%Iva"
            class="w-full bg-blue-100 py-1 text-left text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Iva"
            class="w-full bg-blue-100 py-1 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Total"
            class="w-full bg-blue-100 py-1 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>

        <div class="w-3/12">
            <input type="text" value="Observaciones"
            class="w-full bg-blue-100 py-1 text-left text-sm font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12"></div>
    </div>
    <form wire:submit.prevent="save">
        <div class="flex w-full py-0 my-0 text-left bg-green-100 border-t-0 border-y space-x-1" wire:loading.class.delay="opacity-50">
            <div class="w-1/12 ">
                <input type="checkbox" wire:model.lazy="visible"
                class="ml-4 text-sm border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full py-1 bg-green-100 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-2/12">
                <x-selectcolor wire:model.lazy="pedido_id" selectname="pedido_id" color="bg-green-100"
                class="w-full py-1 bg-green-100 text-sm font-thin text-gray-500 border-none shadow-none">
                    <option value="">-Selecciona-</option>
                    @forelse ($pedidos as $pedido)
                    <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                    @empty
                    <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </x-selectcolor>
            </div>
            <div class="w-4/12">
                <input type="text" wire:model.defer="concepto" placeholder="Concepto"
                class="w-full py-1 bg-green-100 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-2/12">
                <input type="number" step="any" wire:model.debounce.500ms="cantidad"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12">
                <x-selectcolor wire:model.debounce.500ms="unidad" selectname="unidad" color="blue"
                class="w-full py-1 bg-green-100  text-left text-sm font-thin text-gray-500 border-none shadow-none">
                    <option value="1">x1</option>
                    <option value="1000">x1000</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12">
                <input type="number" step="any" wire:model.debounce.500ms="importe"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12">
                <input type="text"  value="{{ $cantidad * $importe / $unidad}}"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <x-selectcolor wire:model.debounce.500ms="iva" selectname="iva" color="bg-green-100"
                class="w-full py-1 bg-green-100 text-center px-0 text-sm font-thin text-gray-500 border-none shadow-none">
                    <option value="0.00"> 0%</option>
                    <option value="0.04"> 4%</option>
                    <option value="0.10">10%</option>
                    <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12">
                <input type="text"  value="{{ $cantidad * $iva * $importe / $unidad}}"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <input type="text"  value="{{ $cantidad * (1+$iva) * $importe / $unidad}}"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-3/12 ">
                <input type="text"  wire:model.defer="observaciones"
                class="w-full py-1 bg-green-100 pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-center">
                <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
            </div>
        </div>
    </form>

    @forelse ($fdetalles as $fdetalle)
        <div class="flex w-full py-0 my-0 text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-1/12 ">
                <input type="checkbox" value="{{ $fdetalle->visible }}" {{ $fdetalle->visible==true ? 'checked' : ''  }}
                    wire:change="changeVisible({{ $fdetalle }},$event.target.value)"
                    class="ml-4 text-sm border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            <div class="w-1/12">
                <input type="number" value="{{ $fdetalle->orden }}"
                    wire:change="changeValor('{{ $fdetalle->id }}','orden',$event.target.value)"
                    class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"/>
                </div>
            <div class="w-2/12">
                <x-selectcolor wire:model.lazy="fdetalle.pedido_id" selectname="pedido_id"
                wire:change="changeValor({{ $pedido_id }},'pedido_id',$event.target.value)"
                class="w-full py-1 text-sm font-thin text-gray-500 border-none shadow-none">
                    @forelse ($pedidos as $pedido)
                        <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                    @empty
                        <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </x-selectcolor>
            </div>
            <div class="w-4/12">
                <input type="text" value="{{ $fdetalle->concepto }}"
                wire:change="changeValor('{{ $fdetalle->id }}','concepto',$event.target.value)"
                class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-2/12">
                <input type="number" step="any" value="{{ $fdetalle->cantidad }}"
                wire:change="changeValor('{{ $fdetalle->id }}','cantidad',$event.target.value)"
                class="w-full py-1  pr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12">
                <x-selectcolor wire:model.lazy="unidades" selectname="unidades" color="blue"
                wire:change="changeValor({{ $fdetalle->unidades }},'iva',$event.target.value)"
                class="w-full py-1 text-sm font-thin text-gray-500 border-none shadow-none">
                <option value="1">x1</option>
                <option value="1000">x1000</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12">
                <input type="number" step="any" value="{{ $fdetalle->importe }}"
                wire:change="changeValor('{{ $fdetalle->id }}','importe',$event.target.value)"
                class="w-full py-1 mr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ $fdetalle->subtotalsiniva }}"
                class="w-full py-1 mr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <x-selectcolor wire:model.lazy="fdetalle.iva" selectname="iva" color="blue"
                wire:change="changeValor({{ $fdetalle->iva }},'iva',$event.target.value)"
                class="w-full py-1 text-center px-0 text-sm font-thin text-gray-500 border-none shadow-none">
                <option value="0.00"> 0%</option>
                <option value="0.04"> 4%</option>
                <option value="0.10">10%</option>
                <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ $fdetalle->subtotaliva }}"
                class="w-full py-1 mr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ $fdetalle->subtotal }}"
                class="w-full py-1 mr-2 text-right text-sm font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-3/12">
                <input type="text" value="{{ $fdetalle->observaciones }}"
                wire:change="changeValor('{{ $fdetalle->id }}','observaciones',$event.target.value)"
                class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            <div class="w-1/12 text-center">
                <x-icon.delete-a wire:click.prevent="delete({{ $fdetalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
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
</div>



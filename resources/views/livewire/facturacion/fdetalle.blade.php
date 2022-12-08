<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    {{-- Titulos --}}
    <div class="flex w-full py-0 my-0 space-x-1 text-left text-gray-500 bg-blue-100 rounded-t-md" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="text" value="Vis."
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Orden"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Pedido"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-4/12 ">
            <input type="text" value="Concepto"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Cantidad"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Importe"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="SubTot."
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="%Iva"
            class="w-full py-1 text-xs font-thin text-left text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Iva"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Total"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>

        <div class="w-3/12">
            <input type="text" value="Observaciones"
            class="w-full py-1 text-xs font-thin text-left text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12"></div>
    </div>

    @if($bloqueado=='0')
    {{-- Nuevo detalle --}}
    <form wire:submit.prevent="save">
        <div class="flex w-full py-0 my-0 space-x-1 text-left bg-green-100 border-t-0 border-y" wire:loading.class.delay="opacity-50">
            {{-- checkbox --}}
            <div class="w-1/12 ">
                <input type="checkbox" wire:model.defer="visible"
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            {{-- orde --}}
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md"/>
            </div>
            {{-- Pedido_id --}}
            <div class="w-2/12">
                {{-- <x-selectcolor wire:model.lazy="pedido_id" selectname="pedido_id" color="bg-green-100" --}}
                <x-selectcolor wire:model.lazy="pedido_id" selectname="pedido_id" color="bg-green-100"
                    class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-none shadow-none">
                    <option value="" >-Selecciona- </option>
                    @forelse ($pedidos as $pedido)
                    <option value="{{ $pedido->id }}">{{ $pedido->id }}</option>
                    @empty
                    <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </x-selectcolor>
            </div>
            {{-- concepto --}}
            <div class="w-4/12">
                <input type="text" wire:model.defer="concepto" placeholder="Introduce el concepto"
                class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md placeholder:text-xs placeholder:text-gray-300 placeholder:italic"/>
            </div>
            {{-- cantidad --}}
            <div class="w-2/12">
                <input type="number" step="any" wire:model.lazy="cantidad"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"/>
            </div>
            {{-- importe --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="importe"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"/>
            </div>
            {{-- subtotalsiniva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotalsiniva"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-200 border-0 rounded-md"
                disabled/>
            </div>
            {{-- iva --}}
            <div class="w-1/12">
                <x-selectcolor wire:model.debounce.500ms="iva" selectname="iva" color="bg-green-100"
                class="w-full px-0 py-1 text-xs font-thin text-center text-gray-500 bg-green-100 border-none shadow-none">
                    <option value="0.00"> 0%</option>
                    <option value="0.04"> 4%</option>
                    <option value="0.10">10%</option>
                    <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            {{-- subtotaliva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotaliva"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-200 border-0 rounded-md"
                disabled/>
            </div>
            {{-- subtotal --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotal"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-200 border-0 rounded-md"
                disabled/>
            </div>
            {{-- observaciones --}}
            <div class="w-3/12 ">
                <input type="text"  wire:model.defer="observaciones"
                class="w-full py-1 pr-2 text-xs font-thin text-left text-gray-500 bg-green-100 border-0 rounded-md"/>
            </div>
            {{-- botones --}}
            <div class="w-1/12 text-center">
                <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
            </div>
        </div>
    </form>
    @endif

    {{-- Lista detalles --}}
    @forelse ($fdetalles as $fdetalle)
        @livewire('facturacion.fdetalles',['factura'=>$factura,'fdetalle'=>$fdetalle],key($fdetalle->id))
    @empty
        <div class="flex w-full text-xs text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
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



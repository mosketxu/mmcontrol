<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    {{-- Titulos --}}
    <div class="flex w-full py-0 my-0 text-gray-500 text-left bg-blue-100 space-x-1 rounded-t-md" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="text" value="Vis."
            class="w-full bg-blue-100 py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Orden"
            class="w-full bg-blue-100 py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Pedido"
            class="w-full bg-blue-100 py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-4/12 ">
            <input type="text" value="Concepto"
            class="w-full bg-blue-100 py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Cantidad"
            class="w-full bg-blue-100 py-1 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Uds"
            class="w-full bg-blue-100 py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Importe"
            class="w-full bg-blue-100 py-1 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="SubTot."
            class="w-full bg-blue-100 py-1 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="%Iva"
            class="w-full bg-blue-100 py-1 text-left text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Iva"
            class="w-full bg-blue-100 py-1 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Total"
            class="w-full bg-blue-100 py-1 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>

        <div class="w-3/12">
            <input type="text" value="Observaciones"
            class="w-full bg-blue-100 py-1 text-left text-xs font-thin text-gray-500 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12"></div>
    </div>

    @if($bloqueado=='0')
    {{-- Nuevo detalle --}}
    <form wire:submit.prevent="save">
        <div class="flex w-full py-0 my-0 text-left bg-green-100 border-t-0 border-y space-x-1" wire:loading.class.delay="opacity-50">
            {{-- checkbox --}}
            <div class="w-1/12 ">
                <input type="checkbox" wire:model.defer="visible"
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            {{-- orde --}}
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full py-1 bg-green-100 text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- Pedido_id --}}
            <div class="w-2/12">
                <x-selectcolor wire:model.lazy="pedido_id" selectname="pedido_id" color="bg-green-100"
                    class="w-full py-1 bg-green-100 text-xs font-thin text-gray-500 border-none shadow-none">
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
                class="w-full py-1 bg-green-100 text-xs font-thin text-gray-500 border-0 rounded-md placeholder:text-xs  placeholder:text-gray-300  placeholder:italic"/>
            </div>
            {{-- cantidad --}}
            <div class="w-2/12">
                <input type="number" step="any" wire:model.lazy="cantidad"
                class="w-full py-1 bg-green-100 pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- importe --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="importe"
                class="w-full py-1 bg-green-100 pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"/>
            </div>
            {{-- subtotalsiniva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotalsiniva"
                class="w-full py-1 bg-green-200 pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            {{-- iva --}}
            <div class="w-1/12">
                <x-selectcolor wire:model.debounce.500ms="iva" selectname="iva" color="bg-green-100"
                class="w-full py-1 bg-green-100 text-center px-0 text-xs font-thin text-gray-500 border-none shadow-none">
                    <option value="0.00"> 0%</option>
                    <option value="0.04"> 4%</option>
                    <option value="0.10">10%</option>
                    <option value="0.21">21%</option>
                </x-selectcolor>
            </div>
            {{-- subtotaliva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotaliva"
                class="w-full py-1 bg-green-200 pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            {{-- subtotal --}}
            <div class="w-1/12">
                <input type="text"  wire:model="subtotal"
                class="w-full py-1 bg-green-200 pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            {{-- observaciones --}}
            <div class="w-3/12 ">
                <input type="text"  wire:model.defer="observaciones"
                class="w-full py-1 bg-green-100 pr-2 text-left text-xs font-thin text-gray-500 border-0 rounded-md"/>
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
        <div class="flex w-full py-0 my-0 text-left bg-white space-x-1 border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-1/12 ">
                <input type="checkbox" value="{{ $fdetalle->visible }}" {{ $fdetalle->visible==true ? 'checked' : ''  }}
                    wire:change="changeVisible({{ $fdetalle }},$event.target.value)"
                    class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    {{ $disabled }}/>
            </div>
            <div class="w-1/12">
                <input type="number" value="{{ $fdetalle->orden }}"
                    wire:change="changeValor('{{ $fdetalle->id }}','orden',$event.target.value)"
                    class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                    {{ $disabled }}/>
                </div>
            <div class="w-2/12">
                <select
                wire:change="changeValor({{ $fdetalle }},'pedido_id',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-none rounded-md shadow-none focus:border-$color-300 focus:ring focus:ring-$color-200 focus:ring-opacity-50"
                {{ $disabled }}>
                    @forelse ($pedidostodos as $pedido)
                        <option value="{{ $pedido->id }}" {{ $pedido->id== $fdetalle->pedido_id ? 'selected' : '' }}>{{ $pedido->id }}</option>
                    @empty
                        <option value="">No hay pedidos pendientes</option>
                    @endforelse
                </select>
            </div>
            <div class="w-4/12">
                <input type="text" value="{{ $fdetalle->concepto }}"
                wire:change="changeValor('{{ $fdetalle->id }}','concepto',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $disabled }}/>
            </div>
            <div class="w-2/12">
                <input type="number" step="any" value="{{ $fdetalle->cantidad }}"
                wire:change="changeValor('{{ $fdetalle->id }}','cantidad',$event.target.value)"
                class="w-full py-1  pr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $disabled }}/>
            </div>
            <div class="w-1/12">
                <input type="number" step="any" value="{{ $fdetalle->importe }}"
                wire:change="changeValor('{{ $fdetalle->id }}','importe',$event.target.value)"
                class="w-full py-1 mr-2 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $disabled }}/>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ number_format($fdetalle->subtotalsiniva,2,',','.') }}"
                class="w-full py-1 mr-2 bg-gray-100 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <select
                wire:change="changeValor({{ $fdetalle }},'iva',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-none rounded-md shadow-none focus:border-$color-300 focus:ring focus:ring-$color-200 focus:ring-opacity-50"
                {{ $disabled }}>
                <option value="0.00" {{ $fdetalle->iva=='0.00' ? 'selected' : ''}}> 0%</option>
                <option value="0.04" {{ $fdetalle->iva=='0.04' ? 'selected' : ''}}> 4%</option>
                <option value="0.10" {{ $fdetalle->iva=='0.10' ? 'selected' : ''}}>10%</option>
                <option value="0.21" {{ $fdetalle->iva=='0.21' ? 'selected' : ''}}>21%</option>
                </select>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ number_format($fdetalle->subtotaliva,2,',','.') }}"
                class="w-full py-1 mr-2  bg-gray-100 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ number_format($fdetalle->subtotal,2,',','.') }}"
                class="w-full py-1 mr-2  bg-gray-100 text-right text-xs font-thin text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-3/12">
                <input type="text" value="{{ $fdetalle->observaciones }}"
                wire:change="changeValor('{{ $fdetalle->id }}','observaciones',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $disabled }}/>
            </div>
            <div class="w-1/12 text-center">
                @if ($disabled=='')
                <x-icon.delete-a wire:click.prevent="delete({{ $fdetalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
                @endif
            </div>
        </div>
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



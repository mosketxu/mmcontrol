<div class="py-1 ">
    <div class="">
        {{-- @include('errores') --}}
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
            <input type="text" value="Producto"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
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
            <input type="text" value="Total"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-4/12">
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
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}}/>
            </div>
            {{-- orde --}}
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- producto_id --}}
            <div class="w-2/12">
                <select wire:model.lazy="producto_id" name="producto_id"
                    class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-gray-300 border-none rounded-md shadow-none focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                    {{$escliente}}>
                    <option value="" >-Selecciona- </option>
                    @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->isbn .'-'. $producto->referencia }}</option>
                    @endforeach
                </select>
            </div>
            {{-- cantidad --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="tirada"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- importe --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="precio_ud"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- subtotalsiniva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="preciototal"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-200 border-0 rounded-md"
                disabled/>
            </div>
            {{-- observaciones --}}
            <div class="w-4/12 ">
                <textarea wire:model.defer="observaciones" rows="1"
                class="w-full py-1 pr-2 text-xs font-thin text-left text-gray-500 bg-green-100 border-0 rounded-md" {{$escliente}}></textarea>
            </div>
            {{-- botones --}}
            <div class="w-1/12 text-right">
                @if(!Auth::user()->hasRole('Cliente'))
                <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                @endif
            </div>
        </div>
    </form>
    @endif

    {{-- Lista detalles --}}
    @forelse ($presupproductos as $pproducto)
        @livewire('presupuesto.presupuesto-productos',['pproducto'=>$pproducto,'deshabilitado'=>$deshabilitado],key($pproducto->id))
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

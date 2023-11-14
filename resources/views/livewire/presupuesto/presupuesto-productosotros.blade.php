<div class="">
    <div class="">
        {{-- @include('errores') --}}
    </div>

    @if($bloqueado=='0' )
    {{-- Nuevo detalle --}}
    <form wire:submit.prevent="save">
        <div class="flex w-full py-0 my-0 space-x-1 text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
            {{-- checkbox --}}
            <div class="w-1/12 ">
                <input type="checkbox" wire:model.defer="visible"
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}}/>
            </div>
            {{-- orde --}}
            <div class="w-1/12">
                <input type="number" wire:model.defer="orden"
                class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- producto_id --}}
            <div class="w-2/12">
                <select wire:model.lazy="producto_id" name="producto_id"
                    class="w-full py-1 text-xs font-thin text-gray-500 border-gray-300 border-none rounded-md shadow-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
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
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- importe --}}
            <div class="w-1/12">
                <input type="number" step="any" wire:model.lazy="precio_ud"
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
                {{$escliente}}/>
            </div>
            {{-- subtotalsiniva --}}
            <div class="w-1/12">
                <input type="text"  wire:model="preciototal"
                class="w-full pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
                disabled/>
            </div>
            {{-- observaciones --}}
            <div class="w-4/12 ">
                <textarea wire:model.defer="observaciones" rows="1"
                class="w-full pr-2 text-xs font-thin text-left text-gray-500 border-0 rounded-md" {{$escliente}}></textarea>
            </div>
            {{-- botones --}}
            {{-- <div class="flex w-1/12 text-right"> --}}
            <div class="flex flex-row-reverse w-1/12">
                @if(!Auth::user()->hasRole('Cliente'))
                <x-icon.delete-a  class="w-6" wire:click.prevent="delete({{ $pproductoid }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
                <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                @endif
            </div>
        </div>
    </form>
    @endif
</div>

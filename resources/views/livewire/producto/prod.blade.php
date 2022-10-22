<div class="">
    {{-- @livewire('menu',['producto'=>$producto],key($producto->id)) --}}

    <div class="flex justify-between mx-2 mt-2 mb-0 space-x-1">
        <div class="flex 6/12" >
            <div class="w-full">
                @if($producto->id)
                <h1 class="text-2xl font-semibold text-gray-900">Producto: {{ $producto->referencia }}</h1>
                @else
                <h1 class="text-2xl font-semibold text-gray-900">Nuevo Producto</h1>
                @endif
            </div>
        </div>
        <div class="flex flex-row-reverse w-2/12 ">
            <div class="">
                <x-button.button  onclick="location.href = '{{ route('producto.create') }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div>
        </div>
    </div>

    {{-- zona errores y mensajes --}}
    <div class="px-2 py-1 space-y-4" >
        @include('errores')
    </div>
    {{-- <x-jet-validation-errors/> --}}

    <div class="h-screen">
        <div class="flex-col space-y-4 text-gray-500 border border-blue-300 rounded shadow-md">
            <form wire:submit.prevent="save" class="text-sm">
                <div class="p-2 m-2 ">
                    <div class="p-1 rounded-md bg-blue-50">
                        <h3 class="pl-1 font-semibold">Datos generales</h3>
                        <input  wire:model.defer="producto.id" type="hidden"/>
                    </div>
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-2/12 form-item">
                            <x-jet-label for="isbn">{{ __('ISBN/Código') }}</x-jet-label>
                            <input wire:model="producto.isbn" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required/>
                        </div>
                        <div class="w-10/12 form-item">
                            <x-jet-label for="referencia">{{ __('Título/Referencia') }}</x-jet-label>
                            <input wire:model.defer="producto.referencia" type="text" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autofocus/>
                        </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                            <x-select wire:model.lazy="producto.cliente_id" selectname="cliente_id" class="w-full" >
                                <option value=''>-- Selecciona cliente --</option>
                                @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="precio">{{ __('€ Precio') }}</x-jet-label>
                            <input  wire:model="producto.precio" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                            <textarea wire:model.defer="producto.observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                            <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="ficheropdf">{{ __('Ficha producto') }}</x-jet-label>
                            <div class="flex">
                                <input type="file" wire:model="ficheropdf">
                                @if($producto->fichaproducto)
                                    <x-icon.pdf-a wire:click="presentaPDF({{ $producto }})" class="pt-2 ml-2" title="PDF"/>
                                @endif
                                @error('ficheropdf') <p class="text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                        <span
                            x-data="{ open: false }"
                            x-init="
                                @this.on('notify-saved', () => {
                                    if (open === false) setTimeout(() => { open = false }, 2500);
                                    open = true;
                                })
                            "
                            x-show.transition.out.duration.1000ms="open"
                            style="display: none;"
                            class="p-2 m-2 text-gray-500 rounded-lg bg-green-50"
                            >Saved!
                        </span>
                        <x-jet-secondary-button  onclick="location.href = '{{route('producto.index')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="">
    {{-- @livewire('menu',['pedido'=>$pedido],key($pedido->id)) --}}

    <div class="flex justify-between mx-2 mt-2 mb-0 space-x-1">
        <div class="flex 6/12" >
            <div class="w-full">
                @if($pedido)
                <h1 class="text-2xl font-semibold text-gray-900">Pedido: {{ $pedido->pedido }}</h1>
                @else
                <h1 class="text-2xl font-semibold text-gray-900">Nuevo pedido</h1>
                @endif
            </div>
        </div>
        <div class="flex flex-row-reverse w-2/12 ">
            <div class="">
                <x-button.button  onclick="location.href = '{{ route('pedido.create') }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div>
        </div>
    </div>

    {{-- zona errores y mensajes --}}
    <div class="px-2 py-1 space-y-4" >
        @if ($errors->any())
            <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
                <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                    <span>×</span>
                </button>
            </div>
        @endif
        @if (session()->has('message'))
            <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-green-200 border-green-500 rounded border-1" >
                <span class="inline-block mx-8 align-middle" >
                    {{ session('message') }}
                </span>
                <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                    <span>×</span>
                </button>
            </div>
        @endif
    </div>
    {{-- <x-jet-validation-errors/> --}}

    <div class="h-screen">
        <div class="flex-col space-y-4 text-gray-500 border border-blue-300 rounded shadow-md">
            <form wire:submit.prevent="save" class="text-sm">
                <div class="p-2 m-2 ">
                    <div class="p-1 rounded-md bg-blue-50">
                        <h3 class="pl-1 font-semibold">Datos generales</h3>
                        <input  wire:model.defer="id" type="hidden"/>
                    </div>
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-2/12 form-item">
                            <x-jet-label for="pedido">{{ __('Pedido') }}</x-jet-label>
                            <input wire:model="pedido" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required/>
                        </div>
                        <div class="w-2/12 form-item">
                            <div class="w-full form-item">
                                <x-jet-label for="producto_id">{{ __('Producto') }}</x-jet-label>
                                <x-select wire:model.lazy="producto_id" selectname="producto_id" class="w-full" >
                                    <option value="">-- Selecciona ISBN --</option>
                                    @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->isbn }}</option>
                                    @endforeach
                                </x-select>
                                <x-select wire:model.lazy="producto_id" selectname="producto_id" class="w-full" >
                                    <option value="">-- Selecciona Referencia --</option>
                                    @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->referencia }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                       </div>
                        <div class="w-2/12 form-item">
                            <div class="w-full form-item">
                                <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                <x-select wire:model.lazy="cliente_id" selectname="cliente_id" class="w-full" >
                                    <option value="">-- Selecciona cliente --</option>
                                    @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                       </div>
                        <div class="w-2/12 form-item">
                            <div class="w-full form-item">
                                <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                                <x-select wire:model.lazy="proveedor_id" selectname="proveedor_id" class="w-full" >
                                    <option value="">-- Selecciona proveedor --</option>
                                    @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                       </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="fechapedido">{{ __('Fecha pedido') }}</x-jet-label>
                            <input  wire:model="fechapedido" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="fechaarchivos">{{ __('Fecha archivos') }}</x-jet-label>
                            <input  wire:model="fechaarchivos" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="fechaplotter">{{ __('Fecha plotter') }}</x-jet-label>
                            <input  wire:model="fechaplotter" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="fechaentrega">{{ __('Fecha entrega') }}</x-jet-label>
                            <input  wire:model="fechaentrega" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                    </div>
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="tiradaprevista">{{ __('Tiradaprevista') }}</x-jet-label>
                            <input  wire:model="tiradaprevista" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="tiradareal">{{ __('Tirada real') }}</x-jet-label>
                            <input  wire:model="tiradareal" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="precio">{{ __('€ Precio') }}</x-jet-label>
                            <input  wire:model="precio" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="preciototal">{{ __('€ Precio total') }}</x-jet-label>
                            <input  wire:model="preciototal" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                    </div>
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="parcial">{{ __('Parcial') }}</x-jet-label>
                            <input  wire:model="parcial" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                            <input  wire:model="estado" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="facturado">{{ __('Facturado') }}</x-jet-label>
                            <input  wire:model="facturado" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="cd_dvd">{{ __('cd_dvd') }}</x-jet-label>
                            <input  wire:model="cd_dvd" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="distribucion">{{ __('distribucion') }}</x-jet-label>
                            <input  wire:model="distribucion" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="cajas">{{ __('cajas') }}</x-jet-label>
                            <input  wire:model="cajas" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="incidencias">{{ __('incidencias') }}</x-jet-label>
                            <input  wire:model="incidencias" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="retardos">{{ __('retardos') }}</x-jet-label>
                            <input  wire:model="retardos" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>

                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                        <div class="w-full form-item">
                            <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                            <textarea wire:model.defer="otros" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                            <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                        </div>
                    </div>
                </div>
                <div class="p-2 m-2 ">
                    <div class="w-full form-item">
                        <x-jet-label for="ficheropdf">{{ __('Ficha pedido') }}</x-jet-label>
                        <div class="flex">
                            <input type="file" wire:model="ficheropdf">
                            @if($fichapedido)
                                <x-icon.pdf-a wire:click="presentaPDF({{ $pedido }})" class="pt-2 ml-2" title="PDF"/>
                            @endif
                            @error('ficheropdf') <p class="text-red-500">{{ $message }}</p> @enderror
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
                        <x-jet-secondary-button  onclick="location.href = '{{route('pedido.index')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


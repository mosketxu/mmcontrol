<div class="">
    {{-- @livewire('menu',['pedido'=>$pedido],key($pedido->id)) --}}

    <div class="h-full p-1 mx-2">
        <div class=" flex space-x-3">
            <div class="">
                <h1 class="text-2xl font-semibold text-gray-900"> {{ $titulo }}
                    <input  class="w-28 text-gray-500 border border-blue-300 rounded shadow-md" wire:model.lazy="pedidoid" type="number" readonly/>
                </h1>
            </div>
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.parciales',$pedidoid)}}'">{{ __('Parciales') }}</x-jet-secondary-button>
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.facturaciones',$pedidoid)}}'">{{ __('facturaciones') }}</x-jet-secondary-button>
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.archivos',$pedidoid)}}'">{{ __('archivos') }}</x-jet-secondary-button>
        </div>
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('pedidos.pedidofilters')
            </div>
            {{-- datos del pedido --}}
            {{-- <div class="h-screen"> --}}
            <div class="flex-col space-y-4 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-2 m-2 ">
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos generales</h3>
                            <input  wire:model.defer="pedidoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    <x-select wire:model.lazy="cliente_id" selectname="cliente_id" class="w-full" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    <x-select wire:model.lazy="contacto_id" selectname="contacto_id" class="w-full" >
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->id }}">{{ $contacto->entidadcontacto->entidad }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="producto_id">{{ __('ISBN/Cód.') }}</x-jet-label>
                                    <x-select wire:model.lazy="producto_id" selectname="producto_id" class="w-full" >
                                        <option value=''>-- Selecciona ISBN --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->isbn .' - '. $producto->referencia}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="producto_id">{{ __('Título/Ref.') }}</x-jet-label>
                                    <x-select wire:model.lazy="producto_id" selectname="producto_id" class="w-full" >
                                        <option value="">-- Selecciona Referencia --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->referencia .' - '. $producto->isbn}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                                    <x-select wire:model.lazy="proveedor_id" selectname="proveedor_id" class="w-full" >
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="responsable_id">{{ __('Responsable') }}</x-jet-label>
                                    <x-select wire:model.lazy="responsable_id" selectname="responsable_id" class="w-full" >
                                        <option value="">-- Selecciona el responsable --</option>
                                        @foreach ($responsables as $responsable)
                                        <option value="{{ $responsable->id }}">{{ $responsable->name }}</option>
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
                                <input  wire:model.lazy="fechapedido" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaarchivos">{{ __('Fecha archivos') }}</x-jet-label>
                                <input  wire:model.lazy="fechaarchivos" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaplotter">{{ __('Fecha plotter') }}</x-jet-label>
                                <input  wire:model.lazy="fechaplotter" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaentrega">{{ __('Fecha entrega') }}</x-jet-label>
                                <input  wire:model.lazy="fechaentrega" type="date" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="tiradaprevista">{{ __('Tirada Prevista') }}</x-jet-label>
                                <input  wire:model.lazy="tiradaprevista" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="tiradareal">{{ __('Tirada Real') }}</x-jet-label>
                                <input  wire:model.lazy="tiradareal" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="preciocoste">{{ __('€ Precio Coste') }}</x-jet-label>
                                <input  wire:model.lazy="preciocoste" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="precioventa">{{ __('€ Precio Venta') }}</x-jet-label>
                                <input  wire:model.lazy="precioventa"  type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="preciototal">{{ __('€ Precio total') }}</x-jet-label>
                                <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="parcial">{{ __('Parcial') }}</x-jet-label>
                                <input  wire:model.lazy="parcial" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-select wire:model.lazy="estado" selectname="estado" class="w-full" >
                                        <option value="0">{{ __('En curso') }}</option>
                                        <option value="1">{{ __('Finalizado') }}</option>
                                        <option value="3">{{ __('Cancelado') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturado">{{ __('Facturado') }}</x-jet-label>
                                    <x-select wire:model.lazy="facturado" selectname="facturado" class="w-full" >
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Sí') }}</option>
                                        <option value="3">{{ __('Parcial') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="distribucion">{{ __('distribucion') }}</x-jet-label>
                                <input  wire:model.lazy="distribucion" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="uds_caja">{{ __('Uds x Caja') }}</x-jet-label>
                                <input  wire:model.lazy="uds_caja" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="incidencias">{{ __('incidencias') }}</x-jet-label>
                                <input  wire:model.lazy="incidencias" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="retardos">{{ __('retardos') }}</x-jet-label>
                                <input  wire:model.lazy="retardos" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
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
</div>


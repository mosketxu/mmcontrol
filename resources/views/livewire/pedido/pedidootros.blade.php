<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 ">
            <div class="">
                @include('errores')
            </div>
            <div class="">
            </div>
            {{-- datos del pedido --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 ">
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos generales</h3>
                            <input  wire:model.defer="pedidoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 md:flex-row md:space-x-4">
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
                                            <option value=''>-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                                <option value="{{ $contacto->contacto_id }}" {{ $contacto->contacto_id == $this->contacto_id ? "selected" : ""}}>{{ $contacto->entidadcontacto->entidad }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="oferta_id">{{ __('Oferta') }}</x-jet-label>
                                    <x-select wire:model.lazy="oferta_id" selectname="oferta_id" class="w-full" >
                                        @if (isset($ofertas))
                                            <option value="">-- Selecciona la oferta aceptada --</option>
                                            @foreach ($ofertas as $oferta)
                                            <option value="{{ $oferta->id }}">{{ $oferta->id }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="pedidocliente">{{ __('Pedido Cliente') }}</x-jet-label>
                                <input  wire:model.lazy="pedidocliente" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="descripcion">{{ __('Descripción') }}</x-jet-label>
                                <input  wire:model.lazy="descripcion" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Proveedor') }}</x-jet-label>
                                    <x-select wire:model.lazy="proveedor_id" selectname="proveedor_id" class="w-full" >
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>

                            <div class="w-full form-item">
                                <x-jet-label for="fechapedido">{{ __('Fecha pedido') }}</x-jet-label>
                                <input  wire:model.lazy="fechapedido" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaarchivos">{{ __('Fecha archivos') }}</x-jet-label>
                                <input  wire:model.lazy="fechaarchivos" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaplotter">{{ __('Fecha plotter') }}</x-jet-label>
                                <input  wire:model.lazy="fechaplotter" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaentrega">{{ __('Fecha entrega') }}</x-jet-label>
                                <input  wire:model.lazy="fechaentrega" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="tiradaprevista">{{ __('Tirada Prevista') }}</x-jet-label>
                                <input  wire:model.lazy="tiradaprevista" type="number" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="tiradareal">{{ __('Tirada Real') }}</x-jet-label>
                                <input  wire:model.lazy="tiradareal" type="number" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="precio">{{ __('€ Precio Venta') }}</x-jet-label>
                                <input  wire:model.lazy="precio"  type="number" step="any" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="preciototal">{{ __('€ Precio total') }}</x-jet-label>
                                <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-1.5 text-xs bg-blue-50 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                                <textarea wire:model.defer="otros" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('observaciones') }} </textarea>
                                <input-error for="otros" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Estado del pedido</h3>
                            <input  wire:model.defer="pedidoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            {{-- facturado por --}}
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturadopor">{{ __('Factura') }}</x-jet-label>
                                    <x-select wire:model.lazy="facturadopor" selectname="facturadopor" class="w-full" >
                                        <option value="">- ¿Quién factura? -</option>
                                        <option value="1">Milimetrica</option>
                                        <option value="0">Proveedor</option>
                                    </x-select>
                                </div>
                            </div>
                            {{-- responsable --}}
                            <div class="w-full form-item">
                                <x-jet-label for="responsable">{{ __('Responsable') }}</x-jet-label>
                                <x-select wire:model.lazy="responsable" selectname="responsable" class="w-full" >
                                    <option value="">-- Selecciona el responsable --</option>
                                    @foreach ($responsables as $responsable )
                                    <option value="{{ $responsable->responsable}}">{{ $responsable->responsable}}</option>
                                @endforeach
                                </x-select>
                            </div>
                            {{-- estado --}}
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-select wire:model.lazy="estado" selectname="estado" class="w-full" >
                                        <option value="0">{{ __('En curso') }}</option>
                                        <option value="1">{{ __('Finalizado') }}</option>
                                        <option value="2">{{ __('Cancelado') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            {{-- facturado --}}
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturado">{{ __('Facturado') }}</x-jet-label>
                                    <x-select wire:model.lazy="facturado" selectname="facturado" class="w-full" >
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Sí') }}</option>
                                        <option value="2">{{ __('Parcial') }}</option>
                                    </x-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-1 pb-1 mx-1 ">
                        <div class="flex flex-col mx-2 md:flex-row md:space-x-4">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                @if($pedidoid)
                {{-- <div class="grid grid-cols-2 gap-1 "> --}}
                    <div class="p-1 border rounded-md">
                        Procesos
                        @livewire('pedido.pedido-proceso',['pedidoid'=>$pedidoid,'deshabilitado'=>$deshabilitado],key($pedidoid.now()))
                    </div>
                    <div class="p-1 border rounded-md">
                        Productos
                        @livewire('pedido.pedido-producto',['pedidoid'=>$pedidoid,'deshabilitado'=>$deshabilitado],key($pedidoid.now()))
                    </div>
                {{-- </div> --}}
                @endif
            </div>
        </div>
    </div>
</div>

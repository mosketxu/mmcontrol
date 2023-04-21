<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                    {{-- @include('presupuestos.presupuestoeditorialfilters') --}}
            </div>
            {{-- datos del presupuesto --}}
            <div class="flex-col space-y-1 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 space-y-1">
                        <div class="flex p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos generales</h3>
                            <input  wire:model.defer="presupuestoid" type="hidden"/>
                            @if($tipo!='1')
                            <x-select wire:model.defer="tipo" selectname="tipo" class="w-1/12 py-0 ml-2" >
                                <option value="2">Packaging</option>
                                <option value="3">Propios</option>
                            </x-select>
                            @endif
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="fechapresupuesto">{{ __('Fecha presupuesto') }}</x-jet-label>
                                    <input  wire:model.lazy="fechapresupuesto" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    <select wire:model.lazy="cliente_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        requiered {{ $deshabilitado }}>
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    <select wire:model.lazy="contacto_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}" {{ $contacto->contacto_id == $this->contacto_id ? "selected" : ""}}>{{ $contacto->entidadcontacto->entidad ?? $contacto->id.'-'}}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                                    <select wire:model.lazy="proveedor_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="responsable">{{ __('Responsable') }}</x-jet-label>
                                    <select wire:model.lazy="responsable"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value="">-- Selecciona el responsable --</option>
                                        @foreach ($responsables as $responsable )
                                            <option value="{{ $responsable->responsable}}">{{ $responsable->responsable}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturadopor">{{ __('Facturado x') }}</x-jet-label>
                                    <select wire:model.lazy="facturadopor"
                                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}>
                                        <option value="">- ¿Quién factura? -</option>
                                        <option value="1">Milimetrica</option>
                                        <option value="0">Proveedor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label for="descripcion">{{ __('Descripcion') }}</x-jet-label>
                                <textarea wire:model.defer="descripcion" class="w-full text-xs border-gray-300 rounded-md" rows="1" {{ $deshabilitado }}> </textarea>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="tirada">{{ __('Cantidad') }}</x-jet-label>
                                    <input  wire:model.lazy="tirada" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="precio_ud">{{ __('Precio Ud.') }}</x-jet-label>
                                    <input  wire:model.lazy="precio_ud" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="preciototal">{{ __('Precio Total') }}</x-jet-label>
                                    <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="transporte">{{ __('Transporte') }}</x-jet-label>
                                    <input  wire:model.lazy="transporte" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="troquel">{{ __('Troquel') }}</x-jet-label>
                                    <input  wire:model.lazy="troquel" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full mx-auto">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <select wire:model.lazy="estado"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value="0">{{ __('Enviado') }}</option>
                                        <option value="1">{{ __('Aceptado') }}</option>
                                        <option value="2">{{ __('Rechazado') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full text-center form-item">
                                @if($espedido=='1')
                                <div class="flex-none w-full md:flex">
                                    <div class="w-full form-item">
                                        <x-jet-label for="espedido">{{ __('Pedido') }}</x-jet-label>
                                        <a class="text-blue-700 underline" href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Pedido">{{ $pedido }}</a>
                                    </div>
                                    <div class=" form-item">
                                        <x-jet-label for="asignarpedido">{{ __('Asignar otro pedido') }}</x-jet-label>
                                        <x-select class="w-/12" selectname="pedido" wire:model.lazy="pedido">
                                            <option value="">-- Selecciona un pedido --</option>
                                            @foreach ($pedidos as $ped )
                                            <option value="{{ $ped->id }}">{{ $ped->id }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                                @else
                                <button class="inline-flex items-center px-2 py-2 mt-2 text-sm font-semibold text-white transition bg-blue-600 border border-transparent rounded-md tracking-tigh hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25"
                                    wire:click.prevent="pedido( {{ $presupuestoid }} )"
                                    onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">{{ __('Convertir en Pedido') }}
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                                <textarea wire:model.defer="otros" class="w-full text-xs border-gray-300 rounded-md" rows="1" {{ $deshabilitado }}> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="p-1 m-1 ">
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('presupuesto.tipo',[$tipo,'e'])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            @if($presupuestoid)
                                @if($deshabilitado=='disabled')
                                    <x-icon.lock-a class="" wire:click.prevent="desbloquear()"  title="Bloqueado"/>
                                @else
                                    <x-icon.lock-open-a class="" wire:click.prevent="desbloquear()"  title="Desbloqueado"/>
                                @endif
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                @if($presupuestoid)
                {{-- <div class="grid grid-cols-2 gap-1 "> --}}
                    <div class="p-1 border rounded-md">
                        Procesos
                        @livewire('presupuesto.presupuesto-proceso',['presupuestoid'=>$presupuestoid,'deshabilitado'=>$deshabilitado],key($presupuestoid.now()))
                    </div>
                    <div class="p-1 border rounded-md">
                        Productos
                        @livewire('presupuesto.presupuesto-producto',['presupuestoid'=>$presupuestoid,'deshabilitado'=>$deshabilitado],key($presupuestoid.now()))
                    </div>
                {{-- </div> --}}
                @endif
            </div>
        </div>
    </div>
</div>


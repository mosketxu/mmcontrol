<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                    @include('presupuestos.presupuestoeditorialfilters')
            </div>
            {{-- datos del presupuesto --}}
            <div class="flex-col space-y-1 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 space-y-1">
                        {{-- Datos generales --}}
                        <div class="">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Datos generales</h3>
                                <input  wire:model.defer="presupuestoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                {{-- fecha --}}
                                <div class="w-full form-item">
                                    <x-jet-label for="fechapresupuesto">{{ __('Fecha presupuesto') }}</x-jet-label>
                                    <input  wire:model.lazy="fechapresupuesto" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $deshabilitado }}/>
                                </div>
                                {{-- Cliente --}}
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    <select wire:model.lazy="cliente_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- contacto --}}
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    <select wire:model.lazy="contacto_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        @if (isset($contactos))
                                            @if(!$contacto_id) <option value="">-- Selecciona contacto --</option> @endif
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}" {{ $contacto->contacto_id == $this->contacto_id ? "selected" : ""}}>{{ $contacto->entidadcontacto->entidad ?? '-'}}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </select>
                                </div>
                                {{-- producto ISBN --}}
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('ISBN/Cód.') }}</x-jet-label>
                                    <select wire:model.lazy="productoeditorialid"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value=''>-- Selecciona ISBN --</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" >{{ $producto->isbn }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- producto titulo --}}
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Título/Ref.') }}</x-jet-label>
                                    <select wire:model.lazy="productoeditorialid"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                        <option value="">-- Selecciona Referencia --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->referencia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Detalle presupuesto --}}
                        <div class="space-y-1">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Detalle</h3>
                                <input  wire:model.defer="presupuestoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                {{-- Proveedor --}}
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
                                {{-- Tirada --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="tirada">{{ __('Tirada') }}</x-jet-label>
                                        <input  wire:model.lazy="tirada" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}/>
                                    </div>
                                </div>
                                {{-- Precio ud --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="precio_ud">{{ __('Precio Ud.') }}</x-jet-label>
                                        <input  wire:model.lazy="precio_ud" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}/>
                                    </div>
                                </div>
                                {{-- Precio tot --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="preciototal">{{ __('Precio Total') }}</x-jet-label>
                                        <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    </div>
                                </div>
                                {{-- caja --}}
                                <div class="w-full form-item">
                                    <div class="w-full mx-auto">
                                        <x-jet-label for="caja_id">{{ __('Caja') }}</x-jet-label>
                                        <select wire:model.lazy="caja_id"
                                            class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $deshabilitado }}>
                                                <option value="">--Selecciona Caja--</option>
                                                @foreach ($cajas as $caja )
                                                    <option value="{{ $caja->id }}">{{ $caja->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- uds x caja --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="uds_caja">{{ __('Uds x Caja') }}</x-jet-label>
                                        <input  wire:model.lazy="uds_caja" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}/>
                                    </div>
                                </div>
                            </div>
                            {{-- Manipulacion    --}}
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <x-jet-label for="manipulacion">{{ __('Manipulación') }}</x-jet-label>
                                    <textarea wire:model.defer="manipulacion" class="w-full text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}> </textarea>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label for="transporte">{{ __('Distribución') }}</x-jet-label>
                                    <textarea wire:model.defer="transporte" class="w-full text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}> </textarea>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label for="especificacioneslogisticas">{{ __('Especificaciones Logísticas') }}</x-jet-label>
                                    <textarea wire:model.defer="especificacioneslogisticas" class="w-full text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}> </textarea>
                                </div>
                            </div>
                            {{-- otros --}}
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                                    <textarea wire:model.defer="otros" class="w-full py-1 text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}> </textarea>
                                </div>
                            </div>
                        </div>
                        {{-- control pedido --}}
                        <div class="">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Control del pedido</h3>
                                <input  wire:model.defer="presupuestoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                {{-- facturado Por --}}
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
                                {{-- responsable MM --}}
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
                                {{-- estado --}}
                                <div class="w-full mx-auto">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <select wire:model.lazy="estado"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $deshabilitado }}>
                                    <option value="0">{{ __('En curso') }}</option>
                                        <option value="1">{{ __('Finalizado') }}</option>
                                        <option value="2">{{ __('Cancelado') }}</option>
                                    </select>
                                </div>
                                {{-- es pedido o convertir a pedido --}}
                                <div class="w-full text-center form-item">
                                    @if($espedido=='1')
                                    <div class="w-full form-item">
                                        <x-jet-label for="espedido">{{ __('Pedido') }}</x-jet-label>
                                        <a class="text-blue-700 underline" href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Pedido">{{ $pedido }}</a>
                                    </div>
                                    @else
                                    <button class="inline-flex items-center px-2 py-2 mt-2 text-sm font-semibold text-white transition bg-blue-600 border border-transparent rounded-md tracking-tigh hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25"
                                        wire:click.prevent="pedido( {{ $presupuestoid }} )"
                                        onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">{{ __('Convertir en Pedido') }}
                                    </button>
                                    @endif
                                </div>
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
        </div>
    </div>
</div>


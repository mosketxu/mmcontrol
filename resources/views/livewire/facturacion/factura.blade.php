<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            {{-- datos de la factura --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 space-y-1">
                        <div class="flex p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos de la {{ ($fac && $fac->esPrefactura()) ? 'prefactura' : 'factura' }}</h3>
                            @if($fac)
                                @if($fac->esPrefactura())
                                    <span style="margin-left:8px;padding:2px 8px;font-size:12px;background:#fef3c7;color:#92400e;border-radius:6px">PREFACTURA · borrador</span>
                                @elseif($fac->estaCerrada())
                                    <span style="margin-left:8px;padding:2px 8px;font-size:12px;background:#e5e7eb;color:#374151;border-radius:6px">Factura cerrada · no modificable</span>
                                @else
                                    <span style="margin-left:8px;padding:2px 8px;font-size:12px;background:#dcfce7;color:#166534;border-radius:6px">Factura creada · modificable hasta el {{ \Carbon\Carbon::parse(config('facturacion.cierre'))->format('d/m/Y') }}</span>
                                @endif
                            @endif
                            <input  wire:model.defer="facturaid" type="hidden"/>
                            {{-- @if($tipo!='1') --}}
                            <div class="w-40 ml-2"><x-combo wire:model.defer="tipo" :options="[['id'=>'1','label'=>'Editorial'],['id'=>'2','label'=>'Packaging'],['id'=>'3','label'=>'Propios']]" placeholder="--Selecciona--" /></div>
                            {{-- @endif --}}
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="facturaid">{{ __('Nº Factura') }}</x-jet-label>
                                <input  wire:model.lazy="facturaid" type="number" class="w-full px-0 py-1 text-xs text-center border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-3/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-combo wire:model.lazy="cliente_id" :options="collect($clientes)->map(fn($cliente)=>['id'=>$cliente->id,'label'=>($cliente->entidad)])->values()->all()" placeholder="-- Selecciona cliente --" />
                                    @else
                                        <input  type="text" value="{{ $fac->cliente->entidad ?? '' }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-3/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-combo wire:model.defer="contacto_id" :options="collect($contactos ?? [])->map(fn($c)=>['id'=>$c->contacto_id,'label'=>$c->entidadcontacto->entidad ?? '-'])->values()->all()" placeholder="{{ isset($contactos) ? '-- Selecciona un contacto --' : '-- Selecciona primero un cliente --' }}" />
                                    @else
                                        <input  type="text" value="{{ $fac->contacto->entidad ?? '' }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-2/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="pedidocliente">{{ __('Su Pedido') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-combo wire:model.defer="pedidocliente" :options="collect($pedidos ?? [])->map(fn($p)=>['id'=>$p['pedidocliente'],'label'=>$p['pedidocliente']])->values()->all()" placeholder="{{ isset($pedidos) ? '-- Selecciona un pedido --' : '-- Selecciona primero un cliente --' }}" />
                                    @else
                                    <input  type="text" value="{{ $pedidocliente }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="fecha">{{ __('Fecha Factura') }}</x-jet-label>
                                <input  wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/
                                {{ $bloqueado!='0' ? 'disabled' :'' }}>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="fechavencimiento">{{ __('Fecha Vto') }}</x-jet-label>
                                <input  wire:model.lazy="fechavencimiento" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/
                                {{ $bloqueado!='0' ? 'disabled' :'' }}>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="importe" class="mr-6 text-right">{{ __('Subtotal') }}</x-jet-label>
                                <input  wire:model.lazy="importe" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="iva" class="mr-6 text-right">{{ __('Iva') }}</x-jet-label>
                                <input  wire:model.lazy="iva" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="total" class="mr-6 text-right">{{ __('Total') }}</x-jet-label>
                                <input  wire:model.lazy="total" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-combo wire:model.lazy="estado" :options="collect($estados)->map(fn($estado, $valor)=>['id'=>$valor,'label'=>($estado[1])])->values()->all()" />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                                <textarea wire:model.defer="observaciones"
                                class="w-full py-1 text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}>{{ old('observaciones') }} </textarea>
                                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="p-0 m-2 ">
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('facturacion.index')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
                            @if($fac && $fac->esPrefactura() && $escliente=='')
                                <button type="button" wire:click="crearFactura"
                                    onclick="confirm('¿Crear la factura? Podrá modificarse hasta el {{ \Carbon\Carbon::parse(config('facturacion.cierre'))->format('d/m/Y') }}.') || event.stopImmediatePropagation()"
                                    style="padding:6px 14px;font-size:12px;color:#fff;background:#16a34a;border-radius:6px;font-weight:600;text-transform:uppercase">Crear factura</button>
                            @endif
                            @if($bloqueado!='0')
                                <x-icon.lock/>
                                @else
                                <x-icon.lock-open/>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                @if($facturaid)
                    @livewire('facturacion.fdetalle',['facturaid'=>$facturaid,'deshabilitado'=>$deshabilitado],key($facturaid.now()))
                @endif
            </div>
        </div>
    </div>
</div>

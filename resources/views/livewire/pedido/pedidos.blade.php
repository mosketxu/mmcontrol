<div class="">
    {{-- @livewire('menu',['entidad'=>$pedido],key($pedido->id)) --}}
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @if($tipo=='1')
                    @include('pedidos.pedidoseditorialfilters')
                @else
                    {{-- @include('pedidos.pedidosotrosfilters') --}}
                @endif
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        <div class="flex w-full text-sm  pt-2 pb-0 pl-2 font-bold text-gray-500 bg-blue-100 rounded-t-md space-x-2">
                            <div class="flex w-5 h-5 mr-2 font-medium text-center" >
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                            <div class="w-1/12 text-left" >{{ __('Pedido') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-1/12 text-left" >{{ __('ISBN') }} </div>
                            <div class="w-2/12 text-left" >{{ __('Referencia') }}</div>
                            <div class="w-1/12 text-right">{{ __('F.Entrega') }}</div>
                            <div class="w-1/12 text-right">{{ __('F. Archivos') }}</div>
                            <div class="w-1/12 text-right">{{ __('F.Plotters') }}</div>
                            <div class="w-2/12 text-left pl-2" >{{ __('Proveedor') }}</div>
                            <div class="w-2/12 text-right pr-6">{{ __('Q.Prev/Q.Real') }}</div>
                            <div class="w-2/12 text-center">{{ __('Estado') }}</div>
                            <div class="w-1/12 text-center">{{ __('Facturado') }}</div>
                            <div class="w-2/12  text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @if($selectPage)
                        <div class="flex w-full bg-gray-200  text-sm text-left border-t-0 border-y" wire:key="row-message">
                            <div class="flex-col w-full text-left">
                                @unless($selectAll)
                                    <span>Has seleccionado <strong>{{ $pedidos->count() }}</strong> pedidos, ¿quieres seleccionar el total: <strong>{{ $pedidos->total() }}</strong> ?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select all</x-button.link>
                                @else
                                    <span>Has seleccionado <strong>todos</strong> los {{ $pedidos->total() }} pedidos</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @forelse ($pedidos as $pedido)
                        <div class="flex w-full text-sm border-t-0 border-y space-x-2 text-gray-500  " wire:loading.class.delay="opacity-50">
                            <div class="flex w-5 h-5 p-2 mr-2 font-medium text-center">
                                <x-input.checkbox wire:model="selected" value="{{ $pedido->id }}" />
                            </div>
                            <div class="flex-col w-1/12 text-left my-2">
                                {{ $pedido->id }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->id }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-2/12 text-left my-2">
                                {{ $pedido->cliente->entidad }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->cliente->entidad }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-1/12 text-left my-2">
                                {{ $pedido->isbn }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->isbn }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-2/12 text-left my-2">
                                {{ $pedido->referencia }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                        value="{{ $pedido->referencia }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-1/12 text-right my-2">
                                {{ $pedido->fentrega }}
                                {{-- <input type="text" class="w-full py-1 pr-3 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fentrega }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-1/12 text-right my-2">
                                {{ $pedido->farchivos }}
                                {{-- <input type="text" class="w-full py-1 pr-3 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->farchivos }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-1/12 text-right my-2">
                                {{ $pedido->fplotter }}
                                {{-- <input type="text" class="w-full py-1 pr-3 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fplotter }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-2/12 text-left my-2 pl-2">
                                {{ $pedido->proveedor->entidad }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->proveedor->entidad }}"  readonly/> --}}
                            </div>
                            <div class="flex-col w-2/12 text-right my-2 pr-2">
                                {{ $pedido->tiradaprevista .' / '. $pedido->tiradareal }}
                                {{-- <input type="text" class="w-full py-1 text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->tiradaprevista .' / '. $pedido->tiradareal }} "  readonly/> --}}
                            </div>
                            <div class="flex-col w-2/12 text-right">
                                <select wire:change="changeValor({{ $pedido }},'estado',$event.target.value)"
                                    class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $pedido->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $pedido->estado== '0'? 'selected' : '' }}>En curso</option>
                                    <option value="1" {{ $pedido->estado== '1'? 'selected' : '' }}>Finalizado</option>
                                    <option value="2" {{ $pedido->estado== '2'? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <div class="flex-col w-1/12 text-right">
                                <select wire:change="changeValor({{ $pedido }},'facturado',$event.target.value)"
                                    class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $pedido->facturado_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $pedido->facturado== '0'? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $pedido->facturado== '1'? 'selected' : '' }}>Sí</option>
                                    <option value="2" {{ $pedido->facturado== '2'? 'selected' : '' }}>Parcial</option>
                                </select>
                            </div>
                            <div class="flex flex-row-reverse w-2/12 pr-2 mt-1 ">
                                <x-icon.delete-a wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                                <x-icon.edit-a href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Editar"/>
                                <x-icon.truck-a class="w-5 my-2 text-pink-500 hover:text-pink-700 " onclick="location.href = '{{route('pedido.parciales',[$pedido->id,'i'])}}'" title="Albaranes"/>
                                <x-icon.euro-a class="w-5 text-orange-500 hover:text-orange-700 " onclick="location.href = '{{route('pedido.facturaciones',[$pedido->id,'i'])}}'" title="Facturaciones"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('pedido.archivos',[$pedido->id,'i'])}}'" title="Archivo"/>
                            </div>
                        </div>
                        @empty
                        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
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
                </div>
            <div>
                {{ $pedidos->links() }}
            </div>
        </div>
    </div>
</div>

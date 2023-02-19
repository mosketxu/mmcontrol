<div class="">
    {{-- @livewire('menu',['entidad'=>$pedido],key($pedido->id)) --}}
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('pedidos.pedidoseditorialfilters')
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        {{-- titulos --}}
                        <div class="flex w-full pt-2 pb-0 pl-2 space-x-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                            <div class="flex w-5 h-5 mr-2 font-medium text-center" >
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                            <div class="w-1/12 text-left" >{{ __('Pedido') }}</div>
                            <div class="w-1/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-1/12 text-left" >{{ __('Presup.') }}</div>
                            {{-- <div class="w-1/12 text-left" >{{ __('Cod./ref') }} </div> --}}
                            <div class="w-2/12 text-left" >{{ __('Descripción') }}</div>
                            <div class="w-2/12 text-right">{{ __('F.Entrega') }}</div>
                            {{-- <div class="w-2/12 pr-6 text-right">{{ __('Q.Prev/Q.Real') }}</div> --}}
                            <div class="w-1/12 text-center">{{ __('Estado') }}</div>
                            <div class="w-1/12 text-center">{{ __('Facturado') }}</div>
                            <div class="w-3/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @if($selectPage)
                        <div class="flex w-full text-sm text-left bg-gray-200 border-t-0 border-y" wire:key="row-message">
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
                        <div class="flex w-full space-x-2 text-sm text-gray-500 border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                            <div class="flex w-5 h-5 p-2 mr-2 font-medium text-center"><x-input.checkbox wire:model="selected" value="{{ $pedido->id }}" /></div>
                            <div class="flex-col w-1/12 my-2 text-left">{{ $pedido->id }}</div>
                            <div class="flex-col w-1/12 my-2 text-left">{{ $pedido->cliente->entidad }}</div>
                            <div class="flex-col w-1/12 my-2 text-left">
                                @if($pedido->presupuesto_id)
                                <a class="text-blue-700 underline" href="{{ route('presupuesto.editar',[$pedido->presupuesto_id,'i']) }}"  title="Pedido">{{ $pedido->presupuesto_id }}</a>
                                @endif
                            </div>
                            {{-- <div class="flex-col w-1/12 my-2 text-left">{{ $pedido->isbn }}</div> --}}
                            <div class="flex-col w-2/12 my-2 text-left">{{ $pedido->descripcion }}</div>
                            <div class="flex-col w-2/12 my-2 text-right">{{ $pedido->fentrega }}</div>
                            {{-- <div class="flex-col w-2/12 pr-2 my-2 text-right">{{ $pedido->tiradaprevista .' / '. $pedido->tiradareal }}</div> --}}
                            <div class="flex-col w-1/12 text-right">
                                <select wire:change="changeValor({{ $pedido }},'estado',$event.target.value)"
                                    class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $pedido->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $pedido->estado== '0'? 'selected' : '' }}>Curso</option>
                                    <option value="1" {{ $pedido->estado== '1'? 'selected' : '' }}>Fin.</option>
                                    <option value="2" {{ $pedido->estado== '2'? 'selected' : '' }}>Canc.</option>
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
                            <div class="w-3/12 space-x-3 text-center">
                                <x-icon.edit-a class="" href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Editar"/>
                                <x-icon.truck-a class="w-5  text-pink-500 hover:text-pink-700 " onclick="location.href = '{{route('pedido.parciales',[$pedido->id,'i'])}}'" title="Albaranes"/>
                                <x-icon.building-circle-arrow-right-a class="w-5  text-gray-500 hover:text-gray-900 " onclick="location.href = '{{route('pedido.distribuciones',[$pedido->id,'i'])}}'" title="Distribuciones"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('pedido.archivos',[$pedido->id,'i'])}}'" title="Archivo"/>
                                <x-icon.triangleexclamation-a class="w-6  text-yellow-500 hover:text-yellow-700 " onclick="location.href = '{{route('pedido.incidencias',[$pedido,'i'])}}'" title="Incidencias"/>
                                <x-icon.sandwatch-a class="w-5  text-brown-500 hover:text-brown-700 " onclick="location.href = '{{route('pedido.retrasos',[$pedido,'i'])}}'" title="Retrasos"/>
                                <x-icon.pdf-a class="w-5 text-red-500 hover:text-red-700 " href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank" />
                                <x-icon.delete-a class="w-6" wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
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

<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                    @include('presupuestos.presupuestosotrosfilters')
            </div>
            {{-- tabla presupuesots --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        {{-- titulos --}}
                        <div class="flex w-full pt-2 pb-0 space-x-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md ">
                            <div class="flex w-5 h-5 px-2 mr-2 font-medium text-center" >
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                            <div class="w-1/12 text-left" >{{ __('Nº.Presup') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Descripción') }}</div>
                            <div class="w-2/12 text-left">{{ __('F.Presup') }}</div>
                            {{-- <div class="w-1/12 text-left" >{{ __('Fact.Por') }}</div> --}}
                            <div class="w-1/12 text-right">{{ __('Cantidad') }}</div>
                            {{-- <div class="w-1/12 text-right">{{ __('Precio Ud.') }}</div> --}}
                            <div class="w-1/12 text-right">{{ __('Precio Total') }}</div>
                            <div class="w-1/12 text-center">{{ __('Estado') }}</div>
                            <div class="w-1/12 text-center">{{ __('Pedido') }}</div>
                            <div class="w-1/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @if($selectPage)
                        <div class="flex w-full text-sm text-left bg-gray-200 border-t-0 border-y" wire:key="row-message">
                            <div class="flex-col w-full text-left">
                                @unless($selectAll)
                                    <span>Has seleccionado <strong>{{ $presupuesto->count() }}</strong> presupuestos, ¿quieres seleccionar el total: <strong>{{ $presupuesto->total() }}</strong> ?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select all</x-button.link>
                                @else
                                    <span>Has seleccionado <strong>todos</strong> los {{ $presupuesto->total() }} presupuestos</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @forelse ($presupuestos as $presupuesto)
                        <div class="flex w-full space-x-1 text-sm text-gray-500 border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                            <div class="flex w-5 h-5 p-2 mr-2 font-medium text-center"><x-input.checkbox wire:model="selected" value="{{ $presupuesto->id }}" /></div>
                            <div class="flex-col w-1/12 my-2 text-left">{{ $presupuesto->id }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->cliente->entidad }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->descripcion }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->fpresupuesto4 }}</div>
                            {{-- <div class="flex-col w-1/12 my-2 text-left">{{ $presupuesto->facturadopor=='1' ? 'MM' : 'Proveedor' }}</div> --}}
                            <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->tirada }}</div>
                            {{-- <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->precio_ud }}</div> --}}
                            <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->preciototal }}</div>
                            <div class="flex-col w-1/12 text-right">
                                <select wire:change="changeValor({{ $presupuesto }},'estado',$event.target.value)"
                                    class="w-full mx-2 text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $presupuesto->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $presupuesto->estado== '0'? 'selected' : '' }}>Enviado</option>
                                    <option value="1" {{ $presupuesto->estado== '1'? 'selected' : '' }}>Aceptado</option>
                                    <option value="2" {{ $presupuesto->estado== '2'? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            <div class="flex-col w-1/12 text-center">
                                @if($presupuesto->pedido)
                                    <a class="text-blue-700 underline " href="{{ route('pedido.editar',[$presupuesto->pedido ,'i']) }}"  title="Pedido">{{ $presupuesto->pedido }}</a>
                                @endif
                            </div>
                            <div class="flex flex-row-reverse w-1/12 pr-2 mt-1 ">
                                <x-icon.delete-a wire:click.prevent="delete({{ $presupuesto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('presupuesto.archivos',[$presupuesto->id,'i'])}}'" title="Archivo"/>
                                <a href="{{route('presupuesto.presupuestoPDF',$presupuesto)}}" target="_blank" ><x-icon.pdf class="text-red-500 hover:text-red-700 " title="PDF Presupuesto"/></a>
                                <x-icon.edit-a class="" href="{{ route('presupuesto.editar',[$presupuesto,'i']) }}"  title="Editar"/>
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
                {{ $presupuestos->links() }}
            </div>
        </div>
    </div>
</div>

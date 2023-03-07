<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="w-full">
                    @include('presupuestos.presupuestoseditorialfilters')
            </div>
            {{-- tabla presupuesots --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        <div class="flex w-full pt-2 pb-0 space-x-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md ">
                            <div class="w-1/12 text-left" >{{ __('Nº.Presup') }}</div>
                            <div class="w-1/12 text-left" >{{ __('Factura') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-2/12 text-left" >{{ __('ISBN / Referencia') }} </div>
                            <div class="w-2/12 text-left">{{ __('F.Presup') }}</div>
                            <div class="w-1/12 text-left md:" >{{ __('Proveedor') }}</div>
                            {{-- <div class="w-1/12 text-right">{{ __('Tirada') }}</div> --}}
                            {{-- <div class="w-1/12 text-right">{{ __('Precio Ud.') }}</div> --}}
                            {{-- <div class="w-1/12 text-right">{{ __('Precio Total') }}</div> --}}
                            <div class="w-1/12 text-center">{{ __('Estado') }}</div>
                            <div class="w-1/12 text-center">{{ __('Pedido') }}</div>
                            <div class="w-1/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($presupuestos as $presupuesto)
                        <div class="flex w-full space-x-1 text-sm text-gray-500 border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                            <div class="flex-col w-1/12 my-2 text-left">{{ $presupuesto->id }}</div>
                            <div class="flex-col w-1/12 my-2 text-left">{{ $presupuesto->facturadopor=='1' ? 'MM' : 'Proveedor' }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->cliente->entidad }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->isbn }} {{ $presupuesto->referencia }}</div>
                            <div class="flex-col w-2/12 my-2 text-left">{{ $presupuesto->fpresupuesto4 }}</div>
                            <div class="flex-col w-1/12 my-2 text-left">{{ $presupuesto->proveedor->entidad }}</div>
                            {{-- <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->tirada }}</div> --}}
                            {{-- <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->precio_ud }}</div> --}}
                            {{-- <div class="flex-col w-1/12 my-2 text-right">{{ $presupuesto->preciototal }}</div> --}}
                            <div class="flex-col w-1/12 pl-0 ml-0 text-left">
                                <select wire:change="changeValor({{ $presupuesto }},'estado',$event.target.value)"
                                    class="w-full text-left py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $presupuesto->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $presupuesto->estado== '0'? 'selected' : '' }}>Enviado</option>
                                    <option value="1" {{ $presupuesto->estado== '1'? 'selected' : '' }}>Aceptado</option>
                                    <option value="2" {{ $presupuesto->estado== '2'? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            <div class="flex-col text-center w-1/12">
                                @if($presupuesto->pedido)
                                    <a class="text-blue-700 underline " href="{{ route('pedido.editar',[$presupuesto->pedido ,'i']) }}"  title="Pedido">{{ $presupuesto->pedido }}</a>
                                @endif
                            </div>
                            <div class="w-1/12 space-x-1 text-center ">
                                <x-icon.edit-a class="" href="{{ route('presupuesto.editar',[$presupuesto,'i']) }}"  title="Editar"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('presupuesto.archivos',[$presupuesto->id,'i'])}}'" title="Archivo"/>
                                <x-icon.pdf-a class="w-4 text-red-500 hover:text-red-700" href="{{route('presupuesto.presupuestoPDF',$presupuesto)}}" target="_blank" title="PDF Presupuesto"/>
                                <x-icon.delete-a class="w-7" wire:click.prevent="delete({{ $presupuesto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
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
            </div>
            <div>
                {{ $presupuestos->links() }}
            </div>
        </div>
    </div>
</div>

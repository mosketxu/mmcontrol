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
                        <div>
                            {{ $presupuestos->links() }}
                        </div>
                        <div class="flex w-full pt-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md ">
                            <div class="flex w-9/12">
                                <div class="w-2/12 pl-2 text-left" >{{ __('N.Pres') }}</div>
                                <div class="w-1/12 text-left" >{{ __('Factura') }}</div>
                                <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                                <div class="w-3/12 text-left" >{{ __('ISBN / Referencia') }} </div>
                                <div class="w-2/12 text-left">{{ __('F.Presup') }}</div>
                                <div class="w-2/12 text-left md:" >{{ __('Proveedor') }}</div>
                            </div>
                            <div class="flex w-3/12">
                                <div class="w-2/12 ">{{ __('Estado') }}</div>
                                <div class="w-2/12 text-center">{{ __('Ok Externo') }}</div>
                                <div class="w-4/12 text-center">{{ __('Pedido') }}</div>
                                <div class="w-4/12 " ></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        @forelse ($presupuestos as $presupuesto)
                        <div class="hover:bg-gray-100 hover:cursor-pointer">
                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" wire:loading.class.delay="opacity-50" >
                                @if(!Auth::user()->hasRole('Cliente'))
                                    <div class="flex w-9/12" onclick="location.href = '{{ route('presupuesto.editar',[$presupuesto,'i']) }}'">
                                @else
                                    <div class="flex w-9/12" onclick="location.href = '{{ route('cliente.presupuesto.editar',[$presupuesto,'i']) }}'">
                                @endif
                                    <div class="w-2/12 pl-2">{{ $presupuesto->id }}</div>
                                    <div class="w-1/12 ">{{ $presupuesto->facturadopor=='1' ? 'MM' : 'Proveedor' }}</div>
                                    <div class="w-2/12 ">{{ $presupuesto->cliente->entidad }}</div>
                                    <div class="w-3/12 ">{{ $presupuesto->isbn }} {{ $presupuesto->referencia }}</div>
                                    <div class="w-2/12 ">{{ $presupuesto->fpresupuesto4 }}</div>
                                    <div class="w-2/12 ">{{ $presupuesto->proveedor->entidad }}</div>
                                </div>
                                <div class="items-center flex-none w-3/12 md:flex">
                                    <div class="w-full md:w-2/12">
                                        <select wire:change="changeValor({{ $presupuesto }},'estado',$event.target.value)"
                                        class="w-full text-left py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $presupuesto->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"
                                        {{$escliente}} {{$deshabilitado}}>
                                        <option value="0" {{ $presupuesto->estado== '0'? 'selected' : '' }}>Enviado</option>
                                        <option value="1" {{ $presupuesto->estado== '1'? 'selected' : '' }}>Aceptado</option>
                                        <option value="2" {{ $presupuesto->estado== '2'? 'selected' : '' }}>Rechazado</option>
                                        </select>
                                    </div>
                                    <div class="w-full text-center md:w-2/12">
                                        <input type="checkbox" {{$presupuesto->okexterno == '1' ? 'checked' : ''}} wire:change="changeValor({{ $presupuesto }},'okexterno',$event.target.value)"
                                            class="py-1 text-xs text-blue-600 border-blue-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>
                                    <div class="w-full text-center md:w-3/12">
                                        @if($presupuesto->pedido)
                                            @if(!Auth::user()->hasRole('Cliente'))
                                                <a class="text-blue-700 underline " href="{{ route('pedido.editar',[$presupuesto->pedido ,'i']) }}"  title="Pedido">{{ $presupuesto->pedido }}</a>
                                            @else
                                                <a class="text-blue-700 underline " href="{{ route('cliente.pedido.editar',[$presupuesto->pedido ,'i']) }}"  title="Pedido">{{ $presupuesto->pedido }}</a>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="w-full space-x-2 text-center md:w-4/12">
                                        @if(!Auth::user()->hasRole('Cliente'))
                                        <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('presupuesto.archivos',[$presupuesto->id,'i'])}}'" title="Archivo"/>
                                        @endif
                                        <x-icon.pdf-a class="w-4 text-red-500 hover:text-red-700" href="{{route('presupuesto.presupuestoPDF',[$presupuesto,'n'])}}" target="_blank" title="PDF Presupuesto"/>
                                        <x-icon.pdf-a class="w-4 text-orange-500 hover:text-orange-700" href="{{route('presupuesto.presupuestoPDF',[$presupuesto,'r'])}}" target="_blank" title="PDF Presupuesto reducido"/>
                                        @if(!Auth::user()->hasRole('Cliente'))
                                        <x-icon.delete-a class="w-7" wire:click.prevent="delete({{ $presupuesto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
                                        @endif
                                    </div>
                                </div>
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
            {{-- <div>
                {{ $presupuestos->links() }}
            </div> --}}
        </div>
    </div>
</div>

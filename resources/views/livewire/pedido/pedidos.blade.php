<div class="">
    {{-- @livewire('menu',['entidad'=>$pedido],key($pedido->id)) --}}
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">Pedidos</h1>
        <div class="py-1 space-y-4">
            @if (session()->has('message'))
                <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
                    <span class="inline-block mx-8 align-middle">
                        {{ session('message') }}
                    </span>
                    <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                        <span>×</span>
                    </button>
                </div>
            @endif
            <x-jet-validation-errors></x-jet-validation-errors>
            <div class="">
                @include('pedidos.pedidosfilters')
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="w-1/12 font-light lg:w-1/12" >{{ __('Pedido') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Resp.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Cli.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Prov.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('ISBN') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Ref.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('F.Pedido') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('F.Archivos') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('F.Plotter') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('F.Entrega') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Tir.Prev.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Tir.Real.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('€ ud.') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('€ Total') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Parcial') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Estado') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Facturado') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Cd_DVD') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Distribución') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Cajas') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Incidencias') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12 " >{{ __('Retardos') }}</div>
                        <div class="w-1/12 font-light lg:w-1/12" >{{ __('Otros') }} </div>
                        <div class="w-1/12 lg:w-1/12" ></div>
                    </div>
                    <div>
                        @forelse ($pedidos as $pedido)
                        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->pedido }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->responsable_id }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->cliente_id }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->cliente_id }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->proveedor_id }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="date" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fechapedido }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="date" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fechaarchivos }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="date" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fechaplotter }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="date" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->fechaentrega }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->tiradaprevista }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->tiradareal }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->precio }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->preciototal }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->parcial }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->estado }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->facturado }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->cd_dvd }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->distribucion }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->cajas }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->incidencias }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->retardos }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md"
                                    value="{{ $pedido->otros }}"  readonly/>
                            </div>
                            <div class="w-1/12 lg:w-1/12">
                                <x-icon.edit-a href="{{ route('pedido.edit',$pedido) }}"  title="Editar"/>
                                <x-icon.usergroup href="{{ route('entidadcontacto.show',$pedido->id) }}"  title="Contactos"/>
                                <x-icon.delete-a wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                            </div>
                        </div>
                        @empty
                            <div>
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

    <!-- PDF Transactions Modal -->
    <x-modal.confirmationPDF wire:model.defer="showPDFModal">
        <x-slot name="title">Generar Pedido en PDF</x-slot>

        <x-slot name="content">
            <div class="py-8 text-gray-700">Selecciona el tipo de Pedido a imprimir</div>
        </x-slot>

        <x-slot name="footer">
            {{-- <x-jet-button  onclick="location.href = '{{route('pedido.imprimir', [$presupPDF,'con']) }}'">{{ __('Con totales') }}</x-jet-button> --}}
            {{-- <x-jet-secondary-button  onclick="location.href = '{{route('pedido.imprimir', [$presupPDF,'sin']) }}'">{{ __('Sin totales') }}</x-jet-secondary-button> --}}
            <x-jet-button  onclick="location.href = '#'">{{ __('Con totales') }}</x-jet-button>
            <x-jet-secondary-button  onclick="location.href = '#'">{{ __('Sin totales') }}</x-jet-secondary-button>
        </x-slot>
    </x-modal.confirmationPDF>
</div>

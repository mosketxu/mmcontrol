<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @if($tipo=='1')
                    @include('oferta.ofertaeditorialfilters')
                @else
                    @include('oferta.ofertaotrosfilters')
                @endif
            </div>
            {{-- tabla ofertas --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        {{-- titulos --}}
                        <div class="flex w-full pt-2 pb-0 pl-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                            <div class="flex w-5 h-5 font-medium text-center" >
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                            <div class="w-1/12 text-left" >{{ __('Oferta') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Fecha') }}</div>
                            {{-- <div class="w-2/12 text-left" >{{ __('Contacto') }} </div> --}}
                            <div class="w-3/12 text-left" >{{ __('Referencia') }} </div>
                            <div class="w-2/12 text-cent">{{ __('Estado') }}</div>
                            <div class="w-2/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @if($selectPage)
                        <div class="flex w-full text-sm bg-gray-200 border-t-0 border-y" wire:key="row-message">
                            <div class="flex w-full text-left">
                                @unless($selectAll)
                                    <span>Has seleccionado <strong>{{ $ofertas->count() }}</strong> ofertas, ¿quieres seleccionar el total: <strong>{{ $ofertas->total() }}</strong> ?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select all</x-button.link>
                                @else
                                    <span>Has seleccionado <strong>todos</strong> los {{ $ofertas->total() }} ofertas</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @forelse ($ofertas as $oferta)
                        <div class="flex w-full py-1 pl-2 text-sm font-medium text-gray-500 border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                            <div class="flex w-5 h-5 text-center"><x-input.checkbox wire:model="selected" value="{{ $oferta->id }}" /></div>
                            <div class="flex w-1/12 text-left">{{ $oferta->id }}</div>
                            <div class="flex w-2/12 text-left">{{ $oferta->cliente->entidad }}</div>
                            <div class="flex w-2/12 text-left">{{ $oferta->ffecha }}</div>
                            {{-- <div class="flex w-2/12 text-left">{{ $oferta->contacto->entidad }}</div> --}}
                            <div class="flex w-3/12 text-left">{{ $oferta->referencia }}</div>
                            <div class="flex w-2/12 text-left">
                                <select wire:change="changeValor({{ $oferta }},'estado',$event.target.value)"
                                    class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $oferta->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $oferta->estado== '0'? 'selected' : '' }}>En Espera</option>
                                    <option value="1" {{ $oferta->estado== '1'? 'selected' : '' }}>Aceptada</option>
                                    <option value="2" {{ $oferta->estado== '2'? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div class="flex flex-row-reverse w-2/12 pr-2 mt-1 ">
                                <x-icon.delete-a wire:click.prevent="delete({{ $oferta->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                                <a href="{{route('oferta.ficha',[$oferta->id,$oferta->tipo])}}" target="_blank" title="Imprimir Oferta"><x-icon.pdf class="mr-5 text-red-500 hover:text-red-700 "/></a>
                                <x-icon.edit-a class="" href="{{ route('oferta.editar',[$oferta,'i']) }}"  title="Editar"/>
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
                {{ $ofertas->links() }}
            </div>
        </div>
    </div>
</div>

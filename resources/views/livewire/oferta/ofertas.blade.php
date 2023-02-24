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
                        <div class="flex w-full pt-2 pb-0 pl-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-t-md">
                            <div class="w-1/12 text-left" >{{ __('Oferta') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Fecha') }}</div>
                            <div class="w-3/12 text-left" >{{ __('Referencia') }} </div>
                            <div class="w-2/12 text-center">{{ __('Estado') }}</div>
                            <div class="w-2/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($ofertas as $oferta)
                        <div class="flex w-full items-center py-1 pl-2 text-xs font-medium text-gray-500 border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                            <div class="flex w-1/12 text-left">{{ $oferta->id }}</div>
                            <div class="flex w-2/12 text-left">{{ $oferta->cliente->entidad }}</div>
                            <div class="flex w-2/12 text-left">{{ $oferta->ffecha }}</div>
                            <div class="flex w-3/12 text-left">{{ $oferta->descripcion }}</div>
                            <div class="flex w-2/12 text-center">
                                <select wire:change="changeValor({{ $oferta }},'estado',$event.target.value)"
                                    class="w-full text-left py-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $oferta->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $oferta->estado== '0'? 'selected' : '' }}>Espera</option>
                                    <option value="1" {{ $oferta->estado== '1'? 'selected' : '' }}>Aceptada</option>
                                    <option value="2" {{ $oferta->estado== '2'? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div class="flex flex-row-reverse w-2/12 space-x-1">
                                <x-icon.delete-a  class="w-5" wire:click.prevent="delete({{ $oferta->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
                                <x-icon.pdf-a class="w-5 text-red-500 hover:text-red-700 " href="{{ route('oferta.ficha',[$oferta->id,$oferta->tipo]) }}"  target="_blank" title="Imprimir Oferta"/>
                                <x-icon.edit-a class="w-5" href="{{ route('oferta.editar',[$oferta,'i']) }}"  title="Editar"/>
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

<div class="py-1 space-y-1">
    <div class="">
        @include('errores')
    </div>
    {{-- Titulos --}}
    <div class="flex w-full py-0 my-0 space-x-1 text-left text-gray-500 bg-blue-100 rounded-t-md" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="text" value="Orden"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Título"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-4/12 ">
            <input type="text" value="Concepto"
            class="w-full py-1 text-xs font-thin text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-2/12 ">
            <input type="text" value="Cantidad"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12 ">
            <input type="text" value="Importe"
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="Total."
            class="w-full py-1 text-xs font-thin text-right text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>

        <div class="w-3/12">
            <input type="text" value="Observaciones"
            class="w-full py-1 text-xs font-thin text-left text-gray-500 bg-blue-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12"></div>
    </div>

    {{-- Nuevo detalle --}}
    @if(!Auth::user()->hasRole('Cliente'))
        <form wire:submit.prevent="save">
            <div class="flex w-full py-0 my-0 space-x-1 text-left bg-green-100 border-t-0 border-y" wire:loading.class.delay="opacity-50">
                {{-- orde --}}
                <div class="w-1/12">
                    <input type="number" wire:model.defer="orden"
                    class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md"/>
                </div>
                {{-- titulo --}}
                <div class="w-2/12">
                    <input type="text" wire:model.defer="titulo" placeholder="Introduce el titulo"
                    class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md placeholder:text-xs placeholder:text-gray-300 placeholder:italic"/>
                </div>
                {{-- concepto --}}
                <div class="w-4/12">
                    <input type="text" wire:model.defer="concepto" placeholder="Introduce el concepto"
                    class="w-full py-1 text-xs font-thin text-gray-500 bg-green-100 border-0 rounded-md placeholder:text-xs placeholder:text-gray-300 placeholder:italic"/>
                </div>
                {{-- cantidad --}}
                <div class="w-2/12">
                    <input type="number" step="any" wire:model.lazy="cantidad"
                    class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"/>
                </div>
                {{-- importe --}}
                <div class="w-1/12">
                    <input type="number" step="any" wire:model.lazy="importe"
                    class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-100 border-0 rounded-md"/>
                </div>
                {{-- total --}}
                <div class="w-1/12">
                    <input type="text"  wire:model="total"
                    class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 bg-green-200 border-0 rounded-md"
                    disabled/>
                </div>
                {{-- observaciones --}}
                <div class="w-3/12 ">
                    <textarea wire:model.lazy='observaciones' rows="1"
                    class="w-full py-1 pr-2 text-xs font-thin text-left text-gray-500 bg-green-100 border-0 rounded-md"></textarea>
                </div>
                {{-- botones --}}
                <div class="w-1/12 text-center">
                    <button type="submit"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                </div>
            </div>
        </form>
    @endif
    {{-- Lista detalles --}}
    @forelse ($odetalles as $odetalle)
        <div class="flex w-full py-0 my-0 space-x-1 text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
            <div class="w-1/12">
                <input type="number" value="{{ $odetalle->orden }}"
                    wire:change="changeValor('{{ $odetalle->id }}','orden',$event.target.value)"
                    class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md" {{$deshabilitado}}/>
                </div>
            <div class="w-2/12">
                <input type="text" value="{{ $odetalle->titulo }}"
                wire:change="changeValor('{{ $odetalle->id }}','concepto',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"{{$deshabilitado}}/>
            </div>
            <div class="w-4/12">
                <input type="text" value="{{ $odetalle->concepto }}"
                wire:change="changeValor('{{ $odetalle->id }}','concepto',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"{{$deshabilitado}}/>
            </div>
            <div class="w-2/12">
                <input type="number" step="any" value="{{ $odetalle->cantidad }}"
                wire:change="changeValor('{{ $odetalle->id }}','cantidad',$event.target.value)"
                class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"{{$deshabilitado}}/>
            </div>
            <div class="w-1/12">
                <input type="number" step="any" value="{{ $odetalle->importe }}"
                wire:change="changeValor('{{ $odetalle->id }}','importe',$event.target.value)"
                class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"{{$deshabilitado}}/>
            </div>
            <div class="w-1/12">
                <input type="text" value="{{ number_format($odetalle->total,2,',','.') }}"
                class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
                disabled/>
            </div>
            <div class="w-3/12">
                <textarea rows="1"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                wire:change="changeValor('{{ $odetalle->id }}','observaciones',$event.target.value)" {{$deshabilitado}}>{{ $odetalle->observaciones }}</textarea>
                {{-- <input type="text" value="{{ $odetalle->observaciones }}"
                wire:change="changeValor('{{ $odetalle->id }}','observaciones',$event.target.value)"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"/> --}}
            </div>
            <div class="w-1/12 text-center">
                @if(!Auth::user()->hasRole('Cliente'))
                <x-icon.delete-a class="w-6 " wire:click.prevent="delete({{ $odetalle->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
                @endif
            </div>
        </div>
        @empty
        <div class="flex w-full text-xs text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
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

<form wire:submit.prevent="save" class="">
    <div class="px-2 py-1 space-y-2" >
        <div class="">
            @include('errores')
        </div>
    </div>
    <div class="flex w-full py-0 my-0 space-x-1 text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
        <div class="w-1/12 ">
            <input type="hidden" wire:model.lazy='fdetalle_id'>
            <input type="checkbox" wire:model.lazy='visible'
                class="ml-4 text-xs border-gray-300 rounded-sm shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12">
            <input type="number" wire:model.lazy='orden'
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $deshabilitado }}/>
            </div>
        <div class="w-2/12">
            <x-combo wire:model="pedido_id" :options="collect($pedidos)->map(fn($p)=>['id'=>$p->id,'label'=>(string) $p->id])->values()->all()" placeholder="{{ count($pedidos) ? '-' : 'No hay pedidos pendientes' }}" :disabled="(bool) $deshabilitado" />
        </div>
        <div class="w-4/12">
            <input type="text" wire:model.lazy='concepto'
            class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-2/12">
            <input type="number" step="any" wire:model.lazy='cantidad'
            class="w-full py-1 pr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>

        </div>
        <div class="w-1/12">
            <input type="number" step="any" wire:model.lazy='importe'
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 border-0 rounded-md"
            {{ $deshabilitado }}/>
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotalsiniva,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <x-combo wire:model.lazy="iva" :options="[['id'=>'0.00','label'=>'0%'],['id'=>'0.04','label'=>'4%'],['id'=>'0.1','label'=>'10%'],['id'=>'0.21','label'=>'21%']]" :disabled="(bool) $deshabilitado" />
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotaliva,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-1/12">
            <input type="text" value="{{ number_format($subtotal,2,',','.') }}"
            class="w-full py-1 mr-2 text-xs font-thin text-right text-gray-500 bg-gray-100 border-0 rounded-md"
            disabled/>
        </div>
        <div class="w-3/12">
            <textarea wire:model.lazy='observaciones' rows="1"
                class="w-full py-1 text-xs font-thin text-gray-500 border-0 rounded-md"
                {{ $deshabilitado }}></textarea>
        </div>
        <div class="w-1/12 text-center">
            @if ($deshabilitado=='')
            <x-icon.save-a wire:click.prevent="save()"  title="Guardar detalle"/>
            <x-icon.delete-a class="w-6 " wire:click.prevent="delete({{ $fdetalle_id }},{{ $pedido_id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" title="Eliminar detalle"/>
            @endif
        </div>
    </div>
</form>


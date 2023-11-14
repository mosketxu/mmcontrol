<form wire:submit.prevent="save" class="text-sm">
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos generales</h3>
            <input  wire:model.defer="producto.id" type="hidden"/>
            <input  wire:model.defer="tipo" type="hidden"/>
        </div>
        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
            {{-- Cod/ref --}}
            <div class="w-full form-item sm:w-3/12">
                <x-jet-label for="isbn">{{ __('Cod.') }}</x-jet-label>
                <input wire:model.lazy="producto.isbn" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required autofocus {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- Descripcion --}}
            <div class="w-full form-item sm:w-5/12">
                <x-jet-label for="referencia">{{ __('Referencia') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- cliente --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <select wire:model.lazy="producto.cliente_id"
                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                    {{$escliente}} {{$deshabilitado}}>
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos Técnicos</h3>
        </div>
        <div class="flex mx-2 space-x-2 ">
            {{-- Material --}}
            <div class="w-2/12 form-item">
                <x-jet-label for="material">{{ __('Material') }}</x-jet-label>
                <input  wire:model.lazy="producto.material" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- medidas --}}
            <div class="w-2/12 form-item">
                <x-jet-label for="medidas">{{ __('Medidas') }}</x-jet-label>
                <input  wire:model.lazy="producto.medidas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- troquel --}}
            <div class="w-2/12 form-item">
                <x-jet-label for="troquel">{{ __('Troquel') }}</x-jet-label>
                <input  wire:model.lazy="producto.troquel" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- troquel --}}
            <div class="w-2/12 form-item">
                <x-jet-label for="troquel">{{ __('Impresión') }}</x-jet-label>
                <input  wire:model.lazy="producto.impresion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- observaciones --}}
            <div class="w-4/12 form-item">
                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                <textarea wire:model.defer="producto.observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="1" {{$escliente}} {{$deshabilitado}}>{{ old('observaciones') }} </textarea>
                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
        </div>
        <div class="py-1 my-0 ">
            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                @if(Auth::user()->hasRole('Cliente'))
                    <x-jet-secondary-button  onclick="location.href = '{{route('cliente.producto.tipo','2')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                @else
                    <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                    <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','2')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                @endif            </div>
        </div>
    </div>
</form>

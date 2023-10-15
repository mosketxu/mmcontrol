<x-guest-layout>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="">
                    <div class="h-full p-1 mx-2">
                        <h1 class="text-2xl font-semibold text-gray-900">Empresas con acceso del cliente: {{ $cliente->name }}
                        <div class="py-1 space-y-4">
                            <div class="">
                                @include('errores')
                            </div>
                            {{-- <div class="">
                                @include('entidad.entidadfilters')
                            </div> --}}
                            <div class="flex-col space-y-4">
                                <div>
                                    <div class="flex w-full py-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                                        <div class="flex w-full">
                                            <div class="w-4/12  pl-2" >{{ __('Nombre.') }}</div>
                                            <div class="w-3/12 " >{{ __('Responsable.') }}</div>
                                            <div class="w-1/12 " >{{ __('Nif') }} </div>
                                            <div class="w-1/12 " >{{ __('Tfno.') }}</div>
                                            <div class="w-3/12 " >{{ __('Email') }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        @forelse ($entidades as $entidad)
                                        <div class="hover:bg-gray-100 hover:cursor-pointer">
                                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" >
                                                <div class="flex items-center w-full">
                                                    <div class="w-4/12 pl-2">{{$entidad->entidad }}</div>
                                                    <div class="w-3/12 ">{{ $entidad->responsable}}</div>
                                                    <div class="w-1/12 ">{{ $entidad->nif }}</div>
                                                    <div class="w-1/12 ">{{ $entidad->tfno }}</div>
                                                    <div class="w-3/12 ">{{ $entidad->emailgral }}</div>
                                                </div>
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


                @forelse ($pedidos as $pedido)
                <div class="" wire:loading.class.delay="opacity-50">
                    @livewire('pedido.pedidos-pedido',['pedido'=>$pedido,'tipo'=>$tipo],key("'ped-'.$pedido->id"))
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


<div>
@if($visible)
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <h3 class="text-lg font-medium text-gray-900">Correo de envío</h3>
                <p class="mt-1 text-sm text-gray-600">Con la contraseña de tu correo, lo que envíes desde la web (p. ej. albaranes) saldrá desde tu cuenta y quedará en tu carpeta de Enviados. Sin ella sale por el correo por defecto ({{ $porDefecto }}).</p>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white shadow sm:rounded-md sm:p-6 space-y-3">
                    <div class="text-sm">Tu cuenta: <b>{{ auth()->user()->email }}</b> ·
                        @if($tiene)<span style="color:#15803d">contraseña guardada (encriptada)</span>@else<span style="color:#b45309">sin contraseña: se usa el correo por defecto</span>@endif
                    </div>
                    <input type="password" wire:model.defer="clave" wire:keydown.enter="guardar" autocomplete="new-password" placeholder="{{ $tiene ? 'Nueva contraseña (para cambiarla)' : 'Contraseña de tu correo' }}" class="py-1 text-sm border-gray-300 rounded-md" style="width:60%">
                    @if($error)<div style="font-size:13px;color:#dc2626">{{ $error }}</div>@endif
                    @if($ok)<div style="font-size:13px;color:#15803d">{{ $ok }}</div>@endif
                    <div>
                        <button type="button" wire:click="guardar" wire:loading.attr="disabled" style="padding:6px 14px;font-size:13px;color:#fff;background:#2563eb;border-radius:6px;font-weight:600">Comprobar y guardar</button>
                        @if($tiene)<button type="button" wire:click="quitar" style="padding:6px 14px;font-size:13px;color:#374151;background:#e5e7eb;border-radius:6px;margin-left:6px">Quitar contraseña</button>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-jet-section-border />
@endif
</div>

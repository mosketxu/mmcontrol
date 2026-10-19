<div class="p-4 space-y-4 text-sm text-gray-700">
    @include('errores')

    @if(config('mail.always_to'))
        <div style="padding:6px 10px;background:#fef3c7;color:#92400e;border-radius:6px;font-size:12px">
            Entorno de pruebas: todo correo sale únicamente a {{ is_array(config('mail.always_to')) ? implode(', ',config('mail.always_to')) : config('mail.always_to') }}, no a los destinatarios de la lista.
        </div>
    @endif

    {{-- Destinatarios --}}
    <div>
        <div class="font-semibold">Destinatarios
            @if($proveedor)<span class="font-normal text-gray-500">· contactos de {{ $proveedor->entidad }}</span>@endif
        </div>
        @if(!$proveedor)
            <div style="font-size:12px;color:#b45309">El pedido no tiene proveedor: añade los destinatarios a mano.</div>
        @endif
        @error('destinatarios')<div style="font-size:12px;color:#dc2626">{{ $message }}</div>@enderror
        <div style="margin-top:6px">
            @forelse($destinatarios as $i => $d)
                <div class="flex items-center" style="gap:8px;padding:3px 0;border-bottom:1px solid #f3f4f6">
                    <input type="checkbox" wire:model="destinatarios.{{ $i }}.activo" wire:change="cancelar">
                    <span style="width:40%">{{ $d['nombre'] }}</span>
                    <span style="flex:1;color:#2563eb">{{ $d['email'] }}</span>
                    <button type="button" wire:click="quitar({{ $i }})" title="Quitar de la lista" style="color:#dc2626;font-size:16px;line-height:1">&times;</button>
                </div>
            @empty
                <div style="color:#6b7280;font-size:12px">Sin destinatarios todavía.</div>
            @endforelse
        </div>
        <div class="flex items-start" style="gap:8px;margin-top:8px">
            <input type="text" wire:model.defer="nuevoNombre" placeholder="Nombre (opcional)" class="py-1 text-sm border-gray-300 rounded-md" style="width:25%">
            <div style="width:35%">
                <input type="email" wire:model.defer="nuevoEmail" placeholder="email@proveedor.com" class="w-full py-1 text-sm border-gray-300 rounded-md" wire:keydown.enter.prevent="anadir">
                @error('nuevoEmail')<div style="font-size:12px;color:#dc2626">{{ $message }}</div>@enderror
            </div>
            <button type="button" wire:click="anadir" style="padding:5px 12px;font-size:12px;color:#fff;background:#2563eb;border-radius:6px">Añadir contacto</button>
        </div>
    </div>

    {{-- Mensaje --}}
    <div>
        <label class="font-semibold">Asunto</label>
        <input type="text" wire:model.defer="asunto" class="w-full py-1 text-sm border-gray-300 rounded-md">
    </div>
    <div>
        <label class="font-semibold">Mensaje</label>
        <textarea wire:model.defer="mensaje" rows="9" class="w-full text-sm border-gray-300 rounded-md"></textarea>
    </div>

    {{-- Adjuntos --}}
    <div>
        <div class="font-semibold">Adjuntos</div>
        <div style="margin:4px 0">
            📄 Albarán {{ $parcialid }} (PDF):
            <label style="margin-left:8px"><input type="radio" wire:model="valorado" value="0"> sin valorar</label>
            <label style="margin-left:8px"><input type="radio" wire:model="valorado" value="1"> valorado</label>
        </div>
        @foreach($adjuntos as $i => $f)
            <div class="flex items-center" style="gap:8px">
                <span>📎 {{ $f->getClientOriginalName() }}</span>
                <button type="button" wire:click="quitarAdjunto({{ $i }})" style="color:#dc2626">&times;</button>
            </div>
        @endforeach
        <input type="file" wire:model="adjuntos" multiple style="margin-top:4px;font-size:12px">
        <div wire:loading wire:target="adjuntos" style="font-size:12px;color:#6b7280">Subiendo…</div>
        @error('adjuntos.*')<div style="font-size:12px;color:#dc2626">{{ $message }}</div>@enderror
    </div>

    {{-- Envío en dos pasos --}}
    <div>
        @if($pedirClave)
            <div style="padding:12px;border:1px solid #bfdbfe;background:#eff6ff;border-radius:6px;max-width:560px">
                <div class="font-semibold">¿Enviar con tu propio correo?</div>
                <div style="font-size:12px;margin:4px 0 8px">
                    Si me das la contraseña de tu correo ({{ auth()->user()->email }}), el albarán saldrá desde tu cuenta y quedará en tu carpeta de Enviados.
                    Se guarda encriptada y la puedes cambiar o quitar en tu perfil. Si prefieres no hacerlo, saldrá con el correo por defecto
                    ({{ config('mail.from.address') }}) y la copia quedará en la bandeja de enviados de ese buzón.
                </div>
                <input type="password" wire:model.defer="claveMail" wire:keydown.enter="guardarClave" autocomplete="new-password" placeholder="Contraseña de tu correo" class="py-1 text-sm border-gray-300 rounded-md" style="width:60%">
                @if($errorClave)<div style="font-size:12px;color:#dc2626;margin-top:4px">{{ $errorClave }}</div>@endif
                <div style="margin-top:8px">
                    <button type="button" wire:click="guardarClave" wire:loading.attr="disabled" style="padding:6px 14px;font-size:13px;color:#fff;background:#2563eb;border-radius:6px;font-weight:600">Guardar y usar mi correo</button>
                    <button type="button" wire:click="ahoraNo" style="padding:6px 14px;font-size:13px;color:#374151;background:#e5e7eb;border-radius:6px;margin-left:6px">Ahora no</button>
                </div>
            </div>
        @elseif(!$confirmando)
            <button type="button" wire:click="preparar" style="padding:6px 16px;font-size:13px;color:#fff;background:#16a34a;border-radius:6px;font-weight:600">Revisar y enviar</button>
        @else
            <div style="padding:10px;border:1px solid #fde68a;background:#fefce8;border-radius:6px">
                <div class="font-semibold">Confirma el envío</div>
                <div>Saldrá desde: <b>{{ $this->desde }}</b>@if($this->desde !== auth()->user()->email) <span style="font-size:12px;color:#6b7280">(correo por defecto; la copia queda en la bandeja de enviados de ese buzón)</span>@endif</div>
                <div>Para: {{ collect($destinatarios)->where('activo',true)->pluck('email')->implode(', ') }}</div>
                <div>Asunto: {{ $asunto }}</div>
                <div>Adjuntos: albarán {{ $parcialid }} ({{ $valorado ? 'valorado' : 'sin valorar' }}){{ count($adjuntos) ? ' + '.count($adjuntos).' fichero(s)' : '' }}</div>
                <div style="margin-top:8px">
                    <button type="button" wire:click="enviar" wire:loading.attr="disabled" style="padding:6px 16px;font-size:13px;color:#fff;background:#dc2626;border-radius:6px;font-weight:600">Sí, enviar ahora</button>
                    <button type="button" wire:click="cancelar" style="padding:6px 16px;font-size:13px;color:#374151;background:#e5e7eb;border-radius:6px;margin-left:6px">Cancelar</button>
                </div>
            </div>
        @endif
    </div>

    {{-- Historial --}}
    @if($envios->count())
        <div>
            <div class="font-semibold">Enviado anteriormente</div>
            @foreach($envios as $e)
                <div style="font-size:12px;padding:2px 0;border-bottom:1px solid #f3f4f6">
                    {{ optional($e->enviado_at)->format('d/m/Y H:i') }} · {{ optional($e->user)->name }} ·
                    a {{ collect($e->destinatarios)->pluck('email')->implode(', ') }} · {{ implode(', ',$e->adjuntos ?? []) }}
                </div>
            @endforeach
        </div>
    @endif
</div>

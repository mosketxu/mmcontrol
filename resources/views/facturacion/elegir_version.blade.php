<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900"> {{ pf(__('Factura:')) }} {{ $factura->id }} · PDF </h2>
    </x-slot>
    <div style="display:flex; justify-content:center; padding:24px;">
        <div style="width:100%; max-width:560px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 10px 25px rgba(0,0,0,.15); padding:24px;">
            <h3 style="margin:0 0 8px; font-size:18px; font-weight:600; color:#111827;">{{ pf('Esta factura ha cambiado desde que se guardó su PDF') }}</h3>
            <p style="margin:0 0 6px; font-size:14px; color:#4b5563;">
                Hay una versión guardada del {{ $factura->pdf_generado_at->format('d/m/Y H:i') }}. ¿Qué quieres hacer?
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:16px;">
                <a href="{{ route('facturacion.show', [$factura->id, 'version' => 'guardada']) }}"
                   style="padding:8px 14px; font-size:14px; font-weight:600; color:#fff; background:#2563eb; border-radius:6px; text-decoration:none;">Ver la versión guardada</a>
                <form method="POST" action="{{ route('facturacion.validarpdf', $factura->id) }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="padding:8px 14px; font-size:14px; font-weight:600; color:#fff; background:#d97706; border:0; border-radius:6px; cursor:pointer;">Generar nueva versión</button>
                </form>
                <a href="javascript:window.close()" style="padding:8px 14px; font-size:14px; color:#374151; background:#f3f4f6; border-radius:6px; text-decoration:none;">Cancelar</a>
            </div>
            <p style="margin:14px 0 0; font-size:12px; color:#6b7280;">
                La versión anterior no se borra: se conserva como factura_{{ $factura->id }}_old_v{{ $antiguas + 1 }}.pdf.
                @if($antiguas > 0) Ya hay {{ $antiguas }} {{ $antiguas == 1 ? 'versión anterior guardada' : 'versiones anteriores guardadas' }}. @endif
            </p>
        </div>
    </div>
</x-app-layout>

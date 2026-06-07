<?php

namespace App\Exports;

use App\Models\Oferta;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OfertasExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Oferta::query()
            ->with(['cliente', 'ofertaproducto'])
            ->where('ofertas.tipo', $this->filters['tipo'])
            ->when($this->filters['search'] ?? null, function ($q, $search) {
                $q->where('ofertas.id', 'like', "%{$search}%");
            })
            ->when($this->filters['cliente'] ?? null, function ($q, $cliente) {
                $q->where('ofertas.cliente_id', $cliente);
            })
            ->when($this->filters['referencia'] ?? null, function ($q, $referencia) {
                $q->where(function ($q) use ($referencia) {
                    $q->whereHas('ofertaproducto', function ($q2) use ($referencia) {
                        $q2->where('referencia', 'like', "%{$referencia}%")
                           ->orWhere('isbn', 'like', "%{$referencia}%");
                    })
                    ->orWhere('descripcion', 'like', "%{$referencia}%");
                });
            })
            ->when($this->filters['isbn'] ?? null, function ($q, $isbn) {
                $q->whereHas('ofertaproducto', function ($q2) use ($isbn) {
                    $q2->where('isbn', 'like', "%{$isbn}%");
                });
            })
            ->when($this->filters['estado'] ?? null, function ($q, $estado) {
                $q->where('ofertas.estado', $estado);
            })
            ->when($this->filters['anyo'] ?? null, function ($q, $anyo) {
                $q->whereYear('fecha', $anyo);
            })
            ->when($this->filters['mes'] ?? null, function ($q, $mes) {
                $q->whereMonth('fecha', $mes);
            })
            ->orderByDesc('ofertas.id');
    }

    public function headings(): array
    {
        $titulo = (($this->filters['tipo'] ?? null) == '1') ? 'Presupuesto MM Editorial' : 'Presupuesto MM Otros';
        return [
            $titulo,
            'Fecha',
            'Cliente',
            'Descripción',
            'Producto',
            'Estado',
            'Importe',
        ];
    }

    public function map($oferta): array
    {
        $producto = $oferta->ofertaproducto;

        return [
            $oferta->id,
            $oferta->fecha,
            $oferta->cliente->entidad ?? '',
            $oferta->descripcion,
            collect([
                $producto?->isbn,
                $producto?->referencia,
            ])->filter()->implode(' / '),
            match ((int) $oferta->estado) {
                0 => 'Espera',
                1 => 'Aceptada',
                2 => 'Rechazada',
                default => '',
            },
            $oferta->importe ?? '',
        ];
    }
}

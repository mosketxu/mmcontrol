<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FacturacionExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Factura::query()
            ->join('entidades','facturas.cliente_id','=','entidades.id')
            ->select('facturas.*','entidades.entidad','entidades.nif','entidades.emailadm')
            ->when($this->filters['search'] ?? null, function ($q, $search) {
                $q->where('facturas.id', 'like', "%{$search}%");
            })
            ->when($this->filters['filtrocliente'] ?? null, function ($q, $cliente) {
                $q->where('facturas.cliente_id', $cliente);
            })
            ->when($this->filters['filtroestado'] ?? null, function ($q, $estado) {
                $q->where('facturas.estado', $estado);
            })
            ->when($this->filters['filtroTipo'] ?? null, function ($q, $tipo) {
                $q->where('facturas.tipo', $tipo);
            })
            ->when($this->filters['filtroFi'] ?? null, function ($q, $fi) {
                $q->where('fecha', '>=', $fi);
            })
            ->when($this->filters['filtroFf'] ?? null, function ($q, $ff) {
                $q->where('fecha', '<=', $ff);
            })
            ->when($this->filters['filtroanyo'] ?? null, function ($q, $anyo) {
                $q->whereYear('fecha', $anyo);
            })
            ->when($this->filters['filtromes'] ?? null, function ($q, $mes) {
                $q->whereMonth('fecha', $mes);
            })
            ->orderByDesc('facturas.id');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Cliente',
            'NIF',
            'Estado',
            'Importe',
        ];
    }

    public function map($factura): array
    {
        return [
            $factura->id,
            $factura->fecha,
            $factura->entidad ?? '',
            $factura->nif ?? '',
            match ((int) $factura->estado) {
                0 => 'Pendiente',
                1 => 'Pagada',
                2 => 'Anulada',
                default => '',
            },
            $factura->importe ?? '',
        ];
    }
}

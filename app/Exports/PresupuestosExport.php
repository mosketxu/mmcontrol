<?php

namespace App\Exports;

use App\Models\Presupuesto;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportPresupuestos implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Presupuesto::query()
            ->with(['cliente', 'proveedor'])
            ->join('entidades', 'presupuestos.cliente_id', '=', 'entidades.id')
            ->join('presupuesto_productos', 'presupuesto_productos.presupuesto_id', '=', 'presupuestos.id')
            ->join('productos', 'presupuesto_productos.producto_id', '=', 'productos.id')
            ->select('presupuestos.*')
            ->when($this->filters['tipo'] ?? null, function ($q, $tipo) {
                $q->where('presupuestos.tipo', $tipo);
            })
            ->when($this->filters['search'] ?? null, function ($q, $search) {
                $q->where('presupuestos.id', 'like', "%$search%");
            })
            ->when($this->filters['anyo'] ?? null, function ($q, $anyo) {
                $q->whereYear('fechapresupuesto', $anyo);
            })
            ->when($this->filters['mes'] ?? null, function ($q, $mes) {
                $q->whereMonth('fechapresupuesto', $mes);
            })
            ->when($this->filters['cliente'] ?? null, function ($q, $cliente) {
                $q->where('presupuestos.cliente_id', $cliente);
            })
            ->when($this->filters['proveedor'] ?? null, function ($q, $proveedor) {
                $q->where('presupuestos.proveedor_id', $proveedor);
            })
            ->when($this->filters['responsable'] ?? null, function ($q, $resp) {
                $q->where('presupuestos.responsable', 'like', "%$resp%");
            })
            ->when($this->filters['referencia'] ?? null, function ($q, $ref) {
                $q->where('productos.referencia', 'like', "%$ref%");
            })
            ->when($this->filters['isbn'] ?? null, function ($q, $isbn) {
                $q->where('productos.isbn', 'like', "%$isbn%");
            })
            ->when($this->filters['estado'] ?? null, function ($q, $estado) {
                $q->where('presupuestos.estado', $estado);
            })
            ->when($this->filters['okexterno'] ?? null, function ($q, $ok) {
                $q->where('presupuestos.okexterno', $ok);
            })
            ->groupBy('presupuestos.id')
            ->orderByDesc('presupuestos.id');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Cliente',
            'Proveedor',
            'Responsable',
            'Estado',
            'OK Externo',
            'Observaciones'
        ];
    }

    public function map($presupuesto): array
    {
        return [
            $presupuesto->id,
            $presupuesto->fechapresupuesto,
            $presupuesto->cliente->entidad ?? '',
            $presupuesto->proveedor->entidad ?? '',
            $presupuesto->responsable,
            $presupuesto->estado,
            $presupuesto->okexterno,
            $presupuesto->observacionesexterno,
        ];
    }
}

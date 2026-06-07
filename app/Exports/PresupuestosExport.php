<?php

namespace App\Exports;

use App\Models\Presupuesto;
use App\Models\UserEmpresa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PresupuestosExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Presupuesto::query()
            ->with(['cliente', 'proveedor', 'presupuestoproductos.producto']);
            // ->join('entidades', 'presupuestos.cliente_id', '=', 'entidades.id')
            // ->join('presupuesto_productos', 'presupuesto_productos.presupuesto_id', '=', 'presupuestos.id')
            // ->join('productos', 'presupuesto_productos.producto_id', '=', 'productos.id')
            // ->select('presupuestos.*');

        // 🔒 CONTROL DE ACCESO (cliente vs propietario)
        if (Auth::user()->hasRole('Cliente')) {
            $entidadescliente = UserEmpresa::where('user_id', Auth::id())->pluck('entidad_id');
            $query->whereIn('presupuestos.cliente_id', $entidadescliente);
        }

        return $query
            ->when($this->filters['tipo'] ?? null, fn($q, $tipo) =>
                $q->where('presupuestos.tipo', $tipo)
            )
            ->when($this->filters['search'] ?? null, fn($q, $search) =>
                $q->where('presupuestos.id', 'like', "%$search%")
            )
            ->when($this->filters['anyo'] ?? null, fn($q, $anyo) =>
                $q->whereYear('fechapresupuesto', $anyo)
            )
            ->when($this->filters['mes'] ?? null, fn($q, $mes) =>
                $q->whereMonth('fechapresupuesto', $mes)
            )
            ->when($this->filters['cliente'] ?? null, fn($q, $cliente) =>
                $q->where('presupuestos.cliente_id', $cliente)
            )
            ->when($this->filters['proveedor'] ?? null, fn($q, $proveedor) =>
                $q->where('presupuestos.proveedor_id', $proveedor)
            )
            ->when($this->filters['responsable'] ?? null, fn($q, $resp) =>
                $q->where('presupuestos.responsable', 'like', "%$resp%")
            )
            ->when($this->filters['referencia'] ?? null, fn($q, $ref) =>
                $q->where('productos.referencia', 'like', "%$ref%")
            )
            ->when($this->filters['isbn'] ?? null, fn($q, $isbn) =>
                $q->where('productos.isbn', 'like', "%$isbn%")
            )
            ->when($this->filters['estado'] ?? null, fn($q, $estado) =>
                $q->where('presupuestos.estado', $estado)
            )
            ->when($this->filters['okexterno'] ?? null, fn($q, $ok) =>
                $q->where('presupuestos.okexterno', $ok)
            )
            ->orderByDesc('id');
    }

    public function headings(): array
    {
        if (($this->filters['tipo'] ?? null) == '1') {
            return [
                'Presupuesto Editorial',
                'Facturado por',
                'Fecha',
                'Cliente',
                'Proveedor',
                'Responsable',
                'ISBN/Referencia',
                'Estado',
                'OK Externo',
                'Pedido',
                'Observaciones Externo',
            ];
        }else{
            return [
                'Presupuesto Otros',
                'Facturado por',
                'Fecha',
                'Cliente',
                'Proveedor',
                'Responsable',
                'Descripción',
                'ISBN/Referencia',
                'Estado',
                'OK Externo',
                'Pedido',
                'Observaciones Externo',
                'Otros',
            ];
        }
    }

    public function map($presupuesto): array
    {
        $producto = optional($presupuesto->presupuestoproductos->first())->producto;

        $estado = match ((int) $presupuesto->estado) {
            0 => 'Enviado',
            1 => 'Aceptado',
            2 => 'Rechazado',
            default => '',
        };

        $codigo = collect([
            $producto->isbn ?? null,
            $producto->referencia ?? null,
        ])->filter()->implode(' / ');

        $facturadoPor = $presupuesto->facturadopor == 1
            ? 'Milimétrica'
            : 'Proveedor';

        if (($this->filters['tipo'] ?? null) == '1') {
            return [
                $presupuesto->id,
                $facturadoPor,
                $presupuesto->fechapresupuesto,
                $presupuesto->cliente->entidad ?? '',
                $presupuesto->proveedor->entidad ?? '',
                $presupuesto->responsable,
                $codigo,
                $estado,
                $presupuesto->okexterno == 1 ? 'Sí' : 'No',
                $presupuesto->pedido,
                $presupuesto->observacionesexterno,
            ];
        }else{
            return [
                $presupuesto->id,
                $facturadoPor,
                $presupuesto->fechapresupuesto,
                $presupuesto->cliente->entidad ?? '',
                $presupuesto->proveedor->entidad ?? '',
                $presupuesto->responsable,
                $presupuesto->descripcion,
                $codigo,
                $estado,
                $presupuesto->okexterno == 1 ? 'Sí' : 'No',
                $presupuesto->pedido,
                $presupuesto->observacionesexterno,
                $presupuesto->otros,
            ];
        }
    }
}

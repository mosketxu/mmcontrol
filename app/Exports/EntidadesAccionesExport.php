<?php

namespace App\Exports;

use App\Models\Entidad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntidadesAccionesExport implements FromCollection, WithHeadings
{
    public function __construct(
        public $search,
        public $filtroresponsable,
        public $entidadtipo_id,
        public $filtrofini,
        public $filtroffin,
        public $ordenarpor,
        public $orden
    ) {}

    public function headings(): array
    {
        return [
            'ID Accion',
            'Fecha accion',
            'Entidad',
            'Tipo',
            'NIF',
            'Telefono',
            'Email',
            'Responsable',
            'Contacto',
            'Nombre',
            'Accion',
            'Descripcion',
            'Proxima accion',
        ];
    }

    public function collection()
    {
        $entidades = Entidad::query()
            ->with([
                'entidadtipo',
                'acciones' => function ($query) {
                    $query->with('contacto.entidadcontacto')->orderByDesc('fechaaccion');
                },
            ])
            ->filtrosEntidad(
                $this->search,
                $this->filtroresponsable,
                $this->entidadtipo_id,
                $this->filtrofini,
                $this->filtroffin
            )
            ->orderBy($this->ordenarpor, $this->orden)
            ->get();

        return $entidades->flatMap(function ($entidad) {
            if ($entidad->acciones->isEmpty()) {
                return new Collection();
            }

            return $entidad->acciones->map(function ($accion) use ($entidad) {
                return $this->row($entidad, $accion);
            });
        });
    }

    protected function row($entidad, $accion = null): array
    {
        return [
            $accion->id,
            optional($accion->fechaaccion)->format('d-m-Y'),
            $entidad->id,
            $entidad->entidad,
            $entidad->entidadtipo->nombre ?? '',
            $entidad->nif,
            $entidad->tfno,
            $entidad->emailgral,
            $entidad->responsable,
            $accion->contacto?->entidadcontacto?->entidad ?? '',
            $accion->nombre,
            $accion->accion,
            $accion->descripcion,
            $accion->proximaaccion,
        ];
    }
}

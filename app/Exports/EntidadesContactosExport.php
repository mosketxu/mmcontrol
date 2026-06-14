<?php

namespace App\Exports;

use App\Models\Entidad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntidadesContactosExport implements FromCollection, WithHeadings
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
            'ID Relacion',
            'ID Entidad',
            'Entidad',
            'Tipo',
            'NIF',
            'Telefono',
            'Email',
            'Responsable',
            'ID Contacto',
            'Contacto',
            'Telefono contacto',
            'Email contacto',
            'Departamento',
            'Comentarios',
        ];
    }

    public function collection()
    {
        $entidades = Entidad::query()
            ->with([
                'entidadtipo',
                'contactosEntidad.entidadcontacto',
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
            if ($entidad->contactosEntidad->isEmpty()) {
                return new Collection();
            }

            return $entidad->contactosEntidad->map(function ($contacto) use ($entidad) {
                return $this->row($entidad, $contacto);
            });
        });
    }

    protected function row($entidad, $contacto): array
    {
        return [
            $contacto->id,
            $entidad->id,
            $entidad->entidad,
            $entidad->entidadtipo->nombre ?? '',
            $entidad->nif,
            $entidad->tfno,
            $entidad->emailgral,
            $entidad->responsable,
            $contacto->contacto_id,
            $contacto->entidadcontacto->entidad ?? '',
            $contacto->entidadcontacto->tfno ?? '',
            $contacto->entidadcontacto->emailgral ?? '',
            $contacto->departamento,
            $contacto->comentarios,
        ];
    }
}

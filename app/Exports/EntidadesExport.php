<?php

namespace App\Exports;

use App\Models\Entidad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class EntidadesExport implements FromCollection,WithHeadings,WithMapping,WithEvents
{

    protected $entidades;
    protected $tipo;

    public function __construct(
        public $search,
        public $filtroresponsable,
        public $entidadtipo_id,
        public $filtrofini,
        public $filtroffin,
        public $ordenarpor,
        public $orden
    ) {}

    public function headings(): array{
        return [
            'ID',
            'Entidad',
            'Tipo',
            'NIF',
            'Teléfono',
            'Email',
            'Responsable',
            'Fecha creacion',
            'Fecha ultima accion',
        ];
    }

    public function collection(){
        return Entidad::query()
            ->with([
                'entidadtipo',
                'acciones' => function ($query) {
                    $query->orderByDesc('fechaaccion');
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
    }

    public function map($entidad): array
    {
        return [
            'id' => $entidad->id,
            'entidad' => $entidad->entidad,
            'tipo' => $entidad->entidadtipo->nombre ?? '',
            'nif' => $entidad->nif,
            'tfno' => $entidad->tfno,
            'emailgral' => $entidad->emailgral,
            'responsable' => $entidad->responsable,
            'created_at' => optional($entidad->created_at)->format('d/m/Y'),
            'ultima_accion' => optional($entidad->acciones->first()?->fechaaccion)->format('d/m/Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->fitColumns($event->sheet->getDelegate());
            },
        ];
    }

    protected function fitColumns($sheet): void
    {
        $highestColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());
        $highestRow = $sheet->getHighestRow();

        for ($column = 1; $column <= $highestColumn; $column++) {
            $letter = Coordinate::stringFromColumnIndex($column);
            $maxLength = 0;

            for ($row = 1; $row <= $highestRow; $row++) {
                $value = (string) $sheet->getCell($letter.$row)->getFormattedValue();
                $maxLength = max($maxLength, mb_strlen($value));
            }

            $sheet->getColumnDimension($letter)->setAutoSize(false);
            $sheet->getColumnDimension($letter)->setWidth(min(max($maxLength + 2, 10), 50));
        }
    }
}


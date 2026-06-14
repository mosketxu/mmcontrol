<?php

namespace App\Exports;

use App\Models\Entidad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class EntidadesContactosExport implements FromCollection, WithHeadings, WithEvents
{
    protected $groupRows = [];

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
        $this->groupRows = [];

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

        $rowNumber = 2;

        return $entidades->flatMap(function ($entidad) use (&$rowNumber) {
            if ($entidad->contactosEntidad->isEmpty()) {
                return new Collection();
            }

            $firstRow = $rowNumber;
            $rows = $entidad->contactosEntidad->map(function ($contacto) use ($entidad, &$rowNumber) {
                $rowNumber++;

                return $this->row($entidad, $contacto);
            });

            if ($rows->count() > 1) {
                $this->groupRows[] = [
                    'summary' => $firstRow,
                    'start' => $firstRow + 1,
                    'end' => $firstRow + $rows->count() - 1,
                ];
            }

            return $rows;
        });
    }

    protected function row($entidad, $contacto = null): array
    {
        return [
            $contacto->id ?? '',
            $entidad->id,
            $entidad->entidad,
            $entidad->entidadtipo->nombre ?? '',
            $entidad->nif,
            $entidad->tfno,
            $entidad->emailgral,
            $entidad->responsable,
            $contacto->contacto_id ?? '',
            $contacto?->entidadcontacto->entidad ?? '',
            $contacto?->entidadcontacto->tfno ?? '',
            $contacto?->entidadcontacto->emailgral ?? '',
            $contacto->departamento ?? '',
            $contacto->comentarios ?? '',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setShowSummaryBelow(false);

                foreach ($this->groupRows as $group) {
                    $sheet->getRowDimension($group['summary'])->setCollapsed(true);

                    for ($row = $group['start']; $row <= $group['end']; $row++) {
                        $sheet->getRowDimension($row)->setOutlineLevel(1);
                    }
                }

                $this->fitColumns($sheet);
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

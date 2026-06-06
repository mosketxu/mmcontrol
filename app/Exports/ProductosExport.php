<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductosExport implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting
{

    public function __construct(
        public $tipo,
        public $filtroisbn,
        public $filtroproductoestado,
        public $filtroreferencia,
        public $filtrocliente,
        public $filtromaterial,
        public $filtroimpresion,
        public $filtrocaja,
    ) {}

        public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // ISBN
        ];
    }

   public function headings(): array
    {
        return [
            'ISBN',
            'Titulo/Referencia',
            'Cliente',
            'Estado',
        ];
    }

    public function collection(){
        return Producto::query()
            ->with('proveedor','cliente')
            ->when($this->tipo, fn($q) => $q->where('tipo', $this->tipo))
            ->when($this->filtroisbn, fn($q) => $q->where('isbn', 'like', "%{$this->filtroisbn}%"))
            ->when($this->filtroproductoestado, fn($q) => $q->where('productoestado', $this->filtroproductoestado))
            ->when($this->filtroreferencia, fn($q) => $q->where('referencia', 'like', "%{$this->filtroreferencia}%"))
            ->when($this->filtrocliente, fn($q) => $q->where('cliente_id', $this->filtrocliente))
            ->when($this->filtromaterial, fn($q) => $q->where('material', $this->filtromaterial))
            ->when($this->filtroimpresion, fn($q) => $q->where('impresion', $this->filtroimpresion))
            ->when($this->filtrocaja, fn($q) => $q->where('caja', $this->filtrocaja))
            ->get();
    }

   public function map($p): array
    {
        $isbn = $p->isbn;
        if (!empty($isbn) && is_numeric($isbn) && strlen((string)$isbn) > 10) {
            $isbn = "'" . $isbn;
        }
        return [
            $isbn,
            $p->referencia,
            $p->cliente?->entidad ?? '',
            $p->productoestado?->value ?? '',
        ];
    }
}


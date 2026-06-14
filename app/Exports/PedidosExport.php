<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PedidosExport extends DefaultValueBinder implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting,WithCustomValueBinder
{

    protected $pedidos;
    protected $tipo;

    function __construct($pedidos,$tipo) {
            $this->pedidos = $pedidos;
            $this->tipo = $tipo;
    }

    public function headings(): array
    {
        if($this->tipo=='1')
        return [
            'ClienteId',
            'Cliente',
            'Pedido',
            'Descripcion',
            'Responsable',
            'Imprenta',
            'Facturado Por',
            'Idioma',
            'fechapedido',
            'fechaarchivos',
            'fechamaqueta',
            'ctrarchivos',
            'ctrmaqueta',
            'fechaplotter',
            'ctrplotter',
            'fechaentrega',
            'ctrentrega',
            'ISBN',
            'Referencia',
            'Tirada Prevista',
            'Tirada Real',
            'estado',
            'facturado',
            'laminado',
            'consumo',
            'ud_consumo',
            'otros',
        ];
        else
        return [
            'ClienteId',
            'Cliente',
            'Pedido',
            'Descripcion',
            'Responsable',
            'Facturado Por',
            'Idioma',
            'fechapedido',
            'fechaarchivos',
            'fechamaqueta',
            'ctrarchivos',
            'ctrmaqueta',
            'fechaplotter',
            'ctrplotter',
            'fechaentrega',
            'ctrentrega',
            'ISBN',
            'Referencia',
            'estado',
            'facturado',
            'otros',
        ];

    }

    public function columnFormats(): array
    {
        return [
            $this->tipo == '1' ? 'R' : 'Q' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function map($pedido): array
    {
        $row = method_exists($pedido, 'getAttributes') ? $pedido->getAttributes() : (array) $pedido;

        if (array_key_exists('isbn', $row)) {
            $row['isbn'] = $this->formatIsbn($row['isbn']);
        }

        return array_values($row);
    }

    protected function formatIsbn($isbn): string
    {
        return (string) $isbn;
    }

    public function bindValue(Cell $cell, $value)
    {
        $isbnColumn = $this->tipo == '1' ? 'R' : 'Q';

        if ($cell->getColumn() === $isbnColumn) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        return $this->pedidos;
    }
}

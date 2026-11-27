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

    /**
     * Columnas: [cabecera, clave(s) del campo en la consulta]. Se mapea por NOMBRE
     * (no por posición) para que cabecera y contenido no se desalineen.
     */
    protected function columnas(): array
    {
        $c = [
            ['ClienteId', 'entidadId'],
            ['Cliente', 'entidad|cliente'],
            ['Pedido', 'id'],
            ['Descripcion', 'descripcion'],
            ['Responsable', 'responsable'],
        ];
        if ($this->tipo == '1') $c[] = ['Imprenta', 'imprenta'];
        $c = array_merge($c, [
            [pf('Facturado Por'), 'facturadopor'],
            ['Idioma', 'idioma'],
            ['fechapedido', 'fechapedido'],
            ['fechaarchivos', 'fechaarchivos'],
            ['fechamaqueta', 'fechamaqueta'],
            ['ctrarchivos', 'ctrarchivos'],
            ['ctrmaqueta', 'ctrmaqueta'],
            ['fechaplotter', 'fechaplotter'],
            ['ctrplotter', 'ctrplotter'],
            ['fechaentrega', 'fechaentrega'],
            ['ctrentrega', 'ctrentrega'],
            ['ISBN', 'isbn'],
            ['Referencia', 'referencia'],
        ]);
        $c = array_merge($c, [
            ['Tirada Prevista', 'tiradaprevista'],
            ['Tirada Real', 'tiradareal'],
        ]);
        $c = array_merge($c, [
            ['estado', 'estado'],
            ['facturado', 'facturado'],
        ]);
        if ($this->tipo == '1') {
            $c = array_merge($c, [
                ['laminado', 'name'],
                ['consumo', 'consumo'],
                ['ud_consumo', 'unidad_consumo'],
            ]);
        }
        $c[] = ['otros', 'otros'];
        return $c;
    }

    protected function columnaIsbn(): string
    {
        foreach ($this->columnas() as $i => $col) {
            if ($col[0] === 'ISBN') return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
        }
        return 'R';
    }

    public function headings(): array
    {
        return array_column($this->columnas(), 0);
    }

    public function columnFormats(): array
    {
        return [
            $this->columnaIsbn() => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function map($pedido): array
    {
        $row = method_exists($pedido, 'getAttributes') ? $pedido->getAttributes() : (array) $pedido;

        $out = [];
        foreach ($this->columnas() as [$cab, $claves]) {
            $v = '';
            foreach (explode('|', $claves) as $k) {
                if (array_key_exists($k, $row)) { $v = $row[$k]; break; }
            }
            if ($claves === 'isbn') $v = $this->formatIsbn($v);
            $out[] = $v;
        }
        return $out;
    }

    protected function formatIsbn($isbn): string
    {
        return (string) $isbn;
    }

    public function bindValue(Cell $cell, $value)
    {
        $isbnColumn = $this->columnaIsbn();

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

<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidosExport implements FromCollection,WithHeadings
{

    protected $pedidos;

    function __construct($pedidos) {
            $this->pedidos = $pedidos;
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Pedido',
            'Descripcion',
            'Responsable',
            'Facturado Por',
            'fechapedido',
            'fechaarchivos',
            'fechaplotter',
            'fechaentrega',
            'ISBN',
            'Referencia',
            'estado',
            'facturado',
            'otros',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        return $this->pedidos;
    }
}

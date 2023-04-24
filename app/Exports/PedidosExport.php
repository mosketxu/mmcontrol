<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidosExport implements FromCollection,WithHeadings
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
            'Cliente',
            'Pedido',
            'Descripcion',
            'Responsable',
            'Imprenta',
            'Facturado Por',
            'fechapedido',
            'fechaarchivos',
            'ctrarchivos',
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
        else
        return [
            'Cliente',
            'Pedido',
            'Descripcion',
            'Responsable',
            'Facturado Por',
            'fechapedido',
            'fechaarchivos',
            'ctrarchivos',
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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        return $this->pedidos;
    }
}

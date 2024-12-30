<?php

namespace App\Http\Livewire\Pedido;

use Livewire\Component;
use App\Models\Laminado;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Stock extends Component
{

    public $pedido;

    public $escliente='';

    public $filtrocategoria='2';
    public $filtrofechaIni='';
    public $filtrofechaFin='';

    protected $queryString=['filtrocategoria','filtrofechaIni','filtrofechaFin'];

    public function mount(){
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render(){

        $categorias=Laminado::where('id','!=','1')->get();

        $query = Pedido::join('laminados', 'laminados.id', '=', 'pedidos.laminado_id')
            ->select(
                'laminados.id as laminado_id',
                'laminados.name as name',
                'pedidos.id as pedido',
                'pedidos.laminado_id',
                'pedidos.fechapedido',
                'pedidos.consumo',
                'pedidos.unidad_consumo',
                DB::raw('SUM(pedidos.consumo) OVER (PARTITION BY laminados.id ORDER BY pedidos.fechapedido ASC) AS saldo')
            )
            ->when($this->filtrocategoria!='', function ($query) {$query->where('laminados.id',$this->filtrocategoria);})
            ->where('pedidos.laminado_id','>','1');

        // Aplicar filtros
        if ($this->filtrocategoria) {$query->where('laminados.id', $this->filtrocategoria);}
        // if ($this->filtrofechaIni) {$query->whereDate('pedidos.fechapedido', '>=', $this->filtrofechaIni);}
        // if ($this->filtrofechaFin) {$query->whereDate('pedidos.fechapedido', '<=', $this->filtrofechaFin);}


        $movimientos=$query->orderBy('laminados.id')
            ->orderBy('pedidos.fechapedido', 'desc')
            ->get();
            // dd($movimientos . '----------- '.$this->filtrocategoria);


        return view('livewire.pedido.stock',compact('categorias','movimientos'));
    }
}

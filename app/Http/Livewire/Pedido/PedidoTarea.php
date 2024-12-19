<?php

namespace App\Http\Livewire\Pedido;

use Livewire\Component;

use App\Models\Pedido;
use App\Models\PedidoTarea as ModelsPedidoTarea;
use Illuminate\Support\Facades\Auth;

class PedidoTarea extends Component
{

    public $ruta;
    public $tipo;
    public $pedido;

    public $tarea='';
    public $pedidoid='';
    public $unidades='';
    public $otros='';
    public $fecha_inicio='';
    public $fecha_fin='';
    public $asignado_a='';
    public $estado='1';

    public $editarvisible=0;
    public $search='';
    public $escliente='';

    protected $queryString=['search'];


    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'tarea'=>'required',
            'pedidoid'=>'required',
            'unidades'=>'nullable',
            'otros'=>'nullable',
            'fecha_inicio'=>'nullable',
            'fecha_fin'=>'nullable',
            'asignado_a'=>'nullable',
            'estado'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'tarea.required'=>'La tarea es necesaria.',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->pedido=Pedido::find($pedidoid);
        $this->pedidoid=$pedidoid;
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render()
    {
        $estados = ModelsPedidoTarea::getEstados();

        $tareas=ModelsPedidoTarea::query()
        ->search('tarea', $this->search)
        ->where('pedido_id',$this->pedido->id)
        ->orderBy('tarea')
        ->get();



        return view('livewire.pedido.pedido-tarea', compact('tareas','estados'));
    }

    public function changeCampo(ModelsPedidoTarea $valor, $campo, $valorcampo)
    {
        $p=ModelsPedidoTarea::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Tarea Actualizada.');
    }

    public function save()
    {
        $this->validate();

        $pedidoarchivo=ModelsPedidoTarea::create([
            'pedido_id'=>$this->pedidoid,
            'tarea'=>$this->tarea,
            'unidades'=> $this->unidades,
            'otros'=> $this->otros,
            'fecha_inicio'=> $this->fecha_inicio,
            'fecha_fin'=> $this->fecha_fin,
            'asignado_a'=> $this->asignado_a
        ]);

        $this->dispatchBrowserEvent('notify', 'Tarea añadida con éxito');

        return redirect()->route('pedido.tareas',[$this->pedidoid,$this->ruta]);
    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoTarea::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $pedido=ModelsPedidoTarea::find($borrar->pedido_id);
            $pedido->save();
            $this->dispatchBrowserEvent('notify', 'Tarea eliminada!');
        }
    }
}

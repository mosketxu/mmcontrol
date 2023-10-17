<?php

namespace App\Http\Livewire\Oferta;

use Livewire\Component;

use App\Models\{Entidad,Oferta,OfertaDetalle};
use Illuminate\Support\Facades\Auth;

class OfertaDetalles extends Component
{

    public $oferta;
    public $oferta_id;
    public $titulo='';
    public $concepto='';
    public $cantidad='0';
    public $importe='0';
    public $total='0';
    public $orden='0';
    public $observaciones='';
    public $deshabilitado='';

    protected function rules()
    {
        return [
            'oferta_id'=>'required',
            'titulo'=>'nullable',
            'concepto'=>'nullable',
            'cantidad'=>'required|numeric',
            'importe'=>'required|numeric',
            'total'=>'required|numeric',
            'orden'=>'nullable',
            'observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'oferta_id.required'=>'la oferta es necesaria.',
            'cantidad.required'=>'La cantidad es necesaria.',
            'cantidad.numeric'=>'La cantidad debe ser numérica.',
            'importe.required'=>'El importe es necesario.',
            'importe.numeric'=>'El importe debe ser numérico.',
            'total.required'=>'El total es necesario.',
            'total.numeric'=>'El total debe ser numérico.',
        ];
    }

    public function mount($ofertaid)
    {
        $this->oferta=Oferta::find($ofertaid);
        $this->oferta_id=$ofertaid;
        $this->deshabilitado=Auth::user()->hasRole('Cliente')? 'disabled' :'';
    }

    public function render()
    {
        $odetalles=OfertaDetalle::where('oferta_id',$this->oferta->id)->orderBy('orden')->get();

        return view('livewire.oferta.oferta-detalles',compact('odetalles'));
    }
    public function UpdatedCantidad(){ $this->total=round($this->cantidad * $this->importe,2);}
    public function UpdatedImporte(){ $this->total=round($this->cantidad * $this->importe,2);}

    public function changeValor(OfertaDetalle $odetalle,$campo,$valor){
        // dd($odetalle,$campo,$valor);
        if($campo=='cantidad')
            $this->total=round($valor * $odetalle->importe,2);
        elseif($campo=='importe')
            $this->total=round($valor * $odetalle->cantidad,2);
        $this->oferta_id=$odetalle->oferta_id;
        $this->validate();
        // $this->oferta_id='';
        // $this->total=round($this->cantidad * $this->importe,2);
        $odetalle->update([
            $campo=>$valor,
            'total'=>$this->total]);
        // $odetalle->update([
        //     'total'=>round($this->cantidad * $this->importe,2)
        //     ]);

        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function save(){
        // $this->oferta_id;
        if(!$this->cantidad) $this->cantidad=0;
        if(!$this->importe) $this->importe=0;
        $this->total=round($this->cantidad * $this->importe,2);

        $this->validate();
        $odetalle=OfertaDetalle::create([
            'oferta_id'=>$this->oferta_id,
            'titulo'=>$this->titulo,
            'concepto'=>$this->concepto,
            'cantidad'=>$this->cantidad,
            'importe'=>$this->importe,
            'total'=>$this->total,
            'orden'=>$this->orden,
            'observaciones'=>$this->observaciones,
        ]);


        $this->titulo='';
        $this->concepto='';
        $this->cantidad='0';
        $this->importe='0';
        $this->total='0';
        $this->orden='0';
        $this->observaciones='';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $this->oferta_id=$valorId;
        $this->validate();
        $this->oferta_id='';

        $borrar = OfertaDetalle::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }
}

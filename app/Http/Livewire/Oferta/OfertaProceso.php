<?php

namespace App\Http\Livewire\Oferta;

use App\Models\OfertaProceso as ModelsOfertaProceso;
use App\Models\Oferta;


use Livewire\Component;

class OfertaProceso extends Component
{
    public $oferta;
    public $oferta_id;
    public $proceso;
    public $orden='0';
    public $visible='1';
    public $tirada='0';
    public $precio_ud='0';
    public $preciototal='0';
    public $descripcion='';
    public $bloqueado=false;
    public $deshabilitado='';

    protected function rules(){
        return [
            'oferta_id'=>'required',
            'proceso'=>'required',
            'tirada'=>'required',
            'precio_ud'=>'nullable',
            'preciototal'=>'nullable',
            'descripcion'=>'nullable',
            'visible'=>'nullable',
            'orden'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'oferta_id'=>'El oferta es necesario.',
            'proceso'=>'El proceso es necesario.',
            'tirada'=>'La cantidad es necesario.',
        ];
    }

    public function mount($ofertaid,$deshabilitado){
        $this->oferta=Oferta::find($ofertaid);
        $this->oferta_id=$ofertaid;
        $this->deshabilitado= $deshabilitado;
    }

    public function render(){
        $pedprocesos=ModelsOfertaProceso::where('oferta_id',$this->oferta_id)->get();
        return view('livewire.oferta.oferta-procesootros',compact('pedprocesos'));
    }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pproc=ModelsOfertaProceso::create([
            'oferta_id'=>$this->oferta_id,
            'proceso'=>$this->proceso,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'descripcion'=>$this->descripcion,
            'visible'=>$this->visible,
            'orden'=>$this->orden,
        ]);

        $this->proceso='';
        $this->tirada='0';
        $this->precio_ud='0';
        $this->preciototal='0';
        $this->descripcion='';
        $this->visible='1';
        $this->orden='0';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = ModelsOfertaProceso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}

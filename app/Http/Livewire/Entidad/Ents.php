<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadContacto, EntidadDestino, EntidadTipo, Pedido, Presupuesto, Producto, User};
use Livewire\Component;
use Livewire\WithPagination;

class Ents extends Component
{
    use WithPagination;

    public $search='';
    public $filtroresponsable='';
    public $Fini='';
    public $Ffin='';
    public $entidadtipo_id='';
    public Entidad $entidad;

    public function render()
    {
        $entidadtipo=EntidadTipo::find($this->entidadtipo_id);

        $entidades=Entidad::query()
            ->with('entidadtipo')
            ->filtrosEntidad($this->search, $this->filtroresponsable, $this->entidadtipo_id, $this->Fini, $this->Ffin)
            ->orderBy('entidad', 'asc')
            ->get();


        return view('livewire.entidad.ents', compact('entidades', 'entidadtipo'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function changeValor(Entidad $entidad, $campo, $valor)
    {
        $entidad->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizada con éxito.');
    }

    public function delete($entidadId){

        $entidad = Entidad::find($entidadId);
        $mensaje='';
        $mensaje1='';
        $mensaje2='';
        $mensaje3='';
        $mensaje4='';
        $mensaje5='';
        $mensaje6='';
        $contactoEnPresupuestos=0;
        $contactoEnPedidos=0;

        $productos=$entidad->productos->count();
        $presupuestos=$entidad->presupuestos->count();
        $ofertas=$entidad->ofertas->count();

        if ($productos>0) $mensaje1="Tiene asociados Productos, ";
        if ($presupuestos>0) $mensaje2='Tiene asociados Presupuestos, ' ;
        if ($ofertas>0) $mensaje3='Tiene asociados Presupuestos MM, ';

        // si el contacto de la entidad se ha usado en algun presupuesto o en algun pedido no puedo eliminarlo
        if($entidad->contactos->count()>0){
            foreach ($entidad->contactos as $contacto) {
                // dd(Presupuesto::where('contacto_id',$contacto->contacto_id)->count());
                $contactoEnPresupuestos=$contactoEnPresupuestos + Presupuesto::where('contacto_id',$contacto->contacto_id)->count();
                $contactoEnPedidos=$contactoEnPedidos +Pedido::where('contacto_id',$contacto->contacto_id)->count();
            }
            if($contactoEnPresupuestos>0) $mensaje5=' Es contacto al menos en un presupuesto. ';
            if($contactoEnPedidos>0) $mensaje6=' Es contacto al menos en un pedido.' ."\n";
        }
            // si el destino de la entidad se ha usado en algun presupuesto o en algun pedido no puedo eliminarlo
            // creo que esto no es un problema
            // if($entidad->destinos->count()>0){

            // }



        if ($mensaje1!='' || $mensaje2!='' || $mensaje3!='' || $mensaje4!='' || $mensaje5!=''  ) {
            $mensaje=$mensaje5 . $mensaje6 . $mensaje1 . $mensaje2 . $mensaje3 ;
            $this->dispatchBrowserEvent('notifyred', $mensaje);
        }

        if ($entidad && $mensaje=='') {
            if($entidad->contactos->count()>0) EntidadContacto::where('contacto_id',$entidadId)->delete();
            if($entidad->destinos->count()>0) EntidadDestino::where('entidad_id',$entidadId)->delete();
            $entidad->delete();
            $this->dispatchBrowserEvent('notify', 'La entidad: '.$entidad->entidad.' ha sido eliminada!');
        }
    }
}

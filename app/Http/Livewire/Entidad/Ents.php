<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad,EntidadTipo, Producto, User};
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
            ->paginate(10);


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

    public function delete($entidadId)
    {
        $entidad = Entidad::find($entidadId);
        $mensaje='';
        $mensaje1='';
        $mensaje2='';
        $mensaje3='';

        $productos=$entidad->productos->count();
        $presupuestos=$entidad->presupuestos->count();
        $ofertas=$entidad->ofertas->count();

        if ($productos>0) $mensaje1="Productos";
        if ($presupuestos>0) $mensaje2=', Presupuestos' ;
        if ($ofertas>0) $mensaje3=', Presupuestos MM';

        if ($mensaje1!='' || $mensaje2!='' || $mensaje3!=''  ) {
            $mensaje='No se puede eliminar porque tiene asociados: '. $mensaje1 . ' ' . $mensaje2 . ' ' . $mensaje3;
            $this->dispatchBrowserEvent('notifyred', $mensaje);
        }

        if ($entidad && $mensaje=='') {
            $entidad->contactos->delete();
            $entidad->destinos->delete();
            $entidad->delete();
            $this->dispatchBrowserEvent('notify', 'La entidad: '.$entidad->entidad.' ha sido eliminada!');
        }
    }
}

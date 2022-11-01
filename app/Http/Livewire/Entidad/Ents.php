<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad,EntidadTipo,User};
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
        $responsables=User::role('Milimetrica')->orderBy('name')->get();

        $entidades=Entidad::query()
            ->with('entidadtipo')
            ->with('responsable')
            ->filtrosEntidad($this->search,$this->filtroresponsable,$this->entidadtipo_id,$this->Fini,$this->Ffin)
            ->orderBy('entidad','asc')
            ->paginate(10);


        return view('livewire.entidad.ents',compact('entidades','entidadtipo','responsables'));
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function changeValor(Entidad $entidad,$campo,$valor)
    {
        $entidad->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actulizada con éxito.');
    }

    public function delete($entidadId)
    {
        $entidad = Entidad::find($entidadId);
        if ($entidad) {
            $entidad->delete();
            $this->dispatchBrowserEvent('notify', 'La entidad: '.$entidad->entidad.' ha sido eliminada!');
        }
    }
}

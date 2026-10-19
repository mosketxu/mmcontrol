<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadAccion, EntidadContacto, EntidadDestino, EntidadTipo, Pedido, Presupuesto, Producto, User};
use Livewire\Component;
use Livewire\WithPagination;

class Ents extends Component
{
    use WithPagination;

    public $search='';
    public $filtronif='';
    public $filtroresponsable='';
    public $filtrofini='';
    public $filtroffin='';
    public $ordenarpor='entidad';
    public $orden='asc';
    public $entidadtipo_id='';

    protected $queryString=['search','filtronif','filtroresponsable','filtrofini','filtroffin','entidadtipo_id','ordenarpor','orden'];

    public Entidad $entidad;

    public function render(){
        $entidadtipo=EntidadTipo::find($this->entidadtipo_id);

        $entidades=Entidad::query()
            ->with('entidadtipo')
            ->filtrosEntidad($this->search, $this->filtroresponsable, $this->entidadtipo_id, $this->filtrofini, $this->filtroffin, $this->filtronif)
            ->orderBy($this->ordenarpor,$this->orden)
            ->orderBy('created_at', 'asc')
            ->get();


        // Sugerencias de los combos de búsqueda (nombre, NIF y responsable de las entidades de este tipo)
        $base=Entidad::query()->filtrosEntidad('', '', $this->entidadtipo_id, '', '')->orderBy('entidad')->get(['entidad','nif','responsable']);
        $opcnombres=$base->map(fn($x)=>['id'=>$x->entidad,'label'=>$x->entidad])->values()->all();
        $opcnifs=$base->filter(fn($x)=>$x->nif)->map(fn($x)=>['id'=>$x->nif,'label'=>$x->nif.' · '.$x->entidad])->values()->all();
        $opcresponsables=$base->pluck('responsable')->filter()->unique()->sort()->map(fn($r)=>['id'=>$r,'label'=>$r])->values()->all();

        return view('livewire.entidad.ents', compact('entidades', 'entidadtipo','opcnombres','opcnifs','opcresponsables'));
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function changeValor($entidadId, $campo, $valor){
        $entidad = Entidad::find($entidadId);

        if (! $entidad) {
            return;
        }

        $entidad->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizada con éxito.');
    }

    public function ordenar($campo){
        $this->ordenarpor=$campo;
        $this->orden= $this->orden=='asc' ? 'desc' : 'asc';
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
            if($entidad->acciones->count()>0) EntidadAccion::where('entidad_id',$entidadId)->delete();
            $entidad->delete();
            $this->dispatchBrowserEvent('notify', 'La entidad: '.$entidad->entidad.' ha sido eliminada!');
        }
    }

    public function exportEntidad(){
        return Excel::download(
            new EntidadesExport(
                $this->search,
                $this->filtroresponsable,
                $this->entidadtipo_id,
                $this->filtrofini,
                $this->filtroffin,
                $this->ordenarpor,
                $this->orden,
                $this->filtronif
            ),
            'entidades.xlsx'
        );
    }
}

<?php

namespace App\Http\Livewire\Presupuesto;

use App\Mail\MilimetricaMail;
use Illuminate\Support\Facades\Mail;
use App\Models\{Presupuesto,PresupuestoArchivo as ModelsPresupuestoArchivo, Responsable};
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;


use Livewire\Component;

class PresupuestoArchivo extends Component
{
    use WithFileUploads;

    public $titulo='Archivo: ';
    public $ruta;
    public $tipo;
    public $presupuestoid;
    public $presupuesto;
    public $pdfvisible ;

    public $routepdf='';

    public $campofecha='';
    public $titcampofecha='';
    public $valorcampofecha='';
    public $longcampofecha='w-1/12';
    public $campofechavisible=0;
    public $campofechadisabled='';

    public $campo2='';
    public $titcampo2='';
    public $valorcampo2='';
    public $longcampo2='';
    public $textcampo2='';
    public $desplazcampo2='';
    public $tipocampo2='';
    public $campo2visible=0;
    public $campo2disabled='';
    public $campo2selectname='';

    public $campo3='nombrearchivooriginal'; //ojo que aunque no se vea se usa
    public $titcampo3='';
    public $valorcampo3='';
    public $longcampo3='';
    public $textcampo3='';
    public $desplazcampo3='';
    public $tipocampo3='';
    public $campo3visible=0;
    public $campo3disabled='';
    public $campo3selectname='';

    public $campo4='comentario';
    public $longcampo4='w-7/12';
    public $titcampo4='Comentario';
    public $valorcampo4='';
    public $textcampo4='text-left';
    public $desplazcampo4='pl-2';
    public $tipocampo4='text';
    public $campo4visible=1;
    public $campo4disabled='';

    public $campo5='';
    public $titcampo5='';
    public $valorcampo5='';
    public $longcampo5='';
    public $textcampo5='';
    public $desplazcampo5='';
    public $tipocampo5='';
    public $campo5visible=0;
    public $campo5disabled='';

    public $campo6='';
    public $titcampo6='';
    public $valorcampo6='';
    public $longcampo6='';
    public $textcampo6='';
    public $desplazcampo6='';
    public $tipocampo6='';
    public $campo6visible=0;
    public $campo6disabled='';

    public $campoimg='archivo';
    public $titcampoimg='Fichero';
    public $valorcampoimg='';
    public $longcampoimg="w-2/12";
    public $campoimgvisible=1;
    public $campoimgdisabled='';

    public $editarvisible=0;
    public $search='';


    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules(){
        return [
            // 'valorcampofecha'=>'required||date',
            // 'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
            'valorcampo4'=>'required',
            'valorcampoimg'=>'required',
        ];
    }

    public function messages(){
        return [
            'valorcampo4.required'=>'El comentario es necesario',
            'valorcampoimg.required'=>'El fichero es necesario',
        ];
    }

    public function mount($presupuestoid,$ruta,$tipo){
        $this->presupuesto=Presupuesto::find($presupuestoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->titulo="Archivos del presupuesto: ";
        if(Auth::user()->hasRole('Cliente')){
            $this->campofechadisabled='disabled';
            $this->campo2disabled='disabled';
            $this->campo3disabled='disabled';
            $this->campo4disabled='disabled';
            $this->campo5disabled='disabled';
            $this->campo6disabled='disabled';
        }

    }

    public function render(){
        $valores=ModelsPresupuestoArchivo::query()
        ->search('comentario', $this->search)
        ->select('id', 'nombrearchivooriginal as valorcampo3','comentario as valorcampo4', 'archivo as valorcampoimg')
        ->where('presupuesto_id',$this->presupuesto->id)
        ->orderBy('comentario')
        ->get();

        return view('livewire.presupuesto.auxiliarpresupuestoscard', compact('valores'));
    }

    public function changeCampo(ModelsPresupuestoArchivo $valor, $campo, $valorcampo){
        $p=ModelsPresupuestoArchivo::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Archivo Actualizado.');
    }

    public function updatedValorcampoimg(){
        $this->validate(['valorcampoimg'=>'file|max:5000']);
    }

    // public function presentaAdjunto($presupuestoarchivoid){
    //     $parchivo=ModelsPresupuestoArchivo::find($presupuestoarchivoid);
    //     $existe=Storage::disk('archivospresupuesto')->exists($parchivo->archivo);
    //     if ($existe)
    //         return Storage::disk('archivospresupuesto')->download($parchivo->archivo);
    //     else{
    //         $this->dispatchBrowserEvent('notifyred', 'Ha habido un problema con el fichero');
    //     }
    // }

    public function save(){
        $this->validate();
        $filename="";
        $extension="";

        $presupuestoarchivo=ModelsPresupuestoArchivo::create([
            'presupuesto_id'=>$this->presupuestoid,
            'comentario'=>$this->valorcampo4,
            'nombrearchivooriginal'=>$this->valorcampoimg->getClientOriginalName(),
            'archivo'=>'',
        ]);

        if($this->campoimgvisible=='1'){
            if ($this->valorcampoimg) {
                $nombre=$this->presupuestoid.'/'.$presupuestoarchivo->id.'.'.$this->valorcampoimg->extension();
                $filename=$this->valorcampoimg->storeAs('/', $nombre, 'archivospresupuesto');
                $presupuestoarchivo->archivo=$nombre;
                $presupuestoarchivo->save();
            }
        }

        $this->enviamail($this->presupuesto);

        $this->dispatchBrowserEvent('notify', 'Archivo añadido con éxito');

        return redirect()->route('presupuesto.archivos',[$this->presupuestoid,$this->ruta]);
    }

    public function enviamail($presupuesto) {

        $responsable=Responsable::where('responsable',$presupuesto->responsable)->first();

        $details=[
            'responsable'=>Responsable::where('responsable',$presupuesto->responsable)->first(),
            'emailmilimetrica'=>$responsable->mailresponsable ? $responsable->mailresponsable : 'alex.arregui@sumaempresa.com',
            'emailexterno'=>Auth::user()->email,
            'title'=>'Se ha subido un archivo en el Presupuesto: ' .$presupuesto->id,
            'subject'=>'Se ha subido un archivo en el Presupuesto: ' .$presupuesto->id,
        ];

        // dd($details);

        Mail::send(new MilimetricaMail($presupuesto,$details));
        return "Correo enviado";
    }

    public function delete($valorId)
    {
        $borrar = ModelsPresupuestoArchivo::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Archivo eliminado!');
        }
    }
}

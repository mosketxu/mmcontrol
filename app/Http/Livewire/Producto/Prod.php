<?php

namespace App\Http\Livewire\Producto;

use Livewire\Component;

use App\Models\{Entidad,Producto };
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class Prod extends Component
{
    use WithFileUploads;

    public $producto;
    public $ficheropdf;

    protected function rules()
    {
        return [
            'producto.id'=>'nullable',
            'producto.cliente_id'=>'nullable',
            'producto.isbn'=>'nullable||unique:productos,isbn',
            'producto.referencia'=>'required||unique:productos,referencia',
            'producto.preciocoste'=>'nullable|numeric',
            'producto.precioventa'=>'nullable|numeric',
            'producto.observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'producto.referencia.required' => 'La referencia es necesaria.',
            'producto.referencia.unique' => 'Esta referencia ya existe.',
            'producto.isbn.unique' => 'El ISBN ya existe.',
            'producto.preciocoste.numeric' => 'El precio de compra debe ser numérico',
            'producto.precioventa.numeric' => 'El precio de venta debe ser numérico',
        ];
    }
    public function mount(Producto $producto)
    {
        $this->producto=$producto;
    }

    public function render()
    {
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);

        return view('livewire.producto.prod',compact('clientes'));
    }

    public function updatedProductoPreciocompra()
    {
        $this->producto->preciocoste=str_replace(',','.',$this->producto->preciocoste);
        $this->validateOnly('producto.preciocoste');
    }

    public function updatedProductoPrecioventa()
    {
        $this->producto->precioventa=str_replace(',','.',$this->producto->precioventa);
        $this->validateOnly('producto.precioventa');
    }

    public function updatedficheropdf()
    {
        $this->validate(['ficheropdf'=>'file|max:5000']);
    }

    public function presentaPDF(Producto $producto){
        $existe=Storage::disk('fichasproducto')->exists($producto->fichaproducto);
        if ($existe)
            return Storage::disk('fichasproducto')->download($producto->fichaproducto);
    }

    public function save()
    {
        if($this->producto->cliente_id=='') $this->producto->cliente_id=null;
        if($this->producto->id){
            $i=$this->producto->id;
            $this->validate([
                'producto.referencia'=>[
                    'required',
                    Rule::unique('productos','referencia')->ignore($this->producto->id)
                    ],
                'producto.isbn'=>[
                    'required',
                    Rule::unique('productos','isbn')->ignore($this->producto->id)
                    ],

                ],
            );
            $mensaje=$this->producto->referencia . " actualizado satisfactoriamente";
        }else{
            $this->validate();
            $i=$this->producto->id;
            $message=$this->producto->referencia . " creado satisfactoriamente";
        }

        // $filename=$this->ficheropdf->store('/','fichasproducto');
        // $filename=$this->ficheropdf->storeAs('/','pp.pdf','fichasproducto');
        $filename="";
        if ($this->ficheropdf) {
            $nombre=$this->producto->id.'.'.$this->ficheropdf->extension();
            $filename=$this->ficheropdf->storeAs('/', $nombre, 'fichasproducto');
        }

        // dd($this->producto);
        $prod=Producto::updateOrCreate([
            'id'=>$i
            ],
            [
            'isbn'=>$this->producto->isbn,
            'referencia'=>$this->producto->referencia,
            'cliente_id'=>$this->producto->cliente_id,
            'preciocoste'=>$this->producto->preciocoste,
            'precioventa'=>$this->producto->precioventa,
            'observaciones'=>$this->producto->observaciones,
            ]
        );
        if($this->ficheropdf){
            $prod->fichaproducto=$filename;
            $prod->save();
        }

        if(!$this->producto->id){
            $this->producto->id=$prod->id;
            $mensaje=$this->producto->referencia . " creado satisfactoriamente";
        }
        $this->dispatchBrowserEvent('notify', $mensaje);
    }
}

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
            'producto.proveedor_id'=>'nullable',
            'producto.isbn'=>'nullable||size:13||unique:productos,isbn',
            'producto.referencia'=>'required||unique:productos,referencia',
            'producto.precio'=>'nullable|numeric',
            'producto.observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'producto.referencia.required' => 'La referencia es necesaria.',
            'producto.referencia.unique' => 'Esta referencia ya existe.',
            'producto.isbn.unique' => 'El ISBN ya existe.',
            'producto.isbn.size' => 'El ISBN debe ser de longitud 13.',
            'producto.precio.numeric' => 'El precio debe ser numérico',
        ];
    }
    public function mount(Producto $producto)
    {
        $this->producto=$producto;
    }

    public function render()
    {
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['2','3']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['1','2']);

        return view('livewire.producto.prod',compact('proveedores','clientes'));
    }

    public function updatedProductoPrecio()
    {
        // dd($this->producto->precio);
        $this->producto->precio=str_replace(',','.',$this->producto->precio);
        $this->validateOnly('producto.precio');
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
            dd('Definir bien el nombre');
            $nombre=$this->producto->referencia.'.'.$this->ficheropdf->extension();
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
            'proveedor_id'=>$this->producto->proveedor_id,
            'precio'=>$this->producto->precio,
            'observaciones'=>$this->producto->observaciones,
            ]
        );
        if($this->ficheropdf){
            $prod->fichaproducto=$filename;
            // dd($prod->fichaproducto);
            $prod->save();
        }

        if(!$this->producto->id){
            $this->producto->id=$prod->id;
            $mensaje=$this->producto->referencia . " creado satisfactoriamente";
        }
        $this->dispatchBrowserEvent('notify', $mensaje);
    }
}

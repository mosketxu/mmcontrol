<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\CuentaBancaria as ModelsCuentaBancaria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use Livewire\Component;

class CuentasBancarias extends Component
{
    public $titulo='Cuentas Bancarias';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo1'=>'required|unique:cuentas_bancarias,iban',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo1.required' => 'El IBAN es necesario,',
            'valorcampo1.unique' => 'Esa cuenta ya existe,',
            'valorcampo3.required' => 'La moneda es necesaria,',
        ];
    }

    public function render()
    {
        $cuentas=ModelsCuentaBancaria::query()
            ->search('iban',$this->search)
            ->orderByDesc('es_defecto')
            ->orderBy('id')
            ->get();
        return view('livewire.seguridad.cuentas-bancarias',compact('cuentas'));
    }

    public function changeCampo(ModelsCuentaBancaria $valor,$campo,$valorcampo)
    {
        if($campo=='iban'){
            Validator::make(['valorcampo'=>$valorcampo],[
                'valorcampo'=>'required|unique:cuentas_bancarias,iban,'.$valor->id,
                ])->validate();
        }
        if($campo=='moneda'){
            Validator::make(['valorcampo'=>$valorcampo],[
                'valorcampo'=>'required',
                ])->validate();
        }
        $p=ModelsCuentaBancaria::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Cuenta Bancaria Actualizada.');
    }

    public function setDefecto($valorId)
    {
        DB::transaction(function () use ($valorId) {
            ModelsCuentaBancaria::where('es_defecto',true)->update(['es_defecto'=>false]);
            ModelsCuentaBancaria::where('id',$valorId)->update(['es_defecto'=>true]);
        });
        $this->dispatch('notify', 'Cuenta marcada como predeterminada.');
    }

    public function save()
    {
        $this->validate();

        ModelsCuentaBancaria::create([
            'iban'=>$this->valorcampo1,
            'bic'=>$this->valorcampo2,
            'moneda'=>$this->valorcampo3,
            'es_defecto'=>false,
        ]);

        $this->dispatchBrowserEvent('notify', 'Cuenta Bancaria añadida con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = ModelsCuentaBancaria::find($valorId);

        if ($borrar) {
            if ($borrar->es_defecto) {
                $this->dispatch('notify', 'No se puede eliminar la cuenta predeterminada: marca otra como predeterminada primero.');
                return;
            }
            try {
                $borrar->delete();
                $this->dispatchBrowserEvent('notify', 'Cuenta Bancaria eliminada!');
            } catch (QueryException $e) {
                $this->dispatchBrowserEvent('notify', 'No se puede eliminar: hay clientes usando esta cuenta.');
            }
        }
    }
}

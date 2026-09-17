<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\CuentaBancaria as ModelsCuentaBancaria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

use Livewire\Component;

class CuentasBancarias extends Component
{
    public $titulo='Cuentas Bancarias';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='IBAN';
    public $titcampo2='BIC';
    public $titcampo3='Moneda';
    public $campo1='iban';
    public $campo2='bic';
    public $campo3='moneda';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $editarvisible=0;
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
        $valores=ModelsCuentaBancaria::query()
            ->search('iban',$this->search)
            ->select('id','iban as valorcampo1','bic as valorcampo2','moneda as valorcampo3')
            ->orderBy('id')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
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

    public function save()
    {
        $this->validate();

        ModelsCuentaBancaria::create([
            'iban'=>$this->valorcampo1,
            'bic'=>$this->valorcampo2,
            'moneda'=>$this->valorcampo3,
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
            try {
                $borrar->delete();
                $this->dispatchBrowserEvent('notify', 'Cuenta Bancaria eliminada!');
            } catch (QueryException $e) {
                $this->dispatchBrowserEvent('notify', 'No se puede eliminar: hay clientes usando esta cuenta.');
            }
        }
    }
}

<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\{Entidad, EntidadContacto, Factura as ModelsFactura,Pedido};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Factura extends Component
{

    public $facturaid='';
    public $ruta;
    public $cliente_id;
    public $contacto_id;
    public $fecha;
    public $fechavencimiento;
    public $pedidocliente;
    public $importe=0;
    public $iva=0;
    public $total=0;
    public $estado=0;
    public $tipo='';
    public $observaciones;

    public $mesagge;
    public $bloqueado='0';
    public $modalDesbloqueo=false;   // pide confirmar el desbloqueo de una factura enviada/cobrada con PDF guardado
    public $confirmaDesbloqueo=false;
    public $deshabilitado='';
    public $escliente='';
    public $filtrocliente;
    public $cliente="";

    public $titulo='';
    public $pedidos;
    public $contactos;
    public $fac;

    protected $listeners = [ 'refreshfactura'];

    public function refreshfactura(){
        $this->mount($this->facturaid);
    // $this->render();
    }

    protected function rules(){
        return [
            // 'facturaid'=>'required',
            'cliente_id'=>'required',
            'contacto_id'=>'nullable',
            'pedidocliente'=>'nullable',
            'fecha'=>'date|required',
            'fechavencimiento'=>'nullable|date',
            'estado'=>'nullable',
            'tipo'=>'required',
            'observaciones'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'facturaid.required'=>pf('El número de factura es necesario.'),
            'cliente_id.required'=>'El cliente es necesario.',
            'tipo.required'=>pf('Es obligatorio el tipo de factura.'),
            'fecha.required'=>'La fecha es necesaria.',
            'fecha.date'=>'La fecha debe ser válida.',
            'fechavencimiento.date'=>'La fecha de vencimiento debe ser válida.',
        ];
    }

    public function mount($facturaid){
        $this->titulo=pf('Nueva Factura:');
        if ($facturaid!='') {
            $factura=ModelsFactura::find($facturaid);
            $this->fac=$factura;
            $this->facturaid=$factura->id;
            $this->cliente_id=$factura->cliente_id;
            $this->contacto_id=$factura->contacto_id;
            $this->fecha=$factura->fecha;
            $this->fechavencimiento=$factura->fechavencimiento;
            $this->pedidocliente=$factura->pedidocliente;
            $this->importe=number_format($factura->importe,4,',','.');
            $this->iva=number_format($factura->iva,2,',','.');
            $this->total=number_format($factura->total,2,',','.');
            $this->estado=$factura->estado;
            $this->tipo=$factura->tipo;
            $this->observaciones=$factura->observaciones;
            $this->bloqueado=($this->estado!='0' || $factura->estaCerrada()) ? '1' : '0';
            $this->deshabilitado=$this->bloqueado=='1' ? 'disabled' : '';

            $pedidossinfacturar=Pedido::select('pedidocliente','facturado')
                ->where('cliente_id',$factura->cliente_id)
                ->where('pedidocliente','<>','')
                ->where('facturado','<>','1')
                ->groupBy('pedidocliente')->get();

            $pedidodeestafactura=Pedido::select('pedidocliente','facturado')
                ->where('pedidocliente',$this->pedidocliente)
                ->where('pedidocliente','<>','')
                ->get();

            $this->pedidos=$pedidossinfacturar->concat($pedidodeestafactura);

            $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id',$factura->cliente_id)->get();
        }
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){
        $clientes=Entidad::orderBy('entidad')->whereIn('entidadtipo_id',['1','2'])->get();
        $estados=ModelsFactura::ESTADOS;
        $avisoPdf=$this->facturaid ? ModelsFactura::find($this->facturaid) : null;
        if($avisoPdf && !$avisoPdf->pdfDesactualizado()) $avisoPdf=null;
        return view('livewire.facturacion.factura',compact(['clientes','estados','avisoPdf']));
    }

    public function updatedClienteId(){
        if(!$this->fecha) $this->fecha=now()->format('Y-m-d');
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id',$this->cliente_id)->get();
        $this->pedidos=Pedido::select('pedidocliente')->where('cliente_id',$this->cliente_id)->where('estado','<>','1')->where('pedidocliente','<>','')->groupBy('pedidocliente')->get();
    }

    // «Crear factura»: la prefactura pasa a factura. Seguirá editable hasta la fecha de cierre (config/facturacion.php).
    public function crearFactura(){
        $f=ModelsFactura::find($this->facturaid);
        if(!$f || !$f->esPrefactura()) return;
        if($f->facturadetalles()->count()==0){
            $this->dispatchBrowserEvent('notifyred', 'La prefactura no tiene líneas.');
            return;
        }
        $f->update(['validada_at'=>now()]);
        $this->dispatchBrowserEvent('notify', pf('Factura creada. Se podrá modificar hasta el ').\Carbon\Carbon::parse(config('facturacion.cierre'))->format('d/m/Y').'.');
        $this->mount($this->facturaid);
    }

    public function updatedContactoId(){if($this->contacto_id=='') $this->contacto_id=null;}

    // Número de factura = 2 cifras del año de la fecha + 5 cifras correlativas (la correlación NO se reinicia cada año: JM, enero 2024).
    // 12-nov-2026: antes se tomaba el máximo de TODAS las facturas; una factura creada con fecha de otro año (2702756) hacía que
    // todas las siguientes salieran con el mismo número (2602757) y se pisaran entre sí. Ahora el correlativo sale del año de la
    // fecha y, si el número ya existe, se salta al siguiente libre: nunca se reutiliza un número.
    public function numfactura(){
        $anyo2=(int) substr(substr((string) $this->fecha, 0, 4), -2);
        $desde=$anyo2*100000;
        $ultimoAnyo=ModelsFactura::whereBetween('id',[$desde,$desde+99999])->max('id');
        if($ultimoAnyo){
            $num=$ultimoAnyo+1;
        }else{
            // primera factura del año: sigue el correlativo del último número anterior a este año
            $previo=ModelsFactura::where('id','<',$desde)->max('id');
            $num=$desde + ($previo ? ($previo % 100000)+1 : 1961);
        }
        while(ModelsFactura::whereKey($num)->exists()) $num++;
        return $num;
    }

    public function save(){
        $mensaje=pf('Factura creada satisfactoriamente');
        $i="";
        if($this->fechavencimiento=='') $this->fechavencimiento=null;
        $this->validate();
        if ($this->facturaid!='') {
            $i=$this->facturaid;
            $mensaje=pf('Factura actualizada satisfactoriamente');
            $nuevo=false;
            $this->validate([
                'facturaid'=>[
                    'required',
                    Rule::unique('facturas', 'id')->ignore($this->facturaid)
                ],],);
        }else{
            $this->facturaid=$this->numfactura();
            $i=$this->facturaid;
            $nuevo=true;
        }
        // Desbloquear (volver a «Sin enviar») una factura enviada/cobrada que ya tiene PDF guardado: primero se confirma en un modal.
        if(!$nuevo){
            $actual=ModelsFactura::find($this->facturaid);
            if($actual && $actual->estado!='0' && ($this->estado=='' || $this->estado=='0') && $actual->pdf_path && !$this->confirmaDesbloqueo){
                $this->modalDesbloqueo=true;
                return;
            }
        }
        $this->modalDesbloqueo=false; $this->confirmaDesbloqueo=false;
        if($nuevo){
            // create, no updateOrCreate: si el número ya existiera, antes se sobrescribía la factura de otro cliente sin avisar
            if(ModelsFactura::whereKey($i)->exists()){
                $this->facturaid='';
                $this->dispatchBrowserEvent('notifyred', 'Ese número de factura ya existe. No se ha guardado nada; vuelve a intentarlo.');
                return;
            }
            $fac=ModelsFactura::create([
                'id'=>$i,
                'cliente_id'=>$this->cliente_id,
                'contacto_id'=>$this->contacto_id,
                'pedidocliente'=>$this->pedidocliente,
                'fecha'=>$this->fecha,
                'fechavencimiento'=>$this->fechavencimiento,
                'estado'=>$this->estado == '' ? '0' : $this->estado,
                'tipo'=>$this->tipo == '' ? '1' : $this->tipo,
                'observaciones'=>$this->observaciones,
            ]);
        }else{
            $fac=ModelsFactura::updateOrCreate([
                'id'=>$i
                ],
                [
                'id'=>$this->facturaid,
                'cliente_id'=>$this->cliente_id,
                'contacto_id'=>$this->contacto_id,
                'pedidocliente'=>$this->pedidocliente,
                'fecha'=>$this->fecha,
                'fechavencimiento'=>$this->fechavencimiento,
                'estado'=>$this->estado == '' ? '0' : $this->estado,
                'tipo'=>$this->tipo == '' ? '1' : $this->tipo,
                'observaciones'=>$this->observaciones,
            ]);
        }

        // Foto de los datos del cliente: al crear la factura y solo si se cambia el cliente (no si cambia la dirección del cliente).
        if($nuevo || !$fac->datos_congelados_at || $fac->wasChanged('cliente_id')) $fac->congelarDatosCliente();

        $this->titulo=pf('Factura:');
        $factura=ModelsFactura::find($i);

        $this->dispatchBrowserEvent('notify', $mensaje);
        return redirect()->route('facturacion.edit',$factura->id);
    }
}

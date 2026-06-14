<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\UserEmpresa;
use Illuminate\Support\Facades\Auth;

class ProductosExport implements FromCollection,WithHeadings,WithMapping,WithColumnFormatting
{
    protected array $columns = [
        'id',
        'cliente_id',
        'cliente',
        'tipo',
        'isbn',
        'idioma_id',
        'idioma',
        'productoestado',
        'referencia',
        'preciocoste',
        'tirada',
        'formato',
        'FSC',
        'tipoimpresion',
        'materialinterior',
        'tintainterior',
        'gramajeinterior',
        'paginas',
        'materialcubierta',
        'tintacubierta',
        'gramajecubierta',
        'plastificado',
        'encuadernado',
        'solapa',
        'descripsolapa',
        'guardas',
        'descripguardas',
        'cd',
        'descripcd',
        'novedad',
        'descripnovedad',
        'caja_id',
        'caja',
        'etiqueta',
        'udxcaja',
        'precioventa',
        'material',
        'medidas',
        'troquel',
        'impresion',
        'desarrollocaja',
        'gramajecaja',
        'acabadocaja',
        'medidasnido',
        'materialnido',
        'impresionnido',
        'procesospack',
        'manipulacion',
        'observaciones',
        'created_at',
        'updated_at',
    ];

    public function __construct(
        public $tipo,
        public $filtroisbn,
        public $filtroproductoestado,
        public $filtroreferencia,
        public $filtrocliente,
        public $filtroidioma,
        public $filtromaterial,
        public $filtroimpresion,
        public $filtrocaja,
    ) {}

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT, // ISBN
        ];
    }

   public function headings(): array
    {
        return $this->columns;
    }

    public function collection(){

        $query = Producto::query()->with('proveedor', 'cliente', 'idioma', 'caja');

        // Empresas a las que tiene acceso el usuario actual
        $entidadescliente = UserEmpresa::where('user_id',Auth::id())->pluck('entidad_id');

        // Si tiene empresas asociadas, es cliente y solo ve sus productos
        if (Auth::user()->hasRole('Cliente')) {
            $entidadescliente = UserEmpresa::where('user_id',Auth::id())->pluck('entidad_id');
            $query->whereIn('cliente_id', $entidadescliente);
        }

        return $query
            ->when($this->tipo, fn($q) => $q->where('tipo', $this->tipo))
            ->when($this->filtroisbn, fn($q) => $q->where('isbn', 'like', "%{$this->filtroisbn}%"))
            ->when($this->filtroproductoestado, fn($q) => $q->where('productoestado', $this->filtroproductoestado))
            ->when($this->filtroreferencia, fn($q) => $q->where('referencia', 'like', "%{$this->filtroreferencia}%"))
            ->when($this->filtrocliente, fn($q) => $q->where('cliente_id', $this->filtrocliente))
            ->when($this->filtroidioma, fn($q) => $q->where('idioma_id', $this->filtroidioma))
            ->when($this->filtromaterial, fn($q) => $q->where('material', $this->filtromaterial))
            ->when($this->filtroimpresion, fn($q) => $q->where('impresion', $this->filtroimpresion))
            ->when($this->filtrocaja, fn($q) => $q->where('caja', $this->filtrocaja))
            ->get();
        }

   public function map($p): array
    {
        $isbn = $this->formatIsbn($p->isbn);

        return [
            $p->id,
            $p->cliente_id,
            $p->cliente?->entidad ?? '',
            $p->tipo == '1' ? 'Editorial' : 'Packaging/Otros',
            $isbn,
            $p->idioma_id,
            $p->idioma?->nombre ?? '',
            $p->productoestado?->label() ?? '',
            $p->referencia,
            $p->preciocoste,
            $p->tirada,
            $p->formato,
            $p->FSC,
            $p->tipoimpresion,
            $p->materialinterior,
            $p->tintainterior,
            $p->gramajeinterior,
            $p->paginas,
            $p->materialcubierta,
            $p->tintacubierta,
            $p->gramajecubierta,
            $p->plastificado,
            $p->encuadernado,
            $p->solapa,
            $p->descripsolapa,
            $p->guardas,
            $p->descripguardas,
            $p->cd,
            $p->descripcd,
            $p->novedad,
            $p->descripnovedad,
            $p->caja_id,
            $p->caja?->name ?? '',
            $p->etiqueta,
            $p->udxcaja,
            $p->precioventa,
            $p->material,
            $p->medidas,
            $p->troquel,
            $p->impresion,
            $p->desarrollocaja,
            $p->gramajecaja,
            $p->acabadocaja,
            $p->medidasnido,
            $p->materialnido,
            $p->impresionnido,
            $p->procesospack,
            $p->manipulacion,
            $p->observaciones,
            optional($p->created_at)->format('d/m/Y'),
            optional($p->updated_at)->format('d/m/Y'),
        ];
    }

    protected function formatIsbn($isbn): string
    {
        if (!empty($isbn) && is_numeric($isbn) && strlen((string)$isbn) > 10) {
            return "'" . $isbn;
        }

        return (string) $isbn;
    }
}


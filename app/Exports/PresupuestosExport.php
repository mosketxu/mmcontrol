<?php

namespace App\Exports;

use App\Models\Presupuesto;
use Maatwebsite\Excel\Concerns\FromCollection;

class PresupuestosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Presupuesto::all();
    }
}

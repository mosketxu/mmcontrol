<?php

namespace App\Exports;

use App\Models\Oferta;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfertasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Oferta::all();
    }
}

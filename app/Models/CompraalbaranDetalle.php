<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraalbaranDetalle extends Model
{
    protected $fillable = ['albaran_id','concepto','cantidad','precio_ud','total'];

    public function albaran()
    {
        return $this->belongsTo(CompraAlbaran::class,'albaran_id');
    }
}

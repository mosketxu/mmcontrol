<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuadernacion extends Model
{
    use HasFactory;

    protected $table = 'encuadernaciones';

    protected $fillable = ['name','descripcion','familia'];

}

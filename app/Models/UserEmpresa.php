<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmpresa extends Model
{
    use HasFactory;

    protected $table = 'user_empresas';


    protected $fillable = ['entidad_id','user_id'];

    public function entidad(){
        return $this->belongsTo(Entidad::class,'entidad_id','id')->orderBy('entidad','ASC');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->orderBy('name','ASC');
    }


}

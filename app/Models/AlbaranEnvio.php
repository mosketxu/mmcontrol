<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbaranEnvio extends Model
{
    protected $fillable = ['parcial_id','user_id','destinatarios','asunto','mensaje','adjuntos','valorado','enviado_at'];

    protected $casts = ['destinatarios' => 'array','adjuntos' => 'array','valorado' => 'boolean','enviado_at' => 'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
}

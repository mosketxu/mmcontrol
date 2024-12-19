<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoTarea extends Model
{
    use HasFactory;

    protected $table = 'pedido_tareas';

    // Campos asignables masivamente
    protected $fillable = ['pedido_id','tarea','unidades','otros','fecha_inicio','fecha_fin','asignado_a','estado'];

    /**
     * Relación con el modelo Pedido (muchos a uno).
     */
    public function pedido(){return $this->belongsTo(Pedido::class, 'pedido_id');}

    const ESTADOS = [
        1 => 'Empezado',
        2 => 'En curso',
        3 => 'Cancelada',
        4 => 'Finzalizad',
    ];

    /**
     * Obtener los valores del ENUM como un array.
     */
    public static function getEstados(){return self::ESTADOS;}

    /**
     * Obtener el texto descriptivo de un valor.
     */
    public function getEstadoTextAttribute(){return self::ESTADOS[$this->estado] ?? 'Desconocido';
    }
}

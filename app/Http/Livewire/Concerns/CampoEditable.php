<?php

namespace App\Http\Livewire\Concerns;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Utilidades para las tarjetas de Seguridad que usan la vista compartida
 * livewire/auxiliarcard (edición en línea celda a celda).
 *
 * - $nonce se incluye en el wire:key de cada fila; al incrementarlo forzamos
 *   que Livewire vuelva a pintar las filas y el <input> recupere su valor
 *   original cuando un cambio en línea se rechaza.
 */
trait CampoEditable
{
    public $nonce = 0;

    /**
     * Valida un cambio en línea. Si falla, repinta la fila (revierte el input)
     * y relanza la excepción para que Livewire muestre el error.
     */
    protected function validarInline(array $data, array $rules, array $messages = []): void
    {
        try {
            Validator::make($data, $rules, $messages)->validate();
        } catch (ValidationException $e) {
            $this->nonce++;
            throw $e;
        }
    }
}

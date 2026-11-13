<?php

namespace App\Http\Livewire\DataTable;

/**
 * Scroll infinito para los listados Livewire (sustituye a WithPagination + links()).
 * Se muestran los primeros $cantidad registros; al llegar al final de la ventana la vista (x-scroll-infinito) llama a cargarMas()
 * y se piden $lote más a la base de datos. Nunca se cargan todos a la vez.
 *
 * Uso: en el componente `use WithScrollInfinito;` y en la consulta  `$this->paginar($query)`  (devuelve un paginador normal:
 * count(), total(), hasMorePages()...). En la vista:  <x-scroll-infinito-info :lista="$x"/>  arriba  y  <x-scroll-infinito :lista="$x"/>  tras la última fila.
 * Los métodos updatingFiltroXxx() que ya llaman a resetPage() siguen valiendo: aquí resetPage() vuelve al primer lote.
 */
trait WithScrollInfinito
{
    /** Registros que se muestran ahora. */
    public $cantidad = 50;

    /** Registros que se añaden cada vez (y los del primer lote). */
    protected function lote(): int
    {
        return 50;
    }

    public function cargarMas(): void
    {
        $this->cantidad = max($this->cantidad, $this->lote()) + $this->lote();
    }

    public function resetPage(): void
    {
        $this->cantidad = $this->lote();
    }

    /** @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query */
    protected function paginar($query)
    {
        return $query->paginate(max($this->cantidad, $this->lote()), ['*'], 'page', 1);
    }
}

<?php

namespace App\Http\Livewire\DataTable;

trait WithBulkActions
{
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

    public function updatedSelected(){
        $this->selectAll=false;
        $this->selectPage=false;
    }

    public function updatedSelectPage($value){

        if($value) return $this->selectPageRows();

        $this->selected= [];
    }

    public function selectAll(){
        $this->selectAll=true;
    }

    public function selectPageRows()
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id);
    }

    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }

    public function getSelectedXlsQueryProperty()
    {
        return (clone $this->xlsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }
}

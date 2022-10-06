<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout2 extends Component
{
    /**
     * Get the view / contents that represents the component pero con datos.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app2');
    }
}

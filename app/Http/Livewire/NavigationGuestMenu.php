<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigationGuestMenu extends Component
{

        /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-guest-menu' => '$refresh',
    ];

    public function render(){
        return view('livewire.navigation-guest-menu');
    }
}

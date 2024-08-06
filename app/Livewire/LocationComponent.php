<?php

namespace App\Livewire;

use Livewire\Component;

class LocationComponent extends Component
{
    public $latitude;
    public $longitude;

    protected $listeners = ['setLocation'];

    public function setLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function render()
    {
        return view('livewire.location-component');
    }
}

<?php

namespace App\Livewire;

use App\Models\UserLocation;
use Livewire\Component;

class LocationComponent extends Component
{
    public $latitude;
    public $longitude;

    protected $listeners = ['customerLocation' => 'setLocation'];
    // protected $listeners = ['setLocation'];

    public function setLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        UserLocation::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'latitude' => $latitude,
                'longitude' => $longitude
            ],
        );
        $this->dispatch('locationUpdated', ['latitude' =>  $this->latitude, 'longitude' =>  $this->longitude]);
    }

    public function render()
    {
        return view('livewire.location-component');
    }
}

<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\UserLocation;
use Livewire\Component;

class LocationComponent extends Component
{
    public $latitude;
    public $longitude;
    public $user_id;

    protected $listeners = ['customerLocation' => 'setLocation'];
    public function changeEvents($user_id)
    {
        $UserLocation = UserLocation::where('user_id', $user_id)->first(); 
        if ($UserLocation) {  // This checks if $UserLocation is not null
            $this->user_id = $UserLocation->latitude;
            $this->dispatch('locationUpdated', ['latitude' =>  $UserLocation->latitude, 'longitude' =>  $UserLocation->longitude]);
            // dd($this->user_id);
        } else {
            // Handle the case where no UserLocation was found
            // dd('No location found for this user');
        }
    }
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
        // if ($this->user_id) {

        //     $this->dispatch('locationUpdated', ['latitude' =>  $this->latitude, 'longitude' =>  $UserLocation->longitude]);
        // } else {

        //     $this->dispatch('locationUpdated', ['latitude' =>  $this->latitude, 'longitude' =>  $this->longitude]);
        // }
        // dd($this->user_id);
    }

    public function render()
    {
        $customers = Customer::get(['id', 'name']);
        return view('livewire.location-component', [
            'customers' => $customers,
        ]);
    }
}

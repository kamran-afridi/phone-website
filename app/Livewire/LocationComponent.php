<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LocationComponent extends Component
{
    public $latitude;
    public $longitude;
    public $getlatitude;
    public $getlongitude;
    public $user_id;

    protected $listeners = ['customerLocation' => 'setLocation'];
    public $customer_id;

    public function mount()
    {
        // Initialize customer_id with old input if it exists, or the current value
        // $this->customer_id = old('customer_id') ?: $this->customer_id;
        $this->customer_id = session('customer_id', '');
        // dd("customer_id");
    }
    public function changeEvents($customer_id)
    { 
        $UserLocation = UserLocation::where('user_id', $customer_id)->first();
        if ($UserLocation) {  // This checks if $UserLocation is not null 
            $this->getlatitude = $UserLocation->latitude;
            $this->getlongitude = $UserLocation->longitude;
            Session::put('customer_id', $customer_id);
            $this->dispatch('locationUpdated', ['latitude' =>  $UserLocation->latitude, 'longitude' =>  $UserLocation->longitude]);
            // dd("asa");
        } else {
            // Handle the case where no UserLocation was found
            // dd('No location found for this user');
            $this->getlatitude = 'Not detected';
            $this->getlongitude = 'Not detected';
            $this->user_id = 'Not detected';
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
    }

    public function render()
    {
        $customers = User::get(['id', 'name']);
        return view('livewire.location-component', [
            'customers' => $customers,
        ]);
    }
}
